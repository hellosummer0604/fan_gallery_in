<?php
/**
 * Created by PhpStorm.
 * User: tianxia
 * Date: 9/18/16
 * Time: 4:18 PM
 */

require_once(APPPATH . 'models/Img.php');
class Tag extends MY_Model {
	protected static $tbl = "Tag";
	protected static $tblTagImg = "Image_tag";

	//columns in database start with underscore
	protected $_tag_name = null;
	protected $_user_id = null;

	public function getUserId() {
		return $this->_user_id;
	}

	public function getTagName() {
		return $this->_tag_name;
	}

	/**
	 * use database generated id
	 **/
	protected function generateId() {
		return null;
	}

	/**
	 * tag_name and user_id cannot be empty
	 * @return bool
	 */
	public function save() {
		if ($this->isEmpty()) {
			return false;
		}

		return parent::save();
	}

	/**
	 * Tag constructor.
	 *
	 * If this tag is already in database, load it.
	 *
	 * @param $tagName
	 * @param $userId
	 */
	public function __construct($tagName = null, $userId = null) {
		parent::__construct();

		$data['tag_name'] = trim($tagName);
		$data['user_id'] = $userId;

		if (empty($data['tag_name']) || empty($data['user_id'])) {
			return;
		}

		$tag = self::loadByTerm($data);

		if (empty($tag)) {
			$this->_tag_name = $tagName;
			$this->_user_id = $userId;
		} else {
			//copy all database columns
			foreach ($tag[0] as $key => $value) {
				if (substr($key, 0, 1) == '_') {
					$this->$key = $value;
				}
			}
		}
	}

	/**
	 * If a tag is just created but haven't been saved into database
	 */
	public function isNew() {
		if (empty($this->_id) && empty($this->_created)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 1. Cannot be saved, updated, deleted, associated, unassociated If tag obj is empty
	 * 2. Empty obj is just for codeIgniter loading
	 * 3. Does not have setters
	 *
	 * @return bool
	 */
	public function isEmpty() {
		if (empty($this->_tag_name) || empty($this->_user_id)) {
			return true;
		} else {
			return false;
		}
	}

	public function updateTagName($newName) {
		if ($this->isEmpty()) {
			return false;
		}

		if (empty($newName)) {
			return false;
		}

		$newName = trim($newName);
		if (empty($newName)) {
			return false;
		}

		$this->_tag_name = $newName;
		$this->save();

		return true;
	}

	/*************** start image - tag relationship ******************************/
	/*************** start image - tag relationship ******************************/

	/*
	 * add this tag to image
	 *
	 * $img must have id at least
	 */
	public function addToImg($img) {
		if ($this->isEmpty()) {
			return false;
		}

		if (empty($img)) {
			return false;
		}

		$imgId = $img->getId();

		if (empty($imgId)) {
			return false;
		}

		//update or insert tag
		if ($this->isNew()) {
			$saved = $this->save();
			if (!$saved) {
				return false;
			}
		}

		$data = array();
		$data['tag_id'] = $this->_id;
		$data['image_id'] = $imgId;
		$data['created'] = date("Y-m-d H:i:s");

		//avoid duplicate relationships in Image_tag table
		$sql = "SELECT id FROM ".self::$tblTagImg." WHERE tag_id = ? AND image_id = ?";
		$res = self::loadByQuery($sql, array($data['tag_id'], $data['image_id']));

		if (empty($res)) {
			$this->db->insert(self::$tblTagImg, $data);
		}

		return true;
	}

	/*
	 * remove this tag from img
	 *
	 * $img must have id at least
	 */
	public function removeFromImg($img) {
		if ($this->isEmpty()) {
			return false;
		}

		if (empty($img)) {
			return false;
		}

		$imgId = $img->getId();

		if (empty($imgId)) {
			return false;
		}

		if ($this->isNew()) {
			return true;
		}

		$sql = "DELETE FROM ".self::$tblTagImg." WHERE tag_id = ? AND image_id = ?";

		$this->db->query($sql, array($this->_id, $imgId));

		$this->deleteUnused();

		return true;
	}

	/*
	 * If this tag has no images, delete this tag
	 */
	public function deleteUnused() {
		return self::clearEmptyTag($this);
	}

	public static function loadImageTags($img) {
		if (empty($img)) {
			return array();
		}

		$imgId = $img->getId();

		if (empty($imgId)) {
			return array();
		}

		$Tag = self::$tbl;
		$Image_tag = self::$tblTagImg;

		$sql = "SELECT $Tag.* FROM $Tag INNER JOIN $Image_tag ON $Tag.id = $Image_tag.tag_id WHERE $Image_tag.image_id = ?";
		$objs = self::loadByQuery($sql, array($imgId));

		if (empty($objs)) {
			return array();
		} else {
			return $objs;
		}

	}


	/*************** end image - tag relationship ******************************/
	/*************** end image - tag relationship ******************************/

	/*
	 * If this tag has no images, delete this tag
	 */
	public static function clearEmptyTag($tagObj) {
		if (empty($tagObj)) {
			return;
		}

		if ($tagObj->getTagName() == IMG_UNASSIGNED) {
			return;
		}

		$res = get_instance()->db->select(" COUNT(*) num")->from(self::$tblTagImg)->where(array(self::$tblTagImg.'.tag_id' => $tagObj->getId()))->get()->result_array();

		if (empty($res) || $res[0]['num'] < 1) {//no images under this tag, delete this tag
			$tagObj->delete();
		}
	}

	public static function getAllTags($userId) {
		if (empty($userId)) {
			return null;
		}

		$data = array('user_id' => $userId);

		return self::loadByTerm($data);
	}


}