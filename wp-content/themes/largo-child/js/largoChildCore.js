jQuery(document).ready(function($) {

	jQuery('#charter_schools').change(function(){
		window.location.href = $(this).val();
	});
	
	jQuery('#school_boards').change(function(){
		window.location.href = $(this).val();
	});

	$(".breakout").each(function() {
		var element = $(this);
		var p_text = [];
		element.children("p").each(function() {
			var p_child = $(this);
			if (p_child.html() != "") {
				p_text.push(p_child.html());
			} 
		});
		
		if (p_text.length) {
			var html = '<table>';
			html += '<tr>';
			html += '<td><div class="number">' + p_text[0] + '</div></td>';
			html += '<td><div class="text">' + p_text[1] + '</div></td>';
			html += '</tr>';
			html += '</table>';
			html += '<table>';
			html += '<tr>';
			html += '<td class="num_border"><div class="number">' + p_text[2] + '</div></td>';
			html += '<td><div class="text">' + p_text[3] + '</div></td>';
			html += '</tr>';
			html += '</table>';
			
			element.html(html);
		}
	});


	/* Shopping cart scripts */
	$("#wpsc_shopping_cart-2").hide();
});
