<?php

require_once 'abstract.php';
 
class TBT_Shell_Create_Rules extends Mage_Shell_Abstract
{
    protected $rulesMap = array(
        // cart rules
        'cart-earning'              => false,
        'cart-spending-slider'      => false,
        'cart-spending-checkbox'    => false,
        
        // catalog rules
        'catalog-earning'           => false,
        'catalog-spending'          => false,
        'points-only'               => false,
        
        // basic behavior rules
        'sign-up'                   => false,
        'review'                    => false,
        'tag'                       => false,
        'newsletter'                => false,
        
        // milestone rules
        'birthday'                  => false,
        'milestone-order'           => false,
        'milestone-revenue'         => false,
        'milestone-referrals'       => false,
        'milestone-points'          => false,
        'inactivity'                => false,
        
        // referral rules
        'referral-sign-up'          => false,
        'referral-first-order'      => false,
        'referral-any-order'        => false,
        
        // social rules
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
        
        if (empty($this->_args)) {
            die($this->usageHelp());
        }
        
        if ($this->getArg('add-all')) {
            $this->addAllRules();
        } else {
            foreach ($this->_args as $key => $value) {
                if (array_key_exists($key, $this->rulesMap)) {
                    $this->rulesMap[$key] = true;
                }
            }
        }
    }
    
    public function addAllRules()
    {
        foreach ($this->rulesMap as $key => $value) {
            $this->rulesMap[$key] = true;
        }
    }
    
