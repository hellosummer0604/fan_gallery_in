<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct() {
		parent::__construct();
		
		$cssArray =  ['default', 'index'];
		$jsArray = ['jquery1.11.3.min', 'prototype1.7.3.0_1', 'jquery-color', 'init', 'indexNav', 'poster_manager', 'color_manager', 'grid_manager', 'img_grid_manager' , 'temp_test'];
		
		$this->setHeader(array('css' => $cssArray, 'js' => $jsArray));
		
		
	}
	
	
	
	public function index()
	{
		$this->load->view('home');
	}
}

?>