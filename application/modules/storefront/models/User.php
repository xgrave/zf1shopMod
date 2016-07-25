<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/23/16
 * Time: 8:38 PM
 */
class Storefront_Model_User extends SF_Model_Abstract
{
    public function getUserById($id)
    {
        $id = (int) $id;
        return $this->getResource('User')->getUserById($id);
    }

    public function getUserByEmail($email, $ignoreUser = null)
    {
        return $this->getResource('User')
                    ->getUserByEmail($email, $ignoreUser);
    }

    public function getUsers($paged = false, $order = null)
    {
        return $this->getResource('User')
                    ->getUsers($paged,$order);
    }

    public function registerUser($post)
    {
        $form = $this->getForm('userRegister'); //userRegister is reweritten to User_Register to request Storefront_Form_User_Register
        return $this->_save(
            $form,
            $post,
            array('role' => 'Customer')
        );
    }

    public function saveUser($post)
    {
        $form = $this->getForm('userEdit');//why do we need the form if we have all the kv pairs in post? post might only hold header/validation info - book bottom pg 186
        return $this->_save($form,$post);
    }

    protected function _save(Zend_Form $form, array $info, $defaults = array())
    {
        if(!$form->isValid($info))
        {
            return false;
        }

        //get filtered vals
        $data = $form->getValues();

        //passhash
        if(array_key_exists('passwd', $data) && '' !== $data['passwd']) //check if pw was set in post
        {
            $data['salt'] = md5($this->createSalt());
            $data['passwd'] = sha1($data['passwd'] . $data['salt']);
        } else {
            unset($data['passwd']); //unset password so that we do not overwrite existing if user chose to not update
        }

        //apply default vals
        foreach($defaults as $col => $value){
            $data[$col] = $value;
        }
        $user = array_key_exists('userId', $data) ?
            $this->getResource('User')
            ->getUserById($data['userId']) : null; //if userId is set, we are updating user, else set to null and create new user
        return $this->getResource('User')
                    ->saveRow($data, $user);
    }

    private function createSalt()
    {
        $salt = '';
        for($i = 0; $i < 50; $i++){
            $salt .= chr(rand(33, 126));
            return $salt;
        }
    }
}