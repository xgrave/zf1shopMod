<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/22/16
 * Time: 1:33 PM
 */
interface Storefront_Resource_Category_Interface
{
    public function getCategoriesByParentId($parentId);
    public function getCategoryByIdent($ident);
    public function getCategoryById($id);
}