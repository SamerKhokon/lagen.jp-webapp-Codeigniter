<?php
class Home_page extends CI_Controller
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
		$this->data['page']='dashboard';
		$this->load->view('template',$this->data);
	}

	function manage_welcome_text()
	{
		$this->load->helper('ckeditor');
		//Ckeditor's configuration
		$this->data['ckeditor'] = array(
			//ID of the textarea that will be replaced
			'id' 	=> 	'welcome_text',
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
				'contentsCss'=> base_url() . 'assets/ckeditor/custom.css',
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
		$all_data=$this->common_model->get_all('home_page');
		$this->data['data']=$all_data[0];
		$this->data['page']='home_page/manage_welcome_text';
		$this->load->view('template',$this->data);
	}
	function update_home_page()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('welcome_text','welcome_text','trim|required');
		//$this->form_validation->set_rules('active_status','Status','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->manage_welcome_text();
		}
		else
		{
			$id=$this->input->post('row_id');
			$where = array('id' => $id);
			$media_data=$this->common_model->get_row_where('home_page',$where);
			if(!empty($id))
			{
				//$dateTime = new DateTime();
				//$date=date_format($dateTime, 'Y-m-d H:i:s');

				$update_data = array(
					'welcome_text'=>$this->input->post('welcome_text')
					);


				$this->load->library('upload');
				//Upload the photo
				$picture='';
				$photo='';
				$failed='';
				if(!empty($_FILES['image']['name']))
				{
					$str=substr($_FILES['image']['name'], 0, 5);
					$picture=$str.time();
					
					$config['upload_path'] = './uploads/home_page/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
					//$config['max_size']	= '100';
					//$config['max_width']  = '1024';
					//$config['max_height']  = '768';
					$config['file_name']  = $picture;
					$config['overwrite']  = FALSE;
					
					//$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					if (!$this->upload->do_upload('image'))
					{
						$failed .= $this->upload->display_errors();
					}
					else
					{
						//Resize
						$img_info=$this->upload->data();
						$source_image_path='./uploads/home_page/'.$img_info['file_name'];
						$new_image_path='./uploads/home_page/thumb/'.$img_info['file_name'];
						$photo=$img_info['file_name'];
						
						$config_img1['image_library'] = 'GD2';//GD, GD2, ImageMagick, NetPBM
						$config_img1['source_image'] = $source_image_path;
						$config_img1['new_image'] = $new_image_path;
						$config_img1['create_thumb'] = FALSE;
						$config_img1['maintain_ratio'] = FALSE;
						$config_img1['width'] = 100;
						$config_img1['height'] = 100;
						//$config_img['quality'] = 80%;
						//$config_img['master_dim'] = 'width';//auto, width, height
						$config_img1['overwrite']  = FALSE;
						
						$this->load->library('image_lib', $config_img1);
						
						$this->image_lib->resize();
						$failed .= $this->image_lib->display_errors();

						$update_data['image']=$photo;
						//delete old one
						if(!empty($media_data['image']))
						{
							$file_name='./uploads/home_page/'.$media_data['image'];
							unlink($file_name);
							$file_name='./uploads/home_page/thumb/'.$media_data['image'];
							unlink($file_name);
						}
					}
				}//end upload photo

				$this->data['custom_redirect']=base_url().'home_page/manage_welcome_text';
				if ($this->common_model->update('home_page',$where,$update_data))
				{
					$this->data['successful'] ='Successfully Updated!';
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

	//TOPICS
	function add_topic()
	{
		$this->load->helper('ckeditor');
		//Ckeditor's configuration
		$this->data['ckeditor'] = array(
			//ID of the textarea that will be replaced
			'id' 	=> 	'description',
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

		$this->data['page']='home_page/add_topic';
		$this->load->view('template',$this->data);
	}

	function save_topic()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		//$this->form_validation->set_rules('image','Description','xss_clean|trim');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->add_topic();
		}
		else
		{
			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			if(!empty($_FILES['image']['name']))
			{

				$str=substr($_FILES['image']['name'], 0, 5);
				$picture=$str.time();
				
				$config['upload_path'] = './uploads/topic/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
				//$config['max_size']	= '100';
				$config['max_width']  = '9999';
				$config['max_height']  = '9999';
				$config['file_name']  = $picture;
				$config['overwrite']  = FALSE;
				
				$this->upload->initialize($config);
				
				if (!$this->upload->do_upload('image'))
				{
					$failed .= $this->upload->display_errors();
				}
				else
				{
					//Resize
					$img_info=$this->upload->data();
					print_r($img_info);
					die();
					$source_image_path='./uploads/topic/'.$img_info['file_name'];
					$new_image_path='./uploads/topic/thumb/'.$img_info['file_name'];
					$photo=$img_info['file_name'];
					
					$config_img1['image_library'] = 'GD2';//GD, GD2, ImageMagick, NetPBM
					$config_img1['source_image'] = $source_image_path;
					$config_img1['new_image'] = $new_image_path;
					$config_img1['create_thumb'] = FALSE;
					$config_img1['maintain_ratio'] = FALSE;
					$config_img1['width'] = 100;
					$config_img1['height'] = 100;
					//$config_img['quality'] = 80%;
					//$config_img['master_dim'] = 'width';//auto, width, height
					$config_img1['overwrite']  = FALSE;
					
					$this->load->library('image_lib', $config_img1);
					
					if($this->image_lib->resize()){

					}
					else{
						$failed .= $this->image_lib->display_errors();
					}
				}
			}//end upload photo

			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');

			$insert_data = array(
				'title' => $this->input->post('title'),
				'description'=>htmlentities($this->input->post('description')),
				'image'=>$photo,
				'active_status'=>$this->input->post('active_status'),
				'entry_dt'=>$date
			);

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->insert('topic',$insert_data))
			{
				$this->data['successful'] ='Successfully Saved to Database.'.$failed;
				$this->data['page']='custom_msg';
				$this->load->view('template',$this->data);
			}
			else
			{
				$this->data['failed'] ='Database Error! Please Try Again'.$failed;
				$this->data['page']='custom_msg';
				$this->load->view('template',$this->data);
			}
		}
	}

	function manage_topic()
	{
		$this->load->library('pagination');
		
		$p_base_url = base_url().'home_page/manage_topic/';
		$config['base_url'] = $p_base_url;
		$config['total_rows'] = $this->common_model->total_rows('topic');
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
		$this->data['list_event'] = $this->common_model->get_all_for_pagination('topic',$config['per_page'],$this->uri->segment(3,0));
		$this->data['table_showing_info']='Showing '.($this->uri->segment(3,0)+1).' - '.($this->uri->segment(3,0)+count($this->data['list_event'])).' (total '.$config['total_rows'].' rows)';

		$this->data['all_data'] = $this->common_model->get_all('topic');
		
		$this->data['page']='home_page/manage_topic';
		$this->load->view('template',$this->data);
	}

	function edit_topic()
	{
		$id=$this->uri->segment(3);
		if (!empty($id))
		{
			$this->load->helper('ckeditor');
			//Ckeditor's configuration
			$this->data['ckeditor'] = array(
				//ID of the textarea that will be replaced
				'id' 	=> 	'description',
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
			$where=array('id'=>$id);
			$this->data['data']=$this->common_model->get_row_where('topic',$where);

			$this->load->library('form_validation');

			$this->data['page']='home_page/edit_topic';
			$this->load->view('template',$this->data);
		}
			
	}
	function update_topic()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('image','Description','xss_clean|trim');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->edit_topic();
		}
		else
		{
			$update_data = array(
				'title' => $this->input->post('title'),
				'description'=>htmlentities($this->input->post('description')),
				'active_status'=>$this->input->post('active_status')
			);

			$id=$this->input->post('row_id');
			$where = array('id' => $id);
			$old_data=$this->common_model->get_row_where('topic',$where);

			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			if(!empty($_FILES['image']['name']))
			{
				$str=substr($_FILES['image']['name'], 0, 5);
				$picture=$str.time();
				
				$config['upload_path'] = './uploads/topic/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
				//$config['max_size']	= '100';
				//$config['max_width']  = '1024';
				//$config['max_height']  = '768';
				$config['file_name']  = $picture;
				$config['overwrite']  = FALSE;
				
				$this->upload->initialize($config);
				
				if (!$this->upload->do_upload('image'))
				{
					$failed .= $this->upload->display_errors();
				}
				else
				{
					//Resize
					$img_info=$this->upload->data();
					$source_image_path='./uploads/topic/'.$img_info['file_name'];
					$new_image_path='./uploads/topic/thumb/'.$img_info['file_name'];
					$photo=$img_info['file_name'];
					
					$config_img1['image_library'] = 'GD2';//GD, GD2, ImageMagick, NetPBM
					$config_img1['source_image'] = $source_image_path;
					$config_img1['new_image'] = $new_image_path;
					$config_img1['create_thumb'] = FALSE;
					$config_img1['maintain_ratio'] = FALSE;
					$config_img1['width'] = 100;
					$config_img1['height'] = 100;
					//$config_img['quality'] = 80%;
					//$config_img['master_dim'] = 'width';//auto, width, height
					$config_img1['overwrite']  = FALSE;
					
					$this->load->library('image_lib', $config_img1);
					
					$this->image_lib->resize();
					$failed .= $this->image_lib->display_errors();

					$update_data['image']=$photo;
					//delete old one
					if(!empty($old_data['image']))
					{
						$file_name='./uploads/topic/'.$old_data['image'];
						unlink($file_name);
						$file_name='./uploads/topic/thumb/'.$old_data['image'];
						unlink($file_name);
					}
				}
			}//end upload photo

			

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->update('topic',$where,$update_data))
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
	function delete_topic()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$where = array('id' => $id);

			$old_data=$this->common_model->get_row_where('topic',$where);

			if(!empty($old_data['image']))
			{
				$file_name='./uploads/topic/'.$old_data['image'];
				unlink($file_name);
				$file_name='./uploads/topic/thumb/'.$old_data['image'];
				unlink($file_name);
			}

			$this->data['custom_redirect']=base_url().'home_page/manage_topic';
			if ($this->common_model->delete('topic',$where))
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

	function delete_image_ajax()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$where = array('id' => $id);

			$old_data=$this->common_model->get_row_where('home_page',$where);

			if(!empty($old_data['image']))
			{
				$file_name='./uploads/home_page/'.$old_data['image'];
				unlink($file_name);
				$file_name='./uploads/home_page/thumb/'.$old_data['image'];
				unlink($file_name);
			}
			$data=array(
				'image'=>''
			);
			if ($this->common_model->update('home_page',$where,$data))
			{
				echo "Successfully Deleted!";
			}
			else
			{
				echo "Failed! Please Try Again!";
			}
		}
	}
}