<?php

class ST_Automation_Model_Executor extends Varien_Object
{
    public function getHelper()
    {
        return Mage::helper('st_automation');
    }
    
    public function newCustomerSignUp($data)
    {
        $customer = Mage::getModel("customer/customer");
        $customer->setData($data);
        $customer->save();
    }
    
    public function newCustomerSignUpFromReferral($data)
    {
        $customer = Mage::getModel("customer/customer");
        $customer->setData($data);

        Mage::getModel('rewardsref/observer_createaccount')->attemptReferralCheck(null, null, $customer->getData());
        $customer->save();
    }
    
    public function newCustomerSignUpFromRepeatedReferral($data)
    {
        $this->newCustomerSignUpFromReferral($data);
    }
    
    public function initializeQuote($data) 
    {
        // Initialize quote
        $quote = Mage::getModel('sales/quote')
            ->assignCustomer($data['customer'])
            ->setStore($data['store']);
        
        // Add products
        foreach ($data['products'] as $item) {
            $product = $item['product'];
            
            $param = array(
                'product' => $product->getId(),
                'qty' => $item['qty'],
            );

            $request = new Varien_Object();
            $request->setData($param);

            $quoteItem = $quote->addProduct($product, $request);
            if (is_string($quoteItem)) {
                $this->getHelper()->log(sprintf("Error: $quoteItem"));
            }

            $quoteItem->setQuote($quote);
            $quoteItem->checkData();
        }
        
        // Set billing address
        $billingAddress = new Mage_Sales_Model_Quote_Address();
        $billingAddress->importCustomerAddress($data['billing_address']);
        $quote->setBillingAddress($billingAddress);
        
        // Set shipping address
        $shippingAddress = new Mage_Sales_Model_Quote_Address();
        $shippingAddress->importCustomerAddress($data['shipping_address']);
        $quote->setShippingAddress($shippingAddress);
        
        // Set Shipping method
        $quote->getShippingAddress()
            ->setShippingMethod($data['shipping_method'])
            ->setCollectShippingRates(true)
            ->collectShippingRates();
        
        // Set Payment Method
        $quotePayment = $quote->getPayment();
        $quotePayment->setMethod($data['payment_method']);
        $quote->setPayment($quotePayment);
        
        return $quote;
    }
    
