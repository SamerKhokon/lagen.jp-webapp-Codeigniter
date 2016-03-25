<div id="content">
<div id="content-header">
	<h1>Manage Welcome Text</h1>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-align-justify"></i>
					</span>
					<h5>Manage</h5>
				</div>
				<div class="widget-content nopadding">
					<form action="<?php echo base_url();?>home_page/update_home_page" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Welcome Text</label>
							<div class="controls">
								<textarea name="welcome_text" id="welcome_text"><?php echo set_value('welcome_text',html_entity_decode($data['welcome_text'])); ?></textarea>
								<?php echo form_error('welcome_text'); ?>
								<?php echo display_ckeditor($ckeditor); ?>
							</div>
						</div>
						<!-- <div class="control-group">
							<label class="control-label">Image</label>
							<div class="controls">
								<input type="file" name="image" >
								<?php if (!empty($data['image'])) { ?>
								<p><img src="<?php echo base_url(); ?>uploads/home_page/thumb/<?php echo $data['image']; ?>" alt="" /><br/><a href="#" class="text-error" onClick="return delete_image(<?php echo $data['id']; ?>)">Remove Image</a><br/><a href="<?php echo base_url(); ?>uploads/home_page/<?php echo $data['image']; ?>" target="_blank">view large size</a></p>

								<?php } ?>
								<?php echo form_error('image'); ?>
							</div>
						</div> -->

						<div class="form-actions">
							<input type="hidden" name="row_id" value="<?php echo $data['id']; ?>" >
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

function delete_image(id)
{
	var msg=confirm("Are you sure you want to delete this image?");
	if(msg==true)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>home_page/delete_image_ajax/"+id
			}).done(function( msg ) {
			alert(msg);
			location.reload();
		});
	}
	return false;
}
</script>