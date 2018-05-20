//load main functions
jQuery( document ).ready(function( $ ) {

	var id = 1;
	
	var timer = null;

	$(window).scroll( function() {
		id++;
		if (timer) {
			clearTimeout(timer);
			timer = null;
		}
		timer = setTimeout(function() {
			trigger_hover();
			trigger_zoom_in_out();
		}, 200 );
	});
	
	$('.widget.stainedglass_image .wrapper-image.hover-all').each(function( index ) {
		$( this ).mouseover(function(){
			$( this ).find('.element').addClass('trigger-hover');
		})
		$( this ).mouseleave(function(){
			$( this ).find('.element').removeClass('trigger-hover');
		});		
	});
	
	function trigger_zoom_in_out() {
		var curr_id = id;
	
		$( '.widget.stainedglass_image .wrapper-image .element.element-zoomed-once, .widget.stainedglass_gallery .wrapper-image .element.element-zoomed-once, .widget.stainedglass_recent_posts .element.element-zoomed-once, .widget.stainedglass_portfolio .wrapper-image .element.element-zoomed-once, .widget.stainedglass_items .wrapper-image .element.element-zoomed-once, .widget.stainedglass_items_category .wrapper-image .element.element-zoomed-once, .widget.stainedglass_items_portfolio .wrapper-image .element.element-zoomed-once' ).each(function( index ) {
			var widget = $( this );
			if(isElementOutOfTheScreen( $( this ) )) {
				$( this ).removeClass('element-zoomed-once'); 	
			}
		});
		
		$( '.widget.stainedglass_image .wrapper-image .element.zoom:not(.element-zoomed-once), .widget.stainedglass_gallery .wrapper-image .element.zoom:not(.element-zoomed-once),.widget.stainedglass_recent_posts .element.zoom:not(.element-zoomed-once), .widget.stainedglass_portfolio .wrapper-image .element.zoom:not(.element-zoomed-once), .widget.stainedglass_items .wrapper-image .element.zoom:not(.element-zoomed-once), .widget.stainedglass_items_category .wrapper-image .element.zoom:not(.element-zoomed-once), .widget.stainedglass_items_portfolio .wrapper-image .element.zoom:not(.element-zoomed-once)' ).each(function( index ) {
			var widget = $( this );
			if( isElementOnTheScreen ( $( this ) ) ) {
				$( this ).addClass('trigger-zoom').addClass('element-zoomed-once').addClass('class-'+curr_id+'-z'); 				
				setTimeout(function() {
					widget.removeClass('trigger-zoom');
					if (widget.hasClass('once')) 
						widget.removeClass('zoom').removeClass('class-'+curr_id+'-z');
				}, 5000 );
			}
		});
	}
	function trigger_hover() {
		var curr_id = id;
		
		$( '.widget.stainedglass_image .wrapper-image .element.element-hovered-once, .widget.stainedglass_gallery .wrapper-image .element.element-hovered-once,.widget.stainedglass_portfolio .wrapper-image .element.element-hovered-once, .widget.stainedglass_items .wrapper-image .element.element-hovered-once, .widget.stainedglass_items_category .wrapper-image .element.element-hovered-once, .widget.stainedglass_items_portfolio .wrapper-image .element.element-hovered-once' ).each(function( index ) {
			var widget = $( this );
			if(isElementOutOfTheScreen( $( this ) )) {
				$( this ).removeClass('element-hovered-once'); 	
			}
		});
		
		$( '.widget.stainedglass_image .wrapper-image.all .element.animate:not(.element-hovered-once):not(.trigger-hover), .widget.stainedglass_gallery .wrapper-image.all .element.animate:not(.element-hovered-once):not(.trigger-hover),.widget.stainedglass_portfolio .wrapper-image.all .element.animate:not(.element-hovered-once):not(.trigger-hover), .widget.stainedglass_items .wrapper-image.all .element.animate:not(.element-hovered-once):not(.trigger-hover), .widget.stainedglass_items_category .wrapper-image.all .element.animate:not(.element-hovered-once):not(.trigger-hover), .widget.stainedglass_items_portfolio .wrapper-image.all .element.animate:not(.element-hovered-once):not(.trigger-hover)' ).each(function( index ) {
			var widget = $( this );
			if( isElementOnTheScreen ( $( this ) ) ) {
			
				$( this ).addClass('trigger-hover').addClass('element-hovered-once').addClass('class-'+curr_id); 				
				setTimeout(function() {
					widget.removeClass('trigger-hover').removeClass('class-'+curr_id);
					if (widget.hasClass('once')) 
						widget.removeClass('animate');

				}, 5000 );
			}
		});
		
		$( '.widget.stainedglass_image .wrapper-image.step, .widget.stainedglass_gallery .wrapper-image.step, .widget.stainedglass_portfolio .wrapper-image.step, .widget.stainedglass_items .wrapper-image.step, .widget.stainedglass_items_category .wrapper-image.step, .widget.stainedglass_items_portfolio .wrapper-image.step' ).each(function( index ) {
			
			var top = $( this ).offset().top;
			var currentPos = $( window ).scrollTop();
			var widget = $( this );
			if( isElementOnTheScreen ( $( this ) ) ) {
						
				var delay = $( this ).find('.element.animate').size()*1000 + 2000;			
				
				$( this ).find('.element.animate:not(.element-hovered-once):not(.trigger-hover)').each(function( index ) {
					var element = $( this );
					element.addClass('element-hovered-once').addClass('class-'+curr_id);
					setTimeout(function() {	
						element.addClass('trigger-hover');
					}, index*1000 );
				});
				
				var wrap = $( this );
				
				setTimeout(function() {
					var element = wrap.find('.element.animate.'+'class-'+curr_id);	
					if( ! element )
						return;
					element.removeClass('trigger-hover').removeClass('class-'+curr_id);	
					if (element.hasClass('once'))
						element.removeClass('animate');
				}, delay );
			}
		});
	}
	function isElementOnTheScreen( $element ) {
		var top = $element.offset().top;
		var currentPos = $( window ).scrollTop();
		
		if( (( currentPos + 250 > top) || 
							(currentPos + 250 > top + $element.height()
							&& currentPos + 250 < top )) 
					&& currentPos < top )
			return true;
		return false;
	}
	
	function isElementOutOfTheScreen( $element ) {
		var top = $element.offset().top;
		var currentPos = $( window ).scrollTop();
		if( currentPos + $( window ).height < top || currentPos > top + $( $element ).height() ) 	
			return true;
		return false;
	}
	
	/*$(window).scroll( function() {
		id++;
		setTimeout(function() {
			trigger_hover();
			trigger_zoom_in_out();
		}, 200 );
	});
	
	$( window ).scroll( function() {
		is_scroling = true;
	});
	$( window ).mousemove(function( event ) {
		is_scroling = false;	
	});	
	
	var timerId = setInterval( function (){
		//id++;
		setTimeout(function() {
			if( false == is_scroling );
			//	trigger_hover();
			//	trigger_zoom_in_out();	
		}, 500);
	}, 2000 );*/
});