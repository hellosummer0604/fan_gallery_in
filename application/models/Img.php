<?php
require_once ('Base_img.php');
require_once ('Tag.php');

class Img extends Base_img
{
	protected static $tbl = "Image";
	protected static $tblTagImg = "Image_tag";

	protected $_exif = null;
	protected $_status = null;
	protected $_thumb = null;
	protected $tags = array();

	/**
	 * @return null
	 */
	public function getExif() {
		return $this->_exif;
	}

	/**
	 * @param null $exif
	 */
	public function setExif($exif) {
		$this->_exif = $exif;
	}

	/**
	 * @return null
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * @param null $status
	 */
	public function setStatus($status) {
		$this->_status = $status;
	}

	/**
	 * @return null
	 */
	public function getThumb($full = false) {
		if ($full) {
			return base_url($this->_thumb);
		} else {
			return $this->_thumb;
		}
	}

	/**
	 * @param null $thumb
	 */
	public function setThumb($thumb) {
		$this->_thumb = $thumb;
	}

	/*
	 * If $refresh is true, it will reload tags from database and lost current tags.
	 */
	public function getTags($refresh = false) {
		if ($refresh) {
			$this->loadTags();
		}

		return $this->tags;
	}

	public function __construct() {
		parent::__construct();
	}

	protected function loadTags() {
		$id = $this->getId();
		if (empty($id)) {
			return false;
		}

		$this->tags = Tag::loadImageTags($this);

		return true;
	}

	public function addTag($tag) {
		array_push($this->tags, $tag);
	}

	private function equalTag($tag1, $tag2) {
		if (empty($tag1) || empty($tag2)) {
			return false;
		}

		if ($tag1->getTagName() != $tag2->getTagName()) {
			return false;
		}

		if ($tag1->getUserId() != $tag2->getUserId()) {
			return false;
		}

		return true;
	}

	public function removeTag($tag) {
		if(!empty($this->tags)) {
			foreach ($this->tags as $key => $item) {
				if ($this->equalTag($item, $tag)) {
					unset($this->tags[$key]);
				}
			}
		}
	}



	public function saveTags() {
		//latest tags of image.
		$current = $this->tags;

		//tags before updates
		$this->loadTags();
		$origin = $this->tags;

		$adds = array();
		$removes = array();

		if (!empty($current)) {
			foreach ($current as $item) {
				$exist = false;

				foreach ($origin as $oldItem) {
					if ($this->equalTag($oldItem, $item)) {
						$exist = true;
						break;
					}
				}

				if ($exist == false) {
					$adds[] = $item;
				}
			}
		}

		if (!empty($origin)) {
			foreach ($origin as $item) {
				$exist = false;

				foreach ($current as $newItem) {
					if ($this->equalTag($newItem, $item)) {
						$exist = true;
						break;
					}
				}

				if ($exist == false) {
					$removes[] = $item;
				}
			}
		}

		if (!empty($adds)) {
			foreach ($adds as $add) {
				$add->addToImg($this);
			}
		}

		if (!empty($removes)) {
			foreach ($removes as $remove) {
				$remove->removeFromImg($this);
			}
		}

		return true;
	}

	public function save() {
		$res = parent::save();

		if ($res) {
			$this->saveTags();
		}

		return $res;
	}

	/**
	 * Must load tags after img loaded.
	 *
	 * Don't forget to add this when you're creating new loading functions
	 *
	 * @param $data
	 * @param int $page
	 * @param int|null $pageSize
	 * @param null $last
	 * @return array|null
	 */
	public static function loadByTerm($data, $page = 0, $pageSize = IMG_SECTION_PAGE_SIZE, $last = null) {
		$objs = parent::loadByTerm($data, $page, $pageSize, $last);

		if (!empty($objs)) {
			foreach ($objs as &$obj) {
				$obj->loadTags();
			}
		}

		return $objs;
	}

	public static function load($id) {
		$obj = parent::load($id);

		if (!empty($obj)) {
			$obj->loadTags();
		}

		return $obj;
	}

	public static function loadByQuery($sql, $data) {
		$objs = parent::loadByQuery($sql, $data);

		if (!empty($objs)) {
			foreach ($objs as &$obj) {
				$obj->loadTags();
			}
		}

		return $objs;
	}

	private static function loadByAuthorAndStatus($userId, $status, $page = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		if (empty($userId) || empty($status)) {
			return null;
		}

		$data = array();

		$data['user_id'] = $userId;
		$data['status'] = $status;

		$objs = self::loadByTerm($data, $page, $pageSize, $last);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	public static function loadRepository($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		return self::loadByAuthorAndStatus(self::$util->isOnline(), IMG_STATE_REPO, $pageNo, $pageSize, $last);
	}

	public static function getRepositoryImgs($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$imgs = self::loadRepository($pageNo, $pageSize, $last);

		$imgSection = self::$util->imgSectionPreprocessor(REPO_ID, $imgs);

		return $imgSection;
	}

	public static function getRepositoryImgsPagination($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE) {

	}


	/************************** start load img section for user **************************/
	public static function getSectionImg($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last) {

	}

	/************************** end load img section for user **************************/

}


?>

