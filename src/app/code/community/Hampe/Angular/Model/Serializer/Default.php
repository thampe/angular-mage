<?php
/**
 *  Interface.php
 *
 *
 *  @license    see LICENSE File
 *  @filename   Interface.php
 *  @package    magento
 *  @author     Thomas Hampe <thomas@hampe.co>
 *  @copyright  2013-2014 Thomas Hampe
 *  @date       23.08.14
 */ 

class Hampe_Angular_Model_Serializer_Default implements Hampe_Angular_Model_Serializer_Interface{

    /**
     * @param $modelClass string
     * @param $id string|int
     * @param $field null|string
     *
     * @return array|null
     */
    public function serializeModel($modelClass, $id, $field = null)
    {
        $model = Mage::getModel($modelClass) ->load($id, $field);
        if($model instanceof Mage_Core_Model_Abstract && $model->getId()) {
            return $model->toArray();
        }else {
            return null;
        }
    }

    /**
     * @param $modelClass string
     * @param $filters array
     * @param $select array
     * @param $limit int|string
     * @param $page int|string
     *
     * @return array
     */
    public function serializeCollection($modelClass, $filters, $select, $limit, $page)
    {
        $collection = $this->_preparePareCollection($modelClass, $filters, $select, $limit, $page);
        return array_values($collection->load()->toArray());
    }

    /**
     * @param $modelClass string
     * @param $filters array
     * @param $select array
     * @param $limit int|string
     * @param $page int|string
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract|Mage_Eav_Model_Entity_Collection_Abstract|null
     */
    public function _preparePareCollection($modelClass, $filters, $select, $limit, $page)
    {
        /* @var Mage_Core_Model_Resource_Db_Collection_Abstract $collection */
        $collection = Mage::getResourceModel($modelClass."_collection");
        if($collection instanceof Varien_Data_Collection) {
            if($collection instanceof Mage_Eav_Model_Entity_Collection_Abstract) {
                /** @var Mage_Eav_Model_Entity_Collection_Abstract $collection */
                foreach($filters as $filter => $condition) {
                    $collection->addAttributeToFilter($filter, $condition);
                }
                if(is_array($select) && count($select) > 0) {
                    $collection->addAttributeToSelect($select);
                }
            }else {
                foreach($filters as $filter => $condition)
                    $collection->addFieldToFilter($filter, $condition);
            }

            if($limit) {
                $collection->setPageSize((int) $limit);
            }
            if($page) {
                $collection->setCurPage((int) $page);
            }

            return $collection;
        }

        return null;
    }


} 