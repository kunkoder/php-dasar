<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("UserModel");
		if($this->session->userdata("login") == null && $this->session->userdata("admin") != true)
		{
			redirect(base_url('login'));
		}
	}
	public function index()
	{
		$this->load->view('admin');
	}
    public function edit()
	{
		$this->load->view('edit');
	}
}

