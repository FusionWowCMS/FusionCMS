'use strict';

function isIE() {
    var userAgent = navigator.userAgent;
    return /MSIE|Trident/.test(userAgent);
}

$(window).on('load', function() {

	/*------------------
		Preloder
	--------------------*/
	$(".loader").fadeOut(); 
	$("#preloder").delay(400).fadeOut("slow");

	/*------------------
		Bootstrap Tooltip
	--------------------*/
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})
})
