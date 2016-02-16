<?php

class ST_OnDemand_Model_Instance extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('st_ondemand/instance');
    }
    
    /**
     * Load the current instance
     * @return ST_OnDemand_Model_Instance
     */
    public function loadCurrentInstance()
    {
        // fetch instance code
        $code = Mage::getStoreConfig('rewards/instance/code');
        
        if ($code) {
            return $this->load($code, 'code');
        }
    }
}
