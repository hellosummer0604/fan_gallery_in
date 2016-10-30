<?php
ini_set('max_execution_time', 300);
set_time_limit(300);
defined('BASEPATH') or exit('No direct script access allowed');

class Cron_controller extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$key = $_GET['k'];


		if (!isset($key) || $key != ARB_activationKey) {
			show_404();
		}

		$this->load->model('Photograph');
		$this->load->model('Repository');
		$this->load->model('Img');
	}

	public function test() {

	}

	//delete tag if no image in it
	public function clearEmptyTags() {
		$sql = "DELETE Tag FROM Tag LEFT JOIN Image_tag on Image_tag.tag_id = Tag.id where Image_tag.image_id is null";

		$this->db->query($sql);

		echo 'All empty tags deleted';
	}


}