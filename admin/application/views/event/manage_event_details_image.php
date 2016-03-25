<div id="content">
<div id="content-header">
<h1>Manage Event Details Image</h1>
</div>
 
<div class="container-fluid">

<div class="widget-box">
			<div class="widget-title">
			
			<h5>Manage - <?php echo $table_showing_info; ?></h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered table-striped table-hover">
					<thead>
					<tr>
					<th>#</th>
					<th>Title</th>
					<th>Image</th>
					<th>For Month</th>
					<th>Entry Date</th>
					<th>Status</th>
					<th>Action</th>
					</tr>
					</thead>

					<tbody>
					<?php
					$i=0;
					if (!empty($all_data))
					{
						foreach ($all_data as $data)
						{
							$i++;
							echo '<tr class="main_row_'.$data['id'].'">';
							echo '<td>'.$i.'</td>';
							echo '<td>'.$data['title'].'</td>';
                            if (!empty($data['image'])) {
                            	echo '<td><img src="'.base_url().'uploads/event_details_image/thumb/'.$data['image'].'" alt="'.$data['title'].'"></td>';
                            }
                            else{
                            	echo '<td>&nbsp</td>';
                            }
							echo '<td>'.$data['event_dt'].'</td>';
							if($data['active_status']==0){ echo '<td>Inactive</td>'; }
							else{ echo '<td style="color:#080;">Active</td>'; }
							echo '<td><a class="btn btn-primary btn-small" href="'.base_url().'event/edit_event_details_image/'.$data['id'].'"><i class="icon-pencil icon-white"></i> Edit</a> <a class="btn btn-danger btn-small" onclick="return delete_sure()" href="'.base_url().'event/delete_event_details_image/'.$data['id'].'"><i class="icon-trash icon-white"></i> Delete</a></td>';
							echo '</tr>';
						} 
					}

					?>
					</tbody>
					</table>  
			</div>
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>
 