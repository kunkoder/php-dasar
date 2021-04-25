<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function register()
	{
		$this->load->view('register');
	}
    public function login()
	{
		$this->load->view('login');
	}
}

