<?php

class Photograph extends MY_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public $id;
	public $title;
	
	//Path of image in each scale, not null
	public $orginalPath;
	public $thumbPath;
	
	//basic info of image, not null
	public $author;
	public $created;
	public $lastEdit;
	public $description;
	public $category;
	public $tag;
	public $orgWidth;
	public $orgHeight;
	
	
	
	//detail information of image, optional
	public $detailInfo;
	
	
	//author, category, tag
	public function getSectionImg($sectionId, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE ) {
		return $this->fakeList($sectionId);
	}
	
	public function fakeList($sid) {
		$fake = "{\"sectionId\":\"".$sid."\",\"imgList\":[{\"id\":\"img28.jpg\",\"thumb\":\".\/resource\/gallery\/img_repository\/img28.jpg\",\"width\":800,\"height\":534},{\"id\":\"img11.jpg\",\"thumb\":\".\/resource\/gallery\/img_repository\/img11.jpg\",\"width\":800,\"height\":427},{\"id\":\"img7.jpg\",\"thumb\":\".\/resource\/gallery\/img_repository\/img7.jpg\",\"width\":800,\"height\":351}]}";
		return  json_decode($fake, true);
	}
	
	//get image detail from database
	public function getImg($imgId) {
		return null;
	}
	
}



?>

