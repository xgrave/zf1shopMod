<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/25/16
 * Time: 3:12 PM
 */
class Storefront_Form_User_Edit extends Storefront_Form_User_Base
{
    public function init()
    {
        //call parent init
        parent::init(); //

        //specialize the form for our use
        $this->getElement('passwd')->setRequired(false);
        $this->getElement('passwdVerify')->setRequired(false);
        $this->getElement('submit')->setLabel('Save User');
    }
}