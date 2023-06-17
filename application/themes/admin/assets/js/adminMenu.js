/**
 * @package    FusionCMS
 * @subpackage AdminMenu
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */
const AdminMenu = (() => {
    // THIS object
    const self = {};

    // Define AdminMenu selector
    self.selector = {
		menuEq: 'ul[nr="{ID}"]',
    	buttonEq: 'button[nr="{ID}"]'
    };

    // Define AdminMenu attributes
    self.attributes = {};

    // Define AdminMenu classes
    self.classes = {};

    /**
     * Open section
     * @return void
     */
    self.openSection = (menuId) => {
        // Get Button
        let $button       = $(self.selector.buttonEq.replaceAll('{ID}', menuId)),
        	$button_arrow = $button.find('svg[role="img"]');

        // Menu
        let $menu = $button.next(self.selector.menuEq.replaceAll('{ID}', menuId));

        $menu.slideToggle('fast');
        $button.toggleClass('open');
        $button_arrow.toggleClass('rotate-180');
    };

    return self;
})();
