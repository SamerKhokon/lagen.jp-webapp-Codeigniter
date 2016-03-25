<div id="content">
<div id="content-header">
	<h1>Add Event Details Image</h1>
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
					<form action="<?php echo base_url();?>event/save_event_details_image" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Title</label>
							<div class="controls">
								<input type="text" name="title" value="<?php echo set_value('title'); ?>" >
								<?php echo form_error('title'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">For Month</label>
							<div class="controls">
								<input type="text" name="event_dt"  id="datepicker"   class="datepicker_jui" value="<?php echo set_value('event_dt'); ?>" > 
								<?php echo form_error('event_dt'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Image</label>
							<div class="controls">
								<input type="file" name="image" >
								<?php echo form_error('image'); ?>
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

<script type="text/javascript">
$("#datepicker").datepicker({dateFormat:"yy-mm-dd"});
</script>