<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/28/16
 * Time: 3:32 PM
 */
interface SF_Model_Acl_Interface
{
    public function setIdentity($identity);
    public function getIdentity();
    public function setAcl(SF_Acl_Interface $acl);
    public function getAcl();
    public function checkAcl($action);

}