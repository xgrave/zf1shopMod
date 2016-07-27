<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/26/16
 * Time: 12:55 PM
 */
class Zend_View_Helper_Cart extends Zend_View_Helper_Abstract
{
    public $cartModel;
    public function Cart() //instantiate new cart instance and then returns the instance of itself so that we can use it in chaining calls
    {
        $this->cartModel = new Storefront_Model_Cart();
        return $this;
    }

    public function getSummary()
    {
        $currency = new Zend_Currency();
        $itemCount = count($this->cartModel);

        if(0 == $itemCount){
            return '<p>No Items In Cart</p>';
        }

        $html = '<p>Items: ' . $itemCount;
        $html .= ' | Total: ' . $currency->toCurrency($this->cartModel->getSubTotal());
        $html .= '<br /><a href="';
        $html .= $this->view->url(array(
            'controller' => 'cart',
            'action' => 'view',
            'module' => 'storefront'
            ),
            'default',
            true
        );
        $html .= '">View Cart</a></p>"';
        return $html;
    }

    public function addForm(Storefront_Resource_Product_Item $product)
    {
        $form = $this->cartModel->getForm('cartAdd'); ///refer to page 131 (absolute) in book for autoloading - Resource Autoloader equivalent of 'new Zend_Form_Cart_Add'
        $form->populate(array(
            'productId' => $product->productId,
            'returnTo' => $this->view->url()
        ));

        $form->setAction($this->view->url(array(
            'controller' => 'cart',
            'action' => 'add',
            'module' => 'storefront'
            ),
            'default',
            true
        ));

        return $form;
    }

    public function cartTable()
    {
        $cartTable = $this->cartModel->getForm('cartTable');
        $cartTable->setAction($this->view->url(array(
            'controller' => 'cart',
            'action' => 'update'
            ),
            'default'
        ));

        $qtys = new Zend_Form_SubForm();

        foreach($this->cartModel as $item){
            $qtys->addElement('text', (string) $item->productId, array(
                'value' => $item->qty,
                'belongsTo' => 'quantity',
                'style' => 'width: 20px;',
                'decorators' => array(
                    'ViewHelper'
                ),
            )
            );

        }

        $cartTable->addSubForm('$qtys', 'qtys');

        //add shipping options
        $cartTable->addElement('select', 'shipping', array(
            'decorators' => array(
                'ViewHelper'
            ),
            'MultiOptions' => $this->_getShippingMultiOptions(),
            'onChange' => 'this.form.submit();',
            'value' => $this->cartModel->getShippingCost()
        ));

        return $cartTable;
    }

    public function formatAmount($amount)
    {
        $currency = new Zend_Currency();
        return $currency->toCurrency($amount);
    }

    private function _getShippingMultiOptions()
    {
        $currency = new Zend_Currency();
        $shipping = new Storefront_Model_Shipping();
        $options = array(0 => 'Please Select');

        foreach($shipping->getShippingOptions() as $key => $value){
            $options["$value"] = $key . ' - ' . $currency->toCurrency($value);
        }

        return $options;
    }
}