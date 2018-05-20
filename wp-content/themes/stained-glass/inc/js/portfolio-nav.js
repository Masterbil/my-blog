jQuery( document ).ready(function( $ ) {

	var width = $('.content-container.jetpack-nav').css('width');
	
	$('.jetpack-widget-nav li').click( function( event ) {
	
		if(	$( this ).hasClass('current')) {
			return;
		}
		$('.jetpack-widget-nav li').removeClass('current');
		$('.jetpack-widget-tag-nav li').removeClass('current');
		
		id = $( this ).attr('class');
		
		$( this ).addClass('current');
		
		$('.content-container.jetpack-nav').not('.' + id).animate({
				'opacity':'0',
				},300);
				
		$('.content-container.jetpack-nav.' + id).animate({
				'opacity':'0',
				},100);
				
		setTimeout(function() {
			if( 'all' === id ) {
				$('.content-container.jetpack-nav').removeClass('hidden-el');	
			} else {
				$('.content-container.jetpack-nav').not('.' + id).addClass('hidden-el');
				$('.content-container.jetpack-nav.' + id).removeClass('hidden-el');
			}
		}, 300);	

		$('.archive-title').text( $( this ).text());
				
		setTimeout(function() {
			if( 'all' === id ) {
				$('.content-container.jetpack-nav').css('width', width);
				$('.content-container.jetpack-nav').animate({
						'opacity':'1',},500);
			}
			else {
				$('.content-container.jetpack-nav.' + id).css('width', width);
				$('.content-container.jetpack-nav.' + id).animate({
						'opacity':'1',
						},500);			
			}
		}, 300);
		
	});	
});

jQuery( document ).ready(function( $ ) {

	var width = $('.content-container.jetpack-nav').css('width');
	
	$('.jetpack-widget-tag-nav li').click( function( event ) {
	
		if(	$( this ).hasClass('current')) {
			return;
		}
		$('.jetpack-widget-nav li').removeClass('current');
		$('.jetpack-widget-tag-nav li').removeClass('current');
		
		id = $( this ).attr('class');
		
		$( this ).addClass('current');
		
		$('.content-container.jetpack-nav').not('.' + id).animate({
				'opacity':'0',
				},300);
				
		$('.content-container.jetpack-nav.' + id).animate({
				'opacity':'0',
				},300);
				
		setTimeout(function() {
			if( 'all' === id ) {
				$('.content-container.jetpack-nav').removeClass('hidden-el');	
			} else {
				$('.content-container.jetpack-nav').not('.' + id).addClass('hidden-el');
				$('.content-container.jetpack-nav.' + id).removeClass('hidden-el');
			}
		}, 300);	

		$('.archive-title').text( $( this ).text());
				
		setTimeout(function() {
			if( 'all' === id ) {
				$('.content-container.jetpack-nav').css('width', width);
				$('.content-container.jetpack-nav').animate({
						'opacity':'1',
						},500);
			}
			else {
				$('.content-container.jetpack-nav.' + id).animate({
						'opacity':'1',
						},500);			
			}
		}, 300);
		
	});	
});