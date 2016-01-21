<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Infocenter extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$cssArray = ['default', 'index'];
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
			'img_grid_manager'];

		$this->setHeader(array('css' => $cssArray, 'js' => $jsArray));
	}

	public function index() {
		$this->loadView('/include/popup/imgPopupEdit');
		
		$this->loadView('/include/poster_empty');
		
		$data['cateList'] = $res = ['Repository' => 'repo_id'];
		
		$this->loadView('img_repository', $data);
	}

}

?>