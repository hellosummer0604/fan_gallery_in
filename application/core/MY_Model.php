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

	public static function loadByTerm($data, $page = null, $pageSize = null, $last = null) {
		if (empty($data)) {
			return null;
		}

		if (is_null($page) || is_null($pageSize)) {
			$res = get_instance()->db->order_by("id", "desc")->get_where(static::$tbl, $data)->result_array();
		} else if (is_null($last)) {
			$res = get_instance()->db->order_by("id", "desc")->get_where(static::$tbl, $data, $pageSize, $page * $pageSize)->result_array();
		} else {
			//get all images
			$count = get_instance()->db->select(" COUNT(*) sum ")->get_where(static::$tbl, $data)->result_array();

			if (empty($count) || $count[0]['sum'] == 0) {
				return null;
			}

			$count = $count[0]['sum'];

			//find how many items in next page
			$numNextPage = $count - (($page + 1) * $pageSize);

			if ($numNextPage < $last) {//load all the rest items
				$fakeInfinity = ($pageSize + $last) * 2; //larger than rest items
			} else {//only load this page
				$fakeInfinity = $pageSize;
			}

			$res = get_instance()->db->order_by("id", "desc")->get_where(static::$tbl, $data, $fakeInfinity, $page * $pageSize)->result_array();
		}

		$objs = self::assembleObjByResultSet($res);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	public static function loadByTermPagination($data, $page = null, $pageSize = null, $last = null) {
		$res = array('pages' => 0, 'current' => 0, 'total' => 0);

		if (empty($data)) {
			return $res;
		}

		$itemCount = get_instance()->db->select(" COUNT(*) num")->order_by("id", "desc")->get_where(static::$tbl, $data)->result_array();
		if (empty($itemCount)) {
			$totalItems = 0;
		} else {
			$totalItems = $itemCount[0]['num'];
		}

		$res['total'] = $totalItems;
		if (is_null($page) || is_null($pageSize)) {//no page
			$res['pages'] = 1;
			$res['current'] = 0;

		} else if (is_null($last)) {//page without last
			$res['pages'] = ceil($totalItems / $pageSize);
			$res['current'] = $page > $res['total'] ? $res['total'] : $page;

		} else {//page with last
			$rest = fmod($totalItems, $pageSize);
			if ($rest < $last) {
				$res['pages'] = round(($totalItems  - $rest) / $pageSize);
			} else {
				$res['pages'] = ceil($totalItems / $pageSize);
			}
			$res['current'] = $page > $res['total'] ? $res['total'] : $page;
		}

		return $res;
	}

	public static function loadByQuery($sql, $data) {
		if (empty($sql)) {
			return null;
		}

		$res = get_instance()->db->query($sql, $data)->result_array();

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

		get_instance()->db->delete(static::$tbl, $data);

		$num = get_instance()->db->affected_rows();

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