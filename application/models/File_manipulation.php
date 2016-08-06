<?php

class File_manipulation extends MY_Model {
	
	private $path = './resource/gallery/img_repository/';
	
	public function getPath() {
		return $this->path;;
	}

	public function __construct() {
		parent::__construct();

		$this->load->helper('directory');
	}
	

	public function getRepositoryImgs($path, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$path = $this->getPath();

		$imgList = $this->getFileList($path, $pageNo, $pageSize, $last, false);
//		echo json_encode($imgList);
		
		$res = array();

		foreach ($imgList as $filename) {
			$width = -1;
			$height = -1;

			$exif = exif_read_data($path.$filename);

			$id = explode("\.", $filename)[0];
			$width = $exif['ExifImageWidth'];
			$height = $exif['ExifImageLength'];

			//exclude img which exif is error
			if ($width == -1 || $height == -1) {
				continue;
			}

			$res[] = array('id' => $id, 'thumb' => $path . $filename, 'width' => $width, 'height' => $height);
		}

		$res = ['sectionId' => 'repository', 'imgList' => $res];
		
		if (empty($res['imgList'])) {
			return null;
		}

		return $res;
	}

	public function getImgDetailInfo($imgId) {
		$imgPath = $this->getPath().$imgId;
		
		if (!file_exists($imgPath)  || $imgId == null) {
			return null;
		}
		
		$exif = exif_read_data($imgPath);
		
		$fileName = $exif['FileName'];
		$createTime = $exif['DateTime'];
		$orgWidth = $exif['ExifImageWidth'] == null ? 0 : $exif['ExifImageWidth'];
		$orgHeight = $exif['ExifImageLength'] == null ? 0 : $exif['ExifImageLength'];
		
		$detail = array('MimeType' => $exif['MimeType'], 'Make' => $exif['Make'], 'Model' => $exif['Model'],
			'ApertureValue' =>  $exif['ApertureValue'], 'FocalLength' => $exif['FocalLength'], 'ExposureTime' => $exif['ExposureTime'],  'ISOSpeedRatings' => $exif['ISOSpeedRatings'], 'exif' => $exif);
		
		$res =  array('path' => $imgPath, 'filename' => $fileName, 'createTime' => $createTime, 'orgWidth' => $orgWidth, 'orgHeight' => $orgHeight, 'details' => $detail);
		
		return $res;
	}

	private function getImgSize() {
		
	}

	private function getImgExif() {
		exif_read_data($filename);
	}

	private function getFileList($path, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE, $full = true) {
		$res = array();

		$fileList = directory_map($path);

		$range = getStartEndOfPage(count($fileList), $pageNo, $pageSize, $last);


		for ($i = $range[0]; $i < $range[1]; $i++) {
			if ($full) {
				$res[] = $path . $fileList[$i];
			} else {
				$res[] = $fileList[$i];
			}
		}

		return $res;
	}

}

?>
