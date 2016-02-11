<?php

class ST_Automation_Model_Data extends Varien_Object
{
    public function getHelper()
    {
        return Mage::helper('st_automation');
    }
    
    public function getGenerator()
    {
        return Mage::helper('st_automation/generator');
    }
    
    public function newCustomerSignUp()
    {
        $helper = $this->getHelper();
        $generator = $this->getGenerator();
        
        return array(
            'website_id' => $helper->getDefaultWebsiteId(),
            'store' => $helper->getDefaultStore(),
            'firstname' => $generator->generateFirstname(),
            'lastname' => $generator->generateLastname(),
            'email' => $generator->generateEmail(),
            'password' => $generator->generatePassword(),
            'dob' => date("Y-m-d", strtotime("+1 month"))
        );
    }
    
    public function newCustomerSignUpFromReferral()
    {
        $data = $this->newCustomerSignUp();
        $data['rewards_referral'] = $this->getHelper()->loadRandomCustomer()->getEmail();
        
        return $data;
    }
    
    public function newCustomerSignUpFromRepeatedReferral()
    {
        $data = $this->newCustomerSignUp();
        $data['rewards_referral'] = $this->getHelper()->loadRandomAffiliate()->getEmail();
        
        return $data;
    }
    
    public function placeOrder()
    {
        $helper = $this->getHelper();
        $generator = $this->getGenerator();
        
        $products = array();
        $productsCount = rand(1, 3);
        
        $count = 0;
        while ($count < $productsCount) {
            $count++;
            $products[] = array(
                'product' => $helper->loadRandomProduct(),
                'qty' => rand(1, 3)
            );
        }
        
        $shipToBillingAddress = rand(0,1) == 1;
        $billingAddress = $generator->generateFullAddress();
        $shippingAddress = ($shipToBillingAddress) 
            ? $billingAddress 
            : $generator->generateFullAddress();
                
        
        $data = array(
            'customer' => $helper->loadRandomCustomer(),
            'products' => $products,
            'store' => $helper->getDefaultStore(),
            'billing_address' => $billingAddress,
            'shipping_address' => $shippingAddress,
            'shipping_method' => 'flatrate_flatrate',
            'payment_method' => 'checkmo',
            'complete' => true
        );
        
        return $data;
    }
    
    public function placeOrderWithPoints()
    {
        $data = $this->placeOrder();
        
        $customerWithPoints = $this->getHelper()->loadRandomCustomerWithPoints();
        $data['customer'] = $customerWithPoints;
        $data['complete'] = true;
        
        return $data;
    }
    
    public function placeRepeatOrderWithPoints()
    {
        $data = $this->placeOrder();
        
        $customerWithPoints = $this->getHelper()->loadRandomCustomerWithPoinsAndOrders();
        $data['customer'] = $customerWithPoints;
        $data['complete'] = true;
        
        return $data;
    }
    
    public function placeReferrerOrderWithPoints()
    {
        $data = $this->placeOrder();
        
        $customerWithPoints = $this->getHelper()->loadRandomReferredCustomerWithPoins();
        $data['customer'] = $customerWithPoints;
        $data['complete'] = true;
        
        return $data;
    }
    
    public function placeOrderWithPointsAndCancel()
    {
        $data = $this->placeRepeatOrderWithPoints();
        $data['complete'] = false;
        
        return $data;
    }
    
    public function reviewProduct()
    {
        $helper = $this->getHelper();
        $storeId = $helper->getDefaultStoreId();
        
        $ratingOptions = array(
            1 => array(1, 2, 3, 4, 5),
            2 => array(6, 7, 8, 9, 10),
            3 => array(11, 12, 13, 14, 15)
        );
        
        $ratings = array();
        foreach ($ratingOptions as $ratingId => $optionIds) {
            $ratings[$ratingId] = $optionIds[array_rand($optionIds)];
        }
        
        return array(
            'entity_pk_value'   => $helper->loadRandomProduct()->getId(),
            'status_id'         => 1,  // Approved
            'title'             => 'Good product',
            'detail'            => 'This is a great product. Recommended++',
            'entity_id'         => 1,
            'store_id'          => $storeId,
            'stores'            => array($storeId),
            'customer_id'       => $helper->loadRandomCustomer()->getId(),
            'nickname'          => $this->getGenerator()->generateFirstname(),
            'ratings'           => $ratings
        );
    }
    
    public function tagProduct()
    {
        $helper = $this->getHelper();
        
        return array(
            'tag_name' => $this->getGenerator()->generatePassword(),
            'customer' => $helper->loadRandomCustomer()->getId(),
            'store' => $helper->getDefaultStoreId(),
            'product'  => $helper->loadRandomProduct()->getId()
        );
    }
    
    public function voteInPoll()
    {
        $helper = $this->getHelper();
        $poll = $helper->loadRandomPoll();
                
        $answers = Mage::getModel('poll/poll_answer')->getCollection();
        $answers->addPollFilter($poll->getId());
        $answers->setPageSize(1);
        $answers->getSelect()->order(new Zend_Db_Expr('RAND()'));

        $answer = $answers->getFirstItem();        
                
        
        return array(
            'customer' => $helper->loadRandomCustomer()->getId(),
            'poll' => $poll,
            'answer' => $answer->getId()
        );
    }
    
    public function sendProductToFriend()
    {
        $helper = $this->getHelper();
        $customer = $helper->loadRandomCustomer();
        
        return array(
            'sender' => array(
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'message' => 'Check out this product'
            ),
            'recipients' => array(
                'name' => array('Sweet Tooth'),
                'email' => array('test+sendproduct@sweettoothhq.com')
            ),
            'website' => $helper->getDefaultWebsiteId(),
            'product' => $helper->loadRandomProduct(),
            'customer' => $customer
        );
    }
    
    public function signUpForNewsletter()
    {
        $helper = $this->getHelper();
        
        return array(
            'customer' => $helper->loadRandomCustomer(),
            'store' => $helper->getDefaultStoreId()
        );
    }
    
    public function shareReferralLink()
    {
        $isFacebookShare = rand(0,1) == 1;
        $action = ($isFacebookShare) ? 'facebook_share_referral' : 'twitter_share_referral';
        
        return array(
            'customer_id' => $this->getHelper()->loadRandomCustomer()->getId(),
            'action' => $action
        );
    }
    
    public function twitterFollow()
    {
        return array(
            'customer_id' => $this->getHelper()->loadRandomCustomer()->getId(),
            'action' => 'twitter_follow'
        );
    }
    
    public function facebookLike()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'facebook_like'
        );
    }
    
    public function facebookShare()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'facebook_share'
        );
    }
    
    public function twitterTweet()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'twitter_tweet'
        );
    }
    
    public function pinterestPin()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'pinterest_pin'
        );
    }
    
    public function sharePurchaseOnFacebook()
    {
        $generator = $this->getGenerator();
        
        $extra = array(
            'product' => $generator->generatePassword(),
            'order' => $generator->generatePassword()
        );
        
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => json_encode($extra),
            'action'    => 'facebook_share_purchase'
        );
    }
    
    public function sharePurchaseOnTwitter()
    {
        $data = $this->sharePurchaseOnFacebook();
        $data['action'] = 'twitter_tweet_purchase';
        
        return $data;
    }
}
