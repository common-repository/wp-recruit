( function($) {
	
'use strict';

	$(document).on('click','.eezy-recruit-single-header',function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).closest('.eezy-recruit-single-accordion').find('.eezy-recruit-single-detail').toggleClass('hidden');
	});
	
} )( jQuery );