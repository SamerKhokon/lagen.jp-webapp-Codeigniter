<div id="content">
<div id="content-header">
	<h1>Edit Topic</h1>
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
					<form action="<?php echo base_url();?>home_page/update_topic/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Title</label>
							<div class="controls">
								<input type="text" name="title" value="<?php echo set_value('title',$data['title']); ?>" >
								<?php echo form_error('title'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Description</label>
							<div class="controls">
								<textarea name="description" id="description"><?php echo set_value('description',html_entity_decode($data['description'])); ?></textarea>
								<?php echo form_error('description');  ?>
								<?php echo display_ckeditor($ckeditor); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Image</label>
							<div class="controls">
								<input type="file" name="image">
								<span class="help-block"><small>Maximum File Size: <?php echo ini_get('upload_max_filesize'); ?></small></span>
								<span class="help-block"><small>Allowed File Types: JPG, GIF, PNG</small></span>
								<span class="help-block"><small>Maximum Image Resolution: 1600X1600 px</small></span>
								<?php if (!empty($data['image'])) { ?>
								<p><img src="<?php echo base_url(); ?>uploads/topic/thumb/<?php echo $data['image']; ?>" alt="" /><br/><a href="<?php echo base_url(); ?>uploads/topic/<?php echo $data['image']; ?>" target="_blank">view large size</a></p>
								<?php } ?>
							</div>
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
							<input type="hidden" name="row_id" value="<?php echo $data['id']; ?>" >
							<button type="submit" class="btn btn-primary">update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>