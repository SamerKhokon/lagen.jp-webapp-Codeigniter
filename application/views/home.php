
<style type="text/css">

div.topic div.title {
    color: #FFFFCC;
    font-weight: bold;
}

</style>


<div class="homepage_slider">
    <img id="g_open_img" src="<?php echo base_url(); ?>assets/images/Lagen_top_forg.png" alt="">
    <!-- <img id="g_open_img" src="<?php echo base_url(); ?>assets/images/grand_11.gif" alt="">
    <img id="gulti" src="<?php echo base_url(); ?>assets/images/star_1.gif" alt=""> -->
    <div class="moving_div">
        <img class="slider_image" src="<?php echo base_url(); ?>assets/images/gallery5_1.jpg">
        <img class="slider_image2" src="<?php echo base_url(); ?>assets/images/gallery5_1.jpg">
        <img class="slider_tp" src="<?php echo base_url(); ?>assets/images/transparent_bg.png">
    </div>
</div>

<!--　FLASH START　-->

  <!-- <div id="flash">
    <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','950','height','450','title','フィリピンクラブ　and lagen(アンドラゲン)','src','<?php echo base_url(); ?>assets/image/flash','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','<?php echo base_url(); ?>assets/image/flash' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="950" height="450" title="フィリピンクラブ　and lagen(アンドラゲン)">
      <param name="movie" value="<?php echo base_url(); ?>assets/image/flash.swf" />
      <param name="quality" value="high" />
      <embed src="<?php echo base_url(); ?>assets/image/flash.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="950" height="450"></embed>
    </object></noscript>
  </div> -->
  
<!--　FLASH END　-->


<!--　CONTETNS START　-->

  <div id="contents">

<?php $this->load->view('include/menu'); ?>

    <ul id="btn-box1">
        <li class="btn1a"><a href="<?php echo base_url(); ?>event#one" title="イベントカレンダー">イベントカレンダー</a></li>
        <li class="btn1b"><a href="<?php echo base_url(); ?>recruit" title="求人情報">求人情報</a></li>
        <li class="btn1c"><a href="<?php echo base_url(); ?>recruit" title="Recruit(English)">Recruit(English)</a></li>
        <li class="btn1d"><a href="<?php echo base_url(); ?>access" title="アクセスマップ">アクセスマップ</a></li>
    </ul>
    <div id="itext">
        <?php if(isset($welcome_text['welcome_text'])){ echo $welcome_text['welcome_text'];} ?>
        <?php if(isset($welcome_text['image'])&&!empty($welcome_text['image'])){ echo '<img src="'.base_url().'admin/uploads/home_page/'.$welcome_text['image'].'" >';} ?>
        <div id="topics_inner">
            <p class="i-topics-t1">詳しくは【<a href="<?php echo base_url(); ?>event#two">イベント情報</a>】にて</p>
        </div>
    </div>
  <div id="i-topics">
        <div id="i-topics2">
        <!-- <iframe scrolling="AUTO" src="http://www.lagen.jp/cgi-bin/whats_new/user/search.cgi" width="575" height="235" frameborder="0"></iframe> -->
        <?php
            if (!empty($all_topics)) {
                foreach ($all_topics as $key => $value) {
                    echo '<div class="topic">';
                    echo '<div class="title">◇ '.$value['title'].'</div>';
                    echo '<div class="datetime">新着情報… '.$value['entry_dt'].'</div>';
                    echo '<div class="description">'.html_entity_decode($value['description']).'</div>';
                    $image=$value['image'];
                    if (!empty($image)) {
                        echo '<div class="image"><img src="'.base_url().'admin/uploads/topic/thumb/'.$image.'" alt="'.$value['title'].'" ></div>';
                    }
                    echo '</div>';
                }
            }
        ?>
        </div>
    </div>


