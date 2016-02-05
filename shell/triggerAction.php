<?php

require_once 'abstract.php';
 
class TBT_Shell_Trigger_Actions extends Mage_Shell_Abstract
{
    protected $customer;
    
    protected $websiteId = 1;
    
    protected $rulesMap = array(
        'sign-up'                   => false,
        'review'                    => false,
        'tag'                       => false,
        'newsletter'                => false,
        'share-referral-link'       => false,
        'facebook-like'             => false,
        'twitter-tweet'             => false,
        'google-plusone'            => false,
        'pinterest-pin'             => false,
        'twitter-follow'            => false,
        'facebook-share'            => false,
        'share-purchase-facebook'   => false,
        'share-purchase-twitter'    => false
    );
    
    public function __construct() 
    {
        parent::__construct();
        
        $email = $this->getArg('customer-email');
        $customerId = $this->getArg('customer-id');
        
        if ($email) {
            $this->customer = Mage::getModel('customer/customer')
                ->setWebsiteId($this->websiteId)
                ->loadByEmail($email);
        } elseif ($customerId) {
            $this->customer = Mage::getModel('customer/customer')->load($customerId);
        } else {
            die($this->formatError('No customer specified.'));
        }
        
        if (!$this->customer || !$this->customer->getId()) {
            die($this->formatError('Customer Not Found!'));
        }
        
        $hasAction = false;
        foreach ($this->_args as $key => $value) {
            if (array_key_exists($key, $this->rulesMap)) {
                $this->rulesMap[$key] = true;
                $hasAction = true;
            }
        }
        
        if (!$hasAction) {
            die($this->formatError('No action specified.'));
        }
    }
    
    public function formatError($message) 
    {
        return "\033[31m$message \033[0m" . PHP_EOL;
    }

