<?php

class File_manipulation extends MY_Model {

	public function __construct() {
		parent::__construct();

		$this->load->helper('directory');
	}

	public function getRepositoryImgs($path, $pageNo = 1, $pageSize = 100, $last = 20) {
		$path = './resource/gallery/img_repository/';

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
		

		return $res;
	}

	public function getImgBreifInfo() {
		
	}

	public function getImgDetailInfo() {
		
	}

	private function getImgSize() {
		
	}

	private function getImgExif() {
		exif_read_data($filename);
	}

	private function getFileList($path, $pageNo = 1, $pageSize = 80, $last = 30, $full = true) {
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
