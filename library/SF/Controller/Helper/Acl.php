<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/30/16
 * Time: 11:38 PM
 */
class SF_Controller_Helper_Acl extends Zend_Controller_Action_Helper_Abstract
{
    protected $_acl;
    protected $_identity;

    public function init()
    {
        $module = $this->getRequest()->getModuleName();
        $acl = ucfirst($module) . '_Model_Acl_' . ucfirst($module);

        if(class_exists($acl)){
            $this->_acl = new $acl; //load acl (list of roles and resources) into class
        }
    }

    public function getAcl()
    {
        return $this->_acl;
    }

    public function isAllowed($resource = null, $privilege = null)
    {
        if(null === $this->_acl){
            return null;
        }

        return $this->_acl->isAllowed($this->getIdentity(), $resource, $privilege); //infinite loop?
    }

    public function setIdentity($identity)
    {
        if(is_array($identity)) { //make a separate helper for this eventually?
            if (!isset($identity['role'])) {
                $identity['role'] = 'Guest';
            }
            $identity = new Zend_Acl_Role($identity['role']);
        }elseif(is_scalar($identity) && !is_bool($identity)) {
            $identity = new Zend_Acl_Role($identity);
        }elseif(null === $identity){
            $identity = new Zend_Acl_Role('Guest');
        }elseif(!$identity instanceof Zend_Acl_Role_Interface){
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
            $this->setIdentity($auth->getIdentity());
        }
        return $this->_identity;
    }

    public function direct($resource = null, $privilege = null)
    {
        return $this->isAllowed($resource, $privilege);
    }
}