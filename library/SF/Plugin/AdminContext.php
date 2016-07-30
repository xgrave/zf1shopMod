<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 7:19 PM
 */
class SF_Plugin_AdminContext extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if($request->getParam('isAdmin')){
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout('admin');
        }
    }
}