"use strict";
jQuery(document).ready(function($) {
	/*hiding display_meta_box_heading() function*/
	$('.showhide').hide();
	if ($('.hideall-trigger').is(':checked')) {
		$('.hideall').hide();
	} 
	if ($('.showhide-trigger').is(':checked')) {
		$('.showhide').show(); 
	}

	$('.showhide-trigger').click(function() {
		if ($('.showhide-trigger').is(':checked')) {
			$('.showhide').show(); 
		}
		else {
			$('.showhide').hide();
		}
	})
	$('.hideall-trigger').click(function() {
		if ($('.showhide-trigger').is(':checked')) {
			$('.showhide-trigger').prop('checked', false); 
		}
		if ($('.hideall-trigger').is(':checked')) {
			$('.hideall').hide();
		}  else {
			$('.hideall').show();
			$('.showhide').hide();
		}
	})
/*
	$('.anps_select2').select2({
	  containerCssClass: 'anps_select2',
	  dropdownCssClass: 'anps_select2'
	});

	$(document).on('widget-updated widget-added', function(){
		$('.anps_select2').select2('destroy'); 
	    $('.anps_select2').select2({
		  containerCssClass: 'anps_select2',
		  dropdownCssClass: 'anps_select2'
		});
	});
*/
})

