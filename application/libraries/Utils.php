<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {

    private $_CI;

    public function __construct($data = NULL, $from_type = NULL)
    {
        // Get the CodeIgniter reference
        $this->_CI = &get_instance();
    }

	private function validateInputFormat($pattern = null, $str = null) {
		if (empty($pattern) || empty($str)) {
			return false;
		}

		if (strlen($str) >= 30) {
			return false;
		}

		if (preg_match($pattern, $str)) {
			return true;
		} else {
			return false;
		}
	}

	//todo
	public function validateUsernameFormat($str) {
		$pattern = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{3,20}$/u";

		return $this->validateInputFormat($pattern, $str);
	}

	public function validatePasswordFormat($str) {
		$pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/";

		return $this->validateInputFormat($pattern, $str);
	}

	public function validateEmailFormat($email) {
		if (empty($email)) {
			return false;
		}

		if (strlen($email) >= 30) {
			return false;
		}

		/**
		 * Validate an email address.
		 * Provide email address (raw input)
		 * Returns true if the email address has the email
		 * address format and the domain exists.
		 */

		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		} else {
			$domain = substr($email, $atIndex + 1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
			} else if ($domainLen < 1 || $domainLen > 255) {
				// domain part length exceeded
				$isValid = false;
			} else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			} else if (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			} else if (preg_match('/\\.\\./', $domain)) {
				// domain part has two consecutive dots
				$isValid = false;
			} else if
			(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
				str_replace("\\\\", "", $local))
			) {
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/',
					str_replace("\\\\", "", $local))
				) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;

	}

	public function addCookie() {
		//todo
	}

	public function removeCookie() {
		//todo
	}

	public function isOnline() {
		$sessionUser = $this->_CI->session->userdata(SESSION_USER);

		if(empty($sessionUser)) {
			return false;
		} else{
			return $sessionUser;
		}
	}

	public function addLoginSession($user) {
		unset($user->password);
		$this->_CI->session->set_userdata(SESSION_USER, $user);

	}

	public function removeAllSession() {
		$this->_CI->session->sess_destroy();
	}
}