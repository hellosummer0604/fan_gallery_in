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

    public function loadByPassword($username, $password)
    {

    }

    public function login($username, $password)
    {


        return null;
    }


}


?>

