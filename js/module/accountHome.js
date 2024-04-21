$(function() {
	content.find('#logout').on('click', function() {
		showConfirm('Tem certeza que deseja sair?', function() {
			ajaxLoaderModal.show();
			$.get('scripts/login.php', {destroy: true}, function(data) {
				window.location.href = 'account.html';
			});
		});
	});
	
	ajaxLoaderModal.show();
	$.getJSON('scripts/accountInfo.php', {}, function(data) {
		if(data) {
			content.find('span#dataName').text(data.name);
			content.find('span#dataCreditos').text(data.creditos);
			content.find('span#dataUltLogin').text(data.lastday);
		} else {
			window.location.href = 'account.html';
		}
		ajaxLoaderModal.hide();
	});
	
	content.each(genericProcessContent);
	
	content.find('input[name="tabs2"]').prop('checked', false);
	
	registerAction('changePassword', function(e, parent, inputs) {		
		var $this = $(this);
        var pass = inputs.eq(1);
        var conf = inputs.eq(2);
        if (pass.val() != conf.val()) {
            showMessage(getTranslation('As senhas não se coincidem.'), function() {
                conf.focus();
            });
        } else {
        	ajaxLoaderModal.show();
            $.getJSON('scripts/changePassword.php', inputs.serialize(), function(data) {
                showMessage(data.msg);
                if (data.result) {
                	content.find('.btnLimpar').trigger('click');
                }
                grecaptcha.reset();
                ajaxLoaderModal.hide();
            });
            return false;
        }
	});
});