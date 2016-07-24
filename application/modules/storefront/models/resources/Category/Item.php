<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 1:30 PM
 */
class Storefront_Resource_Category_Item extends SF_Model_Resource_Db_Table_Row_Abstract implements Storefront_Resource_Category_Item_Interface
{
    public function getParentCategory()
    {
        return $this->findParentRow(
            'Storefront_Resource_Category',
            'SubCategory'
        );
    }
}