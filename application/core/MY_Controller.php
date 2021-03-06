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
			
			$headCSS = $headCSS."<link rel='stylesheet' href='".base_url()."/resource/theme/".$this->theme_path."/css/".$item.".css'>";
		}
		
		return $headCSS;
	}
	
	private function loadJS($data) {
		$headJS = "";
		
		foreach($data as $item) {
			$headJS = $headJS." <script src='".base_url()."/resource/js/".$item.".js'></script>";
		}
		
		return $headJS;
	}
	
	protected function loadView($view, $data = null) {
		
		
		$this->load->view($view, $data);
	}


	//generate link items in nav

	public function getCategoryLink($userId) {
		$this->load->model('Tag');

		//to do
		$tags = Tag::getStickedTag($userId);


		
		$result = array();
		$result['all'] = TAG_ALL;
		foreach ($tags as $key => $item) {
			$result[strtolower($key)] = $item;
		}
		$result['more'] = "";
		
		$this->CategoryLink = $result;
		
		return $this->CategoryLink ;
	}
	
	public function needLogin($destination = WEN_LOGIN) {
		if(!$this->isOnline() && $destination != WEN_NO_REDIRECT) {
//			redirect($destination);
		}
	}

	public function isOnline() {
		return $this->utils->isOnline();
	}

	//check if this userid is the current/login user
	public function isActiveUser($userId = null) {
		if(empty($userId)) {
			return false;
		}

		$sessUserId = $this->isOnline();

		if ($sessUserId) {
			return true;
		}

		return false;
	}

	public function logout() {
		$this->utils->removeAllSession();
	}

	public function loadImgPopView() {
		$data[ONLINE_FLAG] = $this->isOnline() ? true : false;
		$this->loadView('/include/popup/imgPopupContainer', $data);
	}

//	public function loadImgPopEditView() {
//		$data[ONLINE_FLAG] = $this->isOnline() ? true : false;
//		$this->loadView('/include/popup/imgPopupEdit', $data);
//	}

	protected function loadPosterView($enable = true, $data = null) {
		if ($enable) {
			if (empty($data)) {
				$data['url'] = "http://north.gallery/resource/theme/default/img/8206-8.jpg";
				$data['width'] = 2880;
				$data['height'] = 1800;
			}

			$data['firstHeadline'] = FIRST_HEADLINE;
			$data['secondHeadline'] = SECOND_HEADLINE;

			if (isset($data['userId']) && !empty($data['userId'])) {
				$this->load->model('User');
				$user = User::load($data['userId']);

				if (!empty($user)) {
					$data['firstHeadline'] = $user->getPrimaryHeadline();
					$data['secondHeadline'] = $user->getSecondHeadline();
				}
			}

			$this->loadView('/include/poster', $data);
		} else {
			$this->loadView('/include/poster_empty');
		}
	}
}
?>