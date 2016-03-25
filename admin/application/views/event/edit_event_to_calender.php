<div id="content">
<div id="content-header">
	<h1>Edit Event to Calendar</h1>
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
					<form action="<?php echo base_url();?>event/update_event_to_calender/<?php echo $this->uri->segment(3);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
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
								<?php echo form_error('description'); ?>
								<?php echo display_ckeditor($ckeditor); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Event DateTime</label>
							<div class="controls">
								<input type="text" name="event_dt"  id="datepicker"   class="datepicker_jui" value="<?php echo set_value('event_dt',$data['event_dt']); ?>" > 
								<?php echo form_error('event_dt'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Image</label>
							<div class="controls">
								<input type="file" name="image" >
								<?php if (!empty($data['image'])) { ?>
								<p><img src="<?php echo base_url(); ?>uploads/event/thumb/<?php echo $data['image']; ?>" alt="" /><br/><a href="<?php echo base_url(); ?>uploads/event/<?php echo $data['image']; ?>" target="_blank">view large size</a></p>
								<?php } ?>
								<?php echo form_error('image'); ?>
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

<script type="text/javascript">
$("#datepicker").datetimepicker({dateFormat:"yy-mm-dd"});
</script>