jQuery(document).ready(function( $ ) {

	$(document).ready(function() {
		$('.page-id-12 .entry-content img').mouseenter(function() {
		    $(this).animate({
		      "max-height":"400px",
		      "max-width":"600px"
		    });
		  });


		$('.page-id-12 .entry-content img').mouseleave(function() {
			$(this).animate({
			  "max-height":"200px",
		      "max-width":"600px"
			});
	  	});		
	});
});





// $(".entry-content img").mouseenter(function() {
// 		  $(this).css({
			// "width":"100%",
			// "height":"auto"
		 //  });
// 		});  
// 		$(".entry-content img").mouseleave(function() {
// 		  $(this).css();