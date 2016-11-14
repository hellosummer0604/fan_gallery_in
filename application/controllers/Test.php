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

	public function test7() {
		$this->load->model('User');
	}

	public function test8() {
		$path = getcwd()."/".FILE_UPLOAD_TEMP_PATH."/2016_08_3";

		print_r($path);
		$out=array();
		$err = 0;
		$run = exec("/usr/bin/convert $path/0b292114421d105af180a1c41772372768e814f7.png  $path/new.png",$out,$err);
		echo implode ("<br>",$out);
		print_r($err);
		print_r($run);
	}

	public function test9() {
		$this->load->model('Img');

		$imgs = $this->Img->loadByAuthorAndStatus('f8057d071686e27832ba66b6b96a371d', IMG_STATE_REPO);
		print_r($imgs);

//		$img->save();
	}

	public function test10() {
//		$this->load->model('Tag');
//
//		$tag = new Tag();
//
//		$tag->setTagName('asd');
//
//		print_r($tag);
//		$tag->save();
//		print_r($tag);
	}

	public function test11() {
		$this->load->model('Tag');
		$this->load->model('Img');

		$img = Img::load(4);

//		print_r($img->getTags());
//		echo '<br>';

		$tag1 = new Tag('unAssigned', 'f8057d071686e27832ba66b6b96a371d');
		$tag2 = new Tag('tag 3', 'f8057d071686e27832ba66b6b96a371d');
		$tag3 = new Tag('tag 4', 'f8057d071686e27832ba66b6b96a371d');
//		$tag3 = new Tag('tag3', 'f8057d071686e27832ba66b6b96a371d');
//		$tag2 = new Tag('tag1', 'f8057d071686e27832ba66b6b96a371d');
//		$tag2 = new Tag('tag1', 'f8057d071686e27832ba66b6b96a371d');

//		print_r($tag2);
//		echo '<br>';


		$img->addTag($tag2);
		$img->addTag($tag3);
//		$img->addTag($tag2);
//		$img->addTag($tag3);

		$img->removeTag($tag1);
//		$img->removeTag($tag2);
//		$img->removeTag($tag3);

		$img->saveTags();


	}

	public function test12() {
		$this->load->model('Img');

		$imgs = Img::loadRepository(5, 5, 5);
		foreach ($imgs as $img) {
			print_r($img->getId()." - ".$img->getTitle()."<br>");
		}


	}

	public function test13() {
		$this->load->model('Img');

		$img = Img::load(30);
		print_r(json_encode($img->getTitle()));

	}

	public function test14() {
		$this->load->model('Img');

		$imgs = Img::getSectionImg('f8057d071686e27832ba66b6b96a371d', '', 0, 4, 2);
		print_r(json_encode($imgs));
//		foreach ($imgs['imgList'] as $img) {
//			print_r($img->getId()." - ".$img->getTitle()."<br>");
//		}


	}

	public function test15() {
		$this->load->model('User');

		$user = $this->User->load('f8057d071686e27832ba66b6b96a371d');

		print_r($user->getStickedTag());
	}

	public function test16() {

		$this->load->model('Master_user');
		$res = $this->Master_user->getPhotos(TAG_NEW);
		print_r(json_encode($res));
	}

	public function test17() {

		$this->load->model('Img');

		$imgs = Img::loadFeatured();
		print_r($imgs);
//		print_r($this->db->last_query());
	}

	public function test18() {

		$this->load->model('Tag');

		$tags = Tag::getAllTags();
		print_r($tags);
//		print_r($this->db->last_query());
	}
}

?>