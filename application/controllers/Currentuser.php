<?php
/**
 * Created by PhpStorm.
 * User: tianxia
 * Date: 7/9/16
 * Time: 5:54 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/User_controller.php');

class Currentuser extends User_Controller {

	public function __construct() {
		parent::__construct();
		$this->needLogin();

	}

	public function info_get() {
		$data = array('csa' => array('a' => 1, 'ccs' => '123123'));

		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function users_get() {
		// Users from a data store e.g. database
		$users = [
			['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
			['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
			['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
		];

		$id = $this->get('id');

		// If the id parameter doesn't exist return all the users

		if ($id === NULL) {
			// Check if the users data store contains users (in case the database result returns NULL)
			if ($users) {
				// Set the response and exit
				$this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
				// Set the response and exit
				$this->response([
					'status'  => FALSE,
					'message' => 'No users were found',
				], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}

		// Find and return a single record for a particular user.

		$id = (int)$id;

		// Validate the id.
		if ($id <= 0) {
			// Invalid id, set the response and exit.
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}

		// Get the user from the array, using the id as key for retreival.
		// Usually a model is to be used for this.

		$user = NULL;

		if (!empty($users)) {
			foreach ($users as $key => $value) {
				if (isset($value['id']) && $value['id'] === $id) {
					$user = $value;
				}
			}
		}

		if (!empty($user)) {
			$this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			$this->set_response([
				'status'  => FALSE,
				'message' => 'User could not be found',
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function infocenter_get() {
		$cssArray = ['default', 'index', 'jquery.auto-complete', 'jquery.dropdown'];
		$jsArray = ['jquery1.11.3.min',
					'prototype1.7.3.0_1',
					'autogrow.min',
					'jquery-color',
					'lib/jquery.dropdown',
					'init',
					'indexNav',
					'popupBox',
					'popupBoxEdit',
					'poster_manager',
					'color_manager',
					'grid_manager',
					'img_grid_manager',
					'temp_test',
					'img_grid_manager',
					'lib/typeahead.bundle.min',
		];

		$this->setHeader(array('css' => $cssArray, 'js' => $jsArray));

		$this->loadImgPopEditView();

		$this->loadPosterView(false);

		$data['cateList'] = $res = ['Repository' => 'repo_id'];

		$this->loadView('img_repository', $data);
	}

	public function moduleUpload_get() {
		$viewPath = $this->basePath . "/module/upload";
		$data = array();

		//todo each hour create new folder, delete the folder before 2 hours ago, timestamp as fold name. Only read and write access


		if ($this->isOnline()) {
			$this->session->set_userdata(SESSION_UPLOAD, $this->utils->tmpRandomKey());
			$this->load->view($viewPath, $data);
		} else {
			$this->response("Need login", 403);
		}
	}

	public function uploadFile_post() {
		$upload = $this->utils->uploadFile();

//		print_r($upload);

		if (!empty($upload) && $upload['result'] && !empty($upload['data']['upload_data'])) {
			$this->response($upload['data']['upload_data']['file_name'], 200);
		} else {
			$this->response("This image cannot be uploaded.", 500);
		}

	}

	private function getValidUploadImgList($jsonStr) {
		if (empty($jsonStr)) {
			return null;
		}

		$result = null;

		try{
			$fileList = json_decode($jsonStr);

			if (empty($fileList)) {
				return $result;
			}

			foreach ($fileList as $file) {
				if (property_exists($file, "status")
					&& $file->status == "success"
					&& property_exists($file, "serverFileName")
					&& !empty($file->serverFileName)) {
					$result[] = $file->serverFileName;
				}

			}

		} catch (Exception $e) {

		}

		return $result;
	}

	public function completeUpload_post() {
		$jsonStr = $this->input->post('fileList');
		$userId = $this->isOnline();

		if ($userId == false) {
			//todo
//			$this->response($str, 200);
		}

		$fileList = $this->getValidUploadImgList($jsonStr);

		if (empty($fileList)) {
			$this->response("No valid file to upload", 500);
			return;
		}

		$num = $this->utils->moveTmpImageToRepo($fileList, $userId);

		$str = $num." image(s) uploaded";

		print_r($str);

//		$this->response($str, 200);

		//http://stackoverflow.com/questions/15088666/generating-image-thumbnails-using-php-without-running-out-of-memory
	}

	public function deleteTmpFile_post() {
		//delete from input box through ajax when delete in dropzone form
		$userId = $this->isOnline();

		if (!$userId) {
			echo responseJson(false, '', "Need login");
			return;
		}

		$fileName = $this->input->post('rmvFile');

		if (!empty($fileName)) {
			$this->utils->removeUploadedFile($fileName, $userId);
		}

		echo responseJson(true, $fileName.' removed.');
	}

	public function deleteAllTmpFile_post() {
		$this->utils->removeAllUploadedFile();
	}


}