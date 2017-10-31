window.addEvent('domready', function() {
	var downloads = $('main').getElements('a.download');
	downloads.addEvents({
		'mousedown': function() { this.setStyle('background-position', 'bottom left'); },
		'mouseup': function() { this.setStyle('background-position', 'center left'); },
		'mouseenter': function() { this.setStyle('background-position', 'center left'); },
		'mouseleave': function() { this.setStyle('background-position', 'top left'); }
	});
});