<div id="content">
<div id="content-header">
    <h1>Mass Email</h1>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-align-justify"></i>
                    </span>
                    <h5>Email</h5>
                </div>
                <div class="widget-content nopadding">
                    <form action="<?php echo base_url();?>mass_mail/send" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Email Type</label>
                            <div class="controls">
                                <select name="email_type" id="email_type">
                                    <option value="text">Plain Text</option>
                                    <option value="html">HTML</option>
                                </select>
                                <?php echo form_error('email_type'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">To</label>
                            <div class="controls">
                                <select name="to_type" id="to_type">
                                    <option value="all">All</option>
                                    <option value="individual">Individual</option>
                                </select>
                                <input type="text" name="to" id="to" value="<?php echo set_value('to'); ?>" placeholder="Email Address" >
                                <?php echo form_error('to'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Subject</label>
                            <div class="controls">
                                <input type="text" name="subject" value="<?php echo set_value('subject'); ?>" placeholder="Subject" >
                                <?php echo form_error('subject'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Email Body</label>
                            <div class="controls">
                                <textarea name="email_body" id="email_body"><?php echo set_value('email_body'); ?></textarea>
                                <?php echo form_error('email_body'); ?>
                                <?php echo display_ckeditor($ckeditor); ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="send_button" class="btn btn-primary">Send</button> 
                            <span class="uploading_info"> <img src="<?php echo base_url(); ?>assets/images/spinner_green.gif" alt="spinner" > Sending Emails. This may take few minutes depending on total user.</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
$(function(){
    $('#to').hide();
    $('#to_type').on('change', function() {
      //alert( this.value ); // or $(this).val()
      var val=$(this).val();
      if(val=='all'){
        $('#to').hide();
      }
      else{
        $('#to').val('');
        $('#to').show();
      }
    });
});
</script>

<script type="text/javascript">
$(function(){
    $('.uploading_info').hide();
    $("#send_button").click(function(){
        $('.uploading_info').show();
        });
});
</script>