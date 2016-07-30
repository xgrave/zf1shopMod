<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/25/16
 * Time: 12:39 PM
 */
class Storefront_Validate_UniqueEmail extends Zend_Validate_Abstract
{
    const EMAIL_EXISTS = 'emailExists';

    protected $_messageTemplates = array(
        self::EMAIL_EXISTS => 'Email "%value%" already exists in our system',
    );

    public function __construct(Storefront_Model_User $model) //new model is being instantiated when called from Base.php form when validating email
    {
        $this->_model = $model;
    }

    public function isValid($value, $context = null)
    {
        $this->_setValue($value);
        $currentUser = isset($context['userId']) ?
            $this->_model->getUserById($context['userId']) : null;
        $user = $this->_model->getUserByEmail($value, $currentUser);

        if(null === $user){
            return true;
        }

        $this->_error(self::EMAIL_EXISTS);
        return false;
    }
}