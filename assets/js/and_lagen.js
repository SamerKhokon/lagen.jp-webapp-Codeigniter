$(function() {
	$("#global-nav a").hover (
		function() {
			$(this).stop().fadeTo("500",0);
		},
		function() {
			$(this).stop().fadeTo("1000",1);
		}
	)
});



$(function() {
	$("#btn-box1 a").hover (
		function() {
			$(this).stop().fadeTo("500",0);
		},
		function() {
			$(this).stop().fadeTo("1000",1);
		}
	)
});


$(function() {
	$(".btn2 a, .btn2_2 a").hover (
		function() {
			$(this).stop().fadeTo("500",0);
		},
		function() {
			$(this).stop().fadeTo("1000",1);
		}
	)
});

//id指定スライドショー
$(function(){
		$(".slide-box img").click(function(){
																			 
			var id = $(this).attr("id");	//slide-box imgのID属性の取得
			
			if ($("#slide" + id).attr("src") !== $(this).attr("src")) {	//クリックした要素がすでに表示されていなければ実行
				$("#slide" + id)	//変更するイメージのIDを指定
				.css('display','none')	//一度display:noneにする
				.attr("src",$(this).attr("src"))	//クリックした要素から属性を取得し、書き換える
				.fadeIn(700);	//フェードイン
				return false;
			}
			
		})
});					 
					 
