<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/23/16
 * Time: 2:53 PM
 */

class Zend_View_Helper_Breadcrumb extends Zend_View_Helper_Abstract
{
    public function breadcrumb($product = null) // used by the actual view as a helper using the data populated in the controller
    {
        if($this->view->bread) { // was populated and assigned in the Controller using getBreadcrumbs
            $bread = $this->view->bread;
            $crumbs = array();
            $bread = array_reverse($bread);

            foreach($bread as $category){
                $href = $this->view->url(array(
                    'categoryIdent' => $category->ident,
                ),
                'catalog_category'
                );
                $crumbs[] = '<a href="' . $href . '">' .
                    $this->view->Escape($category->name) . '</a>';
            }

            if(null !== $product){
                $crumbs[] = $this->view->Escape($product->name);
            }

            return join(' &raquo; ', $crumbs);
        }
    }
}