$(window).load(function() {

	$('.preloader').fadeOut();

	// Header Menu
	$(".dropdown-toggle").click(function(){
		$(this).parent().toggleClass('open');
	});

	$("#toggle-menu").click(function(){
		$("#header").toggleClass('open');
	});

	//Enable submit when choose radio value's vote.
	if($("#ranking")){
		$("#ranking .popup").hide();
		$("#ranking .btn-alert").hide();
		$("input[type='radio']").change(function(){
			$("input[type='radio']").removeAttr("checked");
			$(this).attr("checked", "checked");
			$("input[type='submit']").prop("disabled", false);
			$("#ranking .popup").fadeIn().toggleClass('open');
			$("#ranking .btn-alert").fadeIn();
		});

		$(".popup").click(function(){
			$(this).fadeOut().removeClass('open');
			$("input[type='radio']").removeAttr("checked");
		});
	}

	if($('.grid').length){

		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.item-isotope',
			layoutMode: 'fitRows',
			getSortData: {
				date: function( itemElem ) {
					var date = $( itemElem ).attr('data-date');
					return parseInt( date );
				},
				view: function( itemElem ) {
					var view = $( itemElem ).attr('data-view');
					return parseInt( view );
				},
				score: function( itemElem ) {
					var score = $( itemElem ).attr('data-score');
					return parseInt( score );
				}
		}
		});

		// bind filter button click
		$('.filters-button-group').on( 'click', 'button', function() {

			var filterValue = $( this ).attr('data-filter');
			var sortValue = $(this).attr('data-sort-value');
			var direction = $(this).attr('data-sort-direction');
			var isAscending = (direction == 'asc');
			var newDirection = (isAscending) ? 'desc' : 'asc';

			$grid.isotope({
				filter: filterValue,
				sortBy: sortValue,
				sortAscending: isAscending
			});

			$(this).attr('data-sort-direction', newDirection);

		});

		// change is-checked class on buttons
		$('.button-group').each( function( i, buttonGroup ) {
			var $buttonGroup = $( buttonGroup );
			$buttonGroup.on( 'click', 'button', function() {
			$buttonGroup.find('.is-checked').removeClass('is-checked');
				$( this ).addClass('is-checked');
			});
		});

	}

	if($('.slider').length){
		$('.slider').slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			autoplay: false,
			responsive: [
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		});
	}

	if($('.recent-list').length){
		$('.recent-list').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			autoplay: false,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		});
	}

	// Tag
	if($('.tags-list').length){
		var listHTML = $('.tags-list').html();
		var listItems = listHTML.split(',');
		$('.tags-list').html('');
		$.each(listItems, function(i, v){
			var item = '<li>' + v + '</li>';
			$('.tags-list').append(item);
		});
	}

	// Reset Editor
	if($('.prologue-desc').length){
		// $('.prologue-desc *').removeAttr('style');
		$('.prologue-desc p').removeClass('p1');
	}

	// Font Family selection.
	// $(".prologue-desc p").css("font-family", $default);
	// $(".prologue-desc p *").css("font-family",$default);
	// $( "select" ).change(function() {
	// 	$y = $(".slc-wrapper select option:selected").text();
	// 	$(".prologue-desc p").css("font-family",$y);
	// 	$(".prologue-desc p *").css("font-family",$y);
	// });

	$(".font-type").change(function() {
		$y = $(".font-type option:selected").text();
		$('.prologue-desc p').css("font-family", $y);
		$('.prologue-desc p *').css("font-family", $y);
	});

	var $default = 'Bai Jamjuree';
	var $color = '#aeb0b8';
	var $font_size = '16px';
	if(localStorage.getItem('modetheme') == 'dark-mode'){
		// $y = $(".slc-wrapper select option:selected").text();
		$('.prologue-desc p').css({
			'font-family': $default,
			'color': $color,
			'font-size': $font_size
		});
		$(".prologue-desc p *").css({
			'font-family': $default,
			'color': $color,
			'font-size': $font_size
		});;
	}

	$(".mode-theme").change(function() {
		$mode_theme = $(".mode-theme option:selected").val();
		localStorage.setItem('modetheme', $mode_theme);

		$(".mode-theme option").removeAttr('selected');

		if(localStorage.getItem('modetheme') == 'dark-mode'){
			$('body').addClass('dark-mode').removeClass('light-mode');
			$(".mode-theme option[value='dark-mode']").attr('selected','selected');
			$(".theme-switch input").attr('checked', 'checked');
		}
		if(localStorage.getItem('modetheme') == 'light-mode'){
			$('body').addClass('light-mode').removeClass('dark-mode');
			$(".mode-theme option[value='light-mode']").attr('selected','selected');
			$(".theme-switch input").removeAttr('checked');
		}
	});

	$('.theme-switch input[type="checkbox"]').click(function() {

		if($(".theme-switch input").prop('checked')){
			localStorage.setItem('modetheme', 'dark-mode');
			$(".theme-switch input").attr('checked', 'checked');
			$('body').addClass('dark-mode').removeClass('light-mode');
			if($('.mode-theme').length){
				$(".mode-theme option").removeAttr('selected');
				$(".mode-theme option[value='dark-mode']").attr('selected','selected');
			}
		}else{
			localStorage.setItem('modetheme', 'light-mode');
			$(".theme-switch input").removeAttr('checked');
			$('body').addClass('light-mode').removeClass('dark-mode');
			if($('.mode-theme').length){
				$(".mode-theme option").removeAttr('selected');
				$(".mode-theme option[value='light-mode']").attr('selected','selected');
			}
		}

	});


	if(localStorage.getItem('modetheme') == 'dark-mode'){
		$('body').addClass('dark-mode').removeClass('light-mode');
		$(".mode-theme option[value='dark-mode']").attr('selected','selected');
		$(".theme-switch input").attr('checked', 'checked');
	}

	if(localStorage.getItem('modetheme') == 'light-mode'){
		$('body').addClass('light-mode').removeClass('dark-mode');
		$(".mode-theme option[value='light-mode']").attr('selected','selected');
		$(".theme-switch input").removeAttr('checked');
	}

	$("#zoom-in").click(function(){
		increaseFont();
	});

	$("#zoom-out").click(function(){
		decreaseFont();
	});

	var section ;
	var factor = 0.8;

	function getFontSize(el)
	{
		var fs = $(el).css('font-size');    
		if(!el.originalFontSize)el.originalFontSize =fs; //set dynamic property for later reset  
		return  parseFloat(fs);  
	}

	function setFontSize(fact){
		if(section==null)
			 section = $('.prologue-desc').find('*')       
			 .filter(
			 function(){return  $(this).clone()
				.children()
				.remove()
				.end()
				.text().trim().length > 0;
				}); //filter -> exclude all elements without text
			
		section.each(function(){  
			var newsize = fact ? getFontSize(this) * fact : this.originalFontSize;
			if(newsize) $(this).css('font-size', newsize );      
		}); 
	}

	function resetFont(){
		setFontSize();
	}
	function increaseFont() {
		setFontSize(1 / factor);
	}
	function decreaseFont(){
		setFontSize(factor);
	}

});