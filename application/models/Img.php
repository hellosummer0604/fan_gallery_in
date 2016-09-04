<?php
require_once ('Base_img.php');

class Img extends Base_img
{
	protected static $tbl = "Image";

	protected $_exif = null;
	protected $_status = null;
	protected $_thumb = null;

	/**
	 * @return null
	 */
	public function getExif() {
		return $this->_exif;
	}

	/**
	 * @param null $exif
	 */
	public function setExif($exif) {
		$this->_exif = $exif;
	}

	/**
	 * @return null
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * @param null $status
	 */
	public function setStatus($status) {
		$this->_status = $status;
	}

	/**
	 * @return null
	 */
	public function getThumb() {
		return $this->_thumb;
	}

	/**
	 * @param null $thumb
	 */
	public function setThumb($thumb) {
		$this->_thumb = $thumb;
	}


	public function __construct() {
		parent::__construct();
	}


}


?>

