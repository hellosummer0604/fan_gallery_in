<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {

	private $_CI;

	public function __construct($data = NULL, $from_type = NULL) {
		// Get the CodeIgniter reference
		$this->_CI = &get_instance();
		$this->_CI->load->model('Temp_img');

	}

	private function randomKey($type = null) {
		$this->_CI->db->db_debug = FALSE;

		$this->_CI->load->helper('string');

		$tbl = null;
		$encrypt = null;
		$strLen = null;

		switch ($type) {
			case "general":
				$tbl = "Unique_id_general";
				$encrypt = "md5";
				$strLen = "32";
				break;
			case "img":
				$tbl = "Unique_id_img";
				$encrypt = "sha1";
				$strLen = "40";
				break;
			default:
				$tbl = "Unique_id_general";
				$encrypt = "md5";
				$strLen = "32";
		}

		$i = RND_KEY_RETRY;

		while ($i-- > 0) {
			$insertRes = false;
			$uniqueKey = random_string($encrypt, $strLen);

			try{
				$this->_CI->db->trans_start();
				$this->_CI->db->insert($tbl, array('str' => $uniqueKey, 'created' => date('Y-m-d H:i:s')));
				$insertRes = $this->_CI->db->affected_rows() > 0 ? true : false;
				$this->_CI->db->trans_complete();
			} catch (Exception $e) {

			}

			if ($insertRes) {
				break;
			}
		}

		if($i == -1) {
			throw new Exception('cannot get unique id');
		}

		return $uniqueKey;
	}

	public function rndId() {
		return $this->randomKey('general');
	}

	public function rndImgId() {
		return $this->randomKey('img');
	}

	private function validateInputFormat($pattern = null, $str = null) {
		if (empty($pattern) || empty($str)) {
			return false;
		}

		if (strlen($str) >= 30) {
			return false;
		}

		if (preg_match($pattern, $str)) {
			return true;
		} else {
			return false;
		}
	}

	//todo
	public function validateUsernameFormat($str) {
		$pattern = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{3,20}$/u";

		return $this->validateInputFormat($pattern, $str);
	}

	public function validatePasswordFormat($str) {
		$pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/";

		return $this->validateInputFormat($pattern, $str);
	}

	public function validateEmailFormat($email) {
		if (empty($email)) {
			return false;
		}

		if (strlen($email) >= 30) {
			return false;
		}

		/**
		 * Validate an email address.
		 * Provide email address (raw input)
		 * Returns true if the email address has the email
		 * address format and the domain exists.
		 */

		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		} else {
			$domain = substr($email, $atIndex + 1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
			} else if ($domainLen < 1 || $domainLen > 255) {
				// domain part length exceeded
				$isValid = false;
			} else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			} else if (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			} else if (preg_match('/\\.\\./', $domain)) {
				// domain part has two consecutive dots
				$isValid = false;
			} else if
			(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
				str_replace("\\\\", "", $local))
			) {
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/',
					str_replace("\\\\", "", $local))
				) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
				// domain not found in DNS
				$isValid = false;
			}
		}

		return $isValid;

	}

	public function addCookie() {
		//todo
	}

	public function removeCookie() {
		//todo
	}

	public function isOnline() {
		$sessUserId = $this->_CI->session->userdata(SESSION_USER_ID);

		if (empty($sessUserId)) {
			return false;
		} else {
			return $sessUserId;
		}
	}

	public function addLoginSession($userId) {
		$this->_CI->session->set_userdata(SESSION_USER_ID, $userId);
	}

	public function removeAllSession() {
		$this->_CI->session->sess_destroy();
	}

	/***************** start image uploading *****************/
	public function createFolder($path) {
		mkdir($path, FILE_UPLOAD_FOLDER_PERMISSION);
	}

	public function getUploadTempPath() {
		$basePath = FILE_UPLOAD_TEMP_PATH;

		//split month by sections, section has 10 days
		$sectionNum = (int)(date('d') / FILE_UPLOAD_SECTION_DAYS);

		$subFolderName = $basePath.date('Y_m_').$sectionNum."/";

		$this->prepareUploadFolder($subFolderName);

		return $subFolderName;
	}

	public function prepareUploadFolder($path, $force = true) {
		if (file_exists($path)) {
			if (is_dir($path)) {
				return;
			} else {
				if ($force) {
					unlink($path);
				}
			}
		}

		$this->createFolder($path);
	}


	public function uploadFile() {
		$result = array('result' => false, 'data' => null, 'error' => null);

		$curUserId = $this->isOnline();

		if (!$curUserId) {
			$result['result'] = false;
			$result['error'] = "Need login";

			return $result;
		}

		//get path, create if needed
		$path = $this->getUploadTempPath();
		if (empty($path)) {
			$result['result'] = false;
			$result['error'] = "cannot get upload folder";

			return $result;
		}

		//config upload
		$config['upload_path'] = $path;
		$config['allowed_types'] = FILE_UPLOAD_TYPE;
		$config['max_size'] = DROP_ZONE_FILE_MAX_SIZE * 1024;
		$config['file_name'] = $this->rndImgId();
		$config['file_ext_tolower'] = true;

		$this->_CI->load->library('upload', $config);

		//upload and write file
		if (!$this->_CI->upload->do_upload('file')) {
			$result['result'] = false;
			$result['error'] = $this->_CI->upload->display_errors();

			return $result;
		} else {
			$uploadData = $this->_CI->upload->data();
			$fileName = $uploadData['file_name'];
			$data = array('upload_data' => $uploadData);

			//if it is img
			if ($uploadData['is_image']) {
				$fileType = $uploadData['image_type'];

				$result['result'] = true;
				$result['data'] = $data;
			} else {//if not, delete this file
				unlink($path . $fileName);
				$result['result'] = false;
				$result['error'] = "Not a image";

				return $result;
			}
		}

		//write to database
		if ($result['result']) {
			$tempImg = new $this->_CI->Temp_img;
			$tempImg->setUserId($curUserId);
			$tempImg->setPath($path);
			$tempImg->setFilename($fileName);
			$tempImg->setType(trim($fileType));
			$tempImg->setSize($uploadData['file_size']);
			$tempImg->setWidth($uploadData['image_width']);
			$tempImg->setHeight($uploadData['image_height']);

			$res = $tempImg->save();

			if (!$res) {
				unlink($path . $fileName);
				$result['result'] = false;
				$result['error'] = "Failed to insert to database";
			}
		}


		return $result;
	}

	/*
	 * Remove both in folder and database
	 */
	public function removeUploadedFile($fileName = null, $userId = null) {
		$imgs = $this->_CI->Temp_img->loadByFileAndUser($fileName, $userId);

		if (empty($imgs)) {
			return;
		}

		$fullPath = $imgs->getPath().$fileName;

		//delete file
		unlink($fullPath);

		//delete database record
		$imgs->delete();
	}

	/*
	 * Move img from temp folder to img folder
	 *
	 * 1. get exif info
	 * 2. insert to img table
	 * 3. mv to img folder, if error, delete new item created by step 2
	 * 4. delete img and db record in tmp folder
	 */

	public function moveTmpImageToRepo($imgList) {
		$num = 0;

		if(empty($imgList)) {
			return $num;
		}

		foreach ($imgList as $item) {

		}

	}

	/***************** end image uploading *****************/


}