    // Shell script point of entry
    public function run() {
        $helper = Mage::helper('rewards');

        $websites = array();
        foreach (Mage::app()->getWebsites() as $website) {
            $websites[] = $website->getId();
        }
        
        $customerGroups = Mage::getModel('customer/group')->getCollection()->getAllIds();
        
        $currencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        $currencySymbol = Mage::app()->getLocale()->currency($currencyCode)->getSymbol();
        
        // Cart Earning Ruke
        if ($this->rulesMap['cart-earning']) {
            $points = 1;
            $data = array(
                'name' => $helper->__("Shell Rule - Cart Earning - %s points = %s1", $points, $currencySymbol),
                'is_active' => 1,
                'website_ids' => $websites,
                'customer_group_ids' => $customerGroups,
                'points_action' => 'give_by_amount_spent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'points_qty_step' => 0,
                'points_max_qty' => 0,
                'stop_rules_processing' => 0
            );
            
            $model = Mage::getModel('rewards/salesrule_rule');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        // Cart Spending Rule (Slider)
        if ($this->rulesMap['cart-spending-slider']) {
            $points = 10;
            $discount = 1;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Cart Spending - Slider - %s points = %s1", $points, $currencySymbol),
                'is_active' => 1,
                'website_ids' => $websites,
                'customer_group_ids' => $customerGroups,
                'points_action' => 'discount_by_points_spent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'points_discount_action' => 'cart_fixed',
                'points_discount_amount' => $discount,
                'stop_rules_processing' => 0
            );
            
            $model = Mage::getModel('rewards/salesrule_rule');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        // Cart Spending Rule (Checkbox)
        if ($this->rulesMap['cart-spending-checkbox']) {
            $points = 100;
            $discount = 20;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Cart Spending - Checkbox - %s points = %s20", $points, $currencySymbol),
                'is_active' => 1,
                'website_ids' => $websites,
                'customer_group_ids' => $customerGroups,
                'points_action' => 'deduct_points',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'points_discount_action' => 'cart_fixed',
                'points_discount_amount' => $discount,
                'stop_rules_processing' => 0
            );
            
            $model = Mage::getModel('rewards/salesrule_rule');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        // catalog spending rule
        if ($this->rulesMap['catalog-spending']) {
            $points = 1;
            $step = 1;
            $discount = 1;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Catalog Spending - %s points = %s1", $points, $currencySymbol),
                'is_active' => 1,
                'website_ids' => $websites,
                'customer_group_ids' => $customerGroups,
                'points_only_mode' => 0,                
                'points_action' => 'deduct_points',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'points_amount_step' => $step,
                'points_catalogrule_simple_action' => 'by_fixed',
                'points_catalogrule_discount_amount' => $discount,
                'points_uses_per_product' => 0,
                'stop_rules_processing' => 0,
                'conditions' => array(
                    '1' => array(
                        'type' => 'catalogrule/rule_condition_combine',
                        'aggregator' => 'all',
                        'value' => '1',
                        'new_child' => ''
                    ),
                    '1--1' => array(
                        'type' => 'catalogrule/rule_condition_product',
                        'attribute' => 'category_ids',
                        'operator' => '==',
                        'value' => '19'
                    )
                )
            );
            
            $model = Mage::getModel('rewards/catalogrule_rule');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        // Catalog earning rule
        if ($this->rulesMap['catalog-earning']) {
            $points = 1;
            $step = 1;
            $discount = 1;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Catalog Earning - %s points = %s1", $points, $currencySymbol),
                'is_active' => 1,
                'website_ids' => $websites,
                'customer_group_ids' => $customerGroups,
                'points_action' => 'give_by_amount_spent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'points_amount_step' => $step,
                'stop_rules_processing' => 0,
                'conditions' => array(
                    '1' => array(
                        'type' => 'catalogrule/rule_condition_combine',
                        'aggregator' => 'all',
                        'value' => '1',
                        'new_child' => ''
                    ),
                    '1--1' => array(
                        'type' => 'catalogrule/rule_condition_product',
                        'attribute' => 'category_ids',
                        'operator' => '==',
                        'value' => '19'
                    )
                )
            );
            
            $model = Mage::getModel('rewards/catalogrule_rule');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        // points only rule
        if ($this->rulesMap['points-only']) {
            $points = 100;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Points Only - %s points", $points),
                'is_active' => 1,
                'website_ids' => $websites,
                'customer_group_ids' => $customerGroups,
                'points_only_mode' => 1,
                'points_action' => 'deduct_points',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'points_catalogrule_simple_action' => 'to_fixed',
                'points_catalogrule_discount_amount' => 0,
                'points_uses_per_product' => 0,
                'stop_rules_processing' => 0,
                'conditions' => array(
                    '1' => array(
                        'type' => 'catalogrule/rule_condition_combine',
                        'aggregator' => 'all',
                        'value' => '1',
                        'new_child' => ''
                    ),
                    '1--1' => array(
                        'type' => 'catalogrule/rule_condition_product',
                        'attribute' => 'category_ids',
                        'operator' => '==',
                        'value' => '18'
                    )
                )
            );
            
            $model = Mage::getModel('rewards/catalogrule_rule');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        // Apply catalog rules
        Mage::getModel('catalogrule/rule')->applyAll();
        Mage::app()->removeCache('catalog_rules_dirty');

        // Sign Up Bonus
        if ($this->rulesMap['sign-up']) {
            $points = 2000;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Sign Up - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_sign_up',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['review']) {
            $points = 5;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Review - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_writes_review',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['tag']) {
            $points = 3;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Tag - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_tag',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['newsletter']) {
            $points = 10;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Newsletter - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_newsletter',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['birthday']) {
            $points = 50;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Birthday - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_birthday',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            
            $data['rewards_special_id'] = $model->getId();
            $object = new Varien_Object();
            $object->setData($data);
            Mage::getSingleton('tbtmilestone/adapter_special')->afterSaveAction($object);
            
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['milestone-order']) {
            $points = 80;
            $orders = 3;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Milestone Orders - %s orders = %s points", $orders, $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'tbtmilestone_orders',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'tbtmilestone_orders' => $orders,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            
            $data['rewards_special_id'] = $model->getId();
            $object = new Varien_Object();
            $object->setData($data);
            Mage::getSingleton('tbtmilestone/adapter_special')->afterSaveAction($object);

            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['milestone-revenue']) {
            $points = 100;
            $revenue = 1000;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Milestone Revenue - $%s = %s points", $revenue, $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'tbtmilestone_revenue',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'tbtmilestone_revenue' => $revenue,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            
            $data['rewards_special_id'] = $model->getId();
            $object = new Varien_Object();
            $object->setData($data);
            Mage::getSingleton('tbtmilestone/adapter_special')->afterSaveAction($object);
            
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['milestone-referrals']) {
            $points = 150;
            $referrals = 5;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Milestone Referrals - %s referrals = %s points", $referrals, $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'tbtmilestone_referrals',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'tbtmilestone_referrals' => $referrals,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            
            $data['rewards_special_id'] = $model->getId();
            $object = new Varien_Object();
            $object->setData($data);
            Mage::getSingleton('tbtmilestone/adapter_special')->afterSaveAction($object);
            
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['milestone-points']) {
            $points = 500;
            $totalPoints = 10000;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Milestone Points - %s points = %s points", $totalPoints, $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'tbtmilestone_points_earned',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'tbtmilestone_points_earned' => $totalPoints,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            
            $data['rewards_special_id'] = $model->getId();
            $object = new Varien_Object();
            $object->setData($data);
            Mage::getSingleton('tbtmilestone/adapter_special')->afterSaveAction($object);
            
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['inactivity']) {
            $points = 200;
            $inactivity = 7;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Milestone Inactivity - %s days = %s points", $inactivity, $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'tbtmilestone_inactivity',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'tbtmilestone_inactivity' => $inactivity,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            
            $data['rewards_special_id'] = $model->getId();
            $object = new Varien_Object();
            $object->setData($data);
            Mage::getSingleton('tbtmilestone/adapter_special')->afterSaveAction($object);
            
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['referral-sign-up']) {
            $points = 20;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Referral Sign Up - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_referral_signup',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['referral-first-order']) {
            $points = 150;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Referral First Order - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_referral_firstorder',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['referral-any-order']) {
            $points = 50;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Referral Any Order - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'customer_referral_order',
                'points_action' => 'grant_points',
                'simple_action' => 'by_fixed',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['share-referral-link']) {
            $points = 2;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Referral Share - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_referral_share',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['facebook-like']) {
            $points = 3;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Facebook Like - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_facebook_like',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['twitter-tweet']) {
            $points = 4;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Twitter Tweet - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_twitter_tweet',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['google-plusone']) {
            $points = 5;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Socil Google PlusOne - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_google_plusOne',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['pinterest-pin']) {
            $points = 6;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Pinterest Pin - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_pinterest_pin',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['twitter-follow']) {
            $points = 7;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Twitter Follow - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_twitter_follow',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['facebook-share']) {
            $points = 8;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Facebook Share - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_facebook_share',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['share-purchase-facebook']) {
            $points = 9;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Purchase Share Facebook - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_purchase_share_facebook',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
        
        if ($this->rulesMap['share-purchase-twitter']) {
            $points = 9;
            
            $data = array(
                'name' => $helper->__("Shell Rule - Social Purchase Share Twitter - %s points", $points),
                'is_active' => 1,
                'website_ids' => implode(',', $websites),
                'customer_group_ids' => implode(',', $customerGroups),
                'points_conditions' => 'social_purchase_share_twitter',
                'points_action' => 'grant_points',
                'simple_action' => 'by_percent',
                'points_currency_id' => 1,
                'points_amount' => $points,
                'is_onhold_enabled' => 0,
                'onhold_duration' => 0
            );
            
            $model = Mage::getModel('rewards/special');
            $model->loadPost($data);
            Mage::getSingleton('adminhtml/session')->setPageData($model->getData());
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->setPageData(false);
        }
    }
    
    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
    Usage:  php -f createRules.php -- [options]

    \033[32m ADD ALL RULES \033[0m
    --add-all                        Will create all available rules
    
    \033[32m CART RULES \033[0m
    --cart-earning                   Creates a cart earning rule
    --cart-spending-slider           Creates a cart spending rule (slider)
    --cart-spending-checkbox         Creates a cart spending rule (checkbox)
        
    \033[32m CATALOG RULES \033[0m
    --catalog-earning                Creates a catalog earning rule
    --catalog-spending               Creates a catalog spending rule
    --points-only                    Creates a catalog points only rule
        
    \033[32m BASIC BEHAVIOR RULES \033[0m
    --sign-up                        Creates a sign up rule
    --review                         Creates a rule that will reward writing reviews
    --tag                            Creates a rule that will reward adding tags
    --newsletter                     Will reward subscriptins to the newsletter
        
    \033[32m MILESTONE RULES \033[0m
    --birthday                       Will reward points on the customers birthday
    --milestone-order                Will reward customers after a number of completed orders
    --milestone-revenue              Rewards for reaching milestone for revenue produced
    --milestone-referrals            Rewards after bringing a certain number of referrals
    --milestone-points               Rewards after reaching a number of loyalty points
    --inactivity                     Triggered after an inactivity period
        
    \033[32m REFERRAL RULES \033[0m
    --referral-sign-up               Triggered when a referral signs up
    --referral-first-order           Triggered when a referral makes the first order
    --referral-any-order             Triggered when a referral makes any order
        
    \033[32m SOCIAL RULES \033[0m
    --share-referral-link            Triggered when you share your referral link
    --facebook-like                  Triggered when after you like a page on facebook
    --twitter-tweet                  Triggered when after you tweet about a page on twitter
    --google-plusone                 Triggered when after you +1 a page on google+
    --pinterest-pin                  Pin an image on pinterest
    --twitter-follow                 Follow the merchant on twitter
    --facebook-share                 Share a product on facebook
    --share-purchase-facebook        Share your purchase on facebook
    --share-purchase-twitter         Share your purchase on twitter
    \n
USAGE;
    }
}

// Instantiate
$shell = new TBT_Shell_Create_Rules();
 
// Initiate script
$shell->run();