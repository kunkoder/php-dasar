<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Member extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->home = base_url();
		$this->profile = base_url("profile");
		$this->load->helper(array('form', 'url'));
		$this->load->model("UserModel");
		$this->load->model("PostModel");
		if($this->session->userdata("login") == null)
		{
			redirect(base_url('login'));
		}
		$this->user = $this->UserModel->findOne("id", $this->session->userdata("login"));
	}
	public function index()
	{	
		$data = [
			"user" => $this->user,
			"posts" => $this->PostModel->findAll()
		];
		 
		$this->load->view('home', $data);
	}
    public function profile()
	{
		$data = [
			"user" => $this->user,
			"posts" => $this->PostModel->findAllByUser($this->user->id),
			"error" => " "
		];
		$this->load->view('profile', $data);
	}
	public function create_post()
	{
		$content = $this->input->post("content");
        $created_at = date("Y-m-d H:i:s");

		$data = [
			"user_id" => $this->user->id,
			"content" => $content,
			"created_at" => $created_at
		];
        if($this->PostModel->create($data) != 1)
		{
            echo"
            <script>
                alert('Post gagal dikirim');
                document.location.href = \"$this->home\";
            </script>";
        }
        echo"
        <script>
            document.location.href = \"$this->home\";
        </script>";
	}
	private function _upload_avatar()
	{
		$config['upload_path']          = './avatar/';
		$config['allowed_types']        = 'jpeg|jpg|png';
		$config['file_name']            = uniqid();
		$config['overwrite']			= true;
		$config['max_size']             = 1000;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('new_avatar'))
        {
            echo"
            <script>
                alert('Terjadi kesalahan upload');
                document.location.href = \"$this->profile\";
            </script>";die();
        }
		else
		{
			if($this->user->avatar != null && file_exists("./avatar/" . $this->user->avatar)) {
				unlink("./avatar/" . $this->user->avatar);
			}
			return $this->upload->data("file_name");
		}

	}
	public function update_profile()
	{
		$id = $this->input->post("id");
        $username = $this->input->post("username");
        $email = $this->input->post("email");
        $avatar = $this->input->post("old_avatar");

		if (!empty($_FILES["new_avatar"]["name"])) {
			$avatar = $this->_upload_avatar();
		}

		$data = [
			"username" => $username,
			"email" => $email,
			"avatar" => $avatar
		];
        
        if($this->UserModel->update($data, $id) == 1)
		{
            echo"
            <script>
                alert('Profile berhasil diubah');
                document.location.href = \"$this->profile\";
            </script>";
        }
        else {
            echo"
            <script>
                alert('Profile gagal diubah');
                document.location.href = \"$this->profile\";
            </script>";
        }
	}
	public function delete_post($id)
	{
		if($this->PostModel->delete($id) != 1)
		{
            echo"
            <script>
                alert('Post gagal dihapus');
                document.location.href = \"$this->profile\";
            </script>";
        }
        echo"
        <script>
            alert('Post berhasil dihapus');
            document.location.href = \"$this->profile\";
        </script>";
	}
}

