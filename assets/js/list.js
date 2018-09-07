var root = $('body');
var loading = root.find('#load');
var refreshContent = function(e)
{
	loading.show();
	e.preventDefault();
	var url = $(this).attr('href');
	$.ajax({
	  type: 'POST',
	  url: '/pages' + url,
	  success: function(data) {
		$('tbody').html(data);				
		$('#load').hide();
	  },
	  error:  function(xhr, str){
		alert('Помилка: ' + xhr.responseCode);
	  }
	});
	
}	
$(document).on("click", ".page-link", refreshContent);
