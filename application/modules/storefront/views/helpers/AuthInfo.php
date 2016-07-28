<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/27/16
 * Time: 6:23 PM
 */
// Can use $this->authInfo('role')/('firstname') to retrieve info in the view
class Zend_View_Helper_AuthInfo extends Zend_View_Helper_Abstract
{
    protected $_authService;
    public function authInfo ($info = null)
    {
        if(null === $this->_authService){
            $this->_authService = new Storefront_Service_Authentication();
        }

        if(null === $info){
            return $this;
        }

        if(false === $this->isLoggedIn()){
            return null;
        }

        return $this->_authService->getIdentity()->$info;
    }

    public function isLoggedIn()
    {
        return $this->_authService->getAuth()->hasIdentity();
    }
}