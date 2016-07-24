<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 1:39 PM
 */
interface Storefront_Resource_Product_Interface
{
    public function getProductById($id);
    public function getProductByIdent($ident);
    public function getProductsByCategory($categoryId, $paged = null, $order = null);
    //public function saveProduct($info);
}