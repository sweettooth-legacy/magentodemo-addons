<?php

/**
 * Automation Base Helper - Fetch random entries
 *
 * @category   ST
 * @package    ST_Automation
 * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class ST_Automation_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Automation log file name
     */
    const LOG_FILE = 'automation.log';
    
    /**
     * Log message to automation log file
     * @param string $message
     */
    public function log($message) 
    {
        Mage::log($message, null, self::LOG_FILE);
    }
    
    /**
     * Load a random customer
     * @return Mage_Customer_Model_Customer
     */
    public function loadRandomCustomer()
    {
        $customers = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect(array('firstname', 'lastname'))
            ->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        return $customers->getFirstItem();
    }
    
    /**
     * Load a random customer that was referred
     * @return Mage_Customer_Model_Customer
     */
    public function loadRandomAffiliate()
    {
        $affiliates = Mage::getModel('rewardsref/referral')->getCollection();
        $affiliates->setPageSize(1);
        $affiliates->getSelect()->order(new Zend_Db_Expr('RAND()'));

        if ($affiliates->getSize()) {
            $affiliate = $affiliates->getFirstItem();
            $customerId = $affiliate->getReferralParentId();
            return Mage::getModel('customer/customer')->load($customerId);
        } else {
            return Mage::getModel('customer/customer');
        }
    }
    
    /**
     * Load a random customer that has points to spend
     * @return Mage_Customer_Model_Customer
     */
    public function loadRandomCustomerWithPoints()
    {
        // Make sure customer points are up to day
        if (!Mage::helper('rewards/customer_points_index')->isUpToDate()) {
            Mage::getResourceModel('rewards/customer_indexer_points')->reindexAll();
        }
        
        $customers = Mage::getModel('rewards/customer_indexer_points')->getCollection()
            ->addFieldToFilter('customer_points_usable', array('gt' => 0))
            ->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        if ($customers->getSize()) {
            $customer = $customers->getFirstItem();
            $customerId = $customer->getCustomerId();
            
            return Mage::getModel('customer/customer')
                ->setIndexedPoints($customer->getCustomerPointsUsable())
                ->load($customerId);
        } else {
            return Mage::getModel('customer/customer');
        }
    }
    
    /**
     * Load random customer that has points to spend and previous orders
     * @return Mage_Customer_Model_Customer
     */
    public function loadRandomCustomerWithPoinsAndOrders()
    {
        $ordersCollection = Mage::getModel('sales/order')->getCollection();
        $ordersCollection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(new Zend_Db_Expr('DISTINCT customer_id'))
            ->where(new Zend_Db_Expr('customer_id IS NOT NULL'));
        
        $customersWithOrders = array();
        foreach ($ordersCollection as $order) {
            $customersWithOrders[] = $order->getCustomerId();
        }
        
        $customers = Mage::getModel('rewards/customer_indexer_points')->getCollection()
            ->addFieldToFilter('customer_points_usable', array('gt' => 0))
            ->addFieldToFilter('customer_id', array('in' => implode(',', $customersWithOrders)))
            ->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        if ($customers->getSize()) {
            $customer = $customers->getFirstItem();
            $customerId = $customer->getCustomerId();
            
            return Mage::getModel('customer/customer')
                ->setIndexedPoints($customer->getCustomerPointsUsable())
                ->load($customerId);
        } else {
            return Mage::getModel('customer/customer');
        }
    }
    
    /**
     * Load a random customer that has points to spend and was referred
     * @return Mage_Customer_Model_Customer
     */
    public function loadRandomReferredCustomerWithPoins()
    {
        $referralsCollection = Mage::getModel('rewardsref/referral')->getCollection();
        $referralsCollection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns('referral_child_id')
            ->where(new Zend_Db_Expr('referral_child_id IS NOT NULL'));
        
        $referredCustomers = array();
        foreach ($referralsCollection as $referral) {
            $referredCustomers[] = $referral->getReferralChildId();
        }
        
        $customers = Mage::getModel('rewards/customer_indexer_points')->getCollection()
            ->addFieldToFilter('customer_points_usable', array('gt' => 0))
            ->addFieldToFilter('customer_id', array('in' => implode(',', $referredCustomers)))
            ->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        if ($customers->getSize()) {
            $customer = $customers->getFirstItem();
            $customerId = $customer->getCustomerId();
            
            return Mage::getModel('customer/customer')
                ->setIndexedPoints($customer->getCustomerPointsUsable())
                ->load($customerId);
        } else {
            return Mage::getModel('customer/customer');
        }
    }
    
    /**
     * Fetch the default website id (usually 1)
     * @return int
     */
    public function getDefaultWebsiteId()
    {
        return Mage::app()
            ->getWebsite(true)
            ->getId();
    }
    
    /**
     * Fetch the default store id (usually 1)
     * @return int
     */
    public function getDefaultStoreId()
    {
        return Mage::app()
            ->getWebsite(true)
            ->getDefaultGroup()
            ->getDefaultStoreId();
    }
    
    /**
     * Fetch the default store
     * @return Mage_Core_Model_Store
     */
    public function getDefaultStore()
    {
        return Mage::getModel('core/store')->load($this->getDefaultStoreId());
    }
    
    /**
     * Load a random simple product that has stock and is saleable
     * 
     * @param string $skuPattern
     * @return Mage_Catalog_Model_Product
     */
    public function loadRandomProduct($skuPattern = null)
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
            
            die($this->formatError($errorMessage));
        }
        
        $firstResult = $products->getFirstItem();
        $product = Mage::getModel('catalog/product')->load($firstResult->getId());
        return $product;
    }
    
    /**
     * Load a random poll
     * @return Mage_Poll_Model_Poll
     */
    public function loadRandomPoll()
    {
        $polls = Mage::getModel('poll/poll')->getCollection();
        $polls->addFieldToFilter('active', 1);
        $polls->setPageSize(1);
        $polls->getSelect()->order(new Zend_Db_Expr('RAND()'));

        if ($polls->getSize()) {
            return $polls->getFirstItem();
        } else {
            return Mage::getModel('poll/poll');
        }
    }
}
