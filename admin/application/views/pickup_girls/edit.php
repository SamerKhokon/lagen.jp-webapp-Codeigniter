<style type="text/css">
.girl_old_images{
	float: left;
	margin: 5px;
}
</style>

<div id="content">
<div id="content-header">
	<h1>Edit Pickup Girl</h1>
</div>
 
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-align-justify"></i>
					</span>
					<h5>Update</h5>
				</div>
				<div class="widget-content nopadding">
					<form action="<?php echo base_url();?>pickup_girls/update_pickup_girls/<?php echo $this->uri->segment(3);?>" method="post" class="form-horizontal" enctype="multipart/form-data">
						<div class="control-group">
							<label class="control-label">Name</label>
							<div class="controls">
								<input type="text" name="name" value="<?php echo set_value('name',$data['name']); ?>" placeholder="cinema name">
								<?php echo form_error('name'); ?>
							</div>
						</div>
						

						<div class="control-group">
							<label class="control-label">Description</label>
							<div class="controls">
								<textarea name="description" id="description"><?php echo set_value('description',htmlspecialchars_decode($data['description'])); ?></textarea>
								<?php echo form_error('description'); ?>
								<?php echo display_ckeditor($ckeditor); ?>
							</div>
						</div>
						
						<div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<?php
							//print_r($edit_cinema_data['theater']);
								if (!empty($data['all_images'])) {
									foreach ($data['all_images'] as $key => $value) {
							?>
							<div class="girl_old_images">
								<p><img src="<?php echo base_url(); ?>uploads/pickup_girls/thumb/<?php echo $value['image']; ?>" alt="" /><br/><a href="<?php echo base_url(); ?>uploads/pickup_girls/<?php echo $value['image']; ?>" target="_blank">view large size</a></p>
								<a href="#" class="btn btn-mini btn-danger" onClick="return delete_image(<?php echo $value['id']; ?>)">Delete</a>
							</div>
							<?php
									}
								}
							?>
							</div>
							</div>


						<div id="image">
						<div class="control-group">
							<label class="control-label">Image</label>
							<div class="controls">
								<input type="file" name="image[]" multiple="multiple">
							</div>
						</div>
						</div>
						<div id="add_image">
						</div>

						<div class="control-group">
							<div class="controls">
								<span class="help-block"><small>Maximum File Size: <?php echo ini_get('upload_max_filesize'); ?></small></span>
								<span class="help-block"><small>Allowed File Types: JPG, GIF, PNG</small></span>
								<span class="help-block"><small>Maximum Image Resolution: Unlimited</small></span>
							</div>
						</div>
						
						<div class="form-actions">
							<button id="add_new_image" type="button" class="btn">Add Another Image</button>
						</div> 
						 
						 <div class="control-group">
							<label class="control-label">Status</label>
							<div class="controls">
								<select name="active_status" class="span2">
									<?php
										if ($data['active_status']==0) {
											echo '<option value="0" selected="selected">Inactive</option> <option value="1">Active</option>';
										} else {
											echo '<option value="0">Inactive</option> <option value="1" selected="selected">Active</option>';
										}
									?>
								</select>
								<?php echo form_error('active_status'); ?>
							</div>
						</div>
						 
						<div class="form-actions">
							<input type="hidden" name="row_id" id="row_id" value="<?php echo $data['id']; ?>">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
			</div>						
		</div>
	</div>
</div>
</div>
<script type="text/javascript">

$(function(){
	$("#add_new_image").click(function(){
	    var content = $("div#image").html();
	    $('div#add_image').before(content);
	    //alert(content);
		});
});

function delete_image(id)
{
	var msg=confirm("Are you sure you want to delete this image?");
	if(msg==true)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>pickup_girls/delete_image_ajax/"+id
			}).done(function( msg ) {
			alert(msg);
			location.reload();
		});
	}
	return false;
}
</script>
