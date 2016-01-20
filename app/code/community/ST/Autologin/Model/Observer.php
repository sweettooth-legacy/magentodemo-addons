<?php


class ST_Autologin_Model_Observer extends Varien_Object {
    
    
    /** 
     * Runs on predispatch of the log-in for administration of a Magento account  
     * @return   ST_Autologin_Model_Admin_Login_Observer   $this
     */         
    public function preLoginDispatch($o) {
        $controller = $o->getControllerAction();
        
      	$username = $controller->getRequest()->get('username');
      	$password = $controller->getRequest()->get('password');
      	if(!$username || !$password) return $this;

        
        
        /** @var $adminSession Mage_Admin_Model_Session */
        $adminSession = Mage::getSingleton('admin/session');
        
                                            
        // If we're already logged in don't do anything.
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            return $this;
        }
        
        // Login as the admin
        $adminSession->login($username, $password);
            
        // If the login was successful, login as the merchant
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            Mage::getSingleton('adminhtml/session')->addNotice('We automatically logged you into the admin panel.');
        } else {
            // If we want to, this can give an error that the token has expired
            //Mage::getSingleton('adminhtml/session')->addError(Mage::helper('platformclient')->__('')); 
        }
                
        return $this;
    }
    
} 
