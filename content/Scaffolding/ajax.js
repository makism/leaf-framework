window.addEvent('domready', function() {
	/*
	 * INSERT
	 */
	$('InsertForm').setStyle('display', 'block');
	var fx = new Fx.Slide($('InsertForm'));
	fx.hide();
	$('Insert').addEvent('click', function(ev) {
		fx.toggle();
	});
	
	new SmoothScroll();
	
	/*
	 *	UPDATE
	 */
	$$('.updatable').each( function(elem) {
		elem.addEvent('dblclick', function() {
			if (elem.hasClass('editable_empty'))
				elem.removeClass('editable_empty');
			
			var before = elem.get('html').trim();
			
			elem.set('html', '');
			
			var input = new Element('input', {'class':'edit_box', 'value':before});
			
			input.addEvent('dblclick', function(e) {
				e.stop();
				return;
			});
			
			input.addEvent('click', function (e) {
				e.stop();
				return;
			});
			
			input.addEvent('keydown', function(e) {
				if (e.key=='enter') {
					this.fireEvent('blur');
				} 
			}); 
			
			input.inject(elem).select();
			
			input.addEvent ('blur', function(event) {
				val = input.get('value').trim();
				elem.set('text', val);
				
				if (val=="")
					elem.addClass('editable_empty');
				
				var url = updateUrl;
				var val = elem.get('rel') + "&v=" + elem.get('text');
				
				if (elem.get('text')!=before) {
                    var req = new Request.HTML({
                        url: url,
                        data: val,
                        onRequest: function() {
                            show_ajax_message('request');
                        },
                        onComplete: function(tree, elems, html) {
                            if (html=="1") {
                                show_ajax_message('success');
                            } else {
                                show_ajax_message('failure');
                            }
                        }
                    }).post();
				}
				
			});
			
		});
		
	});

	/*
	 *	DELETE
	 */
	$$('.record').each(function(elem) {
		var td	= elem.getFirst();
		var a	= td.getFirst();
		var img = a.getFirst();
		
		a.addEvent('click', function(event) {
			event.stop();
			
			var conf = confirm("Διαγραφή;");
			
			if (conf==true) {
			
                var req = new Request.HTML({
                    url: a.get('href'),
                    onRequest: function() {
                        show_ajax_message('request');
                    },
                    onComplete: function(tree, elems, html) {
                        if (html=="1") {
                            show_ajax_message('success');
	                        elem.setStyle('background-color', '#ff0000');
	                        elem.fade('out');
                        } else {
                            show_ajax_message('failure');
                        }
                    }
                }).get();
			}
			
			return false;
		});
		
	});
});

function show_ajax_message(state) {
	$('message').setStyle('top',window.getScrollTop() + 45); 

	if (state=="request") {
		$('message').set('text', 'Εκτέλεση...');
		$('message').set('styles', {'background-color':'#fffea1','display':'block','opacity':'100'});  
	} else if(state=="success") {
		$('message').set('text', 'Επιτυχής!');
		var myMorph = new Fx.Morph('message',{'duration':1100});
		myMorph.start({'opacity': 0,'background-color': '#90ee90'}); 
	} else if(state=="failure") {
		$('message').set('text', 'Αποτυχία');
		var myMorph = new Fx.Morph('message',{'duration':1100});
		myMorph.start({'opacity': 0,'background-color': '#ff0000'});
	}
}

document.write('<style type="text/css" media="screen">#InsertForm {display: none;}</style>');

