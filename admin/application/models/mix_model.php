<?php

class Mix_model extends CI_Model
{
	function get_all_girls($limit=10, $offset=0)
    {
        $this->db->limit($limit, $offset);
        $result = $this->db->get('pickup_girls')->result_array();
        foreach ($result as $key => $value) {
            $this->db->where('girl_id',$value['id']);
            $value['all_images'] = $this->db->get('pickup_girls_image')->result_array();
            $result[$key] = $value;
        }
        return $result;
    }
    function all_girls_total_number()
    {
        return $this->db->get('pickup_girls')->num_rows();
    }
    function get_pickup_girl($id)
    {
        $this->db->where('id',$id);
        $result = $this->db->get('pickup_girls')->row_array();
        
        $this->db->where('girl_id',$id);
        $result['all_images'] = $this->db->get('pickup_girls_image')->result_array();
        return $result;
    }

}