    // Shell script point of entry
    public function run() 
    {
        $session = Mage::getSingleton('customer/session')
            ->setCustomer($this->customer)
            ->setCustomerAsLoggedIn($this->customer);

        $storeId = Mage::app()
            ->getWebsite()
            ->getDefaultGroup()
            ->getDefaultStoreId();
        
        if ($this->rulesMap['sign-up']) {
            $ruleCollection = Mage::getSingleton('rewards/special_validator')->getApplicableRulesOnSignup();
            
            foreach ($ruleCollection as $rule) {
                Mage::helper('rewards/transfer')->transferSignupPoints(
                    $rule->getPointsAmount(), 
                    $rule->getPointsCurrencyId(), 
                    $this->customer->getId(), 
                    $rule
                );
            }
        }
        
        if ($this->rulesMap['review']) {
            $product = $this->loadRandomProduct();
            
            $review = Mage::getModel('review/review')
                ->setEntityPkValue($product->getId())
                ->setStatusId(1)
                ->setTitle('Automatically Created Review')
                ->setDetail('Automatically Created Review')
                ->setEntityId(1)
                ->setStoreId($storeId)
                ->setStores(array($storeId))
                ->setCustomerId($this->customer->getId())
                ->setNickname('automatic')
                ->save();
            
            $ratingOptions = array(
                1 => array(1, 2, 3, 4, 5),
                2 => array(6, 7, 8, 9, 10),
                3 => array(11, 12, 13, 14, 15)
            );
            
            foreach ($ratingOptions as $ratingId => $optionIds) {
                Mage::getModel('rating/rating')
                    ->setRatingId($ratingId)
                    ->setReviewId($review->getId())
                    ->setCustomerId($this->customer->getId())
                    ->addOptionVote($optionIds[array_rand($optionIds)], $product->getId());
            }
            
            $review->aggregate();
            
            $ruleCollection = Mage::getSingleton('rewards/review_validator')->getApplicableRulesOnReview();
            foreach ($ruleCollection as $rule) {
                Mage::getModel('rewards/review_transfer')->transferReviewPoints($review, $rule);
            }
        }
        
        if ($this->rulesMap['tag']) {
            $product = $this->loadRandomProduct();
            $tagName = substr(md5(rand()), 0, 9);

            try {
                $tagModel = Mage::getModel('tag/tag')->loadByName($tagName);
                if (!$tagModel->getId()) {
                    $tagModel->setName($tagName)
                        ->setFirstCustomerId($this->customer->getId())
                        ->setFirstStoreId($storeId)
                        ->setStatus($tagModel->getApprovedStatus())
                        ->save();
                }
                
                $tagModel->saveRelation(
                    $product->getId(), 
                    $this->customer->getId(), 
                    $storeId
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $session->addError($this->__('Unable to save tag(s).'));
            }
        }
        
        if ($this->rulesMap['newsletter']) {
            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($this->customer->getEmail());
            
            if (
                !$subscriber->getId()
                || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED
                || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE
            ) {
                $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
                $subscriber->setSubscriberEmail($this->customer->getEmail());
                $subscriber->setSubscriberConfirmCode($subscriber->RandomSequence());
            }
            
            $subscriber->setStoreId($storeId);
            $subscriber->setCustomerId($this->customer->getId());
            $subscriber->save();
        }
        
        if ($this->rulesMap['share-referral-link']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('facebook_share_referral')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }
        
        if ($this->rulesMap['facebook-like']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('facebook_like')
                ->setExtra('http://automaticallycreated.transfer/')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }

        if ($this->rulesMap['twitter-tweet']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('twitter_tweet')
                ->setExtra('http://automaticallycreated.transfer/')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }

        if ($this->rulesMap['google-plusone']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('google_plusone')
                ->setExtra('http://automaticallycreated.transfer/')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }

        if ($this->rulesMap['pinterest-pin']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('pinterest_pin')
                ->setExtra('http://automaticallycreated.transfer/')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }
        
        if ($this->rulesMap['twitter-follow']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('twitter_follow')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }
        
        if ($this->rulesMap['facebook-share']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('facebook_share')
                ->setExtra('http://automaticallycreated.transfer/')
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }
        
        $extra = array(
            'product' => 'sample',
            'order' => 'sample'
        );
        
        if ($this->rulesMap['share-purchase-facebook']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('facebook_share_purchase')
                ->setExtra(json_encode($extra))
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }
        
        if ($this->rulesMap['share-purchase-twitter']) {
            $actionModel = Mage::getModel('rewardssocial2/action')
                ->setCustomerId($this->customer->getId())
                ->setAction('twitter_tweet_purchase')
                ->setExtra(json_encode($extra))
                ->save();

            Mage::getModel('rewardssocial2/transfer')->initiateTransfers($actionModel);
        }
    }
    
    /**
     * Load a random product
     * 
     * @param string $skuPattern
     * @return Mage_Catalog_Model_Product
     * @throws Exception
     */
    protected function loadRandomProduct($skuPattern = null)
    {
        $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);

        $products->setPageSize(1);
        $products->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        if ($skuPattern) {
            $products->getSelect()->where('sku LIKE %?%', $skuPattern);
        }
        
        $productStatus = Mage::getModel('catalog/product_status');
        $productStatus->addSaleableFilterToCollection($products);
        
        $stock = Mage::getModel('cataloginventory/stock');
        $stock->addInStockFilterToCollection($products);
        
        if (!$products->getSize()) {
            $errorMessage = 'No products are matching the criteria';
            if ($skuPattern) {
                $errorMessage .= " ($skuPattern)";
            }
            throw new Exception($errorMessage);
        }
        
        $firstResult = $products->getFirstItem();
        $product = Mage::getModel('catalog/product')->load($firstResult->getId());
        return $product;
    }
    
    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
    Usage:  php -f triggerAction.php -- [options]

    \033[32m CUSTOMER INFORMATION (ONE IS REQUIRED) \033[0m
    --customer-email                 Load customer by email
    --customer-id                    Load customer by id
        
    \033[32m ACTION TO TRIGGER (AT LEAST ONE IS REQUIRED) \033[0m
    --sign-up                        Trigger customer sign up behavior
    --review                         Create a review for a random product
    --tag                            Add a tag to a random product
    --newsletter                     Subscribe the customer to the newsletter
    --share-referral-link            Trigger referral share action
    --facebook-like                  Trigger facebook like
    --twitter-tweet                  Trigger twitter tweet
    --google-plusone                 Trigger google +1
    --pinterest-pin                  Trigger pinterest pin
    --twitter-follow                 Trigger twitter follow
    --facebook-share                 Trigger facebook share
    --share-purchase-facebook        Trigger purchase share on facebook
    --share-purchase-twitter         Trigger purchase share on twitter
    \n
USAGE;
    }
}

// Instantiate
$shell = new TBT_Shell_Trigger_Actions();
 
// Initiate script
$shell->run();