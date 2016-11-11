<?php

class Master_user extends MY_Model
{
	public function __construct() {
		parent::__construct();
		$this->load->model('Img');
	}

	public function getRecentPhotos($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {
		return $this->Img->getSectionImg(null, TAG_ALL, $pageNo, $pageSize, $last, $visitor);
	}



	public function getPopularPhotos($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {

	}

	public function getFeaturedPhotos($pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {

	}

	public function getPhotos($type, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $visitor = null) {
		$res = null;

		switch ($type) {
			case TAG_NEW:
				$res =  $this->getRecentPhotos($pageNo, $pageSize, $last, $visitor);
				break;

			case TAG_POPULAR:
				$res = $this->getPopularPhotos($pageNo, $pageSize, $last, $visitor);
				break;

			case TAG_FEATURED:
				$res = $this->getFeaturedPhotos($pageNo, $pageSize, $last, $visitor);
				break;
		}

		//recover section tag id
		if (!empty($res)) {
			$res['sectionId'] = $type;
		}

		return $res;
	}
}


?>

