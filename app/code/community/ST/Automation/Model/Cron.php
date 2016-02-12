<?php

/**
 * Cron Entry point - Execute a random action
 *
 * @category   ST
 * @package    ST_Automation
 * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class ST_Automation_Model_Cron extends Varien_Object
{
    /**
     * Possible actions with weighted probability
     * @var array
     */
    protected $weightMap = array(
        'newCustomerSignUp'                         => 2,
        'newCustomerSignUpFromReferral'             => 3,
        'newCustomerSignUpFromRepeatedReferral'     => 3,
        'placeOrder'                                => 5,
        'placeOrderWithPoints'                      => 7,
        'placeRepeatOrderWithPoints'                => 7,        
        'placeReferrerOrderWithPoints'              => 8,        
        'placeOrderWithPointsAndCancel'             => 1,        
        'reviewProduct'                             => 5,
        'tagProduct'                                => 5,
        'voteInPoll'                                => 2,
        'sendProductToFriend'                       => 2,        
        'signUpForNewsletter'                       => 5,
        'shareReferralLink'                         => 5,
        'twitterFollow'                             => 5,
        'facebookLike'                              => 5,
        'facebookShare'                             => 5,
        'twitterTweet'                              => 5,
        'googlePlusone'                             => 5,
        'pinterestPin'                              => 5,
        'sharePurchaseOnFacebook'                   => 5,
        'sharePurchaseOnTwitter'                    => 5
    );
    
    /**
     * Cron entry point - will execute a random action
     */
    public function run()
    {
        $helper = Mage::helper('st_automation');
        Mage::app()->setCurrentStore($helper->getDefaultStoreId());
        
        try {
            $method = $this->getRandomAction();
            $helper->log("Executing '$method'");
            
            $dataModel = Mage::getSingleton('st_automation/data');
            $data = $dataModel->$method();

            $this->updateCustomerSession($data);
            
            $executorModel = Mage::getSingleton('st_automation/executor');
            $executorModel->$method($data);
        } catch (Exception $e) {
            $helper->log($e->getMessage());
        }
    }
    
    /**
     * Generate a random action to perform (each action has a different probability)
     * 
     * @return string (method name)
     * @see self::weightMap for possible methods and their weight
     */
    public function getRandomAction()
    {
        $randomValue = rand(1, 100);
        $currentValue = 0;
        
        foreach ($this->weightMap as $key => $weight) {
            $currentValue += $weight;
            if ($currentValue >= $randomValue) {
                return $key;
            }
        }
    }
    
    /**
     * Set the customer session to make it look like someone is logged in.
     * We need this because transfers are not created if nobody is logged in.
     * 
     * @param array $data
     * @return boolean
     */
    public function updateCustomerSession($data)
    {
        // Check if there is any customer data in the input
        $key = 'customer';
        
        if (!isset($data[$key])) {
            $key = 'customer_id';
        }
        
        if (!isset($data[$key])) {
            return false;
        }
        
        $customer = $data[$key];
        if (!is_object($customer)) {
            $customer = Mage::getModel('customer/customer')->load($customer);
        }
        
        // Set customer session
        Mage::getSingleton('customer/session')
            ->setCustomer($customer)
            ->setCustomerAsLoggedIn($customer);
        
        // Save login event in customer log (needed for the inactivity milestone)
        $storeId = $helper = Mage::helper('st_automation')->getDefaultStoreId();
        Mage::getModel('log/customer')
            ->setCustomerId($customer->getId())
            ->setStoreId($storeId)
            ->save();
        
        return true;
    }
}