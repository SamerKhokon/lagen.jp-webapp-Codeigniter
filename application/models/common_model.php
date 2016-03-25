<?php

class Common_model extends CI_Model
{
	function insert($table='',$data=array())
    {
        return $this->db->insert($table,$data);
    }
    function get_all($table)
    {
        return $this->db->get($table)->result_array();
    }
    function get_row_where($table,$where)
    {
        $this->db->where($where);
        return $this->db->get($table)->row_array();
    }
    function get_all_where($table,$where)
    {
        $this->db->where($where);
        return $this->db->get($table)->result_array();
    }
    function update($table,$where,$data)
    {
        $this->db->where($where);
        return $this->db->update($table,$data);
    }
    function update_all($table,$data)
    {
        return $this->db->update($table,$data);
    }
    function total_rows($table)
    {
    	return $this->db->get($table)->num_rows();
    }
    function total_rows_where($table,$where)
    {
        $this->db->where($where);
        return $this->db->get($table)->num_rows();
    }
    function delete($table,$where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }
}