<div id="content">
<div id="content-header">
	<h1>Add New Topic</h1>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-align-justify"></i>
					</span>
					<h5>Add New</h5>
				</div>
				<div class="widget-content nopadding">
					<form action="<?php echo base_url();?>home_page/save_topic" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Title</label>
							<div class="controls">
								<input type="text" name="title" value="<?php echo set_value('title'); ?>" >
								<?php echo form_error('title'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Description</label>
							<div class="controls">
								<textarea name="description" id="description"><?php echo set_value('description'); ?></textarea>
								<?php echo form_error('description'); ?>
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
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Status</label>
							<div class="controls">
								<select name="active_status" class="span2">
									<option value="0">Inactive</option>
									<option value="1" selected="selected">Active</option>
								</select>
								<?php echo form_error('active_status'); ?>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>