<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostModel extends CI_Model {
    private $table = "post";

    public function findOne($col, $val)
    {
        return $this->db->get_where($this->table, [$col => $val])->row();
    }
    public function findAll()
    {
        return $this->db->query("SELECT u.*, p.* FROM post p INNER JOIN user u WHERE p.user_id=u.id ORDER BY created_at DESC")->result();
    }
    public function findAllByUser($id)
    {
        return $this->db->query("SELECT * FROM post WHERE user_id='$id' ORDER BY created_at DESC")->result();
    }
    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }
    public function update($data, $id)
    {
        return $this->db->update($table, $data, array('id' => $id));
    }
    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
}