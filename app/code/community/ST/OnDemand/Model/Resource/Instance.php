<?php

class ST_OnDemand_Model_Resource_Instance extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('st_ondemand/instance', 'id');
    }
}
