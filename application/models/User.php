<?php

class User extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

//    protected $values = array();
//
//    public function __get($key)
//    {
//        return $this->values[$key];
//    }
//
//    public function __set($key, $value)
//    {
//        $this->values[$key] = $value;
//    }


    public function load($uid)
    {

    }

	//$identifier can be email or username
    public function loadByPassword($identifier = null, $password = null)
    {
		return true;
    }

    public function login($username, $password)
    {


        return null;
    }


}


?>

