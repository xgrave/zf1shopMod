<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/30/16
 * Time: 8:09 PM
 */
class Storefront_Filter_Ident implements Zend_Filter_Interface
{
    public function filter($value)
    {
        //find and replace for passed $value
        $find = array('`', '&', ' ', '""', "'");
        $replace = array('', 'and', '-', '', '',);
        $new = str_replace($find, $replace, $value);

        $noalpha ='ÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÀÈÌÒÙàèìòùÄËÏÖÜäëïöüÿÃãÕõÅåÑñÇç@°oa';
        $alpha   ='AEIOUYaeiouyAEIOUaeiouAEIOUaeiouAEIOUaeiouyAaOoAaNnCcaooa';

        $new = substr($new, 0 , 200);
        $new = strtr($new, $noalpha, $alpha);

        //replace illegal chars with "-"
        $new = preg_replace('/[^a-zA-Z0-9_\+]/', '-', $new );

        //remove dashes from regex
        $new = preg_replace('/(-+)/', '-', $new);

        return rtrim($new, '-');
    }
}