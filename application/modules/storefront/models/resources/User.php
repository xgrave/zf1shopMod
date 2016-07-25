<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/24/16
 * Time: 7:33 PM
 */
require_once dirname(__FILE__) . '/User/Item.php';

class Storefront_Resource_User extends SF_Model_Resource_Db_Table_Abstract implements Storefront_Resource_User_Interface
{
    protected $_name = 'user';
    protected $_primary = 'userId';
    protected $_rowClass = 'Storefront_Resource_User_Item'; //why these 3 lines?

    public function getUserById($id)
    {
        return $this->find($id)->current();
    }

    public function getUserByEmail($email, $ignoreUser = null)
    {
        $select = $this->select();
        $select->where('email = ?', $email);

        if(null !== $ignoreUser){
            $select->where('email != ?', $ignoreUser->email);
        }

        return $this->fetchRow($select);
    }

    public function getUsers($paged = false, $order = null)
    {
        if(true === is_array($order)){
            $select->order($order);
        }

        if(null !== $paged){ //clarify how this works by referring to chapter 5
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $count = clone $select;
            $count->reset(Zend_Db_Select::COLUMNS);
            $count->reset(Zend_Db_Select::FROM);
            $count->from('user', new Zend_Db_Expr('COUNT)(*) AS `zend_paginator_row_count`'));
            $adapter->setRowCount($count);

            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(15)->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
}