<?php
class Dashboard extends CI_Controller
{
	private $data=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('mix_model');
		date_default_timezone_set('Asia/Dacca');

		$logged_in_ayna=$this->session->userdata('logged_in_ayna');
		if(empty($logged_in_ayna) || $logged_in_ayna != true)
		{	
			redirect('login/');
		}
		else
		{
			$this->data['username']=$this->session->userdata['username'];
			$this->data['logged_in']=true;
		}
	}

	function index()
	{
		$this->data['page']='dashboard';
		$this->load->view('template',$this->data);
	}

	function password_change()
	{
		$this->load->library('form_validation');
		$this->data['page']='password_change_form';
		$this->load->view('template',$this->data);
	}
	function password_update()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('password','New Password ','xss_clean|trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('retype_password','Retype New Password','xss_clean|trim|required|matches[password]');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->password_change();
		}
		else
		{
			$pass=$this->input->post('password');

			$where=array(
				'user_id'=>$this->data['username']
			);
			$data=array(
				'pass'=>md5($pass)
			);

			$this->data['redirect_previous_page']=TRUE;
			if($this->common_model->update('admin_user',$where,$data))
			{
				$this->data['successful'] ='Password Successfully Changed.';
				$this->data['page']='custom_msg';
				$this->load->view('template',$this->data);
			}
			else
			{
				$this->data['failed'] ='Database Error! Please Try Again';
				$this->data['page']='custom_msg';
				$this->load->view('template',$this->data);
			}
		}
	}
}