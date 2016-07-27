<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/26/16
 * Time: 10:30 AM
 */
class Storefront_Model_Shipping extends SF_Model_Abstract
{
    protected $_shippingData = array(
        'Standard' => 1.99,
        'Special' => 5.99,
    );

    public function getShippingOptions()
    {
        return $this->_shippingData;
    }
}