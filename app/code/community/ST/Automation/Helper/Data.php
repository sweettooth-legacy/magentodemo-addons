<?php

class ST_Automation_Helper_Data extends Mage_Core_Helper_Abstract
{
    const LOG_FILE = 'automation.log';
    
    public function log($message) 
    {
        Mage::log($message, null, self::LOG_FILE);
    }
    
    public function loadRandomCustomer()
    {
        $customers = Mage::getModel('customer/customer')->getCollection();
        $customers->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        return $customers->getFirstItem();
    }
    
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
            return new Varien_Object();
        }
    }
    
    public function loadRandomCustomerWithPoints()
    {
        $customers = Mage::getModel('rewards/customer_indexer_points')->getCollection()
            ->addFieldToFilter('customer_points_usable', array('gt' => 0))
            ->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        if ($customers->getSize()) {
            $customer = $customers->getFirstItem();
            $customerId = $customer->getCustomerId();
            
            return Mage::getModel('customer/customer')
                ->load($customerId)
                ->setRewardsPointsBalance($customer->getCustomerPointsUsable());
        } else {
            return new Varien_Object();
        }
    }
    
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
            $customer = $customers->getFirstItem()->load();
            $customerId = $customer->getCustomerId();
            
            return Mage::getModel('customer/customer')
                ->load($customerId)
                ->setRewardsPointsBalance($customer->getCustomerPointsUsable());
        } else {
            return new Varien_Object();
        }
    }
    
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
                ->load($customerId)
                ->setRewardsPointsBalance($customer->getCustomerPointsUsable());
        } else {
            return new Varien_Object();
        }
    }
    
    public function getDefaultWebsiteId()
    {
        return Mage::app()
            ->getWebsite(true)
            ->getId();
    }
    
    public function getDefaultStoreId()
    {
        return Mage::app()
            ->getWebsite(true)
            ->getDefaultGroup()
            ->getDefaultStoreId();
    }
    
    public function getDefaultStore()
    {
        return Mage::getModel('core/store')->load($this->getDefaultStoreId());
    }
    
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
    
    public function loadRandomPoll()
    {
        $pools = Mage::getModel('poll/poll')->getCollection();
        $pools->addFieldToFilter('active', 1);
        $pools->setPageSize(1);
        $pools->getSelect()->order(new Zend_Db_Expr('RAND()'));

        if ($pools->getSize()) {
            return $pools->getFirstItem();
        } else {
            return new Varien_Object();
        }
    }
}
