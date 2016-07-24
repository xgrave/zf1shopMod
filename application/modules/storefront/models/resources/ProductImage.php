<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/21/16
 * Time: 6:22 PM
 */
//DB_Table does not use autoloader so have to manually include resource classes
if(!class_exists('Storefront_Resource_ProductImage_Item')){
    require_once dirname(__FILE__) . '/ProductImage/Item.php';
}

class Storefront_Resource_ProductImage extends SF_Model_Resource_Db_Table_Abstract implements Storefront_Resource_ProductImage_Interface
{
    protected $_name = 'productImage';
    protected $_primary = 'imageId';
    protected $_rowClass = 'Storefront_Resource_ProductImage_Item';
    protected $_referenceMap = array(
        'Image' => array(
            'columns' => 'productId',
            'refTableClass' => 'Storefront_Resource_Product',
            'refColumns' => 'productId',
        )
    );
}