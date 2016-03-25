<?php
class Mass_mail extends CI_Controller
{
	private $data=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
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

		ini_set('max_execution_time', 600); //300 seconds = 5 minutes
	}

	function index()
	{
		$this->load->helper('ckeditor');
		//Ckeditor's configuration
		$this->data['ckeditor'] = array(
			//ID of the textarea that will be replaced
			'id' 	=> 	'email_body',
			'path'	=>	'assets/ckeditor',
			//Optionnal values
			'config' => array(
				//'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'toolbar' 	=> 	array(		//Setting a custom toolbar
					array('Source','-'),
					array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                    array('Link', 'Unlink'),
					array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv'),
					array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
                    array('Table', 'HorizontalRule', 'SpecialChar'),
					array('TextColor', 'BGColor'),
					array('Maximize', 'ShowBlocks'),
					array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                    array('Styles', 'Format', 'Font', 'FontSize'),
					'/'
				),
				//'contentsCss'=> base_url() . 'assets/ckeditor/custom.css',
				'width' 	=> 	"98%",	//Setting a custom width
				'height' 	=> 	'200px',	//Setting a custom height
				'filebrowserBrowseUrl' => base_url() . 'assets/ckfinder/ckfinder.html',
                'filebrowserImageBrowseUrl' => base_url() . 'assets/ckfinder/ckfinder.html?Type=Images',
                'filebrowserFlashBrowseUrl' => base_url() . 'assets/ckfinder/ckfinder.html?Type=Flash',
                'filebrowserUploadUrl' => base_url() . 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                'filebrowserImageUploadUrl' => base_url() . 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                'filebrowserFlashUploadUrl' => base_url() . 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
		);

		$this->load->library('form_validation');

		$this->data['page']='mass_mail/mass_mail_send_form';
		$this->load->view('template',$this->data);
	}

	function send()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$to_type=$this->input->post('to_type');
			
		if ($to_type=='individual') {
			$this->form_validation->set_rules('to','To','xss_clean|trim|required|valid_email|max_length[40]');
		}
		
		$this->form_validation->set_rules('email_type','Email Type','xss_clean|trim|required');
		$this->form_validation->set_rules('subject','Subject','xss_clean|trim|required|max_length[100]');
		$this->form_validation->set_rules('email_body','Email Body','trim|required');
		
		if($this->form_validation->run()==FALSE)
		{
			
			$this->index();
		}
		else
		{
			$email_type=$this->input->post('email_type');
			$subject=$this->input->post('subject');
			$email_body=$this->input->post('email_body');

			$this->load->library('email');
			/*$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'mail.atomixsystem.com';
			$config['smtp_user'] = 'sujon@atomixsystem.com';
			$config['smtp_pass'] = 'asl13456';
			$config['smtp_port'] = 25;
			
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = FALSE;*/
			$config['wordwrap'] = FALSE;

			if ($email_type=='html') {
				$config['mailtype'] = 'html';
				$body=$email_body;
			}
			else{
				$config['mailtype'] = 'text';

				$body=strip_tags($email_body);
			}
			
			$this->email->initialize($config);



			//first check the user logged in or not than check sender/receiver exist or not
            //$total_student_of_that_course=0;
            $success_flag=0;
            $error_flag=0;
            $loop=0;
            
            $to_type=$this->input->post('to_type');
            if($to_type=='all'){
                //get all email from registration
                //send email to each user by loop
                $all_user = $this->common_model->get_all('user_registration');
                $total_user = count($all_user);
                if($total_user>0){
                    foreach ($all_user as $user)
                    {
                    	if (!empty($user['email'])) {
                    		$this->email->clear(); //clear all to,from,subject,message etc.
							$this->email->to($user['email']);
							$this->email->from('info@lagen.jp', 'Lagen');
							$this->email->subject($subject);
							$this->email->message($body);
							if($this->email->send()){
								$success_flag++;
							}
							else{
								$error_flag++;
							}
                    	}
                    }
                    $total_user_without_email_address=$total_user-($success_flag+$error_flag);
                    if($success_flag==$total_user){
                        $this->data['successful']='Your Email Successfully sent to: '.$total_user.' Users.';
                        $this->data['page']='custom_msg';
                        $this->load->view('template',$this->data);
                    }else{
                        $this->data['failed']='Total User '.$total_user.' Successfully Send: '.$success_flag.' Failed: '.$error_flag.' User don\'t have email address: '.$total_user_without_email_address;
                        $this->data['page']='custom_msg';
                        $this->load->view('template',$this->data);
                    }
                }else{
                    $this->data['failed']='No user found!';
                    $this->data['page']='custom_msg';
                    $this->load->view('template',$this->data);
                }
            }else{
                //send message to individual email
                $to_user=$this->input->post('to');
                //echo $to_user; exit();
                $this->email->to($to_user);
				$this->email->from('info@lagen.jp', 'Lagen');
				$this->email->subject($subject);
				$this->email->message($body);
				if($status = $this->email->send()){
					//print_r($status);exit();
					$this->data['successful']='Your Email has been successfully sent to '.$to_user;
					$this->data['page']='custom_msg';
					$this->load->view('template',$this->data);
				}
				else{
					$this->data['failed']='Email Sending Failed!';
					$this->data['page']='custom_msg';
					$this->load->view('template',$this->data);
				}
    		}
        }
	}
}