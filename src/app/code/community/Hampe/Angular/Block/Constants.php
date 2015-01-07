<?php
/**
 *  Hampe_Angular_Block_Script.php
 *
 *
 *  @license    see LICENSE File
 *  @filename   Hampe_Angular_Block_Script.php
 *  @package    magento
 *  @author     Thomas Hampe <thomas@hampe.co>
 *  @copyright  2013-2014 Thomas Hampe
 *  @date       22.08.14
 */ 

class Hampe_Angular_Block_Constants extends Mage_Core_Block_Template
{
    /**
     * @param bool $secure
     *
     * @return string
     */
    public function getBaseUrl($secure = false)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, $secure);
    }

    /**
     * @param bool $secure
     *
     * @return string
     */
    public function getBaseMediaUrl($secure = false)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA, $secure);
    }

    /**
     * @param bool $secure
     *
     * @return string
     */
    public function getBaseSkinUrl($secure = false)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN, $secure);
    }

    /**
     * @param bool $secure
     *
     * @return string
     */
    public function getBaseJsUrl($secure = false)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS, $secure);
    }

    /**
     *
     * @return string
     */
    public function isCustomerLoggedIn()
    {
        /* @var $customerHelper Mage_Customer_Helper_Data */
        $customerHelper = $this->helper('customer');
        return $customerHelper->isLoggedIn() ? 'true' : 'false';
    }

    /**
     *
     * @return string
     */
    public function getPriceFormat()
    {
        /* @var $locale Mage_Core_Model_Locale */
        $locale = Mage::app()->getLocale();
        /* @var $coreHelper Mage_Core_Helper_Data */
        $coreHelper = $this->helper('core');
        return $coreHelper->jsonEncode($locale->getJsPriceFormat());
    }

    /**
     *
     * @return string
     */
    public function getAuthToken()
    {
        /* @var $angularSession Hampe_Angular_Model_Session */
        $angularSession = Mage::getSingleton('angular/session');

        return $angularSession->getAuthToken();
    }
} 