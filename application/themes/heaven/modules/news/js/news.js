/**
 * @package    News
 * @subpackage News
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

const News = (() => {
    // THIS object
    const self = {};

    // Define news selector
    self.Selector = {
        carousel: '.page-news [owl]'
    };

    // Define news attribute
    self.Attribute = {};

    /**
     * Fire carousel
     * @return void
     */
    self.fireCarousel = () => {
        $(self.Selector.carousel).owlCarousel({
            'nav': false,
            'dots': true,
            'loop': true,
            'items': 1,
        });
    };

    /**
     * Fire whole thing
     * @return void
     */
    self.init = () => {
        self.fireCarousel();
    };

    return self;
})();

// Call News when content is loaded
(document.readyState !== 'loading') ? News.init() : document.addEventListener('DOMContentLoaded', function() { News.init(); });
