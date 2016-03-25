<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller
{
    private $data=array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('mix_model');
        date_default_timezone_set('Asia/Dacca');
    }

    function index()
    {
        $this->data['page_title']='大宮PREMIUMフィリピンクラブ｜LAGEN -ラゲン- 在籍50名PHILLIPINE CLUB';
        $this->data['all_calender_events']=$this->mix_model->get_all_current_calender_events();
        $this->data['event_details_image']=$this->mix_model->get_event_details_image();
        //print_r($this->data['all_calender_events']);
        //die();
        $this->data['prev']=date("Y-m-d",strtotime("-1 month"));
        $this->data['next']=date("Y-m-d",strtotime("+1 month"));

        $this->data['page']='event';
        $this->load->view('template',$this->data);
    }
    function event_calendar($date)
    {
        $this->data['prev']=date("Y-m-d",strtotime($date." -1 month"));
        $this->data['next']=date("Y-m-d",strtotime($date." +1 month"));

        $this->data['page_title']='大宮PREMIUMフィリピンクラブ｜LAGEN -ラゲン- 在籍50名PHILLIPINE CLUB';
        $this->data['all_calender_events']=$this->mix_model->get_calender_events_for_month($date);
        $this->data['event_details_image']=$this->mix_model->get_event_details_image_for_month($date);
        $this->data['page']='event';
        $this->load->view('template',$this->data);
    }
}