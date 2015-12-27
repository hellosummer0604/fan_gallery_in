<?php

class Image extends MY_Model {
	public function __construct() {
		parent::__construct();
	}
	
	private $id;
	private $title;
	
	//Path of image in each scale, not null
	private $orginalPath;
	private $moderatePath;
	private $thumbPath;
	
	//basic info of image, not null
	private $author;
	private $created;
	private $lastEdit;
	private $description;
	private $category;
	private $tag;
	private $orgWidth;
	private $orgHeight;
	
	
	
	//detail information of image, optional
	private $detailInfo;
	
	private function getImgList() {
		
	}
	
	
	/**
	 * Before image insert to DB or after load from DB, check whether the image model has all the correct information
	 * 
	 * @param type $img 
	 * @return boolean
	 */
	public function validateImg($img) {
		if (!isset($img)) {
			$img = $this;
		}
		
		
		return true;
	}
	
	
	public function test() {
		
		
		
	}
	
	
}



?>

