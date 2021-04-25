<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("UserModel");
		if($this->session->userdata("login") == null)
		{
			redirect(base_url('login'));
		}
	}
	public function index()
	{	
		$this->load->view('home');
	}
    public function profile()
	{
		$this->load->view('profile');
	}
}

