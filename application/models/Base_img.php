<?php

abstract class Base_img extends MY_Model
{
	protected static $tbl = "";

	//columns in database start with underscore
	protected $_user_id = null;
	protected $_path = null;
	protected $_filename = null;
	protected $_type = null;
	protected $_size = null;
	protected $_width = null;
	protected $_height = null;


	/**
	 * @return null
	 */
	public function getUserId() {
		return $this->_user_id;
	}

	/**
	 * @param null $user_id
	 */
	public function setUserId($user_id) {
		$this->_user_id = $user_id;
	}

	/**
	 * @return null
	 */
	public function getPath() {
		return $this->_path;
	}

	/**
	 * @param null $path
	 */
	public function setPath($path) {
		$this->_path = $path;
	}

	/**
	 * @return null
	 */
	public function getFilename() {
		return $this->_filename;
	}

	/**
	 * @param null $filename
	 */
	public function setFilename($filename) {
		$this->_filename = $filename;
	}

	/**
	 * @return null
	 */
	public function getType() {
		return $this->_type;
	}

	/**
	 * @param null $type
	 */
	public function setType($type) {
		$this->_type = $type;
	}

	/**
	 * @return null
	 */
	public function getSize() {
		return $this->_size;
	}

	/**
	 * @param null $size
	 */
	public function setSize($size) {
		$this->_size = $size;
	}

	/**
	 * @return null
	 */
	public function getWidth() {
		return $this->_width;
	}

	/**
	 * @param null $width
	 */
	public function setWidth($width) {
		$this->_width = $width;
	}

	/**
	 * @return null
	 */
	public function getHeight() {
		return $this->_height;
	}

	/**
	 * @param null $height
	 */
	public function setHeight($height) {
		$this->_height = $height;
	}

	protected function generateId() {
		return null;
	}

	public function __construct() {
		parent::__construct();
	}

	/********** start static function **********/
	public static function loadByFileAndUser($fileName, $userId) {
		$data = array();

		if (!empty($fileName)) {
			$data['filename'] = $fileName;
		} else {
			return null;
		}

		if (!empty($userId)) {
			$data['user_id'] = $userId;
		} else {
			return null;
		}

		$objs = self::loadByTerm($data);

		if (empty($objs)) {
			return null;
		}

		return $objs[0];
	}

	public static function deleteById($id) {
		$img = self::load($id);

		return $img->delete();
	}

	/********** end static function **********/

	public function getFullPath() {
		return $this->getPath().$this->getFilename();
	}

	public function delete() {
		$uniqueKey = str_replace(".".$this->getType(), "", $this->getFilename());
		print_r($uniqueKey);
		$res = parent::delete();

		if ($res) {
			$this->db->delete("Unique_id_img", array("str" => $uniqueKey));
		}

		return $res;
	}



}


?>

