/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */
// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {
$(window).load(function() {
   function update_header_position() {
      if ($('#admin-menu').length > 0) {
        $('#header').css('margin-top', $('#admin-menu').height());
      }
    }
   // Footer element to be made sticky
   var footer = '.footer-wrapper';
   // Get footer's top margin
   var footerMargin = parseInt($(footer).css('margin-top'));
   function fixFooter() {
	 $admin_height = 0;
	 if ($('#admin-menu').length > 0) {
	    //$('#header').css('margin-top', $('#admin-menu').height());
		 $admin_height = $('#admin-menu').height();
		 console.log($admin_height);
	 }
	        // Reset margin
     $(footer).css('margin-top', footerMargin + 'px');
    
     // Get window height
     var windowHeight = $(window).height();
    
     // Get bottom of footer
     var footerTop = $(footer).offset().top;
     var footerHeight = $(footer).outerHeight(true) - $admin_height; // Includes any margins
     var footerBottom = footerTop + footerHeight;
    
     if (windowHeight > footerBottom) {
       // Get difference between window height and bottom of footer
       var difference = windowHeight - (footerBottom);
    
       // Add difference to footer's top margin
       var newMargin = footerMargin + difference;
       $(footer).css('margin-top', newMargin + 'px');
     }
     $(footer).fadeTo( "slow" , 1);
   }
   fixFooter();
   
   
   $(window).resize(function() {
     update_header_position();
     fixFooter();
   });
   
   $(window).trigger('resize');
});

})(jQuery, Drupal, this, this.document);
