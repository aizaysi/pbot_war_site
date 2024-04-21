var lastLanguage;
function translator(lang) {
	if(lastLanguage == lang) {
		return;
	}
	lastLanguage = lang;
	console.log($('[translate="yes"]').length);
	$('[translate="yes"]').each(function() {
		var $this = $(this);
		var txt = $this.attr('original') || $this.text();
		console.log(txt);
		
		var t = TRANSLATOR ? TRANSLATOR[txt] : txt; 
		if(t) {
			$this.text(t);
			$this.attr('original', txt);
		} else {
			console.log('Chave de Tradução: '+txt+', Linguagem: '+lang+': Chave ou Linguagem não registrados.');
		}		
	});
}