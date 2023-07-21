var MainSlider = {
	SLIDER_ANIMATION_INCOMING: [
		"animate__backInDown",					//1
		"animate__backInUp",							//2
		"animate__backInLeft",						//3
		"animate__backInRight",						//4
		
		"animate__bounceInDown",				//5
		"animate__bounceInUp",					//6
		"animate__bounceInLeft",					//7
		"animate__bounceInRight",				//8
		
		"animate__fadeInDown",					//9
		"animate__fadeInUp",							//10
		"animate__fadeInLeft",						//11
		"animate__fadeInRight",						//12
		
		"animate__fadeInTopLeft",				//13
		"animate__fadeInTopRight",				//14
		"animate__fadeInBottomLeft",		//15
		"animate__fadeInBottomRight",		//16
		
		"animate__fadeInDownBig",				//17
		"animate__fadeInUpBig",					//18
		"animate__fadeInLeftBig",					//19
		"animate__fadeInRightBig",				//20
		
		"animate__rotateInDownLeft",		//21
		"animate__rotateInDownRight",		//22
		"animate__rotateInUpLeft",				//23
		"animate__rotateInUpRight",			//24
		
		"animate__rollIn",									//25
		
		"animate__slideInDown",					//26
		"animate__slideInUp",							//27
		"animate__slideInLeft",						//28
		"animate__slideInRight"						//29
	],

	SLIDER_ANIMATION_OUTGOING: [
		"animate__backOutDown",
		"animate__backOutUp",
		"animate__backOutRight",
		"animate__backOutLeft",
		
		"animate__bounceOutDown",
		"animate__bounceOutUp",
		"animate__bounceOutRight",
		"animate__bounceOutLeft",
		
		"animate__fadeOutDown",
		"animate__fadeOutUp",
		"animate__fadeOutRight",
		"animate__fadeOutLeft",
		
		"animate__fadeOutBottomRight",
		"animate__fadeOutBottomLeft",
		"animate__fadeOutTopRight",
		"animate__fadeOutTopLeft",
		
		"animate__fadeOutDownBig",
		"animate__fadeOutUpBig",
		"animate__fadeOutRightBig",
		"animate__fadeOutLeftBig",
		
		"animate__rotateOutDownLeft",
		"animate__rotateOutDownRight",
		"animate__rotateOutUpLeft",
		"animate__rotateOutUpRight",
		
		"animate__rollOut",
		
		"animate__slideOutDown",
		"animate__slideOutUp",
		"animate__slideOutRight",
		"animate__slideOutLeft",
	]
};

$(window).on('load', function() {
	var $slider = $('.main-slider');
	var SLIDER_TIMEOUT = Config.Slider.Interval;
	var SLIDER_ANIMATION_OUTGOING = MainSlider.SLIDER_ANIMATION_OUTGOING;
	var SLIDER_ANIMATION_INCOMING = MainSlider.SLIDER_ANIMATION_INCOMING;
	
	if(Config.Slider.effect != "") {
		SLIDER_ANIMATION_OUTGOING = SLIDER_ANIMATION_OUTGOING[(Config.Slider.effect - 1)];
		SLIDER_ANIMATION_INCOMING = SLIDER_ANIMATION_INCOMING[(Config.Slider.effect - 1)];
	}
	
	$slider.owlCarousel({
		items: 1,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: SLIDER_TIMEOUT,
		animateOut: SLIDER_ANIMATION_OUTGOING,
		animateIn: SLIDER_ANIMATION_INCOMING,
		loop: false,
		mouseDrag: false,
		touchDrag: false,
		pullDrag: false
	});
});