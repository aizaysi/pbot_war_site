$(function() {
	var main = $('table#onlines tbody');
	var onlineCount = $('span#onlineCount');
	var lastUpdate = $('span#lastUpdate');
	ajaxLoaderModal.show();
	$.getJSON('scripts/playersOnline.php', {}, function(dataFound) {
		var d = new Date(dataFound.time*1000);
		var day = d.getDate();
		var month = d.getMonth()+1;
		var hours = d.getHours();
		var minutes = d.getMinutes();
		if(day < 10) day = '0'+day;
		if(month < 10) month = '0'+month;
		if(hours < 10) hours = '0'+hours;
		if(minutes < 10) minutes = '0'+minutes;
		
		onlineCount.text(dataFound.players.length);
		lastUpdate.text(day + '/' + month + '/' + d.getFullYear() + ' ' +hours+ ':' +minutes);
		for (var i = -1; ++i < dataFound.players.length;) {
			var data = dataFound.players[i];
			var tr = $('<tr><td><a style="color: #00D9E8" href="playerinfo.html?name='+data.name+'">'+data.name+'</a></td><td>'+data.vocation+'</td><td>'+data.level+'</td></tr>').appendTo(main);
		}
		ajaxLoaderModal.hide();
	});
});