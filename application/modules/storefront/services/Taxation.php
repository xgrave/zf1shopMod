<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 7:40 PM
 */
class Storefront_Service_Taxation
{
    const TAXRATE = 15;

    public function addTax($amount){
        $tax = ($amount*self::TAXRATE)/100;
        $amount = round($amount + $tax,2);

        return $amount;
    }
}