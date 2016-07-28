<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 2:41 PM
 */
class Storefront_Model_Acl_Storefront extends Zend_Acl implements SF_Acl_Interface
{
    public function __construct()
    {   // defines the role hierarchy, each subsequent inherits from the predecessor
        $this->addRole(new Storefront_Model_Acl_Role_Guest)
            ->addRole(new Storefront_Model_Acl_Role_Customer, 'Guest')
            ->addRole(new Storefront_Model_Acl_Role_Admin, 'Customer');
        $this->deny();


        $this->add(new Storefront_Model_Acl_Resource_Admin)
            ->allow('Admin');
    }

}