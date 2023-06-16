// Tooltip

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.length && tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

// Popover
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.length && popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

// Tabs
var tabsTriggerList = [].slice.call(document.querySelectorAll('a[data-bs-toggle="tab"], button[data-bs-toggle="tab"]'))
tabsTriggerList.length && tabsTriggerList.map(function (tabEl) {
	tabEl.addEventListener('shown.bs.tab' , function (e) {
		$(this).parents('.nav-tabs').find('.active').removeClass('active');
		$(this).parents('.nav-pills').find('.active').removeClass('active');
		$(this).addClass('active').parent().addClass('active');
	})
  })

// Bootstrap Datepicker
if (typeof($.fn.datepicker) != 'undefined') {
	$.fn.bootstrapDP = $.fn.datepicker.noConflict();
}

// Simple Sticky Header
if( $('html.simple-sticky-header-enabled').get(0) ) {
	var $window = $(window),
		distance = ( typeof $('html').data('sticky-header-distance') != 'undefined' ? $('html').data('sticky-header-distance') : 100 );

	$window.on('scroll', function(){
		if( $window.scrollTop() > distance ) {
			$('html').addClass('simple-sticky-header-active');
		} else {
			$('html').removeClass('simple-sticky-header-active');
		}
	});
}