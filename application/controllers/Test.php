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

	public function test3() {
		for ($i = 0; $i < 5; $i++){
			$res = $this->utils->rndId();

			print_r($res);

			echo "<br>";

		}

	}

	public function test4() {
		$this->load->model('Temp_img');

		$img = $this->Temp_img->load(13);

		print_r($img);
	}

	public function test5() {
		$this->load->model('Temp_img');

		$img = new $this->Temp_img;

		$img->save();
	}

	public function test6() {
		$this->load->model('Temp_img');

//		$img = call_user_func_array(array($this->Temp_img, 'load'), array(23));

		$img = $this->Temp_img->loadByFileAndUser(23);
		print_r($img);

//		$img->save();
	}
}

?>