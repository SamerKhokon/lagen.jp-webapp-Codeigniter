<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />

<title><?php if(isset($page_title)){echo $page_title;} ?></title>

<meta http-equiv="pragma" content="no-cache" />
<meta name="viewport" content="width=1024" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="content-language" content="ja" />
<meta name="robots" content="index, follow" />
<meta name="keywords" content="大宮,lagen,フィリピン,クラブ" />
<meta name="description" content="大宮インターナショナル・フィリピンクラブ｜LAGEN -EXECTIVE-(ラゲン）。在籍50名…高級感あふれる店…そのすべてがPREMIUMな人魚の島LAGEN。マーメイドのような日本、フィリピン、ヨーロピアンの美女と大宮でPREMIUMなINTERNATIONAL-PHILLIPINE CLUBで極上のひと時を…安心・低価格・明朗会計。" />

<link href="<?php echo base_url(); ?>assets/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/and_lagen.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23840113-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<script src="<?php echo base_url(); ?>assets/Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<?php $this->load->view('include/css'); ?>
</head>


<script type="text/javascript">
var array_index=0;
var array_total=0;

$(function(){
  go_bottom();
  change_image();
});

function change_image()
{
  var slider_images=["gallery5_1.jpg","gallery5_2.jpg","gallery5_3.jpg","gallery5_4.jpg","gallery5_5.jpg"];
  array_total=slider_images.length;
  var base_url="<?php echo base_url(); ?>assets/images/";
  $('.slider_image').attr("src", base_url+slider_images[0]);

  setInterval(function(){
    var src=base_url+slider_images[array_index];
    /*console.log(src+' --- '+array_index);
    $('.slider_image').fadeTo(1000,0.60,function(){
      $('.slider_image').fadeTo(1000,1.0,function(){
        $('.slider_image').attr("src", src);
      });
   });*/
    var old_image=$('.slider_image').attr("src");
    $('.slider_image2').attr("src", old_image);
    $('.slider_image').hide();
    //$('.slider_image').css({'left':'-940px','opacity':'0.3'});
    $('.slider_tp').css({'left':'-100px','opacity':'0.1'});
    $('.slider_image').attr("src", src);
    $('.slider_tp').animate({'left':'940px','opacity':'.1'},800);
    $('.slider_image').fadeIn(2000);
    
    //$('.slider_image').animate({'left':'0px','opacity':'1.0'},500);
    //console.log('hello');
    if (array_index >= array_total-1) { array_index=0; }else{ array_index++; };
  },4000);
}

function go_top()
{
  //alert('go top');
  $('.moving_div').stop(true, false).animate({
      top: '-50px'
  }, 5000,go_bottom);
}

function go_bottom()
{
  //alert('go_bottom');
  $('.moving_div').stop(true, false).animate({
      top: '0px'
  }, 5000,go_top);
}
</script>

<body>


<!--　HEADER START　-->

    <div id="header">
    <div id="header2">
        <h1><a href="<?php echo base_url(); ?>" title="and lagen">さいたま市大宮のハイクオリティーなフィリピンクラブ｜lagen (ラゲン)</a></h1>
            <address class="header">埼玉県さいたま市大宮区仲町1-105-1 南銀川鍋ビル3Ｆ</address>
            <p class="header">【営業時間】20:00〜ラスト　年中無休<br />【アクセス】JR線・東武線「大宮駅」から徒歩4分</p>
    </div>
  </div>

<!--　HEADER END　-->