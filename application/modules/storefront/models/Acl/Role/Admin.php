<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 3:07 PM
 */
class Storefront_Model_Acl_Role_Admin implements Zend_Acl_Role_Interface
{
    public function getRoleId()
    {
        return 'Admin';
    }
}