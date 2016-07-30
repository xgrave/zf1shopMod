<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 4:17 PM
 */
interface Storefront_Resource_ProductImage_Item_Interface
{
    public function thumbnail();
    public function full();
    public function isDefault();
}