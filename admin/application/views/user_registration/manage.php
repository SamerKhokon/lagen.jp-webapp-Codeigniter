<div id="content">
<div id="content-header">
<h1>Manage Coupon</h1>
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
					<th>Name</th>
					<th>Email</th>
					<th>Address</th>
					<th>Contact Number</th>
					<th>Entry Date</th>
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
							echo '<td>&nbsp;'.$data['name'].'</td>';
							echo '<td>&nbsp;'.$data['email'].'</td>';
							echo '<td>&nbsp;'.$data['address'].'</td>';
							echo '<td>&nbsp;'.$data['contact_number'].'</td>';
							echo '<td>'.$data['entry_dt'].'</td>';
							echo '<td><a class="btn btn-primary btn-small" href="'.base_url().'user_registration/edit/'.$data['id'].'"><i class="icon-pencil icon-white"></i> Edit</a> <a class="btn btn-danger btn-small" onclick="return delete_sure()" href="'.base_url().'user_registration/delete/'.$data['id'].'"><i class="icon-trash icon-white"></i> Delete</a></td>';
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
 