    public function invoiceAndShipOrder($order) 
    {
        // Create invoice
        if (!$order->canInvoice()) {
            $this->getHelper()->log("Cannot create invoice for order {$order->getId()}");
        } else {
            $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
            $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
            $invoice->register();

            $transaction = Mage::getModel('core/resource_transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder());

            $transaction->save();
        }

        // Ship
        if (!$order->canShip()) {
            $this->getHelper()->log("Cannot ship order {$order->getId()}");
        } else {
            $itemQty =  $order->getItemsCollection()->count();
            Mage::getModel('sales/service_order', $order)->prepareShipment($itemQty);
            Mage::getModel('sales/order_shipment_api')->create($order->getIncrementId());
        }
    }
    
    public function placeOrder($data)
    {
        // Create Quote
        $quote = $this->initializeQuote($data);
        $quote->collectTotals()->save();
        
        // Create Order
        $service = Mage::getModel('sales/service_quote', $quote);
        $order = $service->submitOrder();
        $order->save();
        
        if ($data['complete']) {
            $this->invoiceAndShipOrder($order);
        }
        
        return $order;
    }
    
    public function placeOrderWithPoints($data)
    {
        $customer = $data['customer'];
        
        $rule = Mage::getModel('rewards/salesrule_rule')->getResourceCollection()
            ->addFieldToFilter("points_action", 'discount_by_points_spent')
            ->addFieldToFilter("points_discount_action", 'cart_fixed')
            ->getFirstItem();

        if (!$rule->getId()) {
            $this->getHelper()->log('No fixed cart slider rule found');
            return $this->placeOrder($data);
        } else {
            // Create Quote
            $quote = $this->initializeQuote($data);
            $quote->collectTotals();
            
            // Calculate maximum points for this order
            $customerPointsBalance = $customer->getRewardsPointsBalance();
            $grandTotal = $quote->getSubtotal();

            $step = $rule->getPointsAmount();
            $discount = $rule->getPointsDiscountAmount();
            
            $pointsNeededForFreeOrder = ceil($grandTotal / $discount) * $step;
            $pointsAmount = min($pointsNeededForFreeOrder, $customerPointsBalance);            
            $quote->setPointsSpending($pointsAmount);

            // Recalculate totals
            $quote->getShippingAddress()->setCollectShippingRates(true)->collectShippingRates();
            $quote->setTotalsCollectedFlag(false)->collectTotals()->save();
            Mage::getModel('rewards/sales_quote')->updateDisabledEarnings($quote);
            
            // Create Order
            $service = Mage::getModel('sales/service_quote', $quote);
            $order = $service->submitOrder();
            $order->save();
            
            // Invoice and Ship
            if ($data['complete']) {
                $this->invoiceAndShipOrder($order);
            }
            
            return $order;
        }
    }
    
    public function placeRepeatOrderWithPoints($data)
    {
        return $this->placeOrderWithPoints($data);
    }
    
    public function placeReferrerOrderWithPoints($data)
    {
        return $this->placeOrderWithPoints($data);
    }
    
    public function placeOrderWithPointsAndCancel($data)
    {
        $order = $this->placeOrderWithPoints($data);
        
        if (!$order->canCancel()) {
            $this->getHelper()->log("Cannot cancel order {$order->getId()}");
        } else {
            $order->cancel();
            $order->getStatusHistoryCollection(true);
            $order->save();
        }
        
        return $order;
    }
    
    public function reviewProduct($data)
    {   
        $review = Mage::getModel('review/review')->setData($data)->save();
        $ratings = $data['ratings'];
            
        foreach ($ratings as $ratingId => $optionId) {
            Mage::getModel('rating/rating')
                ->setRatingId($ratingId)
                ->setReviewId($review->getId())
                ->setCustomerId($data['customer_id'])
                ->addOptionVote($optionId, $data['entity_pk_value']);
        }

        $review->aggregate();

        $ruleCollection = Mage::getSingleton('rewards/review_validator')->getApplicableRulesOnReview();
        foreach ($ruleCollection as $rule) {
            Mage::getModel('rewards/review_transfer')->transferReviewPoints($review, $rule);
        }
    }
    
    public function tagProduct($data)
    {
        $tagModel = Mage::getModel('tag/tag')->loadByName($data['tag_name']);
        if (!$tagModel->getId()) {
            $tagModel->setName($data['tag_name'])
                ->setFirstCustomerId($data['customer'])
                ->setFirstStoreId($data['store'])
                ->setStatus($tagModel->getApprovedStatus())
                ->save();
        }

        $tagModel->saveRelation(
            $data['product'], 
            $data['customer'], 
            $data['store']
        );
        
        $ruleCollection = Mage::getSingleton('rewards/tag_validator')->getApplicableRulesOnTag();
        foreach ($ruleCollection as $rule) {
            Mage::getModel('rewards/tag_transfer')->transferTagPoints($tagModel, $rule);
        }
    }
    
    public function voteInPoll($data)
    {
        $vote = Mage::getModel('poll/poll_vote')
            ->setPollAnswerId($data['answer'])
            ->setIpAddress('127.0.0.1')
            ->setCustomerId($data['customer']);

        $poll = $data['poll'];
        $poll->addVote($vote);
        
        Mage::dispatchEvent('poll_vote_add', array(
            'poll'  => $poll,
            'vote'  => $vote
        ));
    }
    
    public function sendProductToFriend($data)
    {
        $model = Mage::getModel('rewards/sendfriend');
        $model->setRemoteAddr(Mage::helper('core/http')->getRemoteAddr(true));
        $model->setCookie(Mage::app()->getCookie());
        $model->setWebsiteId($data['website']);

        if (!Mage::registry('send_to_friend_model')) {
            Mage::register('send_to_friend_model', $model);
        }

        $model->setSender($data['sender']);
        $model->setRecipients($data['recipients']);
        $model->setProduct($data['product']);

        $validate = $model->validate();
        if ($validate === true) {
            $model->send();
        }
    }
    
    public function signUpForNewsletter($data)
    {
        $customer = $data['customer'];
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($customer->getEmail());
            
        if (
            !$subscriber->getId()
            || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED
            || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE
        ) {
            $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
            $subscriber->setSubscriberEmail($customer->getEmail());
            $subscriber->setSubscriberConfirmCode($subscriber->RandomSequence());
        }

        $subscriber->setStoreId($data['store']);
        $subscriber->setCustomerId($customer->getId());
        $subscriber->save();
    }
    
    public function shareReferralLink($data)
    {
        $actionModel = Mage::getModel('rewardssocial2/action')
            ->setData($data)
            ->save();

        Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
    }
    
    public function twitterFollow($data)
    {
        $this->shareReferralLink($data);
    }
    
    public function facebookLike($data)
    {
        $this->shareReferralLink($data);
    }
    
    public function facebookShare($data)
    {
        $this->shareReferralLink($data);
    }
    
    public function twitterTweet($data)
    {
        $this->shareReferralLink($data);
    }
    
    public function pinterestPin($data)
    {
        $this->shareReferralLink($data);
    }
    
    public function sharePurchaseOnFacebook($data)
    {
        $this->shareReferralLink($data);
    }
    
    public function sharePurchaseOnTwitter($data)
    {
        $this->shareReferralLink($data);
    }
}