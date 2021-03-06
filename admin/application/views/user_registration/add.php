<div id="content">
<div id="content-header">
	<h1>Add new user</h1>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-align-justify"></i>
					</span>
					<h5>Add</h5>
				</div>
				<div class="widget-content nopadding">
					<form action="<?php echo base_url();?>user_registration/save_user_registration" method="post" class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Name</label>
							<div class="controls">
								<input type="text" name="name" value="<?php echo set_value('name'); ?>" >
								<?php echo form_error('name'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Email</label>
							<div class="controls">
								<input type="text" name="email" value="<?php echo set_value('email'); ?>" >
								<?php echo form_error('email'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Address</label>
							<div class="controls">
								<input type="text" name="address" value="<?php echo set_value('address'); ?>" >
								<?php echo form_error('address'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Contact Number</label>
							<div class="controls">
								<input type="text" name="contact_number" value="<?php echo set_value('contact_number'); ?>" >
								<?php echo form_error('contact_number'); ?>
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