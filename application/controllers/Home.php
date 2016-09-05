<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->cssArray = [
			'default',
			'index',
			'jquery.dropdown',
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
	
	
	public function index()
	{
        //must be the first line
        $this->setHeader(array('css' => $this->cssArray, 'js' => $this->jsArray));

		$this->loadImgPopView();

		$this->tempLoadPosterView();//todo will replace by real functions
		
		$data['cateList'] = $this->getCategoryLink();

		$this->loadView('home', $data);
	}

	//todo temporary, remove it
	private function tempLoadPosterView() {
		$path = "./resource/gallery/img_publish/img_poster/";

		$imgNames = $this->filehelper->getFolderFiles($path);
		$img = $path.$imgNames[array_rand($imgNames)];//get random img

		$imgInfo = $this->filehelper->getImgSize($img);

		$data['src'] = base_url($img);
		$data['width'] = $imgInfo['width'];
		$data['height'] = $imgInfo['height'];


		$this->loadPosterView(true, $data);
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

		if(!$this->User->signup($data)) {
			$error = "Server Error, please try later.";
		}

		if (!empty($error)) {
			echo responseJson(false, '', $error);
		} else {
			echo responseJson(true, 'Success!');
		}

		return;
	}




    public function retrieve() {

    }


}

?>