<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
	public function index()
	{
		$this->session->unset_userdata($this->session->all_userdata());
  		$this->session->sess_destroy();

  		$this->load->library('form_validation');
  		$data['logged_out']=true;
		$this->load->view('login',$data);
	}
}