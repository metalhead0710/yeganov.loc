$(function () {
	var body = $("body");
	var scrolled = false;

	$(window).scroll(function () {
		var _scrolled = !!(window.pageYOffset || document.documentElement.scrollTop);

		if (scrolled != _scrolled)
			_scrolled ? body.addClass("scrolled") : body.removeClass("scrolled");

		scrolled = _scrolled;
	});

	$('a[href*="#"]:not([href="#"])').click(function () {
		var offset = parseInt($(this).data("offset")) || 0;
		var navMain = $('#mainMenu');
		navMain.collapse('hide');
		 
		if (location.hostname == this.hostname && location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: target.offset().top - offset
				}, 600);
				return false;
			}
		}
	});
	$('.gallery a').simpleLightbox();
  $('a.poster').simpleLightbox({
    nav: false
  });
	$(".email-us").on('click', function() {
		$("#contact-form").validate({
		  submitHandler: function() {
		    send();
		  }
		});			
		var send = function() {
			var msg   = $('#contact-form').serialize();
			$.ajax({
				type: 'POST',
				url: '/emailus',
				data: msg,
				success: function(data) {
				$('.results').html(data);
				setTimeout();
				$('#contact-form')[0].reset();
				},
				error:  function(xhr, str){
				console.log('Помилка: ' + xhr.responseCode);
				}
			}); 
		};			
	});		
	var setTimeout = function(){
	$('.alert').fadeOut(4000)
	}; 	
});