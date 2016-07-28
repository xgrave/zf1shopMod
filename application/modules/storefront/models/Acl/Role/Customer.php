<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 3:08 PM
 */
class Storefront_Model_Acl_Role_Customer implements Zend_Acl_Role_Interface
{
    public function getRoleId()
    {
        return 'Customer';
    }
}