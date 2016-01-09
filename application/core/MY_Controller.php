<?php

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	private $theme_path = "";
	
	private $js_path = "resource/js/";
	
	
	protected function setLanguage() {
		
	}
	
	protected function setTheme($data) {
		
	}
	
	protected function setHeader($data) {
		$this->theme_path = 'default';
		
		$headData['headerCss'] = $this->loadCss($data['css']);
		
		$headData['headerJs'] = $this->loadJS($data['js']);
		
		$this->loadView("include/header", $headData);
	}
	
	private function loadCss($data) {
		
		$headCSS = "";
		
		foreach($data as $item) {
			
			$headCSS = $headCSS."<link rel='stylesheet' href='resource/theme/".$this->theme_path."/css/".$item.".css'>";
		}
		
		return $headCSS;
	}
	
	private function loadJS($data) {
		$headJS = "";
		
		foreach($data as $item) {
			$headJS = $headJS." <script src='resource/js/".$item.".js'></script>";
		}
		
		return $headJS;
	}
	
	protected function loadView($view, $data) {
		
		
		$this->load->view($view, $data);
	}

}
?>