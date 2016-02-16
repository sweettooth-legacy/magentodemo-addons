<?php

require_once 'abstract.php';
 
class TBT_Shell_Sign_Up extends Mage_Shell_Abstract
{
     /**
     * mode 0 - new sign up - no referral
     * mode 1 - new sign up - first referral
     * mode 2 - new sign up - repeated referral
     * 
     * @var int
     */
    protected $mode;
    
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $referral;
    
    protected $websiteId = 1;
    protected $storeId = 1;
    protected $password = 'st_test';
 
    public function __construct() 
    {
        parent::__construct();
 
        $this->firstname = $this->getArg('firstname');
        $this->lastname = $this->getArg('lastname');
        $this->email = $this->getArg('email');
        $this->referral = $this->getArg('referral');
        $this->mode = (int) $this->getArg('mode');
        
        $password = $this->getArg('password');
        if ($password) {
            $this->password = $password;
        }
        
        $websiteId = $this->getArg('website-id');
        if ($websiteId) {
            $this->websiteId = $websiteId;
        }
        
        $storeId = $this->getArg('store-id');
        if ($storeId) {
            $this->storeId = $storeId;
        }
        
        if (!$this->firstname) {
            die($this->formatError('No firstname provided'));
        }
        
        if (!$this->lastname) {
            die($this->formatError('No lastname provided'));
        }
        
        if (!$this->email) {
            die($this->formatError('No email provided'));
        }
        
        if (!$this->referral) {
            switch ($this->mode) {
                case 1:
                    $this->referral = $this->loadRandomCustomer()->getEmail();
                    break;
                case 2:
                    $this->referral = $this->loadRandomAffiliate()->getEmail();
                    break;
            }
        }
    }
    
    protected function loadRandomCustomer()
    {
        $customers = Mage::getModel('customer/customer')->getCollection();
        $customers->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        $customer = $customers->getFirstItem()->load();
        return $customer;
    }
    
    protected function loadRandomAffiliate()
    {
        $affiliates = Mage::getModel('rewardsred/referral')->getCollection();
        $affiliates->setPageSize(1);
        $affiliates->getSelect()->order(new Zend_Db_Expr('RAND()'));

        if ($affiliates->getSize()) {
            $affiliate = $affiliates->getFirstItem()->load();
            $customerId = $affiliate->getReferralParentId();
            return Mage::getModel('customer/customer')->load($customerId);
        } else {
            return new Varien_Object();
        }
    }
        
    public function formatError($message) 
    {
        return "\033[31m$message \033[0m" . PHP_EOL;
    }
 
    // Shell script point of entry
    public function run() 
    {
        Mage::app()->setCurrentStore($this->storeId);
        
        $store = Mage::getModel('core/store')->load($this->storeId);
        $birthDate = date("Y-m-d", strtotime("+1 month"));
        
        $customer = Mage::getModel("customer/customer");
        $customer->setWebsiteId($this->websiteId)
            ->setStore($store)
            ->setFirstname($this->firstname)
            ->setLastname($this->lastname)
            ->setEmail($this->email)
            ->setPassword($this->password)
            ->setDob($birthDate);
        
        if ($this->mode !== 0 && $this->referral) {
            $customer->setRewardsReferral($this->referral);
            Mage::getModel('rewardsref/observer_createaccount')->attemptReferralCheck(null, null, $customer->getData());
        }
        
        $customer->save();
    }
    
    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
    Usage:  php -f signUp.php -- [options]

    \033[32mREQUIRED \033[0m
    --firstname <string>        Customer's first name
    --password <string>         Customer's last name
    --email <string>            Customer's email address
        
    \033[32mOPTIONAL \033[0m
    --referral <string>         Referrrer's email address (will add random email otherwise)
    --mode <int>                0 - no referral, 1 - new referral, 2 - repeated referral (default is 0)
    --password <string>         Default is "st_test"
    --website-id <int>          Default is 1
    --store-id <int>            Default is 1
    \n
USAGE;
    }
}

// Instantiate
$shell = new TBT_Shell_Sign_Up();
 
// Initiate script
$shell->run();