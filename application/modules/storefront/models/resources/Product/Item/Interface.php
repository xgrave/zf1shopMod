<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 1:47 PM
 */
interface Storefront_Resource_Product_Item_Interface
{
    public function getImages($includeDefault = false);
    public function getDefaultImage();
    public function getPrice($withDiscount = true, $withTax = true);
    public function isDiscounted();
    public function isTaxable();
}