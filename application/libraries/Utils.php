<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {

    private $_CI;

    public function __construct($data = NULL, $from_type = NULL)
    {
        // Get the CodeIgniter reference
        $this->_CI = &get_instance();
    }


}