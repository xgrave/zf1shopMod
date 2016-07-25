<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/24/16
 * Time: 7:24 PM
 */
class Storefront_Resource_User_Item extends SF_Model_Resource_Db_Table_Row_Abstract implements Storefront_Resource_User_Item_Interface
{
    public function getFullname()
    {
       return $this->getRow()->title. ' ' . $this->getRow()->firstname . ' ' . $this->getRow()->lastname;
    }
}