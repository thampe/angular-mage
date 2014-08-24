<?php
/**
 *  Session.php
 *
 *
 *  @license    see LICENSE File
 *  @filename   Session.php
 *  @package    magento
 *  @author     Thomas Hampe <thomas@hampe.co>
 *  @copyright  2013-2014 Thomas Hampe
 *  @date       23.08.14
 */ 

class Hampe_Angular_Model_Session extends Mage_Core_Model_Session_Abstract
{
    public function __construct()
    {
        $this->init('angular');
    }

    /**
     *
     * @return string
     */
    public function getAuthToken()
    {
        if(!$this->getData('_key')) {
            /* @var $coreHelper Mage_Core_Helper_Data */
            $coreHelper = Mage::helper('core');

            $this->setData('_key',$coreHelper->getRandomString(16));
        }

        return $this->getData('_key');
    }
} 