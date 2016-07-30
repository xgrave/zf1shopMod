<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/27/16
 * Time: 2:25 PM
 */
class Storefront_Service_Authentication
{
    protected $_authAdapter;
    protected $_userModel;
    protected $_auth;

    public function __construct(Storefront_Model_User $userModel = null)
    {
        $this->_userModel = null === $userModel ? new Storefront_Model_User() : $userModel;
    }

    public function authenticate($credentials)
    {
        $adapter = $this->getAuthAdapter($credentials);
        $auth = $this->getAuth();
        $result = $auth->authenticate($adapter);

        if(!$result->isValid()){
            return false;
        }

        $user = $this->_userModel->getUserByEmail($credentials['email']);
        $auth->getStorage()->write($user); //Zend_auth persistence layer - stores user in the session
        return true;
    }

    public function getAuth()
    {
        if(null === $this->_auth){
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }

    public function getIdentity()
    {
        $auth = $this->getAuth();
        if($auth->hasIdentity()){
            return $auth->getIdentity();
        }
        return false;
    }

    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }

    public function setAuthAdapter(Zend_Auth_Adapter_Interface $adapter)
    {
        $this->_authAdapter = $adapter;
    }

    public function getAuthAdapter($values)
    {
        if(null === $this->_authAdapter)
        {
            $authAdapter = new Zend_Auth_Adapter_DbTable( //class accepts 5 params
                Zend_Db_Table_Abstract::getDefaultAdapter(), // param 1 = db adapter
                'user', // db table
                'email', // column name
                'passwd' // identity column
                            //optional credential treatment, defined below
            );
            $this->setAuthAdapter($authAdapter);
            $this->_authAdapter->setIdentity($values['email']);
            $this->_authAdapter->setCredential($values['passwd']);
            $this->_authAdapter->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        }
        return $this->_authAdapter;
    }
}