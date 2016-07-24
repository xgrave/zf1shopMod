<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 1:29 PM
 */
class Storefront_Resource_ProductImage_Item extends SF_Model_Resource_Db_Table_Row_Abstract implements Storefront_Resource_ProductImage_Item_Interface
{
    public function thumbnail()
    {
        return $this->getRow()->thumbnail;
    }

    public function full()
    {
        return $this->getRow()->full;
    }

    public function isDefault()
    {
        return 'Yes' === $this->getRow()->isDefault ? true : false;
    }
}