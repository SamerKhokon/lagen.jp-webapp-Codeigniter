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

//id�w��X���C�h�V���[
$(function(){
		$(".slide-box img").click(function(){
																			 
			var id = $(this).attr("id");	//slide-box img��ID�����̎擾
			
			if ($("#slide" + id).attr("src") !== $(this).attr("src")) {	//�N���b�N�����v�f�����łɕ\������Ă��Ȃ���Ύ��s
				$("#slide" + id)	//�ύX����C���[�W��ID���w��
				.css('display','none')	//��xdisplay:none�ɂ���
				.attr("src",$(this).attr("src"))	//�N���b�N�����v�f���瑮�����擾���A����������
				.fadeIn(700);	//�t�F�[�h�C��
				return false;
			}
			
		})
});					 
					 
