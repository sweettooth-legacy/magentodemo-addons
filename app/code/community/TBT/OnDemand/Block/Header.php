<?php

class TBT_OnDemand_Block_Header extends Mage_Core_Block_Template
{
    /**
     * Get the expiration date of this instance
     * @return int (UNIX timestamp)
     */
    public function getExpiryTimestamp()
    {
        $instance = Mage::getModel('tbt_ondemand/instance')->loadCurrentInstance();
        $date = new DateTime($instance->getExpiresAt());
        
        return $date->getTimestamp();
    }
    
    /**
     * Fetch the current sweettooth version
     * @return string
     */
    public function getSweetToothVersion()
    {
        return Mage::getConfig()->getNode('modules/TBT_Rewards/version');
    }
}
