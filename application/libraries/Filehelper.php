<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Filehelper {

    private $_CI;

    public function __construct()
    {
        // Get the CodeIgniter reference
        $this->_CI = &get_instance();
    }

	public function getImgSize($filePath = null) {
		if (empty($filePath)) {
			return null;
		}

		list($width, $height) = getimagesize($filePath);

		$data['width'] = $width;
		$data['height'] = $height;

		return $data;
	}

	public function getFolderFiles($folderPath = null) {
		if (empty($folderPath)) {
			return null;
		}

		$files = scandir($folderPath, 1);

		if (($key = array_search('.', $files)) != false) {
			unset($files[$key]);
		}

		if (($key = array_search('..', $files)) != false) {
			unset($files[$key]);
		}

		return $files;
	}

	public function convertPath() {

	}

}