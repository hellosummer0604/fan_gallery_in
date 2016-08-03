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

		$this->load->model('User');
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
			$this->returnFailure($error);
			return;
		}

		if(!$this->utils->validateEmailFormat($username) && !$this->utils->validateUsernameFormat($username)) {
			$error = "Email/Username not valid.";
		} else if (!$this->utils->validatePasswordFormat($password)) {
			$error = "Password invalid.";
		}

		if (!empty($error)) {
			$this->returnFailure($error);
			return;
		}

        $user = $this->User->login($username, $password);

        if (!empty($user)) {
			if ($rememberme) {
				$this->utils->addCookie();//todo
			}

            $this->returnSuccess("Login Success, Loading...", array('username' => $user->getUsername(), 'id' => $user->getId()));
        } else {
            $this->returnFailure("Wrong Password.");
        }

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
			$this->returnFailure($error);
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
			$this->returnFailure($error);
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
			$this->returnFailure($error);
		} else {
			$this->returnSuccess('haha');
		}

	}

	public function logout() {
		$this->utils->removeCookie();

		//todo
	}

    public function retrieve() {

    }
}

?>