$(document).scroll(function() {
	var y = $(this).scrollTop();
	if (y > 200) {
		$('.menu').fadeIn();
	} else {
		$('.menu').fadeOut();
	}

}).ready(function() {
	$('#slideshow').cycle({
		fx : 'fade',
		pager : '#smallnav',
		pause : 0,
		speed : 3000,
		timeout : 2000
	});
});

document.oncontextmenu = function() {
    return false;
};

var captchaDiv, googleSecurity, content, ajaxLoaderModal;
function basic() {
	var lastUrl;
	$('a[ajax]').each(function() {
		var url = this.getAttribute('ajax');
		$(this).on('click', function(e) {
			e.preventDefault();
			if (lastUrl != url) {
				googleSecurity.append(captchaDiv);
				lastUrl = url;
				ajaxLoaderModal.show();
				$.get('contents/' + url+'?_=' + new Date().getTime(), {}, function(data) {
					if (!(location.hostname === "localhost" && location.hostname === "127.0.0.1")) {
						history.replaceState({}, null, url);
					}
					content.html(data);
					
					translator(lastLanguage, content);
					basic();
					ajaxLoaderModal.hide();
				});
			}
		}).removeAttr('ajax');
	});
}
$(function() {
	/*if (location.protocol != 'https:') {
		location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
		return;
	}*/
	
	content = $('div.content-main');
	googleSecurity = $('div#googleSecurity');
	captchaDiv = $('div.g-recaptcha');
	ajaxLoaderModal = $('div#ajaxLoader');
	
	document.onmousedown = function(event) {
		if (event.button == 2) {
			return false;
		}
	};
	basic();
	$("#ocultar").on('click', function(event) {
		event.preventDefault();
		$("#content").fadeToggle(2000);
	});
	var divMessage = $(document.createElement('div')).attr('id', 'alert-message').appendTo(document.body);
	window.showMessage = function(msg, onClose) {
		divMessage.html(msg);
		translator(lastLanguage, divMessage);		
		divMessage.dialog({
			title: getTranslation('Aviso'),
			draggable: false,
			resizable: false,
			modal: true,
			close: function() {
				if (onClose) {
					onClose.call(divMessage);
				}
			},
			buttons: [{
				text: "OK",
				click: function() {
					$(this).dialog("close");
				}
			}]
		});
	};
	window.showConfirm = function(msg, onConfirm) {
		divMessage.html(msg).dialog({
			title: getTranslation('Aviso'),
			draggable: false,
			resizable: false,
			modal: true,
			buttons: [{
				text: "OK",
				click: function() {
					if (onConfirm) {
						onConfirm.call(this);
					}
					$(this).dialog("close");
				}
			}, {
				text: getTranslation("Cancelar"),
				click: function() {
					$(this).dialog("close");
				}
			}]
		});
	};
	var actions = [];
	window.registerAction = function(name, action) {
		actions[name] = action;
	};
	window.genericProcessContent = function() {
		$this = $(this);
		var inputs = $this.find('input:not([type="hidden"])');
		inputs.keypress(function(e) {
			$this = $(this);
			setTimeout(function() {
				if ($this.val()[0] == ' ') $this.val('');
			});
		});
		var btnLimpar = $this.find('.btn-limpar').on('click', function(e) {
			inputs.filter(':visible:not(:checkbox):not([type="button"])').val('');
			inputs.filter(':visible:checkbox:not([type="button"])').prop('checked', false);
		});
		setTimeout(function() {
			btnLimpar.trigger('click');
		}, 50);
		$this.find('.btn-entrar').on('click', function(e) {
			var action = this.getAttribute('action');
			if(!action) {
				return;
			}
			var hasError = false;
			var parent = $(this).parent();
			var inputs = parent.find('input[required], textarea').each(function() {
				$this = $(this);
				var isCheckbox = $this.attr('type') == 'checkbox'
				if (this.name == 'g-recaptcha-response' && !grecaptcha.getResponse()) {
					showMessage(getTranslation('Verifique se não é um robô.'));
					hasError = true;
					return false;
				} else if (isCheckbox && !$this.prop('checked') || !isCheckbox && $this.val().length == 0) {
					var name = $this.attr('msg:key') || $this.attr('title') || $this.attr('name');
					showMessage(getTranslation('O campo {0} é obrigatorio.', name), function() {
						$this.focus();
					});
					hasError = true;
					return false;
				}
			});
			if (!hasError) {
				actions[action].call(this, e, parent, inputs);
			}
		});
	};
	
	var personagemField = $('#personagemField');
	var actionPesquisarPersonagem = function() {
		var name = personagemField.val().trim();
		if(!name) {
			showMessage(getTranslation('Por favor, digite um nome.'));
		} else {
			window.location.href = 'playerinfo.html?name='+name;
		}
	};
	
	$('.btn-pesquisar-personagem').on('click', actionPesquisarPersonagem);
	personagemField.on('keyup', function (e) {
	    if (e.keyCode == 13) {
	    	actionPesquisarPersonagem();
	    }
	});
	
	var translateTo = function(lang) {
		document.cookie = 'lang='+lang;
		translator(lang);
	};
	
	$('a.language').on('click', function(e) {
		e.preventDefault();
		var lang = this.getAttribute('lang');
		translateTo(lang);
	});
	
	var lang = getCookie('lang');
	if(lang) {
		translateTo(lang);
	} else {
		var userLang = navigator.language || navigator.userLanguage;
		if(userLang != 'pt-BR') {
			translateTo('en');
		}
	}
});

