<?php
/**
 *  Hampe_Angular_Controller_JsonController.php
 *
 *
 *  @license    see LICENSE File
 *  @filename   Hampe_Angular_Controller_JsonController.php
 *  @package    magento
 *  @author     Thomas Hampe <thomas@hampe.co>
 *  @copyright  2013-2014 Thomas Hampe
 *  @date       23.08.14
 */ 

class Hampe_Angular_Controller_JsonAction extends Mage_Core_Controller_Front_Action
{

    /**
     * HTTP Status Code 404 Not Found
     */
    protected function _notFound() {
        $this->getResponse()->setHeader('HTTP/1.0','404',true);
    }

    /**
     * HTTP Status Code 401 Unauthorized
     */
    protected function _unauthorized() {
        $this->getResponse()->setHeader('HTTP/1.0','401',true);
    }

    /**
     * Send Unauthorized JSON Response Error Message
     */
    protected function _sendUnAuthorizedResponse()
    {
        $this->_unauthorized();
        $this->_setJsonBody(array('error' => array('message' => 'This is not allowed, without correct token', 'code' => 401)));
    }

    /**
     * @param $data
     */
    protected function _setJsonBody($data)
    {
        $this->getResponse()->setHeader('Content-type', 'application/json');
        /** @var Mage_Core_Helper_Data $coreHelper */
        $coreHelper = Mage::helper('core');
        $this->getResponse()->setBody($coreHelper->jsonEncode($data, true));
    }

    /**
     * Authenticate Request against a Session Key
     *
     * @return bool
     */
    protected function _authenticateRequest() {
        /* @var $session Hampe_Angular_Model_Session */
        $session = Mage::getSingleton('angular/session');
        $authTokenSent = $this->getRequest()->getHeader('Mage-Auth-Token');

        return $authTokenSent === $session->getAuthToken();
    }
} 