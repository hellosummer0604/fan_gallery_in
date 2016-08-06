<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Infocenter extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$cssArray = ['default', 'index', 'jquery.auto-complete'];
		$jsArray = ['jquery1.11.3.min',
			'prototype1.7.3.0_1',
			'autogrow.min',
			'jquery-color',
			'init',
			'indexNav',
			'popupBox',
			'popupBoxEdit',
			'poster_manager',
			'color_manager',
			'grid_manager',
			'img_grid_manager',
			'temp_test',
			'img_grid_manager',
			'lib/typeahead.bundle.min'
		];

	}

	public function index() {
		$this->setHeader(array('css' => $this->cssArray, 'js' => $this->jsArray));

		$this->loadImgPopEditView();
		
		$this->loadPosterView(false);
		
		$data['cateList'] = $res = ['Repository' => 'repo_id'];
		
		$this->loadView('img_repository', $data);
	}
}

?>