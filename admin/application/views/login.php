<!DOCTYPE html>
<html lang="en">

<head>
        <title>Lagen Admin Panel</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/unicorn.login.css" />
    </head>
    <body>


        <div id="logo">
            <img src="<?php echo base_url();?>assets/img/logo.png" alt="" />
        </div>
        <div id="loginbox">
            <form id="loginform" class="form-vertical" method="post" action="<?php echo base_url();?>login/login_action">
                <p>Enter username and password to continue.</p>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span><input type="text" name="username" placeholder="Username" />
                        </div>
                        <?php //echo form_error('username'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                        </div>
                        <?php //echo form_error('password'); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <!-- <span class="pull-left"><a href="#" class="flip-link" id="to-recover">Lost password?</a></span> -->
                    <span class="pull-right"><input type="submit" class="btn btn-inverse" value="Login" /></span>
                </div>
            </form>
            <form id="recoverform" method="post" action="<?php echo base_url();?>login/password_reset_action" class="form-vertical">
                <p>Reset Your Password</p>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span><input name="username" type="text" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-envelope"></i></span><input name="email_address" type="text" placeholder="E-mail address" />
                        </div>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span><input name="password" type="password" placeholder="Password">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span><input name="retypePassword" type="password"  placeholder="Retype Password">
                        </div>
                    </div>
                </div> -->
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link" id="to-login">&lt; Back to login</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-inverse" value="Recover" /></span>
                </div>
            </form>
        </div>
        <div class="login_validation_errors">
            <?php echo validation_errors(); ?>
            <?php
                if(isset($logged_out))
                {
                    echo '<div class="alert alert-success">You logged out successfully.</div>';
                }
                if(isset($wrong_username_password))
                {
                    echo $wrong_username_password;
                }
                if(isset($successful))
                {
                    echo '<div class="alert alert-success">'.$successful.'</div>';
                }
                if(isset($failed))
                {
                    echo '<div class="alert alert-error">'.$failed.'</div>';
                }
            ?>
        </div>
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/unicorn.login.js"></script>
    </body>

</html>
