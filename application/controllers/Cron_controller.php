<?php
ini_set('max_execution_time', 300);
set_time_limit(300);
defined('BASEPATH') or exit('No direct script access allowed');

class Cron_controller extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$key = $_GET['k'];

//		if ($key != ARB_activationKey) {
//			show_404();
//		}

		$this->load->model('Photograph');
		$this->load->model('Repository');
		$this->load->model('Img');
	}

	public function test() {

	}

	//delete tag if no image in it
	public function clearEmptyTags() {

	}

	/*********** start calculate how many imgs and public imgs in each tag *********/
	//todo wrong sql
	private function countTagImg() {
//		$sql = "SELECT COUNT(Image_tag.tag_id) num, Tag.id, Tag.tag_name FROM Tag LEFT JOIN Image_tag ON Tag.id = Image_tag.tag_id WHERE num = 0 GROUP BY Tag.id";
//
//		$res = $this->db->query($sql)->result_array();
//
//		if(empty($res)) {
//			return null;
//		} else {
//			return $res;
//		}
	}


	/*********** end calculate how many imgs and public imgs in each tag *********/

}