(function($){
	'use strict';
	$(window).on('load', function () {
		if ($(".preloader").length > 0)
		{
			$(".preloader").fadeOut("slow");
		}
	});
})(jQuery);

(function($) {
	'use strict';

	var $document,
		idleTime;

	$document = $(document);

	$(function() {
		$.idleTimer( 900000 );

		$document.on( 'idle.idleTimer', function() {
			$.post(Config.URL + 'admin/destroySession', {csrf_token_name: Config.CSRF}, function(data)
			{});
			window.location.replace(Config.URL + 'admin');
		});
	});

}).apply(this, [jQuery]);

var Custom = {
	destroySession: function()
	{
		$.post(Config.URL + 'admin/destroySession', {csrf_token_name: Config.CSRF}, function(data)
		{});
	},
}

var Login = {
	send: function(form)
	{
		var values = {csrf_token_name: Config.CSRF, send:"1"};

		$(form).find("input[type='password']").each(function()
		{
			values[$(this).attr("id")] = $(this).val();
		});
		console.log(values);
		$.post(Config.URL + "admin", values, function(data)
		{
			console.log(data);
			switch(data)
			{
				case "key":
					$("#security_code").addClass("border border-danger");
				break;

				case "permission":
					$("#security_code").attr("disabled", "disabled").removeClass("border border-danger");

					alert("You do not have permission to access the admin panel (assign permission: [view, admin])");
				break;

				case "welcome":
					$("#security_code").attr("disabled", "disabled").removeClass("border border-danger");
					console.log(data);
					
					window.location.reload(true);
				break;

				default:
					console.log(data);
				break;
			}
		}).fail(function(e) {
			console.log(e);
		  });
	}
}

/**
 * @package    FusionCMS
 * @subpackage AdminCustomJS
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */
const AdminCustomJS = (() => {
    // THIS object
    const self = {};

    // Define AdminCustomJS selector
    self.selector = {
        // Sidebar
        sidebar: '[__sidebar__]',
        sidebarToggler: '[__sidebartoggler__]',
        sidebarTogglerMobile: '[__sidebartogglermobile__]',

        // Mainbar
        mainbar: '[__mainbar__]'
    };

    // Define AdminCustomJS attributes
    self.attributes = {};

    // Define AdminCustomJS classes
    self.classes = {};

    /**
     * Initialize actions
     * @return void
     */
    self.init = () => {
        self.sidebar();

        const _toggleSidebar = (() => {
			$(document.body).on('click', self.selector.sidebarToggler, function()
            {
                self.toggleSidebar();
            });

            $(document.body).on('click', self.selector.sidebarTogglerMobile, function()
            {
                self.toggleSidebar();
            });
        })();
    };

    /**
     * Sidebar
     * @return void
     */
    self.sidebar = () => {
        const handleSidebar = () => {
            // Get elements
            let $sidebarToggler = $(self.selector.sidebarToggler);

            // No need to go any further
            if(!$sidebarToggler.length)
                return;

            // is closed?
            let isClosed = $sidebarToggler.hasClass('closed');

            // Get window width
            let width = document.body.clientWidth;

            if(isClosed)
                return;

            if(width > 1025)
                return;

            $sidebarToggler.trigger('click');
        };

        addEventListener('load', (event) => {handleSidebar();});
        addEventListener('resize', (event) => {handleSidebar();});
    };

    /**
     * Toggle sidebar
     * @return void
     */
    self.toggleSidebar = () => {
        // Get elements
        let $mainbar                  = $(self.selector.mainbar),
            $sidebar                  = $(self.selector.sidebar),
            $sidebarToggler           = $(self.selector.sidebarToggler),
            $sidebarToggler_div       = $sidebarToggler.find('div'),
            $sidebarToggler_div_span1 = $sidebarToggler_div.find('span:nth-child(1)'),
            $sidebarToggler_div_span2 = $sidebarToggler_div.find('span:nth-child(2)'),
            $sidebarToggler_div_span3 = $sidebarToggler_div.find('span:nth-child(3)');

        // No need to go any further
        if(!$mainbar.length || !$sidebar.length || !$sidebarToggler.length || !$sidebarToggler_div.length || !$sidebarToggler_div_span1.length || !$sidebarToggler_div_span2.length || !$sidebarToggler_div_span3.length)
            return;

        // Toggle button class
        $sidebarToggler.toggleClass('closed');

        // Toggle button DIV class
        $sidebarToggler_div.toggleClass('scale-90');

        // is closed?
        let isClosed = $sidebarToggler.hasClass('closed');

        // Toggle button SPAN classes
        if(isClosed)
        {
            $sidebarToggler_div_span1.addClass('top-0.5').removeClass('-rotate-45 rtl:rotate-45 max-w-[75%] top-1');
            $sidebarToggler_div_span2.removeClass('opacity-0 translate-x-4');
            $sidebarToggler_div_span3.addClass('bottom-0').removeClass('rotate-45 rtl:-rotate-45 max-w-[75%] bottom-1');
        }
        else
        {
            $sidebarToggler_div_span1.removeClass('top-0.5').addClass('-rotate-45 rtl:rotate-45 max-w-[75%] top-1');
            $sidebarToggler_div_span2.addClass('opacity-0 translate-x-4');
            $sidebarToggler_div_span3.removeClass('bottom-0').addClass('rotate-45 rtl:-rotate-45 max-w-[75%] bottom-1');
        }

        // Toggle sidebar classes
        $sidebar.toggleClass('rtl:translate-x-[calc(100%_+_80px)] translate-x-[calc(-100%_-_80px)]');

        // Toggle mainbar classes
        if(isClosed)
        {
            $mainbar.addClass('xl:max-w-100% xl:ms-[0px]').removeClass('xl:max-w-[calc(100%_-_280px)] xl:ms-[280px]');
        }
        else
        {
            $mainbar.addClass('xl:max-w-[calc(100%_-_280px)] xl:ms-[280px]').removeClass('xl:max-w-100% xl:ms-[0px]');
            
        }
    };

    return self;
})();

// Call AdminCustomJS when content is loaded
(document.readyState !== 'loading') ? AdminCustomJS.init() : document.addEventListener('DOMContentLoaded', function() { AdminCustomJS.init(); });
