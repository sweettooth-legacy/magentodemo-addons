<?php

require_once 'abstract.php';
 
class TBT_Shell_Platform_DummyOrder extends Mage_Shell_Abstract
{
    protected $websiteId = 1;
    protected $productsCount;
    protected $minimumNumberOfProducts = 1;
    protected $maximumNumberOfProducts = 3;
    
    protected $spending;
    
    protected $customer;
    protected $products = array();
    protected $storeId;
    protected $quote;
    protected $order;
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->spending = $this->getArg('add-spending');
        
        $email = $this->getArg('customer-email');
        $customerId = $this->getArg('customer-id');
        
        if ($email) {
            $this->customer = Mage::getModel('customer/customer')
                ->setWebsiteId($this->websiteId)
                ->loadByEmail($email);
        } elseif ($customerId) {
            $this->customer = Mage::getModel('customer/customer')->load($customerId);
        }
        
        if (($email || $customerId) && (!$this->customer || !$this->customer->getId())) {
            die($this->formatError('Customer Not Found!'));
        }
        
        $products = $this->getArg('products');
        if ($products) {
            $products = explode(',', $products);
            foreach ($products as $productId) {
                $product = Mage::getModel('catalog/product')->load($productId);
                
                if (!$product->getId()) {
                    $message = "No product was foudn with the following id: {$productId}";
                    die($this->formatError($message));
                }
                
                $this->products[] = $product;
            }
        } else {
            $this->productsCount = $this->getArg('products-count');
            
            if (!$this->productsCount) {
                $this->productsCount = rand($this->minimumNumberOfProducts, $this->maximumNumberOfProducts);
            }
        }
    }
 
    // Shell script entry point
    public function run() 
    {
        if (!$this->customer) {
            $this->customer = $this->loadRandomCustomer();
        }
        
        if (empty($this->products)) {
            $count = 0;
            while ($count < $this->productsCount) {
                $count++;
                $this->products[] = $this->loadRandomProduct();
            }
        }
        
        $this->storeId = $this->setDefaultStoreId();
        $this->quote = $this->initQuote();
        
        $this->populateQuote();
        $this->createOrder();
        $this->addRewardPoints();
    }
    
    public function formatError($message) 
    {
        return "\033[31m$message \033[0m" . PHP_EOL;
    }
    
    /**
     * Load a random product
     * 
     * @param string $skuPattern
     * @return Mage_Catalog_Model_Product
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
            
            die($this->formatError($errorMessage));
        }
        
        $firstResult = $products->getFirstItem();
        $product = Mage::getModel('catalog/product')->load($firstResult->getId());
        return $product;
    }
    
    /**
     * Load a random customer
     * @return Mage_Customer_Model_Customer
     */
    protected function loadRandomCustomer()
    {
        $customers = Mage::getModel('customer/customer')->getCollection();
        $customers->setPageSize(1);
        $customers->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        $customer = $customers->getFirstItem()->load();
        return $customer;
    }
    
    protected function setDefaultStoreId()
    {
        return Mage::app()
            ->getWebsite(true)
            ->getDefaultGroup()
            ->getDefaultStoreId();
    }
    
    protected function initQuote()
    {
        $quote = Mage::getModel('sales/quote');
        $quote->assignCustomer($this->customer);
        
        $store = $quote->getStore()->load($this->storeId);
        $quote->setStore($store);
        
        return $quote;
    }
    
    protected function populateQuote()
    {
        $this->addProductsToQuote();
        $this->setQuoteAddresses();
        $this->setShippingMethod();
        $this->setPaymentMethod();
        
        $this->quote->collectTotals()->save();
    }
    
    protected function addProductsToQuote()
    {
        foreach ($this->products as $product) {
            $param = array(
                'product' => $product->getId(),
                'qty' => 1,
            );

            $request = new Varien_Object();
            $request->setData($param);

            $quoteItem = $this->quote->addProduct($product, $request);
            if (is_string($quoteItem)) {
                die($this->formatError(sprintf("Error: $quoteItem")));
            }

            $quoteItem->setQuote($this->quote);
            $quoteItem->checkData();
        }
        
        return $this;
    }
    
    protected function setQuoteAddresses()
    {
        $defaultAddress = $this->getDefaultAddress();

        $billingAddress = new Mage_Sales_Model_Quote_Address();
        $billingAddress->importCustomerAddress($defaultAddress);
        $this->quote->setBillingAddress($billingAddress);
        
        $shippingAddress = new Mage_Sales_Model_Quote_Address();
        $shippingAddress->importCustomerAddress($defaultAddress);
        $this->quote->setShippingAddress($shippingAddress);
        
        return $this;
    }
    
    protected function getDefaultAddress()
    {
        $data = array (
            'firstname' => $this->customer->getData('firstname'),
            'lastname' => $this->customer->getData('lastname'),
            'street' => array (
                '0' => '123 Whatever Road',
            ),
            'city' => 'San Francisco',
            'region_id' => '12',
            'region' => 'California',
            'postcode' => '91201',
            'country_id' => 'US',
            'telephone' => '888 888 8888',
        );
        $address = Mage::getModel('customer/address')->setData($data);
        return $address;
    }
    
    protected function setShippingMethod()
    {
        $this->quote->getShippingAddress()
            ->setShippingMethod('flatrate_flatrate')
            ->setCollectShippingRates(true)
            ->collectShippingRates();
        
        return $this;
    }
    
    protected function setPaymentMethod()
    {
        $quotePayment = $this->quote->getPayment();
        $quotePayment->setMethod('checkmo');
        $this->quote->setPayment($quotePayment);
        
        return $this;
    }
    
    protected function addRewardPoints()
    {
        if ($this->spending) {
            $rule = Mage::getModel('rewards/salesrule_rule')->getResourceCollection()
                ->addFieldToFilter("points_action", array('IN' => 'discount_by_points_spent'))
                ->getFirstItem();

            if (!$rule->getId()) {
                echo $this->formatError('No spending rule found');
            } else {
                Mage::helper('rewards/transfer')->transferOrderPoints(-$this->spending, 1, $this->order->getId(), $rule->getId());
        
                Mage::getSingleton('index/indexer')->processEntityAction(
                    Mage::getModel('rewards/customer')->load($this->customer->getId()), 
                    TBT_Rewards_Model_Customer_Indexer_Observer::REWARDS_CUSTOMER_ENTITY, 
                    Mage_Index_Model_Event::TYPE_SAVE
                );
            }
        }
    }
    
    protected function createOrder()
    {
        $service = Mage::getModel('sales/service_quote', $this->quote);
        $order = $service->submitOrder();
        $order->save();
        
        $this->order = $order;
    }
    
    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
    Usage:  php -f dummyOrder.php -- [options]

    \033[32m CUSTOMER INFORMATION (WILL LOAD A RANDOM CUTSOMER IF NONE SPECIFIED) \033[0m
    --customer-email                Load customer by email (optional)
    --customer-id                   Load customer by id (optional)
    
    \033[32m PRODUCTS INFORMATION (WILL ADD RANDOM PRODUCTS IF NONE SPECIFIED) \033[0m
    --products <string>             Simple products that will be added to the order (use comma sepparated id's)
    --products-count <int>          Will add a number of random products equal to this value (not used if id's are specified) 
        
    \033[32m POINT ACTIONS \033[0m
    --add-spending <int>        Spend points on this order (needs a slider rule to work)
    \n
USAGE;
    }
}

// Instantiate
$shell = new TBT_Shell_Platform_DummyOrder();
 
// Initiate script
$shell->run();