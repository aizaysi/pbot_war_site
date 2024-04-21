$(function() {
	var tableRankTbody = $('.datagrid-rank table > tbody');
	var tdRank = $('.datagrid-rank table th#type');
	var lastRank = 'level';
	var currentPage = 1;
	var executing = false;
	var rankText = 'Level';
	var selectVocation = $('select#vocation');
	var selectRanking = $('select#ranking');

	var rank = function(rank) {
		executing = true;
		ajaxLoaderModal.show();
		$.getJSON('scripts/rank.php', {
			vocation: selectVocation.val(),
			rank : lastRank,
			page : currentPage
		}, function(list) {
			tdRank.text(rankText);
			if (list.length == 0) {
				--currentPage;
			} else {
				tableRankTbody.empty();

				for (var i = -1; ++i < list.length;) {
					var rank = list[i];
					var pos = i + 1 + ((currentPage - 1) * 5);
					tableRankTbody.append('<tr><td>'+pos+'</td><td><a style="color: #00D9E8" href="playerinfo.html?name='+rank.name+'">'+rank.name+'</a></td><td>'+rank.rank+'</td></tr>');
				}
			}

			executing = false;
			ajaxLoaderModal.hide();
		});
	}
	
	var changeEvent = function(e) {
		if (executing)
			return false;

		var optionSelected = selectRanking.find('option:selected'); 
		
		currentPage = 1;
		lastRank = optionSelected.val();			
		rankText = optionSelected.text();
		rank();
	};
	
	selectVocation.on('change', changeEvent);
	selectRanking.on('change', changeEvent);
	rank();

	$('.datagrid-rank-pag span').bind('click', function() {
		if (executing)
			return;

		var clazz = $(this).attr('class');

		if (clazz == 'first') {
			currentPage = 1;
		} else if (clazz == 'prev') {
			currentPage -= 1;
			if (currentPage == 0) {
				currentPage = 1;
				return;
			}
		} else if (clazz == 'next') {
			if (currentPage == 10)
				return;

			currentPage += 1;
		} else if (clazz == 'last') {
			currentPage = 10;
		}

		rank();
	}).disableSelection();
});