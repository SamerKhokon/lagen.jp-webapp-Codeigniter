<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	private $data=array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

	public function index()
	{
		$this->load->library('form_validation');
		$this->load->view('login');
		
	}
	public function test()
	{
		$this->data['successful'] ='Your Password Successfully Changed!';
		$this->load->view('include/header');
		$this->load->view('custom_msg',$this->data);
		$this->load->view('include/footer');
	}
	public function login_action()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		
		$this->form_validation->set_rules('username','Username ','xss_clean|trim|required');
		$this->form_validation->set_rules('password','Password ','xss_clean|trim|required');
		
		if($this->form_validation->run()==FALSE)
		{
			
			$this->index();
		}
		else
		{
			$login_data['username']=$this->input->post('username');
			$login_data['password']=md5($this->input->post('password'));
			
			
			$query=$this->user_model->user_login_check($login_data);

			if($query)
			{
				$session_data=array(
					'username'=>$login_data['username'],
					'logged_in_ayna'=> true
				);
				$this->session->set_userdata($session_data);
				redirect('dashboard/');
			}
			else
			{
				$this->data['wrong_username_password']='<div class="alert alert-error"><strong>Login Failed!!!</strong> Invalid Username or Password!</div>';
				//$this->data['main_content']='custom_msg';
				$this->load->view('login',$this->data);
				//$this->load->view('template',$this->data);
			}
		}
	}

	public function password_reset_confirm()
	{
		$hash=$this->uri->segment(3);
		if(!empty($hash))
		{
			$reset_data=$this->user_model->get_active_reset_data_by_hash($hash);
			if(!empty($reset_data))
			{
				if($this->user_model->change_password($reset_data['user_id'],$reset_data['new_password']))
				{
					$this->user_model->inactive_reset_request($reset_data['id']);
					
					$this->data['successful'] ='Your Password Successfully Changed!';
					$this->load->view('login',$this->data);
				}
				else
				{
					$this->data['failed'] ='Database Error! Please Try Again';
					$this->load->view('login',$this->data);
				}
			}
			else
			{
				$this->data['failed'] ='This link is not active anymore.';
				$this->load->view('login',$this->data);
			}
		}
	}
	public function password_reset_cancel()
	{
		$hash=$this->uri->segment(3);
		if(!empty($hash))
		{
			$reset_data=$this->user_model->get_active_reset_data_by_hash($hash);
			if(!empty($reset_data))
			{
				if($this->user_model->inactive_reset_request($reset_data['id']))
				{
					$this->data['successful'] ='Password Reset Request Cancelled!';
					$this->load->view('login',$this->data);
				}
				else
				{
					$this->data['failed'] ='Database Error! Please Try Again';
					$this->load->view('login',$this->data);
				}
			}
			else
			{
				$this->data['failed'] ='This link is not active anymore.';
				$this->load->view('login',$this->data);
			}
		}
	}
	public function password_reset_action()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		//$this->form_validation->set_rules('password','New Password ','xss_clean|trim|required|min_length[4]|max_length[32]');
		//$this->form_validation->set_rules('retypePassword','Retype New Password','xss_clean|trim|required|matches[password]');
		$this->form_validation->set_rules('email_address','Email Address','xss_clean|trim|required|valid_email');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->index();
		}
		else
		{
			$email=$this->input->post('email_address');
			$username=$this->input->post('username');
			$user_id=$this->user_model->email_associate_with_user($email,$username);
			if(!empty($user_id))
			{
				if(!$this->user_model->check_existing_reset_request($email,$user_id))
				{
					$this->load->helper('string');
					$hash=random_string('unique');
					$random_password=random_string('alnum',6);
					$date_time=date('Y-m-d H:i:s');
					
					$dateTime = new DateTime($date_time);
					$formateed_date=date_format ( $dateTime, 'd M, Y g:i:s a' );
					$reset_data=array(
						'user_id'=>$user_id,
						'email_address'=>$email,
						'new_password'=>md5($random_password),
						'hash_code'=>$hash
					);
					if($this->user_model->save_password_reset_data($reset_data))
					{
						$this->load->library('email');
						$config['protocol'] = 'smtp';
						$config['smtp_host'] = 'mail.atomixsystem.com';
						$config['smtp_user'] = 'sujon@atomixsystem.com';
						$config['smtp_pass'] = 'asl13456';
						$config['smtp_port'] = 25;
						
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'utf-8';
						$config['wordwrap'] = FALSE;
						$config['mailtype'] = 'html';
						
						$body='<html>
								<head>
								</head>
									<body>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td>
												We got a password reset request on '.$formateed_date.' of Username: '.$username.'<br/>
												Your new Password is: '.$random_password.'
												To activate the password you must click the link below:<br/>
												'.base_url().'login/password_reset_confirm/'.$hash.'
												<br/><br/>
												Please click the link below if you don\'t make this request or want to cancel it.<br/>
												'.base_url().'login/password_reset_cancel/'.$hash.'
												<br/><br/>
												Regards,<br/>
												Zurna Team.
												
												</td>
											</tr>
										</table>
									</body>
								</html>';
						
						$this->email->initialize($config);
				
						$this->email->from('sujon@atomixsystem.com', 'Zurna Team');
						$this->email->to($email);
						
						$this->email->subject('Password Reset Request');
						$this->email->message($body);
						
						if($this->email->send())
						{
							$this->data['successful'] ='An Email has been sent to the email address with a link. please click on the link to change your password. If you don\'t found our email in inbox please check in spam folder.';
							$this->load->view('login',$this->data);
						}
						else
						{
							$this->data['failed'] ='Mail Sending Failed! Technical Info: '.$this->email->print_debugger();
							$this->load->view('login',$this->data);
						}
					}
					else
					{
						$this->data['failed'] ='Database Error! Please Try Again.';
						$this->load->view('login',$this->data);
					}
				}
				else
				{
					$this->data['failed'] ='A password reset request already has been submitted associated with this Username and Email Address!';
					$this->load->view('login',$this->data);
				}
			}
			else
			{
				$this->data['failed'] ='We don\'t found any account associated with this Username and Email Address!';
				//$this->data['page']='login';
				$this->load->view('login',$this->data);
			}
		}
	}
}