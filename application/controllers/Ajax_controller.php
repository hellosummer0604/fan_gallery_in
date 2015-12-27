<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_controller extends MY_Controller {

	
	public function index()
	{
		echo "index---";
		echo repository_url("img2.jpg");
		echo "!!!";
	}
	
	public function getImgList($authorID, $category = "undefined", $tag = "undefined") {
		$this->load->model('Image');
		
	}
}



?>

