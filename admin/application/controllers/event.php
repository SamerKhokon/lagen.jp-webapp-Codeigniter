<?php
class Event extends CI_Controller
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

	function add_event_to_calender()
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

		$this->data['page']='event/add_event_to_calender';
		$this->load->view('template',$this->data);
	}

	function save_event_to_calender()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('event_dt','Event Datetime','xss_clean|trim|required');
		$this->form_validation->set_rules('description','Description', 'xss_clean');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		//echo $_POST['description']; 
		//echo $_POST['title']; 
		
		//exit();
		if($this->form_validation->run()==FALSE)
		{
			$this->add_event_to_calender();
		}
		else
		{
			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			

			$this->load->library('upload');
			$this->load->library('image_lib');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';


			ini_set('max_execution_time', 600);
			$field_name = 'image';
			if(!empty($_FILES[$field_name]['name']))
			{

					//print_r($_FILES); exit();
					if ((($_FILES[$field_name]["type"] == "image/gif")
					|| ($_FILES[$field_name]["type"] == "image/jpeg")
					|| ($_FILES[$field_name]["type"] == "image/jpg")
					|| ($_FILES[$field_name]["type"] == "image/pjpeg")
					|| ($_FILES[$field_name]["type"] == "image/x-png")
					|| ($_FILES[$field_name]["type"] == "image/png"))){


					$photo = time();
		        	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/event/" . $photo);
		        	//move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/topic/thumb/" . $photo);
		        	$this->createThumbs("./uploads/event/","./uploads/event/thumb/",100);
		        	$result = $this->resize_image("./uploads/event/".$photo, 1024, 600);
		        	/*print_r($result);
		        	exit();*/
		        	// print_r($_FILES[$field_name]["type"]);exit();

		        	}else{
		        		$data['error'] = "unsupported file type";
		        		$failed .= "unsupported file type";
		        	}


				}



			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');

			$insert_data = array(
				'title' => $this->input->post('title'),
				'description'=>$this->input->post('description'),
				'event_dt' => $this->input->post('event_dt'),
				'image'=>$photo,
				'active_status'=>$this->input->post('active_status'),
				'entry_dt'=>$date
			);

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->insert('event_calender',$insert_data))
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

	function manage_event_calender()
	{
		$this->load->library('pagination');
		
		$p_base_url = base_url().'event/manage_event_calender/';
		$config['base_url'] = $p_base_url;
		$config['total_rows'] = $this->common_model->total_rows('event_calender');
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
		$this->data['all_data'] = $this->common_model->get_all_for_pagination('event_calender',$config['per_page'],$this->uri->segment(3,0));
		$this->data['table_showing_info']='Showing '.($this->uri->segment(3,0)+1).' - '.($this->uri->segment(3,0)+count($this->data['all_data'])).' (total '.$config['total_rows'].' rows)';

		//$this->data['all_data'] = $this->common_model->get_all('event_calender');
		
		$this->data['page']='event/manage_event_calender';
		$this->load->view('template',$this->data);
	}

	function edit_event_to_calender()
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
			$this->data['data']=$this->common_model->get_row_where('event_calender',$where);

			$this->load->library('form_validation');

			$this->data['page']='event/edit_event_to_calender';
			$this->load->view('template',$this->data);
		}
			
	}
	function update_event_to_calender()
	{

		$id=$this->uri->segment(3);

		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('event_dt','Event Datetime','xss_clean|trim|required');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->edit_event_to_calender($id);

			
		}
		else
		{
			$id=$this->input->post('row_id');
			$where = array('id' => $id);

			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');

			$update_data = array(
				'title' => $this->input->post('title'),
				'description'=>$this->input->post('description'),
				'event_dt' => $this->input->post('event_dt'),
				'active_status'=>$this->input->post('active_status'),
				'entry_dt'=>$date
			);

			//_________________________________
			$old_data=$this->common_model->get_row_where('event_calender',$where);

			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			



			$this->load->library('image_lib');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';


			ini_set('max_execution_time', 600);
			$field_name = 'image';
			if(!empty($_FILES[$field_name]['name']))
			{

					//print_r($_FILES); exit();
					if ((($_FILES[$field_name]["type"] == "image/gif")
					|| ($_FILES[$field_name]["type"] == "image/jpeg")
					|| ($_FILES[$field_name]["type"] == "image/jpg")
					|| ($_FILES[$field_name]["type"] == "image/pjpeg")
					|| ($_FILES[$field_name]["type"] == "image/x-png")
					|| ($_FILES[$field_name]["type"] == "image/png"))){


					$photo = time();
		        	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/event/" . $photo);
		        	//move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/topic/thumb/" . $photo);
		        	$this->createThumbs("./uploads/event/","./uploads/event/thumb/",100);

		        	$update_data = array(
						'title' => $this->input->post('title'),
						'description'=>$this->input->post('description'),
						'event_dt' => $this->input->post('event_dt'),
						'active_status'=>$this->input->post('active_status'),
						'image' => $photo,
						'entry_dt'=>$date
					);
		        	// print_r($_FILES[$field_name]["type"]);exit();

		        	}else{
		        		$data['error'] = "unsupported file type";
		        		$failed .= "unsupported file type";
		        	}


				}


			//$this->data['redirect_previous_page']=TRUE;
			$this->data['custom_redirect']=base_url().'event/manage_event_calender';
			if ($this->common_model->update('event_calender',$where,$update_data))
			{
				$this->data['successful'] ='Successfully Updated to Database.'.$failed;
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
	function delete_event_to_calender()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$where = array('id' => $id);

			$old_data=$this->common_model->get_row_where('event_calender',$where);
			//delete image
			if(!empty($old_data['image']))
			{
				$file_name='./uploads/event/'.$old_data['image'];
				unlink($file_name);
				$file_name='./uploads/event/thumb/'.$old_data['image'];
				unlink($file_name);
			}

			$this->data['custom_redirect']=base_url().'event/manage_event_calender';
			if ($this->common_model->delete('event_calender',$where))
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

	//EVENT DETAIL IMAGE
	function add_event_details_image()
	{
		$this->load->library('form_validation');

		$this->data['page']='event/add_event_details_image';
		$this->load->view('template',$this->data);
	}
	function save_event_details_image()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('event_dt','Event Datetime','xss_clean|trim|required');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->add_event_details_image();
		}
		else
		{
			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			$field_name = "image";
			if(!empty($_FILES[$field_name]['name']))
			{




				if ( $_FILES[$field_name]["error"][0] > 0)
		            {
		                // if upload fail, grab error 
		                $error['upload'][] = $_FILES[$field_name]["error"];
		                // $failed .= $this->upload->display_errors();
		            }
		            else
		            {

		            	if ((($_FILES[$field_name]["type"] == "image/gif")
						|| ($_FILES[$field_name]["type"] == "image/jpeg")
						|| ($_FILES[$field_name]["type"] == "image/jpg")
						|| ($_FILES[$field_name]["type"] == "image/pjpeg")
						|| ($_FILES[$field_name]["type"] == "image/x-png")
						|| ($_FILES[$field_name]["type"] == "image/png"))){


						$photo = time();
		            	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/event_details_image/" . $photo);



		            	$this->createThumbs("./uploads/event_details_image/","./uploads/event_details_image/thumb/",100);
		            	$update_data = array(
							'title' => $this->input->post('title'),
							'description'=>$this->input->post('description'),
							'image' => $photo,
							'active_status'=>$this->input->post('active_status')
						);
		            	
						// print_r($_FILES[$field_name]["type"]);exit();

		            	}else{
		            		$data['error'] = "unsupported file type";
		            		$failed .= "unsupported file type";
		            	}

		            }






			}//end upload photo

			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');

			$insert_data = array(
				'title' => $this->input->post('title'),
				'event_dt' => $this->input->post('event_dt'),
				'image'=>$photo,
				'active_status'=>$this->input->post('active_status'),
				'entry_dt'=>$date
			);

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->insert('event_details_image',$insert_data))
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
	function manage_event_details_image()
	{
		$this->load->library('pagination');
		
		$p_base_url = base_url().'event/manage_event_details_image/';
		$config['base_url'] = $p_base_url;
		$config['total_rows'] = $this->common_model->total_rows('event_details_image');
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
		$this->data['all_data'] = $this->common_model->get_all_for_pagination('event_details_image',$config['per_page'],$this->uri->segment(3,0));
		$this->data['table_showing_info']='Showing '.($this->uri->segment(3,0)+1).' - '.($this->uri->segment(3,0)+count($this->data['all_data'])).' (total '.$config['total_rows'].' rows)';

		//$this->data['all_data'] = $this->common_model->get_all('event_calender');
		
		$this->data['page']='event/manage_event_details_image';
		$this->load->view('template',$this->data);
	}
	function edit_event_details_image()
	{
		$id=$this->uri->segment(3);
		if (!empty($id))
		{
			$where=array('id'=>$id);
			$this->data['data']=$this->common_model->get_row_where('event_details_image',$where);

			$this->load->library('form_validation');

			$this->data['page']='event/edit_event_details_image';
			$this->load->view('template',$this->data);
		}
			
	}
	function update_event_details_image()
	{
		$id = $this->uri->segment(3);
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('event_dt','Event Datetime','xss_clean|trim|required');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->edit_event_details_image($id);
		}
		else
		{
			$id=$this->input->post('row_id');
			$where = array('id' => $id);

			$update_data = array(
				'title' => $this->input->post('title'),
				'event_dt' => $this->input->post('event_dt'),
				'active_status'=>$this->input->post('active_status')
			);

			//_________________________________
			$old_data=$this->common_model->get_row_where('event_details_image',$where);

			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			


			$field_name = "image";
			if(!empty($_FILES[$field_name]['name']))
			{




				if ( $_FILES[$field_name]["error"][0] > 0)
		            {
		                // if upload fail, grab error 
		                $error['upload'][] = $_FILES[$field_name]["error"];
		                // $failed .= $this->upload->display_errors();
		            }
		            else
		            {

		            	if ((($_FILES[$field_name]["type"] == "image/gif")
						|| ($_FILES[$field_name]["type"] == "image/jpeg")
						|| ($_FILES[$field_name]["type"] == "image/jpg")
						|| ($_FILES[$field_name]["type"] == "image/pjpeg")
						|| ($_FILES[$field_name]["type"] == "image/x-png")
						|| ($_FILES[$field_name]["type"] == "image/png"))){


						$photo = time();
		            	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/event_details_image/" . $photo);



		            	$this->createThumbs("./uploads/event_details_image/","./uploads/event_details_image/thumb/",100);

		            	$update_data = array(
							'title' => $this->input->post('title'),
							'event_dt' => $this->input->post('event_dt'),
							'image' => $photo,
							'active_status'=>$this->input->post('active_status')
						);


		            	
		            	
						// print_r($_FILES[$field_name]["type"]);exit();

		            	}else{
		            		$data['error'] = "unsupported file type";
		            		$failed .= "unsupported file type";
		            	}

		            }






			}//end upload photo


			//$this->data['redirect_previous_page']=TRUE;
			$this->data['custom_redirect']=base_url().'event/manage_event_details_image';
			if ($this->common_model->update('event_details_image',$where,$update_data))
			{
				$this->data['successful'] ='Successfully Updated to Database.'.$failed;
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
	function delete_event_details_image()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$where = array('id' => $id);

			$old_data=$this->common_model->get_row_where('event_details_image',$where);
			//delete image
			if(!empty($old_data['image']))
			{
				$file_name='./uploads/event_details_image/'.$old_data['image'];
				unlink($file_name);
				$file_name='./uploads/event_details_image/thumb/'.$old_data['image'];
				unlink($file_name);
			}

			//$this->data['custom_redirect']=base_url().'event/manage_event_details_image';
			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->delete('event_details_image',$where))
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


	function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )
	{
		error_reporting(0);
	  // open the directory
	  $dir = opendir( $pathToImages );

	  // loop through it, looking for any/all JPG files:
	  while (false !== ($fname = readdir( $dir ))) {
	    // parse path for the extension



	    $info = pathinfo($pathToImages . $fname);
	     

	      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
	      $img1 = imagecreatefrompng( "{$pathToImages}{$fname}" );
	      if($img){
	      		 
	      	$img = $img;		  
		  }else if($img1){
		  	$img = $img1;
	      }

	      		  $width = imagesx( $img );
			      $height = imagesy( $img );
			      //print_r($img."   ");
			      // calculate thumbnail size
			      $new_width = $thumbWidth;
			      $new_height = floor( $height * ( $thumbWidth / $width ) );

			      // create a new temporary image
			      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

			      // copy and resize old image into new image
			      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

			      // save thumbnail into a file
			      imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
	    
	     
	  }
	  // close the directory
	  closedir( $dir );

	  // exit();
	}



	function resize_image($file, $w, $h, $crop=FALSE) {
		//echo $file;
	    list($width, $height) = getimagesize($file);
	    $r = $width / $height;
	    if ($crop) {
	        if ($width > $height) {
	            $width = ceil($width-($width*abs($r-$w/$h)));
	        } else {
	            $height = ceil($height-($height*abs($r-$w/$h)));
	        }
	        $newwidth = $w;
	        $newheight = $h;
	    } else {
	        if ($w/$h > $r) {
	            $newwidth = $h*$r;
	            $newheight = $h;
	            //echo 1;
	        } else {
	            $newheight = $w/$r;
	            $newwidth = $w;
	            //echo 2;
	        }
	    }
	    $src = imagecreatefromjpeg($file);
	    $src1 = imagecreatefrompng($file);
	    if(!$src){
	    	$src = $src1;
	    }
	    //print_r($src);
	    $dst = imagecreatetruecolor($newwidth, $newheight);
	    $imageCopy = imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	    imagejpeg( $dst, $file );
	    //print_r("result:  ".$imageCopy);
	    return $dst;
	}


}