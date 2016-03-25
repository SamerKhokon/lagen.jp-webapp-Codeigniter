<!--　TITLE START　-->

  <div id="temp-image">
  	<img src="<?php echo base_url(); ?>assets/image/access/temp-image.jpg" />
  </div>

<!--　TITLE END　-->


<!--　CONTENTS START　-->

  <div id="contents">

	<?php $this->load->view('include/menu'); ?>


		<div id="temp-main">
    	<img src="<?php echo base_url(); ?>assets/image/access/title1a.jpg" alt="アクセス情報" width="910" height="70" border="0" class="title1"/>
			<div id="map">
				<!-- <iframe width="400" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E4%BB%B2%E7%94%BA1-87-2&amp;aq=&amp;sll=34.685028,135.503333&amp;sspn=0.020962,0.020213&amp;g=%E5%A4%A7%E9%98%AA%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E6%9C%AC%E7%94%BA3-1-6&amp;brcurrent=3,0x6018c14398d521e3:0xc741809d9708e34b,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E4%BB%B2%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%98%EF%BC%97&amp;ll=35.905094,139.625952&amp;spn=0.004345,0.004281&amp;z=17&amp;output=embed"></iframe> -->
				[10:15:16 AM] Bipul khan: <iframe width="400" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/ms?msa=0&amp;msid=204422087406246614786.0004ec8566aaff1d2b1b0&amp;ie=UTF8&amp;ll=35.904386,139.626679&amp;spn=0,0&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://maps.google.com/maps/ms?msa=0&amp;msid=204422087406246614786.0004ec8566aaff1d2b1b0&amp;ie=UTF8&amp;ll=35.904386,139.626679&amp;spn=0,0&amp;t=m&amp;source=embed" style="color:#0000FF;text-align:left">〒330-0845 Saitama-ken, Saitama-shi, Ōmiya-ku, Nakachō, 1 Chome105−1 南銀川鍋ビル</a> in a larger map</small>
			</div>
			<div id="access1">
				<p class="access-t1">店名</p>
				<h2 class="access-t2">フィリピンクラブ　lagen</h2>
				<p class="access-t1">住所</p>
				<address class="access-t2">埼玉県さいたま市大宮区仲町</address>
				<p class="access-t1">　</p>
				<p class="access-t2">1-105-1 南銀川鍋3Ｆ</p>
				<p class="access-t1">営業時間</p>
				<p class="access-t2">20：00〜ラスト</p>
				<p class="access-t1">定休日</p>
				<p class="access-t2">年中無休</p>
				<p class="access-t1">アクセス</p>
				<p class="access-t2">JR線・東武線「大宮駅」から徒歩3分</p>
				<img src="<?php echo base_url(); ?>assets/image/access/access1.jpg" width="450" height="260" class="access1" />
			</div>
    	<img src="<?php echo base_url(); ?>assets/image/access/title1b.jpg" alt="お得なクーポン" width="910" height="70" border="0" class="title1"/>
    	<?php
    	if (!empty($all_coupon)) {
            foreach ($all_coupon as $key => $value) {
            	echo '<a href="'.base_url().'admin/uploads/coupon/'.$value['image'].'" target="_blank"><img src="'.base_url().'admin/uploads/coupon/thumb/'.$value['image'].'" alt="お得なクーポン" class="coupon"/></a>';
            }
        }
    	?>
			<br clear="all" />
		</div>