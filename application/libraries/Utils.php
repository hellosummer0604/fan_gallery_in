<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {

	private $_CI;

	public function __construct($data = NULL, $from_type = NULL) {
		// Get the CodeIgniter reference
		$this->_CI = &get_instance();
		$this->_CI->load->model('Temp_img');
		$this->_CI->load->model('Img');

	}

	public function tmpRandomKey() {
		$this->_CI->load->helper('string');

		return random_string("md5", "32");
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

		if (is_dir($path)) {
			return $path;
		} else {
			return null;
		}
	}

	public function createUploadFolder($path, $force = true) {
		if (file_exists($path)) {
			if (is_dir($path)) {
				return $path;
			} else {
				if ($force) {
					unlink($path);
				}
			}
		}

		return $this->createFolder($path);
	}

	public function getUploadTempPath() {
		$basePath = FILE_UPLOAD_TEMP_PATH;

		//split month by sections, section has 7 days
		$sectionNum = (int)(date('d') / FILE_UPLOAD_SECTION_DAYS);

		$subFolderName = $basePath.date('Y_m_').$sectionNum."/";

		return $this->createUploadFolder($subFolderName);
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
			$tempImg->setSession($this->_CI->session->userdata(SESSION_UPLOAD));

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
		$img = $this->_CI->Temp_img->loadByFileAndUser($fileName, $userId);

		if (empty($img)) {
			return;
		}

		//delete file
		unlink($img->getFullPath());

		//delete database record
		$img->delete();
	}

	/*
	 * Move img from temp folder to img folder
	 *
	 * 1. get exif info
	 * 2. insert to img table
	 * 3. mv to img folder, if error, delete new item created by step 2
	 * 4. delete img and db record in tmp folder
	 */

	public function moveTmpImageToRepo($imgList, $userId) {
		$num = 0;

		if(empty($imgList) || empty($userId)) {
			return $num;
		}

		foreach ($imgList as $fileName) {
			//get exif
			$tmpImg = $this->_CI->Temp_img->loadByFileAndUser($fileName, $userId);

			//get exif infomation
			$exif = exif_read_data($tmpImg->getFullPath());

			//insert to img table
			$Img =  new $this->_CI->Img;


			$Img->setUserId($tmpImg->getUserId());
			$Img->setFilename($this->rndImgId().".jpg");
			$Img->setType("jpeg");
			$Img->setSize($tmpImg->getSize());
			$Img->setWidth($tmpImg->getWidth());
			$Img->setHeight($tmpImg->getHeight());
			if($exif) {
				$Img->setExif(json_encode($exif));
			}
			$Img->setStatus(IMG_STATE_REPO);
//			$Img->setThumb("test");

			//move file
			$persist = $this->persistTmpImg($tmpImg, $Img);

			if ($persist) {
				$num++;
				//remove tmp file and record
				$this->removeUploadedFile($fileName, $userId);
			}

		}

		return $num;
	}

	//todo need to add this to cron
	/*
	 * 1. delete item in Unique_id_img and Upload_temp
	 * 2. delete item in folder
	 * 3. delete folder if needed
	 */
	public function removeExpiredTmpImg() {

	}

	/************************ start compress image ************************/

	/*********** start get image size***********/
	private function compressImgSize($height, $width, $size, $targetSize) {
		if (empty($height) || empty($width) || empty($size) || empty($targetSize)) {
			return array('width' => $width, 'height' => $height);
		}

		if ($height <= THUMB_MIN_HEIGHT || $width <= THUMB_MIN_WIDTH || $targetSize >= $size) {
			return array('width' => $width, 'height' => $height);
		}

		$coarseRatio = floatval($size / $targetSize);

		$newHeight = $height / $coarseRatio;
		$newWidth = $width / $coarseRatio;

		//find proper ratio
		if ($newHeight < THUMB_MIN_HEIGHT || $newWidth < THUMB_MIN_WIDTH) {
			$ratioH = $height / THUMB_MIN_HEIGHT;
			$ratioW = $width / THUMB_MIN_WIDTH;

			$ratio = min($ratioH, $ratioW);

			$newHeight = $height / $ratio;
			$newWidth = $width / $ratio;
		}

		return array('width' => round($newWidth), 'height' => round($newHeight));
	}

	public function bigImgSize($height, $width, $size) {
		//will return original
		return $this->compressImgSize($height, $width, $size, 10000);
	}

	public function thumbImgSize($height, $width, $size) {
		return $this->compressImgSize($height, $width, $size, THUMB_SIZE);
	}
	/*********** end get image size***********/


	/*********** start move tmp img to gallery ***********/
	private function convertImg($orgPath, $targetPath, $width = null, $height = null) {
		if (empty($orgPath) || empty($targetPath)) {
			return false;
		}

		print_r($width);
		print_r($height);

		if (is_numeric($width) && is_numeric($height)) {
			$cmdStr = "/usr/bin/convert $orgPath -resize ".$width."x".$height." ".$targetPath;
			print_r($cmdStr);
		} else {
			$cmdStr = "/usr/bin/convert $orgPath $targetPath";
		}

		$run = exec($cmdStr, $out, $err);

		if (!$run) {
			return array('res' => false, 'errorMsg' => $err, 'msg' => $out);
		} else {
			return array('res' => true, 'errorMsg' => '', 'msg' => $out);
		}
	}

	private function prepareImgFolder() {
		$subFolder = date("Y_m_d")."/";

		$hdPath = FILE_HD_PATH.$subFolder;
		$thumbPath = FILE_THUMB_PATH.$subFolder;

		$hdPath = $this->createUploadFolder($hdPath);
		$thumbPath = $this->createUploadFolder($thumbPath);

		if (empty($hdPath) || empty($thumbPath)) {
			return null;
		} else {
			return array('hd' => $hdPath, 'thumb' => $thumbPath);
		}
	}


	public function persistTmpImg($tmpImg, $img) {
		//calc img size
		$thumbSizeArr = $this->thumbImgSize($tmpImg->getHeight(), $tmpImg->getWidth(), $tmpImg->getSize());
		if (!empty($thumbSizeArr)) {
			$success = true;
		} else {
			$success = false;
		}

		//prepare img folder
		if ($success) {
			$folderArr = $this->prepareImgFolder();

			if (empty($folderArr)) {
				$success = false;
			} else {
				$img->setPath($folderArr['hd']);
				$img->setThumb($folderArr['thumb']);

				$success = true;
			}
		}

		//convert img
		if ($success) {
			$orgPath = getcwd()."/".$tmpImg->getFullPath();
			$targetHDPath = getcwd()."/".$img->getFullPath();
			$targetThumbPath = getcwd()."/".$img->getThumb().$img->getFilename();

			$hdImg = $this->convertImg($orgPath, $targetHDPath)['res'];
			$thumbImg = $this->convertImg($orgPath, $targetThumbPath, $thumbSizeArr['width'], $thumbSizeArr['height'])['res'];

			if ($hdImg && $thumbImg) {


				$success = true;
			} else {
				$success = false;
			}
		}

		//save to database
		if ($success) {
			$success = $img->save();
		}


		return $success;
	}
	/*********** end move tmp img to gallery***********/

	/************************ end compress image ************************/




	/***************** end image uploading *****************/


}