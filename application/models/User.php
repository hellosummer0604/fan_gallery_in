<?php

class User extends MY_Model
{
	private $tbl = "User";

	public $id = null;
	public $username = null;
	public $email = null;
	public $password = null;
	public $type = TYPE_USER;
	public $created = null;
	public $first_name = null;
	public $last_name = null;

	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * @return null
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param null $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return null
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param null $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return null
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param null $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return null
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param null $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return int
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param int $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return null
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @param null $created
	 */
	public function setCreated($created) {
		$this->created = $created;
	}

	/**
	 * @return null
	 */
	public function getFirstName() {
		return $this->first_name;
	}

	/**
	 * @param null $first_name
	 */
	public function setFirstName($first_name) {
		$this->first_name = $first_name;
	}

	/**
	 * @return null
	 */
	public function getLastName() {
		return $this->last_name;
	}

	/**
	 * @param null $last_name
	 */
	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}




	private function checkFieldExist($needle = null, $field = null) {
		if (empty($needle) || empty($field)) {
			throw new Exception('parameter error');
		}

		$res = $this->db->get_where($this->tbl, array($field => $needle))->result();

		if (empty($res)) {
			return false;
		} else {
			return true;
		}
	}

	public function checkEmailExist($email) {
		return $this->checkFieldExist($email, 'email');
	}

	public function checkUsernameExist($username) {
		return $this->checkFieldExist($username, 'username');
	}

	//$identifier can be email or username
    public function loadByPassword($identifier = null, $password = null)
    {
		$password = md5($password);
		$sql = "SELECT * FROM ".$this->tbl." WHERE password = ? AND (email = ? OR username = ?)";
		$obj = $this->db->query($sql, array($password, $identifier, $identifier))->row(0, "User");

		return $obj;
    }

    public function login($identifier, $password)
    {
		$user = $this->loadByPassword($identifier, $password);

		if (!empty($user)) {
			$this->utils->addLoginSession($user);
			return $user;
		} else {
			return null;
		}
    }

	public function signup($data = null) {
		if (empty($data)) {
			return false;
		}

		$flag = false;

		if (array_key_exists('username', $data)) {
			$this->username = $data['username'];
		} else {
			$flag = true;
		}

		if (array_key_exists('email', $data)) {
			$this->email = $data['email'];
		} else {
			$flag = true;
		}

		if (array_key_exists('password', $data)) {
			$this->password = md5($data['password']);
		} else {
			$flag = true;
		}

		if ($flag) {
			return false;
		}

		$this->id = md5(uniqid(rand(), true));
		$this->created = date("Y-m-d H:i:s");

		$res = $this->save();

		if ($res) {
			$this->utils->addLoginSession($this);
		}

		return $res;
	}

	public function save() {
		$data = array(
			'id' => $this->id,
			'username' => $this->username,
			'email' => $this->email,
			'password' => $this->password,
			'type' => $this->type,
			'created' => $this->created,
			'last_name' => $this->last_name,
			'first_name' => $this->first_name
		);

		return $this->db->insert($this->tbl, $data);
	}
}


?>

