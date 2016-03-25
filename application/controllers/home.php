<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
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
        $all_data=$this->common_model->get_all('home_page');
        $this->data['welcome_text']=$all_data[0];
        $this->data['all_topics']=$this->mix_model->get_all_topics();
        $this->data['page']='home';
        $this->load->view('template',$this->data);
    }
}