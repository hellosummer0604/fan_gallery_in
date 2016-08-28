<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

	public function __construct() {
		parent::__construct();


	}

	public function test() {
//		$res = $this->utils->getUploadTempPath();

		$res = $this->utils->isOnline();

		print_r($res);

		print_r(date("Y-m-d H:i:s"));
	}

	public function test2() {
//		$res = $this->utils->getUploadTempPath();

		$res = $this->utils->removeUploadedFile('c8e4e01c0a620ff3f4416122fb8a431e.png', 'db005f68e850ac923152419f200e2a26');

	}

}

?>