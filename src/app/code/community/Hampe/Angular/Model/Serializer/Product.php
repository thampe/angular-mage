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

class Hampe_Angular_Model_Serializer_Product extends Hampe_Angular_Model_Serializer_Default
{

    /**
     * @param string $modelClass
     * @param int|string $id
     * @param null $field
     *
     * @return array|null
     */
    public function serializeModel($modelClass, $id, $field = null)
    {
        try {
            $productData = $this->_getApi()->info($id, null, null, $field);
        }catch (Exception $e) {
            $productData = null;
        }
        return $productData;
    }

    /**
     * @param string $modelClass
     * @param array $filters
     * @param array $select
     * @param int|string $limit
     * @param int|string $page
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection|Mage_Core_Model_Resource_Db_Collection_Abstract|Mage_Eav_Model_Entity_Collection_Abstract|null
     */
    public function _preparePareCollection($modelClass, $filters, $select, $limit, $page)
    {
        if(isset($filters['category_id'])) {
            $categoryId = $filters['category_id'];
            unset($filters['category_id']);
        }else {
            $categoryId = null;
        }

        $categoryIds = isset($select['category_ids']);
        $options = isset($select['options']);
        unset($select['options']);
        unset($select['category_ids']);

        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = parent::_preparePareCollection($modelClass, $filters, $select, $limit, $page);
        $collection->addPriceData();

        $collection->addOptionsToResult();

        if($categoryId) {
            $collection->addCategoryFilter(new Varien_Object(array('entity_id' => $categoryId)));
        }

        if(in_array('*', $select) || $categoryIds) {
            $collection->addCategoryIds();
        }

        if(in_array('*', $select) || $options) {
            $collection->addOptionsToResult();
        }

        return $collection;
    }


    /**
     *
     * @return Mage_Catalog_Model_Product_Api
     */
    protected function _getApi()
    {
        return Mage::getSingleton('catalog/product_api');
    }
} 