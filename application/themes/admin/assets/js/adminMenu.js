var AdminMenu = {
	openSection: function(nr) {
		$('.admin_section').slideUp(300);
		$('.admin_section_icon[nr="'+ nr +'"]').removeClass('nav-expanded');
			
		if($('.admin_section[nr="'+ nr +'"]').css('display') != 'block') {
			$('.admin_section[nr="'+ nr +'"]').slideDown(300);
			$('.admin_section_icon[nr="'+ nr +'"]').addClass('nav-expanded');
		}
	}
}