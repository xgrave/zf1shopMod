<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/25/16
 * Time: 3:09 PM
 */
class Storefront_Form_User_Register extends Storefront_Form_User_Base
{
    public function init()
    {
        // call parent init
        parent::init();

        //then specialize the form for our needs
        $this->removeElement('userId');
        $this->getElement('submit')->setLabel('Register');
    }
}