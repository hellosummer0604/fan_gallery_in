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

	private function checkFieldExist($needle = null, $field = null) {
		if (empty($needle) || empty($field)) {
			throw new Exception('parameter error');
		}
		//todo
		return false;
	}

	public function checkEmailExist($email) {
		return $this->checkFieldExist($email, 'email');
	}

	public function checkUsernameExist($username) {
		return $this->checkFieldExist($username, 'username');
	}

    public function load($uid)
    {
		//todo
    }

	//$identifier can be email or username
    public function loadByPassword($identifier = null, $password = null)
    {
		//todo
		return true;
    }

    public function login($username, $password)
    {
		//todo

        return null;
    }


}


?>

