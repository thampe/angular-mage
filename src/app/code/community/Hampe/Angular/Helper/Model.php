<?php
/**
 *  Hampe_Angular_Helper_Model.php
 *
 *
 *  @license    see LICENSE File
 *  @filename   Hampe_Angular_Helper_Model.php
 *  @package    magento
 *  @author     Thomas Hampe <thomas@hampe.co>
 *  @copyright  2013-2014 Thomas Hampe
 *  @date       22.08.14
 */ 

class Hampe_Angular_Helper_Model extends Mage_Core_Helper_Abstract {

    const CONFIG_MODELS = 'angular/models';
    const DEFAULT_SERIALIZER = 'angular/serializer_default';

    /**
     * @var array
     */
    protected $_modelConfig;


    /**
     * @param $modelClass string
     * @param $id string|int
     * @param $field null|string
     *
     * @return null|array
     */
    public function getModel($modelClass, $id, $field = null)
    {
        if($this->_isAllowed($modelClass)){
            $serializer = $this->_getSerializer($modelClass);
            if($serializer instanceof Hampe_Angular_Model_Serializer_Interface) {
                return $serializer->serializeModel($modelClass, $id, $field);
            }
        }

        return null;
    }

    /**
     * @param $modelClass string
     * @param $filters array
     * @param $select array
     * @param $limit int|string
     * @param $page int|string
     *
     * @return null|array
     */
    public function getCollection($modelClass, $filters, $select, $limit, $page)
    {
        if($this->_isAllowed($modelClass)){
            $serializer = $this->_getSerializer($modelClass);
            if($serializer instanceof Hampe_Angular_Model_Serializer_Interface) {
                return $serializer->serializeCollection($modelClass, $filters, $select, $limit, $page);
            }
        }

        return null;
    }

    /**
     * @param $data mixed
     *
     * @return string
     */
    public function jsonEncode($data) {
        /** @var Mage_Core_Helper_Data $coreHelper */
        $coreHelper = Mage::helper('core');

        return $coreHelper->jsonEncode($data, true);
    }

    /**
     * @param $modelClass string
     *
     * @return bool
     */
    protected function _isAllowed($modelClass)
    {
        $config = $this->_getModelConfig();
        foreach($config as $configElement) {
            if(
                $modelClass === $configElement['model']
                && (!isset($configElement['allowed']) || $configElement['allowed'] === "true")
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @return array
     */
    protected function _getModelConfig(){
        if(!$this->_modelConfig) {
            $this->_modelConfig = Mage::getStoreConfig(self::CONFIG_MODELS);
        }

        return $this->_modelConfig;
    }

    /**
     * @param $modelClass
     *
     * @return Hampe_Angular_Model_Serializer_Interface
     */
    protected function _getSerializer($modelClass)
    {
        foreach($this->_getModelConfig() as $configElement){
            if($modelClass == $configElement['model'] && $configElement['serializer']) {
                return Mage::getSingleton($configElement['serializer']);
            }
        }
        return Mage::getSingleton(self::DEFAULT_SERIALIZER);
    }


} 