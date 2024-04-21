$(function() {
	$.getJSON('scripts/eventos.php', {}, function(list) {
		for (var i = -1; ++i < list.length;) {
			var noticia = list[i];

			var titulo = $(document.createElement('a')).css('color', '#ffbf00').attr('target', '_blank').attr('href', 'forum/viewtopic.php?f='+noticia.forum_id+'&t='+noticia.topic_id).text(noticia.post_subject);
			var item = $(document.createElement('div')).addClass('item').appendTo(content);
			$(document.createElement('div')).addClass('item-header').append(titulo).appendTo(item);
			$(document.createElement('div')).addClass('item-sub-header').text(noticia.post_time).appendTo(item);
			$(document.createElement('div')).addClass('item-content').html(noticia.post_text).appendTo(item);
			$(document.createElement('div')).addClass('item-sign').text('Equipe PBOT').appendTo(item);			
		}
	});
});