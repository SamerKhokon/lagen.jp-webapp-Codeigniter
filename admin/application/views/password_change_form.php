<div id="content">
<div id="content-header">
	<h1>Change Password</h1>
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
					<form action="<?php echo base_url();?>dashboard/password_update" method="post" class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Your Username</label>
							<div class="controls">
								<input type="text" name="username" value="<?php echo set_value('username',$username); ?>" readonly="readonly" >
								<?php echo form_error('username'); ?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">New Password</label>
							<div class="controls">
								<input type="password" name="password" value="<?php echo set_value('password'); ?>" >
								<?php echo form_error('password'); ?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">Retype New Password</label>
							<div class="controls">
								<input type="password" name="retype_password" value="<?php echo set_value('retype_password'); ?>" >
								<?php echo form_error('retype_password'); ?>
							</div>
						</div>
						

						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Update Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
$("#datepicker").datetimepicker({dateFormat:"dd-mm-yy"});
</script>