<script type="text/javascript">
<!-- 
    $(function() {
        $('#gallery-main a').lightBox(
            {
              imageLoading:     '<?php echo base_url(); ?>assets/images/lightbox-ico-loading.gif',   // (string) Path and the name of the loading icon
              imageBtnPrev:     '<?php echo base_url(); ?>assets/images/lightbox-btn-prev.gif',      // (string) Path and the name of the prev button image
              imageBtnNext:     '<?php echo base_url(); ?>assets/images/lightbox-btn-next.gif',      // (string) Path and the name of the next button image
              imageBtnClose:    '<?php echo base_url(); ?>assets/images/lightbox-btn-close.gif',   // (string) Path and the name of the close btn
              imageBlank:       '<?php echo base_url(); ?>assets/images/lightbox-blank.gif'
            }
          );
    });
-->
    </script>


<!--　TITLE START　-->

  <div id="temp-image">
  	<img src="<?php echo base_url(); ?>assets/image/gallery/temp-image.jpg" />
  </div>

<!--　TITLE END　-->


<!--　CONTENTS START　-->

  <div id="contents">

  <?php $this->load->view('include/menu'); ?>


		<div id="gallery-main">
			<p class="com3">※クリックで拡大表示されます。</p>
			<a href="<?php echo base_url(); ?>assets/images/gallery5_1.jpg" title="and lagen GALLERY"><img src="<?php echo base_url(); ?>assets/image/gallery/gallery_01.jpg" width="340" height="300" border="0" class="gallery_thumbs2 alpha" /></a>
			<a href="<?php echo base_url(); ?>assets/images/gallery5_2.jpg" title="and lagen GALLERY"><img src="<?php echo base_url(); ?>assets/image/gallery/gallery_02.jpg" width="270" height="150" border="0" class="gallery_thumbs3 alpha" /></a>
			<a href="<?php echo base_url(); ?>assets/images/gallery5_3.jpg" title="and lagen GALLERY"><img src="<?php echo base_url(); ?>assets/image/gallery/gallery_03.jpg" width="270" height="150" border="0" class="gallery_thumbs3 alpha" /></a>
			<a href="<?php echo base_url(); ?>assets/images/gallery5_4.jpg" title="and lagen GALLERY"><img src="<?php echo base_url(); ?>assets/image/gallery/gallery_04.jpg" width="270" height="150" border="0" class="gallery_thumbs3 alpha" /></a>
			<a href="<?php echo base_url(); ?>assets/images/gallery5_5.jpg" title="and lagen GALLERY"><img src="<?php echo base_url(); ?>assets/image/gallery/gallery_05.jpg" width="270" height="150" border="0" class="gallery_thumbs3 alpha" /></a>
			<br clear="all" />
		</div>