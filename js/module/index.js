$(function() {
	ajaxLoaderModal.show();
	$.getJSON('scripts/noticias.php', {}, function(list) {
		for (var i = -1; ++i < list.length;) {
			var noticia = list[i];

			var item = $(document.createElement('div')).addClass('item').appendTo(content);
			$(document.createElement('div')).addClass('item-header').text(noticia.post_subject).appendTo(item);
			$(document.createElement('div')).addClass('item-sub-header').text(noticia.post_time).appendTo(item);
			$(document.createElement('div')).addClass('item-content').html(noticia.post_text).appendTo(item);
			$(document.createElement('div')).addClass('item-sign').text('Equipe PBOT').appendTo(item);			
		}
		ajaxLoaderModal.hide();
	});
});