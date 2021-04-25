<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function index()
	{
		$this->load->view('home');
	}
    public function profile()
	{
		$this->load->view('profile');
	}
}

