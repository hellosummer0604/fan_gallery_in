<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_controller extends MY_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Photograph');
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
		$photo = $this->Photograph;
		
		echo json_encode($photo->test());
	}
}



?>

