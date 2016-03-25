<!--　TITLE START　-->

  <div id="temp-image">
  	<img src="<?php echo base_url(); ?>assets/image/contact/temp-image.jpg" />
  </div>

<!--　TITLE END　-->


<!--　CONTENTS START　-->

  <div id="contents">

    <?php $this->load->view('include/menu'); ?>


		<div id="temp-main">
    	<img src="<?php echo base_url(); ?>assets/image/contact/title1a.jpg" alt="お問い合わせはこちら" width="910" height="70" border="0" class="title1"/>
      <div id="contact1">
        <form action="<?php echo base_url(); ?>contact/send_mail" method="post">
          <table width="600" border="0" cellpadding="5" cellspacing="0" class="com1">
            <tr>
              <td width="150">お名前</td>
              <td>
                <input name="name1" type="text" id="name1" size="50" value="<?php echo set_value('name1'); ?>" />
              </td>
            </tr>
            <tr>
              <td width="150">フリガナ</td>
              <td>
                <input name="kana" type="text" id="kana" size="50" value="<?php echo set_value('kana'); ?>" />
              </td>
            </tr>
            <tr>
              <td width="150">メールアドレス</td>
              <td>
                <input name="mail" type="text" id="mail" size="50" value="<?php echo set_value('mail'); ?>" />
              </td>
            </tr>
            <tr>
              <td width="150">T E L</td>
              <td>
                <input name="tel" type="text" id="tel" size="50" value="<?php echo set_value('tel'); ?>" />
              </td>
            </tr>
            <tr>
              <td width="150">お問い合わせ</td>
              <td>
                <textarea name="message" cols="50" rows="5" wrap="virtual" id="message"><?php echo set_value('message'); ?></textarea>
              </td>
            </tr>
          </table>
          <div align="center" style="margin-top:10px; width:600px;">
            <input type="submit" name="Submit" value="送信" style="width:80px;" />　<input name="reset" type="reset" id="reset" style="width:80px;" value="リセット" />
          </div>
        </form>
        <div style="color: #CEB66A; font-size: 15px; text-align:center; padding:5px 0px;">
          <?php if(isset($mail_send)){ echo $mail_send; } ?>
          <?php echo validation_errors(); ?>
        </div>
      </div>
    </div>