var TRANSLATOR = {};
var lastLanguage;
function translator(lang, objectContent) {
	if(!objectContent && lastLanguage == lang) {
		return;
	}
	lastLanguage = lang;
	$('[translate="yes"]', objectContent || document).each(function() {
		var $this = $(this);
		var isButton = $this.is('[type="button"]');
		var txt = (($this.attr('original')) || (isButton ? $this.val() : $this.text())).trim();
		
		
		var t = TRANSLATOR[lang] ? TRANSLATOR[lang][txt] : txt;
		if(t) {
			if(isButton) {
				$this.val(t);
			} else {
				$this.text(t);
			}
			$this.attr('original', txt.trim());
		} else {
			console.log('Chave de Tradução: '+txt+', Linguagem: '+lang+': Chave ou Linguagem não registrados.');
		}		
	});
}

function getTranslation(txt) {
	var props = TRANSLATOR[lastLanguage];
	if(props && props[txt]) {
		txt = props[txt];
	}
	if (arguments.length > 1) {
		var extraParam = '';
		for (var i = 0; ++i < arguments.length;) {
			if(i > 1) {
				extraParam += ',';
			}
			extraParam += 'arguments['+i+']';
		}
		return eval('txt.format('+extraParam+');');
	} else {
		return txt;
	}
}

var modal = null;

function simpleModal(content) {
	modal = $('div#modal');
	if (modal.length == 0) {
		modal = $(document.createElement('div')).attr('id', 'modal').append($(document.createElement('div')).attr('id', 'background'))
		$('body').append(modal)
	}
	modal.append(content);
}

function getParameterByName(name, url) {
	if (!url) {
		url = window.location.href;
	}
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function showModal(name, title, onConfirm, param, afterLoad) {
	ajaxLoaderModal.show();
	$.get('modals/' + name + '.html?_=' + new Date().getTime(), param || {}, function(data) {
		var div = $(document.createElement('div'));
		div.append(data);
		translator(lastLanguage, div);
		div.dialog({
			title: getTranslation(title),
			draggable: false,
			resizable: false,
			closeOnEscape: false,
			width: '640px',
			modal: true,
			close: function() {
				div.dialog('destroy').remove();
			},
			buttons: [{
				text: "OK",
				click: function() {
					var hasError = false;
					var inputs = $(this).find('input[required], textarea[required]').each(function() {
						$this = $(this);
						if ($this.val().length == 0) {
							showMessage(getTranslation('O campo {0} é obrigatorio.', $this.attr('name')), function() {
								$this.focus();
							});
							hasError = true;
							return false;
						}
					});
					if ((!hasError) && (onConfirm == null || onConfirm.call(this))) {
						$(this).dialog("close");
					}
				}
			}]
		});
		div.parent().find('.ui-dialog-titlebar-close').remove();
		if (afterLoad) {
			afterLoad.call(div.find('div:first'));
		}
		ajaxLoaderModal.hide();
	});
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getCookie(name) {
    var cookies = document.cookie;
    var prefix = name + "=";
    var begin = cookies.indexOf("; " + prefix);
 
    if (begin == -1) {
 
        begin = cookies.indexOf(prefix);
         
        if (begin != 0) {
            return null;
        }
 
    } else {
        begin += 2;
    }
 
    var end = cookies.indexOf(";", begin);
     
    if (end == -1) {
        end = cookies.length;                        
    }
 
    return unescape(cookies.substring(begin + prefix.length, end));
}

String.prototype.format = function() {
  a = this;
  for (k in arguments) {
    a = a.replace("{" + k + "}", arguments[k]);
  }
  return a;
};