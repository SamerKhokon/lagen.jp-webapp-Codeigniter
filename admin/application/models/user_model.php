<?php

class User_model extends CI_Model
{
	public function user_login_check($data=array())
	{
		$this->db->where('user_id',$data['username']);
		$this->db->where('pass',$data['password']);
		$query = $this->db->get('admin_user');
		
		if($query->num_rows()==1)
		{
			return true;
		}
	}
	public function get_user_id_by_username($username)
	{
		$this->db->where('user_id',$username);
		$result = $this->db->get('admin_user')->row_array();
		return $result['id'];
	}
	public function email_associate_with_user($email,$username)
	{
		$this->db->where('user_id',$username);
		$this->db->where('email',$email);
		$query = $this->db->get('admin_user');
		if($query->num_rows()>0)
		{
			$result=$query->row_array();
			return $result['id'];
		}
	}
	public function check_existing_reset_request($email,$username)
	{
		$this->db->where('active',1);
		$this->db->where('id',$username);
		$this->db->where('email',$email);
		$query=$this->db->get('password_reset_request');
		if($query->num_rows()>0)
		{
			return TRUE;
		}
	}
	public function save_password_reset_data($reset_data=array())
	{
		return $this->db->insert('password_reset_request',$reset_data);
	}
	public function get_active_reset_data_by_hash($hash)
	{
		$this->db->where('active',1);
		$this->db->where('hash_code',$hash);
		$query=$this->db->get('password_reset_request');
		return $query->row_array();
	}
	public function change_password($user_id, $new_password)
	{
		$data=array(
			'pass'=>$new_password
		);
		$this->db->where('id',$user_id);
		return $this->db->update('admin_user', $data);
	}
	public function inactive_reset_request($id)
	{
		$data=array(
			'active'=>0
		);
		$this->db->where('id',$id);
		return $this->db->update('password_reset_request', $data);
	}
}