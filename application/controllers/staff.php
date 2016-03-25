<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller
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
        $this->data['all_girls']=$this->mix_model->get_all_girls();
        
        $this->data['page']='staff';
        $this->load->view('template',$this->data);
    }
}