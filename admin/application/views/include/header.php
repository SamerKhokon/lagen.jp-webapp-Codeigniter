<!DOCTYPE html>
<html lang="en">

<head>
	<title>Lagen Admin Panel</title>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/unicorn.main.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/unicorn.light-blue.css" class="skin-color" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/uniform.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.css" />

	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-timepicker-addon.js"></script>

	<style type="text/css">
	    .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	    .ui-timepicker-div dl{ text-align: left; }
	    .ui-timepicker-div dl dt{ height: 25px; }
	    .ui-timepicker-div dl dd{ margin: -25px 0 10px 65px; }
	    .ui-timepicker-div td { font-size: 90%; }

	    /*.widget-content{
    background-color:#BBB !important;
}*/
	</style>
</head>

<body>	
		
	<div id="header">
		<h1><a href="<?php echo base_url();?>dashboard">Lagen Admin</a></h1>		
	</div>
	
	<div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav btn-group">
            <li class="btn btn-inverse"><a title="" href="<?php echo base_url();?>dashboard/password_change"><i class="icon icon-cog"></i> <span class="text">Change Password</span></a></li>
       		<li class="btn btn-inverse"><a title="" href="<?php echo base_url();?>logout"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
        </ul>
    </div>