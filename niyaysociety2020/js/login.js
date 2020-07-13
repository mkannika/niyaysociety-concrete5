$(window).load(function() {
	var alert = $(".container > .row > .span10.offset1 > .alert");
	var alertRow = $(".container > .row");
	var secLogin = $("#primary #sec-login");
	var secForgotPassword = $("#primary #sec-forgot-password");
	if(alert.length){
		if ((window.location.href.indexOf("do_login") > -1) || (window.location.href.indexOf("do_register") > -1)){
			alert.prependTo(secLogin);	
			alertRow.remove();
		}
		if (window.location.href.indexOf("forgot_password") > -1){
			$('.sec-area').removeClass('sec-active');
			alert.prependTo(secForgotPassword);	
			alertRow.remove();
			$(secForgotPassword).addClass('sec-active');
		}
	}
	
	// $('#content .work-slide').slick({
	// 	infinite: true,
	// 	slidesToShow: 2,
	// 	slidesToScroll: 2
	// });

});

$(document).ready(function(){
	$('.btn-link').click(function(){
		var section = $(this).data('target');
		$('.sec-area').removeClass('sec-active');
		$(section).addClass('sec-active');
	});

	$('.toggle-login').click(function(){
		$('.sec-area').removeClass('sec-active');
		$('#sec-login').addClass('sec-active');
	});

	// $('.sidebar__wrap').stickySidebar({
  //   topSpacing: 30,
	// 	bottomSpacing: 30,
	// 	containerSelector: '#content',
  //   innerWrapperSelector: '#sidebar'
	// });

});