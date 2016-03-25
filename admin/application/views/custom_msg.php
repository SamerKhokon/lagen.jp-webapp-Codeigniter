<div id="content">
<div id="content-header">
<h1></h1>
</div>
<div class="container-fluid">
	<?php
		if(isset($custom_redirect))
		{
	?>
	<script type="text/javascript">
	window.setTimeout(function() {
	    window.location.href = "<?php echo $custom_redirect; ?>";
	}, <?php if(isset($redirect_time)){ echo $redirect_time; }else{ echo '2000'; } ?>);
	</script>
	<?php
		}
	?>
	<?php
		if(isset($redirect_previous_page))
		{
	?>
	<script type="text/javascript">
	window.setTimeout(function() {
	    window.location.href = document.referrer;
	}, <?php if(isset($redirect_time)){ echo $redirect_time; }else{ echo '2000'; } ?>);
	</script>
	<?php
		}
	?>

	<div class="row-fluid">
	        <div class="span10 offset1">
	        <?php
			if(isset($successful))
			{	
				echo '<div class="hero-unit custom_msg_successful">
					<h1>Successful!</h1>
					<div class="alert alert-success">'.$successful.'</div>
					</div>';
			}
			if(isset($failed))
			{
				echo '<div class="hero-unit custom_msg_failed">
					<h1>Error!</h1>
					<div class="alert alert-error">'.$failed.'</div>
					</div>';
			}
			?>
	        </div>
	</div>
</div>
</div>