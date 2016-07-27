<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/26/16
 * Time: 10:59 AM
 */
class Storefront_CartController extends Zend_Controller_Action
{
    protected $_cartModel;
    protected $_catalogModel;

    public function init()
    {
        $this->_cartModel = new Storefront_Model_Cart();
        $this->_catalogModel = new Storefront_Model_Catalog();
    }

    public function addAction()
    {
        $product = $this->_catalogModel->getProductById(
            $this->_getParam('productId')
        );

        if(null === $product){
            throw new SF_Exception(
                'Product could not be added to cart as it does not exists'
            );
        }

        $this->_cartModel->addItem(
            $product, $this->_getParam('qty')
        );

        //redirect after adding item
        $return = rtrim(
            $this->getRequest()->getBaseUrl(), '/'
        ) . $this->_getParam('returnto');
        $redirector = $this->getHelper('redirector');
        return $redirector->gotoUrl($return);
    }

    public function viewAction()
    {
        $this->view->cartModel = $this->_cartModel;
    }

    public function updateAction()
    {
        foreach($this->_getParam('quantity') as $id => $value)
        {
            $product = $this->_catalogModel->getProductById($id);
            if(null !== $product){
                $this->_cartModel->addItem($product, $value);
            }
        }

        $this->_cartModel->setShippingCost(
            $this->_getParam('shipping')
        );

        return $this->_helper->redirector('view'); // redirect to viewAction after updateAction completes

    }
}