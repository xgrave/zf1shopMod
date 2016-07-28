<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 3:36 PM
 */
abstract class  SF_Model_Acl_Abstract extends SF_Model_Abstract implements SF_Model_Acl_Interface, Zend_Acl_Resource_Interface
{
    protected $_acl;
    protected $_identity;
    public function setIdentity($identity)
    {
        if(is_array($identity)){
            if(!isset($identity['role'])){
                $identity['role'] = 'Guest';
            }
            $identity = new Zend_Acl_Role($identity['role']);
        } elseif (is_scalar($identity) && !is_bool($identity)){
            $identity = new Zend_Acl_Role($identity);
        } elseif (null === $identity){
            $identity = new Zend_Acl_Role('Guest');
        } elseif (!$identity instanceof Zend_Acl_Role_Interface){
            throw new SF_Model_Exception('Invalid Identity Provided');
        }
        $this->_identity = $identity;
        return $this;
    }

    public function getIdentity()
    {
        if(null === $this->_identity){
            $auth = Zend_Auth::getInstance();
            if(!$auth->hasIdentity()){
                return 'Guest';
            }
        }
        return $this->_identity;
    }

    public function checkAcl($action)
    {
        return $this->getAcl()->isAllowed(
            $this->getIdentity(),
            $this,
            $action
        );
    }


}