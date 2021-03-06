<?php
require_once ('Base_img.php');
require_once ('Tag.php');

class Img extends Base_img
{
	protected static $tbl = "Image";
	protected static $tblTagImg = "Image_tag";

	protected $_exif = null;
	protected $_text = null;
	protected $_visited = null;
	protected $_featured = null;
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
	public function getText() {
		return $this->_text;
	}

	/**
	 * @param null $text
	 */
	public function setText($text) {
		$this->_text = $text;
	}

	/**
	 * @return null
	 */
	public function getVisited() {
		return $this->_visited;
	}

	/**
	 * If featured, it will be sticked on your homepage randomly
	 * @return null
	 */
	public function getFeatured() {
		return $this->_featured;
	}

	/**
	 * @param null $featured
	 */
	public function setFeatured($featured) {
		$this->_featured = $featured;
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

	public function clearTags() {
		$this->tags = array();
	}

	public function addTag($tag) {
		if (!empty($tag)) {
			array_push($this->tags, $tag);
		}
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
				$remove->deleteUnused();
			}
		}

		return true;
	}

	public function save() {
		//dont update visited
		$visited = $this->_visited;
		unset($this->_visited);

		$res = parent::save();

		//recover visited
		$this->_visited = $visited;

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

	public static function loadFeatured($userId = null, $status = IMG_STATE_PUBLIC, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$data = array();
		$data['featured'] = true;

		if (!empty($userId)) {
			$data['user_id'] = $userId;
		}

		if (!empty($status)) {
			$data['status'] = $status;
		}

		$objs = self::loadByTerm($data, $pageNo, $pageSize, $last);
		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	public static function loadFeaturedPagination($userId = null, $status = IMG_STATE_PUBLIC, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$data = array();
		$data['featured'] = true;

		if (!empty($userId)) {
			$data['user_id'] = $userId;
		}

		if (!empty($status)) {
			$data['status'] = $status;
		}

		return self::loadByTermPagination($data, $pageNo, $pageSize, $last);
	}


	private static function loadByAuthorAndStatus($userId, $status, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		if (empty($userId) || empty($status)) {
			return null;
		}

		$data = array();

		$data['user_id'] = $userId;
		$data['status'] = $status;

		$objs = self::loadByTerm($data, $pageNo, $pageSize, $last);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	public static function loadRepository($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		return self::loadByAuthorAndStatus(self::$util->isOnline(), IMG_STATE_REPO, $pageNo, $pageSize, $last);
	}

	public static function loadRepositoryPagination($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$data = array();
		$data['user_id'] = self::$util->isOnline();
		$data['status'] = IMG_STATE_REPO;

		return self::loadByTermPagination($data, $pageNo, $pageSize, $last);
	}

	public static function getRepositoryImgs($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$imgs = self::loadRepository($pageNo, $pageSize, $last);
		$pagination = self::loadRepositoryPagination($pageNo, $pageSize, $last);

		$imgSection = self::$util->imgSectionPreprocessor(REPO_ID, $imgs, $pagination);

		return $imgSection;
	}

	public static function getRepositoryImgsPagination($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE) {

	}


	/************************** start load img section for user **************************/
	/**
	 * 1. except repo
	 * 2. visitor can only get public photo
	 * @param $userId
	 * @param null $tagId
	 * @param int $page
	 * @param int $pageSize
	 * @param int $last
	 * @param null $visitor
	 * @return array|null
	 */
	public static function loadSectionImgs($userId = null, $tagId = null, $page = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {
		$imgTbl = self::$tbl;
		$imgTagTbl = self::$tblTagImg;

		if (!empty($userId)) {
			$data = array(
				"$imgTbl.user_id" => $userId
			);
		}


		//if not owner, only public photo is visiable
		if (empty($userId) || $visitor != $userId) {
			$data["$imgTbl.status"] = IMG_STATE_PUBLIC;
		}

		$data["$imgTbl.status != "] = IMG_STATE_REPO;
		$data["$imgTagTbl.tag_id"] = $tagId;

		if (is_null($page) || is_null($pageSize)) {
			$res = get_instance()->db
								->select("$imgTbl.*")
								->from($imgTbl)
								->join($imgTagTbl, "$imgTbl.id  = $imgTagTbl.image_id", 'inner')
								->where($data)
								->order_by("$imgTbl.id", "desc")
								->get()
								->result_array();

		} else if (is_null($last)) {
			$res = get_instance()->db
								->select("$imgTbl.*")
								->from($imgTbl)
								->join($imgTagTbl, "$imgTbl.id  = $imgTagTbl.image_id", 'inner')
								->where($data)
								->order_by("$imgTbl.id", "desc")
								->limit($pageSize, $page * $pageSize)
								->get()
								->result_array();
		} else {
			//get all images
			$count = get_instance()->db
								->select(" COUNT(*) sum")
								->from($imgTbl)
								->join($imgTagTbl, "$imgTbl.id  = $imgTagTbl.image_id", 'inner')
								->where($data)
								->get()
								->result_array();

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

			$res = get_instance()->db
				->select("$imgTbl.*")
				->from($imgTbl)
				->join($imgTagTbl, "$imgTbl.id  = $imgTagTbl.image_id", 'inner')
				->where($data)
				->order_by("$imgTbl.id", "desc")
				->limit($fakeInfinity, $page * $pageSize)
				->get()
				->result_array();
		}

		$objs = self::assembleObjByResultSet($res);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	/**
	 * The difference from loadSectionImgs are
	 * 1. remove join
	 * 2. remove where on tagid
	 *
	 * @param null $userId
	 * @param int $page
	 * @param int $pageSize
	 * @param int $last
	 * @param null $visitor
	 * @param null $orderBy
	 * @return array|null
	 */
	public static function loadAllSectionImgs($userId = null, $page = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null, $orderBy = null) {
		$imgTbl = self::$tbl;

		if (empty($orderBy)) {
			$orderBy = "$imgTbl.id";
		} else {
			$orderBy = "$imgTbl.$orderBy";
		}

		if (!empty($userId)) {
			$data = array(
				"$imgTbl.user_id" => $userId
			);
		}

		//if not owner, only public photo is visiable
		if (empty($userId) || $visitor != $userId) {
			$data["$imgTbl.status"] = IMG_STATE_PUBLIC;
		}

		$data["$imgTbl.status != "] = IMG_STATE_REPO;

		if (is_null($page) || is_null($pageSize)) {
			$res = get_instance()->db
				->select("$imgTbl.*")
				->from($imgTbl)
				->where($data)
				->order_by($orderBy, "desc")
				->order_by("$imgTbl.id", "desc")
				->get()
				->result_array();

		} else if (is_null($last)) {
			$res = get_instance()->db
				->select("$imgTbl.*")
				->from($imgTbl)
				->where($data)
				->order_by($orderBy, "desc")
				->order_by("$imgTbl.id", "desc")
				->limit($pageSize, $page * $pageSize)
				->get()
				->result_array();
		} else {
			//get all images
			$count = get_instance()->db
				->select(" COUNT(*) sum")
				->from($imgTbl)
				->where($data)
				->order_by($orderBy, "desc")
				->order_by("$imgTbl.id", "desc")
				->get()
				->result_array();

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

			$res = get_instance()->db
				->select("$imgTbl.*")
				->from($imgTbl)
				->where($data)
				->order_by($orderBy, "desc")
				->order_by("$imgTbl.id", "desc")
				->limit($fakeInfinity, $page * $pageSize)
				->get()
				->result_array();
		}

		$objs = self::assembleObjByResultSet($res);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

	public static function loadSectionImgsPagination($userId = null, $tagId = null, $page = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {
		$imgTbl = self::$tbl;
		$imgTagTbl = self::$tblTagImg;

		if (!empty($userId)) {
			$data = array(
				"$imgTbl.user_id" => $userId
			);
		}


		//if not owner, only public photo is visiable
		if (empty($userId) || $visitor != $userId) {
			$data["$imgTbl.status"] = IMG_STATE_PUBLIC;
		}

		$data["$imgTbl.status != "] = IMG_STATE_REPO;


		if (!empty($tagId)) {
			$data["$imgTagTbl.tag_id"] = $tagId;
		}

		$res = array('pages' => 0, 'current' => 0, 'total' => 0);

		$itemCount = get_instance()->db
			->select(" COUNT(*) num")
			->from($imgTbl)
			->join($imgTagTbl, "$imgTbl.id  = $imgTagTbl.image_id", 'inner')
			->where($data)
			->get()
			->result_array();

		if (empty($itemCount)) {
			$totalItems = 0;
		} else {
			$totalItems = $itemCount[0]['num'];
		}

		$res['total'] = $totalItems;
		if (is_null($page) || is_null($pageSize)) {//without page
			$res['pages'] = 1;
			$res['current'] = 0;

		} else if (is_null($last)) {//page without last number
			$res['pages'] = ceil($totalItems / $pageSize);
			$res['current'] = $page > $res['total'] ? $res['total'] : $page;

		} else {//page with last number
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

	/**
	 * The difference from loadSectionImgs are
	 * 1. remove join
	 * 2. remove where on tagid
	 * @param $userId
	 * @param int $page
	 * @param int $pageSize
	 * @param int $last
	 * @param null $visitor
	 * @return array
	 */
	public static function loadAllSectionImgsPagination($userId = null, $page = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {
		$imgTbl = self::$tbl;

		if (!empty($userId)) {
			$data = array(
				"$imgTbl.user_id" => $userId
			);
		}

		//if not owner, only public photo is visiable
		if (empty($userId) || $visitor != $userId) {
			$data["$imgTbl.status"] = IMG_STATE_PUBLIC;
		}

		$data["$imgTbl.status != "] = IMG_STATE_REPO;

		$res = array('pages' => 0, 'current' => 0, 'total' => 0);

		$itemCount = get_instance()->db
			->select(" COUNT(*) num")
			->from($imgTbl)
			->where($data)
			->get()
			->result_array();

		if (empty($itemCount)) {
			$totalItems = 0;
		} else {
			$totalItems = $itemCount[0]['num'];
		}

		$res['total'] = $totalItems;
		if (is_null($page) || is_null($pageSize)) {//without page
			$res['pages'] = 1;
			$res['current'] = 0;

		} else if (is_null($last)) {//page without last number
			$res['pages'] = ceil($totalItems / $pageSize);
			$res['current'] = $page > $res['total'] ? $res['total'] : $page;

		} else {//page with last number
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


	public static function getSectionImg($userId, $tagId, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null, $orderBy = null) {
		if (strtolower($tagId) == TAG_ALL) {
			$imgs = self::loadAllSectionImgs($userId, $pageNo, $pageSize, $last, $visitor, $orderBy);
			$pagination = self::loadAllSectionImgsPagination($userId, $pageNo, $pageSize, $last, $visitor);
		} elseif (strtolower($tagId) == TAG_FEATURED) {
			$imgs = self::loadFeatured($userId, null, $pageNo, $pageSize, $last);
			$pagination = self::loadFeaturedPagination($userId, null, $pageNo, $pageSize, $last);
		} else {
			$imgs = self::loadSectionImgs($userId, $tagId, $pageNo, $pageSize, $last, $visitor);
			$pagination = self::loadSectionImgsPagination($userId, $tagId, $pageNo, $pageSize, $last, $visitor);
		}

		$tag = Tag::load($tagId);

		if (empty($tag)) {
			$sectionName = TAG_ALL;
		} else {
			$sectionName = $tag->getTagName();
		}

		$imgSection = self::$util->imgSectionPreprocessor($sectionName, $imgs, $pagination);

		return $imgSection;
	}

	public static function getFeaturedSectionImg($userId, $status = IMG_STATE_PUBLIC, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$imgs = self::loadFeatured($userId, $status, $pageNo, $pageSize, $last);
		$pagination = self::loadFeaturedPagination($userId, $status, $pageNo, $pageSize, $last);

		$sectionName = TAG_FEATURED;

		$imgSection = self::$util->imgSectionPreprocessor($sectionName, $imgs, $pagination);

		return $imgSection;
	}

	/************************** end load img section for user **************************/
	/**
	 * @param $imgId
	 */
	public static function addVisitedCount($imgId) {
		$imgTbl = self::$tbl;
		$sql = "UPDATE $imgTbl SET visited = visited + 1 WHERE id = ?";

		get_instance()->db->query($sql, array($imgId));
	}
}


?>

