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
		return $sectionId;
	}
	
	
	
	
	public function test() {
		return $this->testList();
	}
	
	public function testList() {
		$img1 = new Photograph();
		
		$img1->id = hash('ripemd160', rand(0, 10000));
		$img1->orginalPath = "resource/gallery/img_repository/img2.jpg";
		$img1->thumbPath = "resource/gallery/img_repository/img2.jpg";
		$img1->orgHeight = 534;
		$img1->orgWidth = 800;
		
		///
		$img2 = new Photograph();
		
		$img2->id = hash('ripemd160', rand(0, 10000));
		$img2->orginalPath = "resource/gallery/img_repository/img3.jpg";
		$img2->thumbPath = "resource/gallery/img_repository/img3.jpg";
		$img2->orgHeight = 561;
		$img2->orgWidth = 800;
		///
		
		$img3 = new Photograph();
		
		$img3->id = hash('ripemd160', rand(0, 10000));
		$img3->orginalPath = "resource/gallery/img_repository/img4.jpg";
		$img3->thumbPath = "resource/gallery/img_repository/img4.jpg";
		$img3->orgHeight = 233;
		$img3->orgWidth = 800;
		
		///
		
		$img4 = new Photograph();
		
		$img4->id = hash('ripemd160', rand(0, 10000));
		$img4->orginalPath = "resource/gallery/img_repository/img5.jpg";
		$img4->thumbPath = "resource/gallery/img_repository/img5.jpg";
		$img4->orgHeight = 361;
		$img4->orgWidth = 800;
		
		///
		
		$img5 = new Photograph();
		
		$img5->id = hash('ripemd160', rand(0, 10000));
		$img5->orginalPath = "resource/gallery/img_repository/img6.jpg";
		$img5->thumbPath = "resource/gallery/img_repository/img6.jpg";
		$img5->orgHeight = 535;
		$img5->orgWidth = 800;
		
		///
		
		$img6 = new Photograph();
		
		$img6->id = hash('ripemd160', rand(0, 10000));
		$img6->orginalPath = "resource/gallery/img_repository/img7.jpg";
		$img6->thumbPath = "resource/gallery/img_repository/img7.jpg";
		$img6->orgHeight = 351;
		$img6->orgWidth = 800;
		
		
		
		$res = [$img1, $img2, $img3, $img4, $img5];
		
		return $res;
	}
	
	
}



?>

