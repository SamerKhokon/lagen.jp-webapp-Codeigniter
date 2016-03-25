<?php
class User_registration extends CI_Controller
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
	}

	function index()
	{
		$this->data['page']='dashboard';
		$this->load->view('template',$this->data);
	}

	function add()
	{

		$this->load->library('form_validation');
		$this->data['page']='user_registration/add';
		$this->load->view('template',$this->data);
	}

	function save_user_registration()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('name','Name','xss_clean|required|trim');
		$this->form_validation->set_rules('email','email','xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('address','address','xss_clean|trim');
		$this->form_validation->set_rules('contact_number','contact_number','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->add();
		}
		else
		{
			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');

			$insert_data = array(
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'address'=>$this->input->post('address'),
				'contact_number'=>$this->input->post('contact_number'),
				'entry_dt'=>$date
			);

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->insert('user_registration',$insert_data))
			{
				$this->data['successful'] ='Successfully Saved to Database.';
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

	function manage()
	{
		$this->load->library('pagination');
		
		$p_base_url = base_url().'user_registration/manage/';
		$config['base_url'] = $p_base_url;
		$config['total_rows'] = $this->common_model->total_rows('user_registration');
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$this->data['all_data'] = $this->common_model->get_all_for_pagination('user_registration',$config['per_page'],$this->uri->segment(3,0));
		$this->data['table_showing_info']='Showing '.($this->uri->segment(3,0)+1).' - '.($this->uri->segment(3,0)+count($this->data['all_data'])).' (total '.$config['total_rows'].' rows)';

		//$this->data['all_data'] = $this->common_model->get_all('coupon');
		
		$this->data['page']='user_registration/manage';
		$this->load->view('template',$this->data);
	}

	function edit()
	{
		$id=$this->uri->segment(3);
		if (!empty($id))
		{
			$where=array('id'=>$id);
			$this->data['data']=$this->common_model->get_row_where('user_registration',$where);

			$this->load->library('form_validation');

			$this->data['page']='user_registration/edit';
			$this->load->view('template',$this->data);
		}
			
	}
	function update()
	{
		$id = $this->uri->segment(3);
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name','Name','xss_clean|required|trim');
		$this->form_validation->set_rules('email','email','xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('address','address','xss_clean|trim');
		$this->form_validation->set_rules('contact_number','contact_number','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->edit($id);
		}
		else
		{
			$update_data = array(
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'address'=>$this->input->post('address'),
				'contact_number'=>$this->input->post('contact_number')
			);

			$id=$this->input->post('row_id');
			$where = array('id' => $id);

			//$this->data['redirect_previous_page']=TRUE;
			$this->data['custom_redirect']=base_url().'user_registration/manage/';
			if ($this->common_model->update('user_registration',$where,$update_data))
			{
				$this->data['successful'] ='Successfully Saved to Database.';
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

	function delete()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$where = array('id' => $id);

			$this->data['custom_redirect']=base_url().'user_registration/manage';
			if ($this->common_model->delete('user_registration',$where))
			{
				$this->data['successful'] ='Successfully Deleted!';
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