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
	
	public function test() {
		$this->getImgSection('repository');
		
	}
	
	public function getImgSection($typeId, $pageNo = 1, $pageSize = 100, $last = 20) {
		$groupSize = 20;
		
		if($typeId == 'repository') {
			$imgSection = $this->File_manipulation->getRepositoryImgs('resource/img_repository', $pageNo, $pageSize, $last);
		}else{
			$imgSection = $this->Photograph->getSectionImg($typeId, $pageNo, $pageSize, $last);
		}
		
		if ($imgSection == null) {
			return null;
		}
		
		$groupNum = count($imgSection['imgList']) / $groupSize;
		
		if ($groupNum < 2 ) {
			$groupName = 's_'.$typeId.'_g_'."0";
			
			$groupList = array( $groupName =>  array('id' => $groupName, 'imgList' => $imgSection['imgList']));
			
			$res = array('id' => $typeId, 'loadingList' => $groupList, 'waitingList' => array());
			
			
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
			
			$res = array('id' => $typeId, 'loadingList' => array_shift($groupList), 'waitingList' => $groupList);
		}
		
		echo json_encode($res);
		
	}
}



?>

