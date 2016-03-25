<?php
class Coupon extends CI_Controller
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

	function add()
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
		$this->data['page']='coupon/add';
		$this->load->view('template',$this->data);
	}

	function save_coupon()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		//$this->form_validation->set_rules('title','Title','xss_clean|trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		//$this->form_validation->set_rules('image','Description','xss_clean|trim');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->add();
		}
		else
		{
			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			$field_name = "image";
			if(!empty($_FILES['image']['name']))
			{
				

				

					//print_r($_FILES); exit();
					if ((($_FILES[$field_name]["type"] == "image/gif")
					|| ($_FILES[$field_name]["type"] == "image/jpeg")
					|| ($_FILES[$field_name]["type"] == "image/jpg")
					|| ($_FILES[$field_name]["type"] == "image/pjpeg")
					|| ($_FILES[$field_name]["type"] == "image/x-png")
					|| ($_FILES[$field_name]["type"] == "image/png"))){


					$photo = time();
		        	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/coupon/" . $photo);
		        	//move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/topic/thumb/" . $photo);
		        	$this->createThumbs("./uploads/coupon/","./uploads/coupon/thumb/",100);

		        	// print_r($_FILES[$field_name]["type"]);exit();

		        	}else{
		        		$data['error'] = "unsupported file type";
		        		$failed .= "unsupported file type";
		        	}


				



			}//end upload photo

			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');

			$insert_data = array(
				'description'=>$this->input->post('description'),
				'image'=>$photo,
				'active_status'=>$this->input->post('active_status'),
				'entry_dt'=>$date
			);

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->insert('coupon',$insert_data))
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
		
		$p_base_url = base_url().'coupon/manage/';
		$config['base_url'] = $p_base_url;
		$config['total_rows'] = $this->common_model->total_rows('coupon');
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
		$this->data['all_data'] = $this->common_model->get_all_for_pagination('coupon',$config['per_page'],$this->uri->segment(3,0));
		$this->data['table_showing_info']='Showing '.($this->uri->segment(3,0)+1).' - '.($this->uri->segment(3,0)+count($this->data['all_data'])).' (total '.$config['total_rows'].' rows)';

		//$this->data['all_data'] = $this->common_model->get_all('coupon');
		
		$this->data['page']='coupon/manage';
		$this->load->view('template',$this->data);
	}

	function edit()
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
			$this->data['data']=$this->common_model->get_row_where('coupon',$where);

			$this->load->library('form_validation');

			$this->data['page']='coupon/edit';
			$this->load->view('template',$this->data);
		}
			
	}
	function update()
	{
		$id = $this->uri->segment(3);
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('active_status','Price','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->edit($id);
		}
		else
		{
			$update_data = array(
				'description'=>$this->input->post('description'),
				'active_status'=>$this->input->post('active_status')
			);

			$id=$this->input->post('row_id');
			$where = array('id' => $id);
			$old_data=$this->common_model->get_row_where('coupon',$where);

			$this->load->library('upload');
			//Upload the photo
			$picture='';
			$photo='';
			$failed='';
			$field_name = "image";
			if(!empty($_FILES['image']['name']))
			{
				
					//print_r($_FILES); exit();
					if ((($_FILES[$field_name]["type"] == "image/gif")
					|| ($_FILES[$field_name]["type"] == "image/jpeg")
					|| ($_FILES[$field_name]["type"] == "image/jpg")
					|| ($_FILES[$field_name]["type"] == "image/pjpeg")
					|| ($_FILES[$field_name]["type"] == "image/x-png")
					|| ($_FILES[$field_name]["type"] == "image/png"))){


					$photo = time();
		        	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/coupon/" . $photo);
		        	//move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/topic/thumb/" . $photo);
		        	$this->createThumbs("./uploads/coupon/","./uploads/coupon/thumb/",100);
		        	$update_data['image']=$photo;
		        	// print_r($_FILES[$field_name]["type"]);exit();

		        	}else{
		        		$data['error'] = "unsupported file type";
		        		$failed .= "unsupported file type";
		        	}

					
					
			}//end upload photo

			//$this->data['redirect_previous_page']=TRUE;
			$this->data['custom_redirect']=base_url().'coupon/manage';
			if ($this->common_model->update('coupon',$where,$update_data))
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

			$old_data=$this->common_model->get_row_where('coupon',$where);

			if(!empty($old_data['image']))
			{
				$file_name='./uploads/coupon/'.$old_data['image'];
				unlink($file_name);
				$file_name='./uploads/coupon/thumb/'.$old_data['image'];
				unlink($file_name);
			}

			$this->data['custom_redirect']=base_url().'coupon/manage';
			if ($this->common_model->delete('coupon',$where))
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
	    
	     //print_r($info); exit();
	    // continue only if this is a JPEG image
	    // if ( strtolower($info['extension']) == 'jpg' )
	    // {
	    //   echo "Creating thumbnail for {$fname} <br />";

	      
	    // }
	  }
	  // close the directory
	  closedir( $dir );

	  // exit();
	}
}