<?php

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->setLanguage();
		$this->setTheme();
	}

	private function setLanguage() {
		
	}
	
	private function setTheme() {
//		echo "extends<br>";
	}
	
}

?>