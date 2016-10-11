<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Infocenter extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$cssArray = ['default', 'index', 'jquery.auto-complete'];
		$jsArray = ['jquery1.11.3.min',
			'prototype1.7.3.0_1',
			'jquery-color',
			'init',
			'indexNav',
			'popupBox',
			'poster_manager',
			'color_manager',
			'grid_manager',
			'img_grid_manager',
			'temp_test',
		];

	}

	public function index() {
		$this->setHeader(array('css' => $this->cssArray, 'js' => $this->jsArray));

		$this->loadImgPopView();
		
		$this->loadPosterView(false);
		
		$data['cateList'] = $res = ['Repository' => REPO_ID];
		
		$this->loadView('img_repository', $data);
	}
}

?>