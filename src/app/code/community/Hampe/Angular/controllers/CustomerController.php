<?php
/**
 *  DemoController.php
 *
 *
 *  @license    see LICENSE File
 *  @filename   DemoController.php
 *  @package    magento
 *  @author     Thomas Hampe <thomas@hampe.co>
 *  @copyright  2013-2014 Thomas Hampe
 *  @date       22.08.14
 */ 

class Hampe_Angular_CustomerController extends Hampe_Angular_Controller_JsonAction
{
    /**
     * Returns the Current Customer
     */
    public function currentCustomerAction()
    {
        if(!$this->_authenticateRequest()) {
            $this->_sendUnAuthorizedResponse();
            return;
        };

        /** @var Mage_Customer_Helper_Data $customerHelper */
        $customerHelper = Mage::helper('customer');
        $customer = $customerHelper->getCurrentCustomer();
        if($customer->getId()) {
            $addressData = array_values($customer->getAddressesCollection()->load()->toArray());
            $customerData = $customer->toArray();
            unset($customerData['password_hash']);
            $customerData['address'] = $addressData;
            $this->_setJsonBody($customerData);
        }else {
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody("{}");
        }

    }

} 