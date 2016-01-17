<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_controller extends MY_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Photograph');
		$this->load->model('File_manipulation');
	}
	
	public function index()
	{
		echo "index---";
		echo repository_url("img2.jpg");
		echo "!!!";
		$this->db->query();
	}
	
	public function getImgList($authorID, $category = "undefined", $tag = "undefined") {
		$this->load->model('Image');
		
	}
	
	
	
	
	/**
	 * get img section from database
	 */
	public function getImg() {
	
		if(empty($_POST['sectionId'])){
			return;
		} else {
			$sectionId = $_POST['sectionId'] ;
		}
		
		$pageNo = empty($_POST['page'])? IMG_SECTION_PAGE_NO : $_POST['page'];
		
		$pageSize = empty($_POST['pageSize']) ? IMG_SECTION_PAGE_SIZE : $_POST['pageSize'];
		
		$lastSize = empty($_POST['lastSize']) ? IMG_SECTION_LAST_SIZE : $_POST['lastSize'];
		
		
		$imgSec = $this->getImgSection($sectionId, $pageNo, $pageSize);
		
		if (empty($imgSec)) {
			echo json_encode(null);
		} else {
			echo json_encode($imgSec);
		}
	}
	
	/*
	 * get img section from database
	 * 
	 * $typeId can be 1.repository, 2.category name, 3.tag name, 4 author id
	 */
	
	private function getImgSection($typeId, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$groupSize = 23;
		
		$typeId = strtolower($typeId);
		
		if($typeId == 'repo_id') {
			$imgSection = $this->File_manipulation->getRepositoryImgs('resource/img_repository', $pageNo, $pageSize, $last);
		}else{
			$imgSection = $this->Photograph->getSectionImg($typeId, $pageNo, $pageSize, $last);
		}
		
		
		if (empty($imgSection['imgList'])) {
			return null;
		}
		
		
		
		$groupNum = count($imgSection['imgList']) / $groupSize;
		
		if ($groupNum < 2 ) {
			$groupName = 's_'.$typeId.'_g_'."0";
			
			$groupList = array( $groupName =>  array('id' => $groupName, 'imgList' => $imgSection['imgList']));
			
			$res = array('id' => $typeId, 'loadingList' => array(), 'waitingList' => $groupList);
			
			
		} else {
			$remainImg = count($imgSection['imgList']);
			
			$groupList = array();
			
			for ($i = 0; $i < $groupNum - 2; $i++) {
				$groupName = 's_'.$typeId.'_g_'.$i;
				
				$temp_img_array = array_slice($imgSection['imgList'], $i * $groupSize, $groupSize);
				
				$temp_img_array = array('id' => $groupName, 'imgList' => $temp_img_array);
				
				$groupList[$groupName] = $temp_img_array;
				
				$remainImg = $remainImg - $groupSize;
			}
			//last group
			$groupName = 's_'.$typeId.'_g_'.$i;
			
			$temp_img_array = array_slice($imgSection['imgList'], $i * $groupSize, $remainImg);
			
			$temp_img_array = array('id' => $groupName, 'imgList' => $temp_img_array);
			
			$groupList[$groupName] = $temp_img_array;
			
			$res = array('id' => $typeId, 'loadingList' => array(), 'waitingList' => $groupList);
		}
		
		return $res;
	}
	
	
}



?>

