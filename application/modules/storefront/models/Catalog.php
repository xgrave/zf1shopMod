<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/21/16
 * Time: 1:55 PM
 */
class Storefront_Model_Catalog extends SF_Model_Abstract
{
    //Categories
    public function getCategoriesByParentId($parentID)
    {
        $parentID = (int) $parentID;

        return $this->getResource('Category')
                    ->getCategoriesByParentId($parentID);
    }

    public function getCategoryByIdent($ident)
    {
        return $this->getResource('Category')
                    ->getCategoryByIdent($ident);
    }

    //Products
    public function getProductById($id)
    {
        $id = (int) $id;
        return $this->getResource('Product')
                    ->getProductById($id);
    }

    public function getProductByIdent($ident)
    {
        return $this->getResource('Product')
                    ->getProductByIdent($ident);
    }

    //Other
    public function getProductsByCategory($category, $paged=false, $order=null, $deep=true)
    {
        if(is_string($category)){
            $cat = $this->getResource('Category')
                        ->getCategoryByIdent($category);
            $categoryId = null === $cat ? 0 : $cat->categoryId;
        }else{
            $categoryId = (int) $category;
        }

        if(true === $deep){
            $ids = $this->getCategoryChildrenIds(
                $categoryId, true
            );
            $ids[] = $categoryId;
            $categoryId = null === $ids ? $categoryId : $ids;
        }

        return $this->getResource('Product')
            ->getProductsByCategory(
                $categoryId,
                $paged,
                $order
            );
    }
    public function getCategoryChildrenIds($categoryId, $recursive=false)
    {
        $categories = $this->getCategoriesByParentId($categoryId);
        $cats = array();

        foreach ($categories as $category){
            $cats[] = $category->categoryId;
            if (true === $recursive) {
                $cats = array_merge(
                    $cats,
                    $this->getCategoryChildrenIds(
                        $category->categoryId, true
                    )
                );
            }
        }

        return $cats;
    }
    public function getParentCategories($category)
    {
        $cats = array($category);

        if (0 == $category->parentId){
            return $cats;
        }

        $parent = $category->getParentCategory();
        $cats[] = $parent;

        if(0 != $parent->parentId){
            $cats = array_merge(
                $cats,
                $this->getParentCategories($parent)
            );
        }

        return $cats;
    }

}