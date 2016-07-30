<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/21/16
 * Time: 6:26 PM
 */

//DB_Table does not use autoloader so have to manually include resource classes
if(!class_exists('Storefront_Resource_Category_Item')){
    require_once dirname(__FILE__) . '/Category/Item.php';
}

class Storefront_Resource_Category extends SF_Model_Resource_Db_Table_Abstract implements Storefront_Resource_Category_Interface
{
    protected $_name = 'category';
    protected $_primary = 'categoryId';
    protected $_rowClass = 'Storefront_Resource_Category_Item';

    protected $_referenceMap = array(
        'SubCategory' => array(
            'columns' => 'parentId',
            'refTableClass' => 'Storefront_Resource_Category',
            'refColumns' => 'categoryId',
        )
    );

    public function getCategoriesByParentId($parentId)
    {
        $select = $this->select()
                        ->where('parentId = ?', $parentId)
                        ->order('name');
        return $this->fetchAll($select);
    }

    public function getCategoryByIdent($ident)
    {
        $select = $this->select()
                        ->where('ident = ?', $ident);
        return $this->fetchRow($select);
    }

    public function getCategoryById($id)
    {
        $select = $this->select()
                        ->where('categoryId = ?', $id);
        return $this->fetchRow($select);
    }
}