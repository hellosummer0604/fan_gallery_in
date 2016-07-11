<?php

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	private $theme_path = "";
	
	private $js_path = "resource/js/";
	
	public $CategoryLink = array();
	
	protected function setLanguage() {
		
	}
	
	protected function setTheme($data) {
		
	}
	
	protected function setHeader($data) {
		$this->theme_path = 'default';
		
		$headData['headerCss'] = $this->loadCss($data['css']);
		
		$headData['headerJs'] = $this->loadJS($data['js']);
		
		$this->loadView("include/header", $headData);

		$this->loadView("include/popup/login", null);
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


	//generate link items in nav
	public function getCategoryLink() {
		$res = ['all' => 'repo_id', 'Popular' =>'pop_id', 'Nature' => 'nature_id'];
		
		$result = array();
		
		foreach ($res as $key => $item) {
			$result[strtolower($key)] = $item;
		}
		
		$this->CategoryLink = $result;
		
		return $this->CategoryLink ;
	}
	
	public function needLogin($destination = WEN_LOGIN) {
		if(!$this->isLogin() && $destination != WEN_NO_REDIRECT) {
//			redirect($destination);
		}
	}

	public function isLogin() {
		$sessUserId = $this->session->userdata(SESSION_USER_ID);

		if(empty($sessUserId)) {
			return false;
		} else{
			return $sessUserId;
		}
	}
	//check if this userid is the current/login user
	public function isActiveUser($userId = null) {
		if(empty($userId)) {
			return false;
		}

		$loggedUserId = $this->session->userdata(SESSION_USER_ID);

		if(!empty($loggedUserId) && $loggedUserId == $userId) {
			return true;
		} else {
			return false;
		}
	}
}
?>