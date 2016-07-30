<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 5:52 PM
 */
class Storefront_Model_Acl_Resource_Admin implements
    Zend_Acl_Resource_Interface
{
    public function getResourceId()
    {
        return 'Admin';
    }
}