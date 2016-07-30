<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/23/16
 * Time: 3:36 PM
 */
class Zend_View_Helper_ProductImage extends Zend_View_Helper_HtmlElement
{
    protected $_image;
    protected $_attribs;

    public function productImage(Storefront_Resource_ProductImage_Item $image = null, $attribs = false)
    {
        $this->_image = $image;
        $this->_attribs = $attribs;
        return $this;
    }

    public function thumbnail()
    {
        if(null !== $this->_image){
            return $this->_createImgTag($this->_image->thumbnail); //what? looks like a recursive loop
        }
    }

    public function full()
    {
        if(null !== $this->_image){
            return $this->_createImgTag($this->_image->full);
        }
    }

    protected function _createImgTag($file)
    {
        if($this->_attribs){
            $attribs = $this->_htmlAttribs($this->_attribs);
        } else {
            $attribs = '';
        }
        $tag = 'img src ="' . $this->view->baseUrl('images/product/' . $file) . '" ';
        return '<' . $tag . $attribs . $this->getClosingBracket() . self::EOL;
    }

}