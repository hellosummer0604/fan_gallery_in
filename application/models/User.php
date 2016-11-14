<?php

class User extends MY_Model
{
	protected static $tbl = "User";

	protected $_id = null;
	protected $_username = null;
	protected $_email = null;
	protected $_password = null;
	protected $_type = TYPE_USER;
	protected $_first_name = null;
	protected $_last_name = null;
	protected $_primary_headline = null;
	protected $_second_headline = null;
	protected $_created = null;

	/**
	 * @return null
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @return null
	 */
	public function getUsername() {
		return $this->_username;
	}

	/**
	 * @param null $username
	 */
	public function setUsername($username) {
		$this->_username = $username;
	}

	/**
	 * @return null
	 */
	public function getEmail() {
		return $this->_email;
	}

	/**
	 * @param null $email
	 */
	public function setEmail($email) {
		$this->_email = $email;
	}

	/**
	 * @return null
	 */
	public function getPassword() {
		return $this->_password;
	}

	/**
	 * @param null $password
	 */
	public function setPassword($password) {
		$this->_password = $password;
	}

	/**
	 * @return int
	 */
	public function getType() {
		return $this->_type;
	}

	/**
	 * @param int $type
	 */
	public function setType($type) {
		$this->_type = $type;
	}

	/**
	 * @return null
	 */
	public function getFirstName() {
		return $this->_first_name;
	}

	/**
	 * @param null $first_name
	 */
	public function setFirstName($first_name) {
		$this->_first_name = $first_name;
	}

	/**
	 * @return null
	 */
	public function getLastName() {
		return $this->_last_name;
	}

	/**
	 * @param null $last_name
	 */
	public function setLastName($last_name) {
		$this->_last_name = $last_name;
	}

	/**
	 * @return null
	 */
	public function getPrimaryHeadline() {
		return $this->_primary_headline;
	}

	/**
	 * @param null $primary_headline
	 */
	public function setPrimaryHeadline($primary_headline) {
		$this->_primary_headline = $primary_headline;
	}

	/**
	 * @return null
	 */
	public function getSecondHeadline() {
		return $this->_second_headline;
	}

	/**
	 * @param null $second_headline
	 */
	public function setSecondHeadline($second_headline) {
		$this->_second_headline = $second_headline;
	}

	/**
	 * @return null
	 */
	public function getCreated() {
		return $this->_created;
	}


	public function __construct()
	{
		parent::__construct();


	}


	/********** start static function **********/


	public static function checkEmailExist($email) {
		$data['email'] = $email;

		$objs = self::loadByTerm($data);

		if (empty($objs)) {
			return false;
		}

		return true;
	}

	public static function checkUsernameExist($username) {
		$data['username'] = $username;

		$objs = self::loadByTerm($data);

		if (empty($objs)) {
			return false;
		}

		return true;
	}

	//$identifier can be email or username
    public static function loadByPassword($identifier = null, $password = null)
    {
    	$data['password'] = $password;
		$data['username'] = $identifier;

		$obj = self::loadByTerm($data);

		if (empty($obj)) {
			unset($data);
			$data['password'] = $password;
			$data['email'] = $identifier;

			$obj = self::loadByTerm($data);
		}


		return $obj;
    }

    public static function login($identifier, $password)
    {
		$user = self::loadByPassword($identifier, md5($password));

		if (!empty($user)) {
			self::$util->addLoginSession($user[0]->getId());
			return $user[0];
		} else {
			return null;
		}
    }

	public static function signup($data = null) {
		if (empty($data)) {
			return null;
		}

		$class = get_called_class();
		$obj = new $class();

		$flag = false;

		if (array_key_exists('username', $data)) {
			$obj->setUsername($data['username']);
		} else {
			$flag = true;
		}

		if (array_key_exists('email', $data)) {
			$obj->setEmail($data['email']);
		} else {
			$flag = true;
		}

		if (array_key_exists('password', $data)) {
			$obj->setPassword(md5($data['password']));
		} else {
			$flag = true;
		}

		if ($flag) {
			return null;
		}

		if ($obj->save()) {
			self::$util->addLoginSession($obj->getId());
			return $obj;
		} else {
			return null;
		}
	}

	/********** end static function **********/
}


?>

