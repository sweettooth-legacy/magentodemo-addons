<?php

/**
 * Automation Data Model
 *  
 * Generate and return the data needed for each action. This data will be used 
 * in the executor model
 *
 * @category   ST
 * @package    ST_Automation
 * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class ST_Automation_Model_Data extends Varien_Object
{
    /**
     * Fetch default helper (load random entries like products, customers, etc.)
     * @return ST_Automation_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('st_automation');
    }
    
    /**
     * Fetch generator helper (generate random data like names, addresses, etc.)
     * @return ST_Automation_Helper_Generator
     */
    public function getGenerator()
    {
        return Mage::helper('st_automation/generator');
    }
    
    /**
     * Create data for a new customer (no referral)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function newCustomerSignUp()
    {
        $helper = $this->getHelper();
        $generator = $this->getGenerator();
        
        $firstname = $generator->generateFirstname();
        $lastname = $generator->generateLastname();
        
        return array(
            'website_id' => $helper->getDefaultWebsiteId(),
            'store' => $helper->getDefaultStore(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $generator->generateEmail($firstname, $lastname),
            'password' => $generator->generatePassword(),
            'dob' => date("Y-m-d", strtotime("+1 month"))
        );
    }
    
    /**
     * Create data for a new referred customer (first time referrer)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function newCustomerSignUpFromReferral()
    {
        $data = $this->newCustomerSignUp();
        $data['rewards_referral'] = $this->getHelper()->loadRandomCustomer()->getEmail();
        
        return $data;
    }
    
    /**
     * Create data for a new referred customer where the refferrer referred before.
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function newCustomerSignUpFromRepeatedReferral()
    {
        $data = $this->newCustomerSignUp();
        $data['rewards_referral'] = $this->getHelper()->loadRandomAffiliate()->getEmail();
        
        return $data;
    }
    
    /**
     * Create data for a new order (no points)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
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
        
        $customer = $helper->loadRandomCustomer()->load();
        $firstname = $customer->getFirstname();
        $lastname = $customer->getLastname();
        
        $shipToBillingAddress = rand(0,1) == 1;
        $billingAddress = $generator->generateFullAddress($firstname, $lastname);
        $shippingAddress = ($shipToBillingAddress) 
            ? $billingAddress 
            : $generator->generateFullAddress();
                
        $data = array(
            'customer' => $customer,
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
    
    /**
     * Create data for a new order (with points, invoiced and shipped)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function placeOrderWithPoints()
    {
        $data = $this->placeOrder();
        
        $customerWithPoints = $this->getHelper()->loadRandomCustomerWithPoints();
        $data['customer'] = $customerWithPoints;
        $data['complete'] = true;
        
        return $data;
    }
    
    /**
     * Create data for a new order for a customer who ordered before
     * (with points, invoiced and shipped)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function placeRepeatOrderWithPoints()
    {
        $data = $this->placeOrder();
        
        $customerWithPoints = $this->getHelper()->loadRandomCustomerWithPoinsAndOrders();
        $data['customer'] = $customerWithPoints;
        $data['complete'] = true;
        
        return $data;
    }
    
    /**
     * Create data for a new order for a referred customer
     * (with points, invoiced and shipped)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function placeReferrerOrderWithPoints()
    {
        $data = $this->placeOrder();
        
        $customerWithPoints = $this->getHelper()->loadRandomReferredCustomerWithPoins();
        $data['customer'] = $customerWithPoints;
        $data['complete'] = true;
        
        return $data;
    }
    
    /**
     * Create data for a new order (with points, canceled)
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function placeOrderWithPointsAndCancel()
    {
        $data = $this->placeRepeatOrderWithPoints();
        $data['complete'] = false;
        
        return $data;
    }
    
    /**
     * Create data for a new review
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
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
    
    /**
     * Create data for a tag
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function tagProduct()
    {
        $helper = $this->getHelper();
        
        return array(
            'tag_name' => $this->getGenerator()->generateRandomAdjective(),
            'customer' => $helper->loadRandomCustomer()->getId(),
            'store' => $helper->getDefaultStoreId(),
            'product'  => $helper->loadRandomProduct()->getId()
        );
    }
    
    /**
     * Create data for voting in a poll
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
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
    
    /**
     * Create data for sending a product to a friend
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
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
    
    /**
     * Create data for subscribing a customer to the newsletter 
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function signUpForNewsletter()
    {
        $helper = $this->getHelper();
        
        return array(
            'customer' => $helper->loadRandomCustomer(),
            'store' => $helper->getDefaultStoreId()
        );
    }
    
    /**
     * Create data for triggering a social action - referral link sharing
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function shareReferralLink()
    {
        $isFacebookShare = rand(0,1) == 1;
        $action = ($isFacebookShare) ? 'facebook_share_referral' : 'twitter_share_referral';
        
        return array(
            'customer_id' => $this->getHelper()->loadRandomCustomer()->getId(),
            'action' => $action
        );
    }
    
    /**
     * Create data for triggering a social action - twitter follow
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function twitterFollow()
    {
        return array(
            'customer_id' => $this->getHelper()->loadRandomCustomer()->getId(),
            'action' => 'twitter_follow'
        );
    }
    
    /**
     * Create data for triggering a social action - facebook like
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function facebookLike()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'facebook_like'
        );
    }
    
    /**
     * Create data for triggering a social action - facebook share
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function facebookShare()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'facebook_share'
        );
    }
    
    /**
     * Create data for triggering a social action - twitter tweet
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function twitterTweet()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'twitter_tweet'
        );
    }
    
    /**
     * Create data for triggering a social action - google plus one
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function googlePlusone()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'google_plusone'
        );
    }
    
    /**
     * Create data for triggering a social action - pinterest pin
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function pinterestPin()
    {
        return array(
            'customer_id'  => $this->getHelper()->loadRandomCustomer()->getId(),
            'extra'     => $this->getGenerator()->generatePassword(),
            'action'    => 'pinterest_pin'
        );
    }
    
    /**
     * Create data for triggering a social action - share a purchase on facebook
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
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
    
    /**
     * Create data for triggering a social action - share a purchase on twitter
     * 
     * @param array $data
     * @see ST_Automation_Model_Cron::run()
     */
    public function sharePurchaseOnTwitter()
    {
        $data = $this->sharePurchaseOnFacebook();
        $data['action'] = 'twitter_tweet_purchase';
        
        return $data;
    }
}
