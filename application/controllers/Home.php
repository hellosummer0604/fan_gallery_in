<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->cssArray = [
			'default',
			'index',
			'jquery.dropdown',
			'jquery.auto-complete',
		];

		$this->jsArray = [
			'jquery1.11.3.min',
			'prototype1.7.3.0_1',
			'jquery-color',
			'lib/jquery.dropdown',
			'init',
			'indexNav',
			'poster_manager',
			'color_manager',
			'grid_manager',
			'popupBox',
			'img_grid_manager',
			'temp_test',
		];

		$this->load->model('User');
	}

	public function headNav() {
		$data[ONLINE_FLAG] = $this->isOnline() ? true : false;
		$this->load->view('include/headNav', $data);
	}

	private function imgForPopup ($imgId) {
		if (empty($imgId)) {
			return null;
		}

		$imgObj = Img::load($imgId);
		Img::addVisitedCount($imgId);

		return $imgObj;
	}
	public function imgPopup($imgId) {
		$imgObj = $this->imgForPopup($imgId);

		if (empty($imgObj)) {
			return;
		}

		$data['imgObj'] = $imgObj;

		$viewHTML = $this->load->view('include/popup/imgPopup', $data, true);

		echo json_encode(array('html' => $viewHTML, 'imgInfo' => $this->utils->imgDetailWrapper($imgObj)));
	}

	public function imgPopupEdit($imgId) {
		extract($_POST);

		$imgObj = $this->imgForPopup($imgId);

		if (empty($imgObj)) {
			return;
		}

		$data['imgObj'] = $imgObj;

		$viewHTML = $this->load->view('include/popup/imgPopupEdit', $data, true);

		echo json_encode(array('html' => $viewHTML, 'imgInfo' => $this->utils->imgDetailWrapper($imgObj)));
	}
	
	public function index($userId = null)
	{
		$this->load->model('Tag');

		$userId = cutUserId($userId);

        //must be the first line
        $this->setHeader(array('css' => $this->cssArray, 'js' => $this->jsArray));

		$this->loadImgPopView();

		$this->tempLoadPosterView($userId);//todo will replace by real functions

		if (!empty($userId)) {
			$data['cateList'] = $this->getCategoryLink($userId);
		} else {
			$data['cateList'] = array('new' => TAG_NEW, 'popular' => TAG_POPULAR, 'featured' => TAG_FEATURED);
		}

		$this->loadView('home', $data);
	}

	//todo temporary, remove it
	private function tempLoadPosterView($userId = null) {
		$this->load->model('Img');

		$imgs = $this->Img->loadFeaturedByAuthor($userId);

		if (empty($imgs)) {
			$data = $this->loadRandomPost();
		} else {
			$img = $imgs[array_rand($imgs, 1)];

			$data['src'] = base_url($img->getFullPath());
			$data['width'] = $img->getWidth();
			$data['height'] = $img->getHeight();
		}

		$this->loadPosterView(true, $data);
	}

	private function loadRandomPost() {
		$path = "./resource/gallery/img_publish/img_poster/";

		$imgNames = $this->filehelper->getFolderFiles($path);
		if (empty($imgNames)) {
			return null;
		}
		$img = $path.$imgNames[array_rand($imgNames)];//get random img

		$imgInfo = $this->filehelper->getImgSize($img);

		$data['src'] = base_url($img);
		$data['width'] = $imgInfo['width'];
		$data['height'] = $imgInfo['height'];

		return $data;
	}

	public function login() {
		$username = trim($this->input->post('username', true));
        $password = trim($this->input->post('password', true));
        $rememberme = $this->input->post('rememberme', true) ? true : false;

        $error = null;

		if (empty($username)) {
			$error = "Please insert email or username";
		} else if (empty($password)) {
			$error = "Please insert password";
		}

		if (!empty($error)) {
			echo responseJson(false, '', $error);
			return;
		}

		if(!$this->utils->validateEmailFormat($username) && !$this->utils->validateUsernameFormat($username)) {
			$error = "Email/Username not valid.";
		} else if (!$this->utils->validatePasswordFormat($password)) {
			$error = "Password invalid.";
		}

		if (!empty($error)) {
			echo responseJson(false, '', $error);
			return;
		}

        $user = $this->User->login($username, $password);

        if (!empty($user)) {
			if ($rememberme) {
				$this->utils->addCookie();//todo
			}

			$msg = "Login Success, Loading...";
			$data = array('username' => $user->getUsername(), 'id' => $user->getId());

			echo responseJson(true, $msg, '', '', $data);
        } else {
			echo responseJson(false, '', "Wrong Password.");
        }

        return;
	}

	public function signup() {
        $email = trim($this->input->post('email', true));
        $username = trim($this->input->post('username', true));
        $password = trim($this->input->post('password', true));
        $passwordConfirm = trim($this->input->post('passwordConfirm', true));

		$error = null;

		if (empty($email)) {
			$error = "Please insert email";
		} else if (empty($username)) {
			$error = "Please insert username";
		} else if (empty($password)) {
			$error = "Please insert password";
		} else if (empty($passwordConfirm)) {
			$error = "Please confirm password ";
		}

		if (!empty($error)) {
			echo responseJson(false, '', $error);
			return;
		}

		if(!$this->utils->validateEmailFormat($email)) {
			$error = "Email not valid.";
		} else if ($this->User->checkEmailExist($email)) {
			$error = "Email already registered.";
		} else if (!$this->utils->validateUsernameFormat($username)) {
			$error = "Username can have Chinese, letters, underscore and numbers, and longer than 3";
		} else if ($this->User->checkUsernameExist($username)) {
			$error = "Username already registered.";
		} else if (!$this->utils->validatePasswordFormat($password)) {
			$error = "Password should at least 1 Uppercase, 1 Lowercase and 1 Number, and longer than 8.";
		} else if ($password != $passwordConfirm){
			$error = "Password doesn't match.";
		}

		if (!empty($error)) {
			echo responseJson(false, '', $error);
			return;
		}

		$data = array(
			'username' => $username,
			'email' => $email,
			'password' => $password
		);

		$user = $this->User->signup($data);
		$data = array('username' => $user->getUsername(), 'id' => $user->getId());

		if(empty($user)) {
			$error = "Server Error, please try later.";
		}

		if (!empty($error)) {
			echo responseJson(false, '', $error);
		} else {
			echo responseJson(true, 'Succeed!', '', '', $data);
		}

		return;
	}


    public function retrieve() {

    }

    public function currentUserId() {
		$userId = $this->isOnline();

		if (!$userId) {
			$userId = null;
		}

		echo responseJson(true, '' , '' ,'', array('userId' => $userId));
	}


}

?>