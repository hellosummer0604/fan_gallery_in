<?php

class MY_Model extends CI_Model {
	protected static $tbl = "";
	protected static $util = null;

	protected $_id = null;
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
	public function getCreated() {
		return $this->_created;
	}

	public function __construct() {
		parent::__construct();
		self::$util = &get_instance()->utils;
	}

	/********** start static function **********/
	public static function load($id) {
		if (empty($id)) {
			return false;
		}

		$objs = self::loadByTerm(array('id'=>$id));

		if (empty($objs)) {
			return null;
		}

		return $objs[0];
	}

	public static function loadByTerm($data) {
		if (empty($data)) {
			return null;
		}

		$res = &get_instance()->db->get_where(static::$tbl, $data)->result_array();

		$objs = self::assembleObjByResultSet($res);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	public static function loadByQuery($sql, $data) {
		if (empty($sql)) {
			return null;
		}

		$res = &get_instance()->db->query($sql, $data)->result_array();

		$objs = self::assembleObjByResultSet($res);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	 protected static function assembleObjByResultSet($res) {
		if (empty($res)) {
			return null;
		}

		$class = get_called_class();

		$objList = array();

		foreach ($res as $re) {
			$obj = new $class();

			foreach ($re as $col => $item) {
				$propertyName = "_".$col;
				$obj->$propertyName = $item;
			}

			$objList[] = $obj;
		}

		return $objList;
	}

	public static function deleteById($id) {
		if (empty($id)) {
			return false;
		}

		$data = array("id" => $id);

		$res = &get_instance()->db->delete(static::$tbl, $data);

		$num = &get_instance()->db->affected_rows();

		return $num > 0;
	}

	/********** end static function **********/

//	public function init() {
//
//	}
//
//	public function requireInit() {
//
//	}

	public function save() {
		if (empty(static::$tbl)) {
			return false;
		}

		//insert, need generate an id.
		if (empty($this->_created)) {
			$this->_id = $this->generateId();
			$this->_created = date("Y-m-d H:i:s");

			$props = get_object_vars($this);

			if (empty($props)) {
				return false;
			}

			$insertData = array();
			foreach ($props as $key => $prop) {
				if (!empty($key) && $key[0] == "_") {
					$insertData[substr($key, 1)] = $prop;
				}
			}

			if (empty($insertData) && !$this->validateFields()) {
				return false;
			}

			$this->db->insert(static::$tbl, $insertData);

			if (empty($this->_id)) {
				$this->_id = $this->db->insert_id();
			}

			return $this->db->affected_rows() > 0;
		} else {//update
			$thisId = $this->getId();
			if (empty($thisId)) {
				return false;
			}

			$props = get_object_vars($this);
			if (empty($props)) {
				return false;
			}

			$updateData = array();
			foreach ($props as $key => $prop) {
				//dont update id and created date
				if (!empty($key) && $key[0] == "_" && $key != "_id" && $key != "_created") {
					$updateData[substr($key, 1)] = $prop;
				}
			}

			if (empty($updateData) && !$this->validateFields()) {
				return false;
			}

			$this->db->update(static::$tbl, $updateData, array("id" => $this->getId()));

			return $this->db->affected_rows() > 0;
		}

		return false;
	}

	//validate fields before save
	protected function validateFields() {

	}

	protected function generateId() {
		return $this->utils->rndId();
	}

	public function delete() {
		$this->db->delete(static::$tbl, array("id" => $this->getId()));

		return $this->db->affected_rows() > 0;
	}



}

?>