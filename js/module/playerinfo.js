$(function() {
	var item = $('div.item');
	var name = getParameterByName('name');
	if(!name) {
		return;
	}
	
	ajaxLoaderModal.show();
	$.getJSON('scripts/playerinfo.php', {name: name}, function(data) {
		ajaxLoaderModal.hide();
		if(!data) {
			content.html('<span class="item-header">'+getTranslation('Personagem não encontrado.')+'</span>');
			return;
		}
		
		if(data.guildName) {
			content.find('#guildName').parent().show();
		}
			
		for(i in data) {
			var txt = data[i];
			if(i == 'sex') {
				txt = getTranslation(txt);
			}
			content.find('td#'+i).text(txt);
		}
		
		if(data.deaths) {
			var grid = content.find('#deaths').show();
			var tbody = grid.find('tbody');
			for(i in data.deaths) {
				var death = data.deaths[i];
				var mostDamage = '';
				if(death.killed_by != death.mostdamage_by && death.is_player != death.mostdamage_is_player) {
					mostDamage = getTranslation('e o maior dano foi dado pelo {0}', (death.mostdamage_is_player == 1 ? '<a href="playerinfo.html?name="'+death.mostdamage_by+'" style="color: red;">'+death.mostdamage_by+'</a>' : death.mostdamage_by))
				}
				tbody.append('<tr><td style="width: 160px;">'+death.time+'</td><td>'+getTranslation('Morto no Level {0} por {1}', death.level, (death.is_player == 1 ? '<a href="playerinfo.html?name='+death.killed_by+'" style="color: red;">'+death.killed_by+'</a>' : death.killed_by))+' '+mostDamage+'</td></tr>');
			}
		}
		
		item.show();
	});
});