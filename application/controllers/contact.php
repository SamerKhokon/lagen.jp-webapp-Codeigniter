<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller
{
    private $data=array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('mix_model');
        date_default_timezone_set('Asia/Dacca');

        $this->load->library('form_validation');
    }

    function index()
    {
        $this->data['page_title']='大宮PREMIUMフィリピンクラブ｜LAGEN -ラゲン- 在籍50名PHILLIPINE CLUB';
        //$this->data['all_topics']=$this->mix_model->get_all_topics();
        $this->data['page']='contact';
        $this->load->view('template',$this->data);
    }

    function send_mail()
    {
        $this->form_validation->set_rules('name1','お名前','xss_clean|trim|required');
        $this->form_validation->set_rules('mail','メールアドレス','xss_clean|trim|valid_email|required');
        $this->form_validation->set_rules('tel','T E L','xss_clean|trim');
        $this->form_validation->set_rules('kana','フリガナ','xss_clean|trim');
        $this->form_validation->set_rules('message','お問い合わせ','xss_clean|trim|required');
        
        if($this->form_validation->run()==FALSE)
        {
            $this->index();
        }
        else
        {
            $name=$this->input->post('name1');
            $kana=$this->input->post('kana');
            $from=$this->input->post('mail');
            $tel=$this->input->post('tel');
            $text = $this->input->post('message');

            $to      = 'bipul@atomixsystem.com';
            $subject = 'contacted from lagen';
            $headers = '';
            /*if (!empty($from)) {
                $headers = 'From: '.$from. "\r\n" .
                            'Reply-To: webmaster@example.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
            }*/

            $message='From: '.$from.' Name: '.$name.' Kana: '.$kana.' Tel:'.$tel.' Message: '.$text;


            $this->load->library('email');
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'mail.atomixsystem.com';
            $config['smtp_user'] = 'sujon@atomixsystem.com';
            $config['smtp_pass'] = 'asl13456';
            $config['smtp_port'] = 25;
            
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = FALSE;
            $config['mailtype'] = 'text';

            $this->email->to($to);
            $this->email->from('sujon@atomixsystem.com', $from);
            $this->email->reply_to($from, $from);
            $this->email->subject($subject);
            $this->email->message($message);

            //if(mail($to, $subject, $message, $headers)){
            if($this->email->send()){
                $this->data['mail_send']='Mail Successfully Sent!';
            }
            else{
                $this->data['mail_send']='Mail sending Failed!';
            }
            $this->data['page_title']='大宮PREMIUMフィリピンクラブ｜LAGEN -ラゲン- 在籍50名PHILLIPINE CLUB';
            //$this->data['all_topics']=$this->mix_model->get_all_topics();
            $this->data['page']='contact';
            $this->load->view('template',$this->data);
        }
    }
}