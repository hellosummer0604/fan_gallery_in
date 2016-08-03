<?php

class MY_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function load($id) {
		$class = get_called_class();

		$obj = $this->db->get_where($this->tbl, array('id'=>$id))->row(0, $class);

		return $obj;
	}

	public function init() {

	}

	public function requireInit() {

	}




}

?>