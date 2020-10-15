//@prepros-prepend jquery.magnific-popup.js
jQuery(document).ready(function($) {
	$('html')
		.delay(300)
		.queue(function(next) {
			$(this).addClass('loaded');
			next();
		});

	$headerHeight = $('header').outerHeight(true);
	$('.hero .heading').css('padding-top', $headerHeight);

	//Random class change on divs in hero
	var vectorHexOutlines = document.getElementsByClassName('hex-outline');
	setInterval(changeHexGlow, 500);
	function changeHexGlow() {
		var randomNumber = Math.floor(Math.random() * vectorHexOutlines.length);
		var selectedHex = '#hex path:nth-of-type(' + randomNumber + ')';
		$(selectedHex).addClass('hex-glow');
	}

	setInterval(changeHexDim, 500);
	function changeHexDim() {
		var randomNumberOff = Math.floor(Math.random() * vectorHexOutlines.length);
		var selectedHexDim = '#hex path:nth-of-type(' + randomNumberOff + ')';
		$(selectedHexDim).removeClass('hex-glow');
	}

	/* CLASS AND FOCUS ON CLICK */

	$('.course-item .read-more').click(function(e) {
		e.preventDefault();
		$(this).slideUp();
		$(this)
			.closest('.course-item')
			.children('.description')
			.slideDown();
		$(this)
			.closest('.course-item')
			.children('.description')
			.children('.read-less')
			.slideDown();
	});
	$('.description .read-less').click(function(e) {
		e.preventDefault();
		$(this).slideUp();
		$(this)
			.closest('.description')
			.slideUp();
		$(this)
			.closest('.description')
			.siblings('.summary')
			.children('.read-more')
			.slideDown();
	});
	/*

  $(".expanding-section__trigger").click(function (e) {
    e.preventDefault();
    $(this).closest('.expanding-section').addClass('open');
    $(this).fadeOut('slow');
    $('.expanding-section__head .heading').fadeOut('slow');
    var currentSection = $(this).closest('.expanding-section');
    function scrollToTop() {
      $('html, body').animate({
        scrollTop: $(currentSection).offset().top - 100
      }, 'slow');
    }
    setTimeout(scrollToTop, 400);
  });

  */
}); //Don't remove ---- end of jQuery wrapper
