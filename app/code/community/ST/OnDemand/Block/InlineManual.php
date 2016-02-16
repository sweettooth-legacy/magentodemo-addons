<?php

class ST_OnDemand_Block_InlineManual extends Mage_Core_Block_Template
{
    /**
     * Get the code for the current instance
     * @return string|null
     */
    public function getInstanceCode()
    {
        $instance = Mage::getModel('st_ondemand/instance')->loadCurrentInstance();
        return $instance->getCode();
    }

}
