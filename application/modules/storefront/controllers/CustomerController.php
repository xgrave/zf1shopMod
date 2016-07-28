<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/24/16
 * Time: 8:03 PM
 */
class Storefront_CustomerController extends Zend_Controller_Action
{
    protected $_model;
    protected $_authService;

    public function init()
    {
        //get default model
        $this->_model = new Storefront_Model_User();
        $this->_authService = new Storefront_Service_Authentication();


        //add forms to view
        $this->view->registerForm = $this->getRegistrationForm();
        $this->view->loginForm = $this->getLoginForm();
        $this->view->userForm = $this->getUserForm();
    }

    public function loginAction()
    {
        //render login.phtml view automatically
    }

    public function authenticateAction()
    {
        $request = $this->getRequest();
        if(!$request->isPost()){
            return $this->_helper->redirector('login');
        }
        //Validate
        $form = $this->_forms['login'];

        if(!$form->isValid($request->getPost())){ //if form fails validation using post data
            return $this->render('login'); //render login.phtml / same as rendering loginAction
        }

        if(false === $this->_authService->authenticate($form->getValues())){ //if wrong username/pw
            $form->setDescription('Login Failed. Please try again.'); //show message
            return $this->render('login');  //render login.phtml / same as rendering loginAction
        }
        return $this->_helper->redirector('index'); //if all is well, redirect to and render index.phtml / indexAction
    }

    public function logoutAction()
    {
        $this->_authService->clear();
        return $this->_helper->redirector('index');
    }

    public function indexAction()
    {
        $userId = $this->_authService->getIdentity()->userId;//will come from session var
        $this->view->user = $this->_model->getUserById($userId);
        $this->view->userForm = $this->getUserForm()->populate($this->view->user->toArray()); //populate accepts an array of values
    }

    public function saveAction()
    {
        $request = $this->getRequest();
        if(!$request->isPost()){
            return $this->_helper->redirector('index');
        }
        if(false === $this->_model->saveUser($request->getPost())){
            return $this->render('index');
        }
    }

    public function registerAction()
    {}

    public function completeRegistrationAction()
    {
        $request = $this->getRequest();
        if(!$request->isPost()){
            return $this->_helper->redirector('register');
        }
        if(false === ($id = $this->_model->registerUser($request->getPost()))){
            return $this->render('register');
        }

    }

    // Begin Form Calls //

    public function getRegistrationForm()
    {
        $urlHelper = $this->_helper->getHelper('url');

        $this->_forms['register'] = $this->_model->getForm('userRegister');

        $this->_forms['register']->setAction($urlHelper->url(array(
                                                                'controller' => 'customer',
                                                                'action' => 'complete-registration'
                                                                ),
                                                                'default'
        ));

        $this->_forms['register']->setMethod('post');

        return $this->_forms['register'];
    }

    public function getUserForm()
    {
        $urlHelper = $this->_helper->getHelper('url');

        $this->_forms['userEdit'] = $this->_model->getForm('userEdit');

        $this->_forms['userEdit']->setAction(
            $urlHelper->url(array(
                'controller' => 'customer',
                'action' => 'save'
            ),
                'default'
        ));

        $this->_forms['userEdit']->setMethod('post');

        return $this->_forms['userEdit'];
    }

    public function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_forms['login'] = $this->_model->getForm('userLogin');
        $this->_forms['login']->setAction($urlHelper->url(array(
            'controller' => 'customer',
            'action' => 'authenticate',
        ),
            'default'
        ));
        $this->_forms['login']->setMethod('post');
        return $this->_forms['login'];
    }
}