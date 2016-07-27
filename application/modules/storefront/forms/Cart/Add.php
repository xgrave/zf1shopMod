<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/26/16
 * Time: 12:15 PM
 */
class Storefront_Form_Cart_Add extends SF_Form_Abstract
{
    public function init()
    {
        $this->setDisableLoadDefaultDecorators(true);

        $this->setMethod('post');
        $this->setAction('');

        $this->setDecorators(array(
            'FormElements',
            'Form'
        ));

        $this->addElement('text', 'qty', array(
            'decorators' => array(
                'ViewHelper'
            ),
            'style' => 'width: 20px;',
            'value' => 1
        ));

        $this->addElement('submit', 'buy-item', array(
            'decorators' => array(
                'ViewHelper'
            ),
            'label' => 'Add to Cart'
        ));

        $this->addElement('hidden', 'productId', array(
            'decorators' => array(
                'ViewHelper'
            ),
        ));

        $this->addElement('hidden', 'returnTo', array(
            'decorators' => array(
                'ViewHelper'
            ),
        ));
    }
}