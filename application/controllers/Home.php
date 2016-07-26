<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->cssArray = ['default', 'index'];
		$this->jsArray = ['jquery1.11.3.min',
			'prototype1.7.3.0_1',
			'jquery-color',
			'init',
			'indexNav',
			'poster_manager',
			'color_manager',
			'grid_manager',
			'popupBox',
			'img_grid_manager',
			'temp_test',
			'img_grid_manager',
		];
		

		
		
	}
	
	
	
	public function index()
	{
        //must be the first line
        $this->setHeader(array('css' => $this->cssArray, 'js' => $this->jsArray));

		$this->loadView('/include/popup/imgPopup');
		
		$this->loadView('/include/poster');
		
		$data['cateList'] = $this->getCategoryLink();

		$this->loadView('home', $data);
	}

	public function login() {
		$res = $this->input->post();

        echo json_encode($res);
	}

	public function signup() {

	}

	public function logout() {

	}

    public function retrieve() {

    }
}

?>