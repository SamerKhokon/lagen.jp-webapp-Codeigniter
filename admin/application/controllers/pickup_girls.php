<?php
class Pickup_girls extends CI_Controller
{
	private $data=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('mix_model');

		date_default_timezone_set("Asia/Dacca");

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

		$this->data['page']='pickup_girls/add';
		$this->load->view('template',$this->data);
	}
	function save_pickup_girls()
    {
    	$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('name','Name','xss_clean|trim|required');
		$this->form_validation->set_rules('active_status','Status','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->add();
		}
		else
		{
			//print_r($_FILES);
			//die();
			$this->load->library('upload');
			$this->load->library('image_lib');
			
	        $picture='';
			$photo='';
			$failed='';
			$i = 0;

			ini_set('max_execution_time', 600); //600 seconds = 10 minutes

			$dateTime = new DateTime();
			$date=date_format($dateTime, 'Y-m-d H:i:s');
			$girl_data = array(
				'name'=>$this->input->post('name'),
				'description'=>$this->input->post('description'),
				'active_status'=>$this->input->post('active_status'),
				'entry_dt'=>$date
			);
			$girl_id=$this->common_model->insert('pickup_girls',$girl_data);
	    
	        // Change $_FILES to new vars and loop them
	        foreach($_FILES['image'] as $key=>$val)
	        {
	            $i = 1;
	            foreach($val as $v)
	            {
	                $field_name = "file_".$i;
	                $_FILES[$field_name][$key] = $v;
	                $i++;   
	            }
	        }
	        // Unset the useless one ;)
	        unset($_FILES['image']);

	        // Put each errors and upload data to an array
	        $error = array();
	        $success = array();
	        
	        // main action to upload each file
	        foreach($_FILES as $field_name => $file)
	        {
	        	if (!empty($file['name']))
	        	{
	        		$str=substr($file['name'], 0, 5);
					$picture=$str.time();
					
					// $config['upload_path'] = './uploads/pickup_girls/';
					// $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
					// // $config['allowed_types'] = '*';
					// //$config['max_size']	= '100';
					// $config['max_width']  = '1600';
					// $config['max_height']  = '1600';
					// $config['file_name']  = $picture;
					// $config['overwrite']  = FALSE;
			    
			        // $this->upload->initialize($config);



			     //    move_uploaded_file($_FILES["image"]["tmp_name"],"./uploads/pickup_girls/" . $_FILES["image"]["name"]);
		   			// $this->createThumbs("./uploads/pickup_girls/","./uploads/pickup_girls/thumb/",100);


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


						$photo = time().$i++;
		            	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/pickup_girls/" . $photo);

		            	$this->createThumbs("./uploads/pickup_girls/","./uploads/pickup_girls/thumb/",100);

		            	$image_data = array(
							'girl_id'=>$girl_id,
							'image'=>$photo
						);
						
						$this->common_model->insert('pickup_girls_image',$image_data);  

						// print_r($_FILES[$field_name]["type"]);exit();

		            	}else{
		            		$data['error'] = "unsupported file type";
		            		$failed .= "unsupported file type";
		            	}



		            	
		                //Resize
		    //             $this->image_lib->clear();
						// $upload_data=$this->upload->data();
						// $source_image_path='./uploads/pickup_girls/'.$upload_data['file_name'];
						// $new_image_path='./uploads/pickup_girls/thumb/'.$upload_data['file_name'];
						// $photo=$upload_data['file_name'];
						
						// $config_img1['image_library'] = 'GD2';//GD, GD2, ImageMagick, NetPBM
						// $config_img1['source_image'] = $source_image_path;
						// $config_img1['new_image'] = $new_image_path;
						// $config_img1['create_thumb'] = FALSE;
						// $config_img1['maintain_ratio'] = FALSE;
						// $config_img1['width'] = 100;
						// $config_img1['height'] = 100;
						// //$config_img['quality'] = 80%;
						// //$config_img['master_dim'] = 'width';//auto, width, height
						// $config_img1['overwrite']  = FALSE;
						
						// $this->image_lib->initialize($config_img1);
						
						// // do it!
						// if ( ! $this->image_lib->resize())
						// {
						// 	// if got fail.
						// 	$error['resize'][] = $this->image_lib->display_errors();
						// }
						// else
						// {
						// 	// otherwise, put each upload data to an array.
						// 	$success[] = $upload_data;
						// }
						// $failed .= $this->image_lib->display_errors();

						
		            }
	        	}
	        }

	        // see what we get
	        // if(count($error > 0))
	        // {
	        //     $data['error'] = $error;
	        //     print_r($error);exit();
	        // }
	        // else
	        // {
	        //     $data['success'] = $upload_data;
	        // }
	        
	        $this->data['redirect_previous_page']=TRUE;
	        $this->data['successful'] ='Successfully Saved to Database. '.$failed;
			$this->data['page']='custom_msg';
			$this->load->view('template',$this->data);
	        /*if ($girl_id)
			{
				$this->data['successful'] ='Successfully Saved to Database. '.$failed;
				$this->data['page']='custom_msg';
				$this->load->view('template',$this->data);
			}
			else
			{
				$this->data['failed'] ='Database Error! Please Try Again'.$failed;
				$this->data['page']='custom_msg';
				$this->load->view('template',$this->data);
			}*/









		
		// if ($_FILES["image"]["error"][0] > 0)
		//   {
		//   print_r($_FILES["image"]["error"]);
		//   }
		// else
		//   {
		//   	print_r($_FILES["image"]);


		//    	move_uploaded_file($_FILES["image"]["tmp_name"],"./uploads/pickup_girls/" . $_FILES["image"]["name"]);
		//    	$this->createThumbs("./uploads/pickup_girls/","./uploads/pickup_girls/thumb/",100);
      		

		//   }






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






	function manage_pickup_girls()
	{
		$this->load->library('pagination');
		
		$p_base_url = base_url().'pickup_girls/manage_pickup_girls/';
		$config['base_url'] = $p_base_url;
		$config['total_rows'] = $this->mix_model->all_girls_total_number();
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
		$this->data['all_data'] = $this->mix_model->get_all_girls($config['per_page'],$this->uri->segment(3,0));
		$this->data['table_showing_info']='Showing '.($this->uri->segment(3,0)+1).' - '.($this->uri->segment(3,0)+count($this->data['all_data'])).' (total '.$config['total_rows'].' rows)';
		$this->data['page']='pickup_girls/manage';
		$this->load->view('template',$this->data);
	}
	function edit()
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
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$this->data['data']=$this->mix_model->get_pickup_girl($id);
			$this->data['page']='pickup_girls/edit';
			$this->load->view('template',$this->data);
		}
	}

	function update_pickup_girls()
    {	$id = $this->uri->segment(3);
    	$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('description','Description','trim');
		$this->form_validation->set_rules('name','Name','xss_clean|trim|required');
		$this->form_validation->set_rules('active_status','Status','xss_clean|trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->edit($id);
		}
		else
		{
			$id=$this->input->post('row_id');
			$where = array('id' => $id);

			$this->load->library('upload');
			$this->load->library('image_lib');
			
	        $picture='';
			$photo='';
			$failed='';

			ini_set('max_execution_time', 600); //600 seconds = 10 minutes

			$update_data = array(
				'name'=>$this->input->post('name'),
				'description'=>$this->input->post('description'),
				'active_status'=>$this->input->post('active_status'),
			);
			$this->common_model->update('pickup_girls', $where, $update_data);
	    
	        // Change $_FILES to new vars and loop them
	        foreach($_FILES['image'] as $key=>$val)
	        {
	            $i = 1;
	            foreach($val as $v)
	            {
	                $field_name = "file_".$i;
	                $_FILES[$field_name][$key] = $v;
	                $i++;   
	            }
	        }
	        // Unset the useless one ;)
	        unset($_FILES['image']);

	        // Put each errors and upload data to an array
	        $error = array();
	        $success = array();
	        
	        // main action to upload each file
	        foreach($_FILES as $field_name => $file)
	        {


				if (!empty($file['name']))
				{
	        	$str=substr($file['name'], 0, 5);
					$picture=$str.time();
					
					// $config['upload_path'] = './uploads/pickup_girls/';
					// $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
					// // $config['allowed_types'] = '*';
					// //$config['max_size']	= '100';
					// $config['max_width']  = '1600';
					// $config['max_height']  = '1600';
					// $config['file_name']  = $picture;
					// $config['overwrite']  = FALSE;
			    
			        // $this->upload->initialize($config);



			     //    move_uploaded_file($_FILES["image"]["tmp_name"],"./uploads/pickup_girls/" . $_FILES["image"]["name"]);
		   			// $this->createThumbs("./uploads/pickup_girls/","./uploads/pickup_girls/thumb/",100);


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


						$photo = time().$i++;
		            	move_uploaded_file($_FILES[$field_name]["tmp_name"],"./uploads/pickup_girls/" . $photo);

		            	$this->createThumbs("./uploads/pickup_girls/","./uploads/pickup_girls/thumb/",100);

		            	$image_data = array(
							'girl_id'=>$id,
							'image'=>$photo
						);
						
						$this->common_model->insert('pickup_girls_image',$image_data);  

						// print_r($_FILES[$field_name]["type"]);exit();

		            	}else{
		            		$data['error'] = "unsupported file type";
		            		$failed .= "unsupported file type";
		            	}



		        	}
		        }



	        	
	        }

	        // see what we get
	        if(count($error > 0))
	        {
	            $data['error'] = $error;
	        }
	        else
	        {
	            $data['success'] = $upload_data;
	        }
	        //$this->data['redirect_previous_page']=TRUE;
	        $this->data['custom_redirect']=base_url().'pickup_girls/manage_pickup_girls';
	        $this->data['successful'] ='Successfully Saved to Database. '.$failed;
			$this->data['page']='custom_msg';
			$this->load->view('template',$this->data);
		}
    }

    function delete()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$where = array('id' => $id);
			$where2 = array('girl_id' => $id);

			$old_data=$this->common_model->get_all_where('pickup_girls_image',$where2);

			if (!empty($old_data)) {
				foreach ($old_data as $key => $value) {
					if(!empty($value['image']))
					{
						$file_name='./uploads/pickup_girls/'.$value['image'];
						unlink($file_name);
						$file_name='./uploads/pickup_girls/thumb/'.$value['image'];
						unlink($file_name);
					}
				}
			}
			
			$this->common_model->delete('pickup_girls_image',$where2);

			$this->data['redirect_previous_page']=TRUE;
			if ($this->common_model->delete('pickup_girls',$where))
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

			$old_data=$this->common_model->get_row_where('pickup_girls_image',$where);

			if(!empty($old_data['image']))
			{
				$file_name='./uploads/pickup_girls/'.$old_data['image'];
				unlink($file_name);
				$file_name='./uploads/pickup_girls/thumb/'.$old_data['image'];
				unlink($file_name);
			}

			if ($this->common_model->delete('pickup_girls_image',$where))
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