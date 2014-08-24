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

interface Hampe_Angular_Model_Serializer_Interface {

    /**
     * @param $modelClass string
     * @param $id string|int
     * @param $field null|string
     *
     * @return mixed
     */
    public function serializeModel($modelClass, $id, $field = null);

    /**
     * @param $modelClass string
     * @param $filters array
     * @param $select array
     * @param $limit int|string
     * @param $page int|string
     *
     * @return array
     */
    public function serializeCollection($modelClass, $filters, $select, $limit, $page);
} 