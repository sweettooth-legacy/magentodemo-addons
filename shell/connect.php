<?php

require_once 'abstract.php';
 
class TBT_Shell_Platform_Connect extends Mage_Shell_Abstract
{
    protected $username;
    protected $password;
    protected $devMode;
 
    public function __construct() 
    {
        parent::__construct();
 
        $this->username = $this->getArg('username');
        $this->password = $this->getArg('password');
        $this->devMode = $this->getArg('devmode');
    }
 
    // Shell script point of entry
    public function run() 
    {
        Mage::getConfig()->saveConfig('rewards/platform/dev_mode', $this->devMode);
        Mage::getConfig()->cleanCache();

        Mage::helper('rewards/platform')->connectWithPlatformAccount(
            $this->username, 
            $this->password, 
            $this->devMode
        );
    }
    
    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
    Usage:  php -f connect.php -- [options]

    -username <username>        Sweettooth account username (required)
    -password <password>        Sweettooth account password (required)
    -devmode                    If specified then we will connect to the dev account
    \n
USAGE;
    }
}

// Instantiate
$shell = new TBT_Shell_Platform_Connect();
 
// Initiate script
$shell->run();