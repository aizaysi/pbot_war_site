$(function() {
    var contents = content.each(genericProcessContent);
    var tabs = contents.find('input[name="tabs2"]').on('click', function(e) {
    	$(this).parent().find('.tab-content div#securityKey').append(captchaDiv);
        grecaptcha.reset();
    });
    
    tabs.prop('checked', false);
    
    $('a#recoveryButton').on('click', function(e) {
    	e.preventDefault();
    	tabs.eq(2).trigger('click');
    });

    registerAction('cadastrarConta', function(e, parent, inputs) {
        var confirmPassword = inputs.filter('[name="confirmPassword"]');
        if (inputs.filter('[name="password"]').val() != confirmPassword.val()) {
            showMessage(getTranslation('As senhas não se coincidem.'), function() {
                confirmPassword.focus();
            });
        } else {
        	ajaxLoaderModal.show();
            $.getJSON('scripts/createAccount.php', inputs.serialize(), function(data) {
                showMessage(data.msg, function() {
                	ajaxLoaderModal.hide();
                    if (data.result) {
                        parent.find('.btnLimpar').trigger('click');
                    }
                    grecaptcha.reset();
                });
                ajaxLoaderModal.hide();
            });
        }
    });
    
    registerAction('login', function(e, parent, inputs) {
    	ajaxLoaderModal.show();
        $.get('scripts/login.php', 'website=1&'+inputs.serialize(), function(data) {
           if(data && data.length) {
        	   showMessage(data, function() {
        		   inputs.eq(0).focus();
        		   grecaptcha.reset();
               });
        	   ajaxLoaderModal.hide();
           } else {
        	   window.location.href = "accountHome.html";
           }
        });
    });

    registerAction('recuperarConta', function(e, parent, inputs) {
    	ajaxLoaderModal.show();
        $.get('scripts/recoveryAccount.php', inputs.serialize(), function(data) {
        	ajaxLoaderModal.hide();
            showMessage(data, function() {
                parent.find('.btnLimpar').trigger('click');
                grecaptcha.reset();
            });
        });
    });

    var key = getParameterByName('key');
    if (key) {
    	ajaxLoaderModal.show();
        $.get('scripts/newPassword.php', {
            key: key
        }, function(data) {
        	ajaxLoaderModal.hide();
            if (data && data.length) {
                showMessage(data);
            } else {
                showModal('newPassword', getTranslation('Digite a sua nova senha.'), function() {
                    var $this = $(this);
                    var inputs = $(this).find('input[type="password"]');
                    var pass = inputs.eq(0);
                    var conf = inputs.eq(1);
                    if (pass.val() != conf.val()) {
                        showMessage(getTranslation('As senhas não se coincidem.'), function() {
                            conf.focus();
                        });
                    } else {
                    	ajaxLoaderModal.show();
                        $.getJSON('scripts/newPassword.php', {key: key, password: pass.val()
                        }, function(data) {
                        	ajaxLoaderModal.hide();
                            showMessage(data.msg);
                            if (data.result) {
                                $this.dialog('close');
                            }
                        });
                        return false;
                    }
                }, {key: key});
            }
        });
    }
    
    $('a#linkTermos').on('click', function(e) {
    	e.preventDefault();
    	showModal('contrato', 'Contrato', null, null, function() {});
    });
});