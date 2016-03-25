<style type="text/css">
a{
  color: #000;
  font-weight: bold;
  text-decoration: none;
}
a:hover{
  color: #FFF;
  font-weight: bold;
  text-decoration: underline;
}
a.event_image{
  color: #FFF;
  text-decoration: none;
}
a.event_image:hover{
  color: #FFF;
  text-decoration: underline;
}
/*img#lightbox-image{
  max-width: 1024px !important;
  max-height: 600px !important;
}*/
</style>

<script type="text/javascript">
<!-- 
    $(function() {
        $('a.event_image, .cal-t2 a, .cal-t2-w a, .cal-t4 a, .event-box a').lightBox(
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
  	<img src="<?php echo base_url(); ?>assets/image/system/temp-image.jpg" />
  </div>

<!--　TITLE END　-->


<!--　CONTENTS START　-->

  <div id="contents">

  <?php $this->load->view('include/menu'); ?>


		<div id="temp-main">
    	<a name="one" id="one"><img src="<?php echo base_url(); ?>assets/image/system/title1a.jpg" alt="イベントカレンダー" width="910" height="70" border="0" class="title1"/></a>
      <div id="cal">
      	<table width="910" border="0" cellspacing="0" cellpadding="0">
        	<caption class="cal-t1">
            <?php
            $current=$this->uri->segment(3,0);
                if (!empty($current)) {
                    $dateTime = new DateTime($current);
                    $month=date_format ($dateTime, 'm');
                    $year=date_format ($dateTime, 'Y');
                }
                else
                {
                  $current=date('Y-m-d H:i:s');
                  $month=date('m');
                  $year=date('Y');
                }
            ?>
        	<!-- 2013年6月<br />※カレンダーをクリックすると詳細が表示されます -->
          <a href="<?php echo base_url().'event/event_calendar/'.$prev; ?>">Prev</a> <?php echo $year; ?>年<?php echo $month; ?>月 <a href="<?php echo base_url().'event/event_calendar/'.$next; ?>">Next</a><br />※カレンダーをクリックすると詳細が表示されます
        	</caption>
          <tr>
            <td class="cal-t2 eve1">日<br /></td>
            <td class="cal-t2 eve">月</td>
            <td class="cal-t2 eve">火</td>
            <td class="cal-t2 eve">水</td>
            <td class="cal-t2 eve">木</td>
            <td class="cal-t2 eve">金</td>
            <td class="cal-t2 eve">土</td>
          </tr>


<?php

/*$current_months_start_date=date('Y-m-01');
$current_months_end_date=date('Y-m-t');
$current_months_total_day=date('t');*/
//___________________________________________________
//$week_start = strtotime('last Sunday', time());
//$week_end = strtotime('next Sunday', time());
$month_start = strtotime($current.' first day of this month');
$month_end = strtotime($current.' last day of this month');

//$year_start = strtotime('first day of January', time());
//$year_end = strtotime('last day of December', time());

//echo date('D, M jS Y', $week_start).'<br/>';
//echo date('D, M jS Y', $week_end).'<br/>';

//echo date('D, M jS Y', $month_start).'<br/>';
//echo date('D, M jS Y', $month_end).'<br/>';

//echo date('D, M jS Y', $year_start).'<br/>';
//echo date('D, M jS Y', $year_end).'<br/>';
//___________________________________________________
$week_start_number=date('w', $month_start);
echo $last_date=date('j', $month_end);
$day_counter=1;

for ($i=1; $i <= 35; $i++) {
  if (($i-1)%7==0) {
    echo '<tr>';
    $class='cal-t2 eve1';
  }
  else{
    $class='cal-t2 eve';
  }
  if (($i-1)<$week_start_number || $day_counter>$last_date) {
    echo '<td class="'.$class.'">&nbsp;</td>';
  }
  else{
    $text='<td class="'.$class.'">'.$day_counter++;
    $text .='<span class="cal-t3">';
    foreach ($all_calender_events as $key => $value) {
      $dateTime = new DateTime($value['event_dt']);
      $event_date=date_format($dateTime, 'j');
      // $day_counter=$day_counter+1;
      if ($event_date==$day_counter-1) {
        if($value['image'] != null){$eventImage = $value['image'];}else{$eventImage = "no_image.png";}
        
        $text .= '<br/><a class="event_image" href="'.base_url().'admin/uploads/event/'.$eventImage.'" alt="'.$value['title'].'">'.$value['title'];
        if (!empty($value['image'])) {
          $text .= '<br/>View Image</a>';
        }
      }
    }
    $text .='</span>';
    $text .='</td>';
    echo $text;
  }
  if ($i%7==0) {
    echo '</tr>';
  }
}
?>
        </table>
  				<div class="event-box">
  					<!-- <a href="<?php //echo base_url(); ?>assets/images/june_1.jpg" title="6月のイベント"><img src="<?php //echo base_url(); ?>assets/image/system/btn3.jpg" alt="6月のイベント詳細はこちら" width="260" height="80" border="0" class="alpha" /></a> -->
            <a href="<?php if(isset($event_details_image['image'])){ ?> <?php echo base_url(); ?>admin/uploads/event_details_image/<?php echo $event_details_image['image']; ?> <?php } else{ echo base_url().'assets/images/no_image.png'; } ?>" title="<?php if(isset($event_details_image['title'])){ echo $event_details_image['title']; } ?>"><img src="<?php echo base_url(); ?>assets/image/system/btn3.jpg" alt="6月のイベント詳細はこちら" width="260" height="80" border="0" class="alpha" /></a>
  				</div>
        </div>
        <a name="two" id="two"><img src="<?php echo base_url(); ?>assets/image/system/title1b.jpg" alt="イベント" width="910" height="70" border="0" class="title1"/></a>
        
				
      	
				<img src="<?php echo base_url(); ?>assets/image/system/event1a.jpg" alt="外国人歌手、キーボード演奏による生バンドをイベント時など、公演中" width="910" height="270" border="0" />
        <img src="<?php echo base_url(); ?>assets/image/system/event1e.jpg" alt="新規・フリーのお客様は、場内指名をいただくと次回指名半額券サービス" width="910" height="50" border="0" />
        <img src="<?php echo base_url(); ?>assets/image/system/event1c.jpg" alt="同伴にてPM9:00までご来店のお客様、生ビールサービス" width="910" height="50" border="0" />
    		<img src="<?php echo base_url(); ?>assets/image/system/title1c.jpg" alt="システム" width="910" height="70" border="0" class="title1"/>
    		<img src="<?php echo base_url(); ?>assets/image/system/system1.jpg" alt="システム" width="910" height="604" border="0" />
		  	<p class="com3">※カラオケ代はクレジットカードでの決済不可<br/>※カラオケは5曲でのチケットを¥1,000にて販売いたします。<br />※飲食物をお持ち込みの場合は、別途料金を頂きます。<br />【PREMIUM SEATについて】<br />PREMIUM SEATは団体割引、3名様以上 ＋￥3,000づつ。但し、延長の場合はCHARGEの追加料金はありません。<br />基本的にPREMIUM SEATでのカラオケのご利用は出来ません。</p>
		</div>
