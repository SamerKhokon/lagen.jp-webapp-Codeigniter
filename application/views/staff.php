<!--　TITLE START　-->

  <div id="temp-image">
  	<img src="<?php echo base_url(); ?>assets/image/staff/temp-image.jpg" width="950" height="150" />
  </div>

<!--　TITLE END　-->


<!--　CONTENTS START　-->

  <div id="contents">

	<?php $this->load->view('include/menu'); ?>

	<div id="temp-main">
	<?php
            if (!empty($all_girls)) {
            	$counter=0;
                foreach ($all_girls as $key => $value) {
                	$image_counter=1;
                	$counter++;
                    echo '<div class="staff-set">';
                    $source='';
                    if (isset($value['all_images'][0]['image'])) {
                    	$source=base_url().'admin/uploads/pickup_girls/'.$value['all_images'][0]['image'];
                    }
                    else{
                    	$source=base_url().'assets/image/staff/comming_soon.jpg';
                    }
                    echo '<img src="'.$source.'" width="200" height="220" border="0" class="slide_contents" id="slide'.$counter.'"/>';
                    echo '<div class="staff_set_right">';
                    echo '<div class="name">'.$value['name'].'</div>';
                    echo '<div class="description">'.htmlspecialchars_decode($value['description']).'</div>';
                    echo '</div>';
                    $all_images=$value['all_images'];
                    /*if (!empty($all_images)) {
                    	echo '<ul class="slide-box">';
                        foreach ($all_images as $image) {
                        	echo '<li><img src="'.base_url().'admin/uploads/pickup_girls/'.$image['image'].'"  class="girl_thumb" id="'.$counter.'"/></li>';
							$image_counter++;	
                        }
                        while ($image_counter <= 4) {
                        	$image_counter++;
                        	echo '<li><img src="'.base_url().'assets/image/staff/comming_soon.jpg" width="300" height="320" border="0" id="'.$counter.'"/></li>';
                        }
                        echo '</ul>';
                    }*/
                    echo '</div>';
                }
            }
        ?>

	</div>