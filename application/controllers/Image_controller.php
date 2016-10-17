<?php
/**
 * Created by PhpStorm.
 * User: tianxia
 * Date: 10/16/16
 * Time: 6:44 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Image_controller extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('Img');
		$this->load->model('Tag');
	}

	public function test() {
		echo 'asd';
	}


	public function update($id) {
		$onlineUser = $this->isOnline();
		if ($onlineUser == false) {
			echo responseJson(false, 'Please login!');
			return;
		}

		$img = Img::load($id);

		if (empty($img)) {
			echo responseJson(false, 'Cannot find image!');
			return;
		}

		if ($onlineUser != $img->getUserId()) {
			echo responseJson(false, 'Only author can modify this photo!');
			return;
		}

		extract($_POST);

		$title = trim($title);
		$desc = trim($desc);

		//return success if no update.
		if ($img->getTitle() == $title && $img->getText() == $desc) {
			echo responseJson(true, 'Succeed, no update.', '', '', array('title' => trim($title)));
			return;
		}

		$img->setTitle($title);
		$img->setText($desc);



		if ($img->save() === false) {
			echo responseJson(false, 'Failed to update this photo!');
			return;
		}

		echo responseJson(true, 'Succeed!', '', '', array('title' => trim($title)));
		return;
	}

}