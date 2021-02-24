//@prepros-prepend mixitup.min.js
jQuery(document).ready(function($) {
	$('html')
		.delay(300)
		.queue(function(next) {
			$(this).addClass('loaded');
			next();
		});

	$headerHeight = $('header').outerHeight(true);
	$('.hero .heading').css('padding-top', $headerHeight);
	$('.book-cta').css('top', $headerHeight + 20);
	$('.under-book-button').css('top', $headerHeight + 120);

	function overlayFooter() {
		$footerHeight = $('footer').outerHeight(true);
		$footerOverlayHeight = $footerHeight + 100;
		$('.dark-section').css('padding-bottom', $footerOverlayHeight);
		$('footer').css('margin-top', -$footerHeight);
	}

	if ($('body').hasClass('single-product')) {
		overlayFooter();
	}

	$(window).scroll(function() {
		var scroll = $(window).scrollTop();

		if (scroll >= $headerHeight) {
			$('body').addClass('scrolled');
		} else {
			$('body').removeClass('scrolled');
		}
	});

	//Random class change on divs in hero
	var vectorHexOutlines = document.getElementsByClassName('hex-item');
	setInterval(changeHexGlow, 500);
	function changeHexGlow() {
		var randomNumber = Math.floor(Math.random() * vectorHexOutlines.length);
		var selectedHex = '.hex-item:nth-of-type(' + randomNumber + ')';
		$(selectedHex).addClass('hex-glow');
	}
	
	setInterval(changeHexDim, 500);
	function changeHexDim() {
		var randomNumberOff = Math.floor(Math.random() * vectorHexOutlines.length);
		var selectedHexDim = '.hex-item:nth-of-type(' + randomNumberOff + ')';
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

	$('.toggle__item .head').click(function(e) {
		e.preventDefault();
		$(this)
			.siblings('.toggle__item .body')
			.slideToggle();
	});

	$('.set-form input').on('input', function() {
		if ($(this).val()) {
			console.log('I HEAR');
			$(this)
				.closest('.form-field')
				.addClass('contains-content');
		} else {
			$(this)
				.closest('.form-field')
				.removeClass('contains-content');
		}
	});
	$('.trigger-login').click(function(e) {
		e.preventDefault();
		$('.modal-wrapper').addClass('visible');
	});
	$('.modal-wrapper .close').click(function(e) {
		e.preventDefault();
		$('.modal-wrapper').removeClass('visible');
	});

	$('.login-submit').click(function() {
		$(this).addClass('clicked');
	});

	$('#sortbox').on('input', function(e) {
		e.preventDefault();
		var desiredOption = $(this).val();
		if (desiredOption == 'desc') {
			$(this).focus();
			var items = $('.course-archive-item');
			items.sort(function(b, a) {
				return +$(a).data('datestamp') - +$(b).data('datestamp');
			});
			items.appendTo('.filter-target');
		}
		if (desiredOption == 'asc') {
			$(this).focus();
			var items = $('.course-archive-item');
			items.sort(function(a, b) {
				return +$(a).data('datestamp') - +$(b).data('datestamp');
			});
			items.appendTo('.filter-target');
		}
	});
	$('.checkboxes input[type="checkbox"]').click(function() {
		$(this)
			.closest('.checkboxes')
			.find('input[type="checkbox"]')
			.prop('checked', false);
		$(this)
			.closest('.checkboxes')
			.find('p')
			.removeClass('selected');
		$(this).prop('checked', true);
		$(this)
			.closest('p')
			.addClass('selected');
	});
	$('.menu-trigger').click(function(e) {
		e.preventDefault();
		$('.menu-overlay').slideToggle();
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

	$('.wpcf7-form-control').on('input', function() {
		if ($(this).val()) {
			$(this)
				.parents('.form-field')
				.addClass('contains-content');
		} else {
			$(this)
				.parents('.form-field')
				.removeClass('contains-content');
		}
	});

	$(function() {
		$('.filter-target').mixItUp();
	});
	
	$(document).ready( function() {
		if ($('form.checkout').hasClass('product-type-membership')){
			var dt = new Date();
			year  = dt.getFullYear() + 1;
			month = (dt.getMonth() + 1).toString().padStart(2, "0");
			day   = (dt.getDate() - 1).toString().padStart(2, "0");
			$('#plan_expiry_date').val(year + '-' + month + '-' + day);	
		}
	});​
	$('.filter-controls__button').click(function(e) {
		function checkVis() {
			if ($('.course-item').is(":hidden")) {
				$('.no-results').show();
			} else {
				$('.no-results').hide();
			}
		}
		setTimeout(checkVis, 700)
	});​
}); //Don't remove ---- end of jQuery wrapper
