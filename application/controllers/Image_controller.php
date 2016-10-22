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

		$title = htmlspecialchars(trim($title));
		$desc = newline2br(htmlspecialchars(trim($desc)));
		$status = trim($status);
		if (!isset($tags)) {
			$tags = array(IMG_UNASSIGNED);
		}
		$tags = $this->sterilizeTags($tags);

		//if status updated, send refresh flag
		if ($status != $img->getStatus()) {
			$action = array('refresh' => true);
		} else {
			$action = array('refresh' => false);
		}

		if (!is_numeric($status)) {
			$status = $img->getStatus();
		}

		//return success if no update.
		if ($img->getTitle() == $title && $img->getText() == $desc && $status == $img->getStatus() && !$this->hasTagsUpdate($img, $tags)) {
			echo responseJson(true, 'Succeed, no update.', '', '', array('title' => trim($title)));
			return;
		}

		$img->setTitle($title);
		$img->setText($desc);
		$img->setStatus($status);

		//update tags
		if (!empty($tags)) {
			$img->clearTags();
			foreach ($tags as $tag) {
				$tagObj = new Tag($tag, $onlineUser);
				$img->addTag($tagObj);
			}
		}

		if ($img->save() === false) {
			echo responseJson(false, 'Failed to update this photo!');
			return;
		}



		echo responseJson(true, 'Succeed!', '', $action, array('title' => trim($title)));
		return;
	}

	private function sterilizeTags($tags) {
		$res = array();

		if (empty($tags)) {
			return $res;
		}

		foreach ($tags as $tag) {
			$res[] = htmlspecialchars(substr(trim($tag), 0, 20));
		}

		return $res;
	}

	private function hasTagsUpdate($img, $tags) {
		if (empty($img) && empty($tags)) {
			return false;
		}

		$tagObjs = $img->getTags(true);

		if (empty($tagObjs)) {
			if (empty($tags)) {
				return false;
			} else {
				return true;
			}
		}

		foreach ($tagObjs as $objKey => $tagObj) {
			if(($key = array_search($tagObj->getTagName(), $tags)) !== false) {
				unset($tags[$key]);
			}

			unset($tagObjs[$objKey]);
		}

		if (empty($img) && empty($tags)) {
			return false;
		} else {
			return true;
		}
	}

}