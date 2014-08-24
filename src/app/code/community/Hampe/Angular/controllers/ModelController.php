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

class Hampe_Angular_ModelController extends Hampe_Angular_Controller_JsonAction
{
    /**
     * Return a JSON encoded Model
     */
    public function modelAction() {

        if(!$this->_authenticateRequest()) {
            $this->_sendUnAuthorizedResponse();
            return;
        };

        $request = $this->getRequest();

        $modelClass = $request->getParam('class');
        $id = $request->getParam('id');
        $field = $request->getParam('field');

        $model = $this->getModelHelper()->getModel($modelClass, $id, $field);
        if($model) {
            $this->_setJsonBody($model);
        }else {
            $this->_notFound();
            $this->getResponse()->setBody("{}");
        }

    }

    /**
     * Returns a JSON encoded Collection
     */
    public function collectionAction()
    {
        if(!$this->_authenticateRequest()) {
            $this->_sendUnAuthorizedResponse();
            return;
        };

        $request = $this->getRequest();

        $modelClass = $request->getParam('class');
        $filters = $request->getParam('filters', array());
        $select = $request->getParam('select', array());
        $limit = $request->getParam('limit');
        $page = $request->getParam('page');

        $collection = $this->getModelHelper()->getCollection($modelClass, $filters, $select, $limit, $page);
        if($collection) {
            $this->_setJsonBody($collection);
        }else {
            $this->_notFound();
            $this->getResponse()->setBody("{}");
        }
    }



    /**
     *
     * @return Hampe_Angular_Helper_Model
     */
    protected function getModelHelper()
    {
        return Mage::helper('angular/model');
    }
} 