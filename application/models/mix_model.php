<?php
class Mix_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Dacca');
    }
    function get_all_topics()
    {
        $this->db->where('active_status',1);
        $this->db->order_by('entry_dt', 'DESC');
        return $this->db->get('topic')->result_array();
    }

    function get_all_girls()
    {
        $this->db->where('active_status',1);
        $result = $this->db->get('pickup_girls')->result_array();
        //print_r($result);exit();
        foreach ($result as $key => $value) {
            $this->db->where('girl_id',$value['id']);
            $value['all_images'] = $this->db->get('pickup_girls_image')->result_array();
            $result[$key] = $value;
        }
        return $result;
    }

    function get_all_coupons()
    {
        $this->db->where('active_status',1);
        $this->db->order_by('entry_dt', 'DESC');
        return $this->db->get('coupon')->result_array();
    }

    function get_all_current_calender_events()
    {
        $this->db->where('MONTH(event_dt)',date('m'));
        return $this->db->get('event_calender')->result_array();
    }
    function get_calender_events_for_month($date)
    {
        $dateTime = new DateTime($date);
        $month=date_format ($dateTime, 'm');

        $this->db->where('MONTH(event_dt)',$month);
        return $this->db->get('event_calender')->result_array();
    }

    function get_event_details_image()
    {
        $this->db->where('MONTH(event_dt)',date('m'));
        return $this->db->get('event_details_image')->row_array();
    }
    function get_event_details_image_for_month($date)
    {
        $dateTime = new DateTime($date);
        $month=date_format ($dateTime, 'm');

        $this->db->where('MONTH(event_dt)',$month);
        return $this->db->get('event_details_image')->row_array();
    }
}