<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks, Elementor
 * @copyright 2019-2024 WebshopWorks.com & Elementor.com
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace CE;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Elementor divider widget.
 *
 * Elementor widget that displays a line that divides different elements in the
 * page.
 *
 * @since 1.0.0
 */
class WidgetDivider extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/85-widgets/basic-widgets/298-divider-widget';

    /**
     * Get widget name.
     *
     * Retrieve divider widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'divider';
    }

    /**
     * Get widget title.
     *
     * Retrieve divider widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Divider');
    }

    /**
     * Get widget icon.
     *
     * Retrieve divider widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-divider';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the divider widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     *
     * @return array Widget categories
     */
    public function getCategories()
    {
        return ['basic'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     *
     * @return array Widget keywords
     */
    public function getKeywords()
    {
        return ['divider', 'hr', 'line', 'border'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    private static function getAdditionalStyles()
    {
        static $additional_styles = null;

        if (null !== $additional_styles) {
            return $additional_styles;
        }
        $additional_styles = [];
        /*
         * Additional Styles.
         *
         * Filters the styles used by Elementor to add additional divider styles.
         *
         * @since 2.7.0
         *
         * @param array $additional_styles Additional Elementor divider styles
         */
        $additional_styles = apply_filters('elementor/divider/styles/additional_styles', $additional_styles);

        return $additional_styles;
    }

    private function getSeparatorStyles()
    {
        return array_merge(
            self::getAdditionalStyles(),
            [
                'curly' => [
                    'label' => _x('Curly', 'shapes'),
                    'shape' => '<path d="M0,21c3.3,0,8.3-.9,15.7-7.1c6.6-5.4,4.4-9.3,2.4-10.3c-3.4-1.8-7.7,1.3-7.3,' .
                    '8.8C11.2,20,17.1,21,24,21"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'line',
                ],
                'curved' => [
                    'label' => _x('Curved', 'shapes'),
                    'shape' => '<path d="M0,6c6,0,6,13,12,13S18,6,24,6"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'line',
                ],
                'multiple' => [
                    'label' => _x('Multiple', 'shapes'),
                    'shape' => '<path d="M24,8v12H0V8H24z M24,4v1H0V4H24z"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'pattern',
                ],
                'slashes' => [
                    'label' => _x('Slashes', 'shapes'),
                    'shape' => '<g transform="translate(-12, 0)">' .
                    '<path d="M28,0L10,18"/><path d="M18,0L0,18"/><path d="M48,0L30,18"/><path d="M38,0L20,18"/>' .
                    '</g>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'view_box' => '0 0 20 16',
                    'group' => 'line',
                ],
                'squared' => [
                    'label' => _x('Squared', 'shapes'),
                    'shape' => '<polyline points="0,6 6,6 6,18 18,18 18,6 24,6"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'line',
                ],
                'wavy' => [
                    'label' => _x('Wavy', 'shapes'),
                    'shape' => '<path d="M0,6c6,0,.9,11.1,6.9,11.1S18,6,24,6"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'line',
                ],
                'zigzag' => [
                    'label' => _x('Zigzag', 'shapes'),
                    'shape' => '<polyline points="0,18 12,6 24,18"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'line',
                ],
                'arrows' => [
                    'label' => _x('Arrows', 'shapes'),
                    'shape' => '<path d="M14.2,4c.3,0,.5,.1,.7,.3l7.9,7.2c.2,.2,.3,.4,.3,.7s-.1,.5-.3,.7l-7.9,7.2' .
                    'c-.2,.2-.4,.3-.7,.3s-.5-.1-.7-.3s-.3-.4-.3-.7l0-2.9l-11.5,0c-.4,0-.7-.3-.7-.7V9.4C1,9,1.3,' .
                    '8.7,1.7,8.7l11.5,0l0-3.6c0-.3,.1-.5,.3-.7S13.9,4,14.2,4z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => true,
                    'round' => true,
                    'group' => 'pattern',
                ],
                'pluses' => [
                    'label' => _x('Pluses', 'shapes'),
                    'shape' => '<path d="M21.4,9.6h-7.1V2.6c0-.9-.7-1.6-1.6-1.6h-1.6c-.9,0-1.6,.7-1.6,1.6v7.1H2.6' .
                    'C1.7,9.6,1,10.3,1,11.2v1.6c0,.9,.7,1.6,1.6,1.6h7.1v7.1c0,.9,.7,1.6,1.6,1.6h1.6c.9,0,1.6-.7,' .
                    '1.6-1.6v-7.1h7.1c.9,0,1.6-.7,1.6-1.6v-1.6C23,10.3,22.3,9.6,21.4,9.6z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'pattern',
                ],
                'rhombus' => [
                    'label' => _x('Rhombus', 'shapes'),
                    'shape' => '<path d="M12.7,2.3c-.4-.4-1.1-.4-1.5,0l-8,9.1c-.3,.4-.3,.9,0,1.2l8,9.1c.4,.4,1.1,.4,' .
                    '1.5,0l8-9.1c.3-.4,.3-.9,0-1.2L12.7,2.3z"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'pattern',
                ],
                'parallelogram' => [
                    'label' => _x('Parallelogram', 'shapes'),
                    'shape' => '<polygon points="9.4,2 24,2 14.6,21.6 0,21.6"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => false,
                    'group' => 'pattern',
                ],
                'rectangles' => [
                    'label' => _x('Rectangles', 'shapes'),
                    'shape' => '<rect x="15" y="0" width="30" height="30"/>',
                    'preserve_aspect_ratio' => false,
                    'supports_amount' => true,
                    'round' => true,
                    'group' => 'pattern',
                    'view_box' => '0 0 60 30',
                ],
                'dots_tribal' => [
                    'label' => _x('Dots', 'shapes'),
                    'shape' => '<path d="M3,10.2c2.6,0,2.6,2,2.6,3.2S4.4,16.5,3,16.5s-3-1.4-3-3.2S.4,10.2,3,10.2z' .
                    'M18.8,10.2c1.7,0,3.2,1.4,3.2,3.2s-1.4,3.2-3.2,3.2c-1.7,0-3.2-1.4-3.2-3.2S17,10.2,18.8,10.2z' .
                    'M34.6,10.2c1.5,0,2.6,1.4,2.6,3.2s-.5,3.2-1.9,3.2c-1.5,0-3.4-1.4-3.4-3.2S33.1,10.2,34.6,10.2z' .
                    'M50.5,10.2c1.7,0,3.2,1.4,3.2,3.2s-1.4,3.2-3.2,3.2c-1.7,0-3.3-.9-3.3-2.6S48.7,10.2,50.5,10.2z' .
                    'M66.2,10.2c1.5,0,3.4,1.4,3.4,3.2s-1.9,3.2-3.4,3.2c-1.5,0-2.6-.4-2.6-2.1S64.8,10.2,66.2,10.2z' .
                    'M82.2,10.2c1.7,.8,2.6,1.4,2.6,3.2s-.1,3.2-1.6,3.2c-1.5,0-3.7-1.4-3.7-3.2S80.5,9.4,82.2,10.2z' .
                    'M98.6,10.2c1.5,0,2.6,.4,2.6,2.1s-1.2,4.2-2.6,4.2c-1.5,0-3.7-.4-3.7-2.1S97.1,10.2,98.6,10.2z' .
                    'M113.4,10.2c1.2,0,2.2,.9,2.2,3.2s-.1,3.2-1.3,3.2s-3.1-1.4-3.1-3.2S112.2,10.2,113.4,10.2z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 126 26',
                ],
                'trees_2_tribal' => [
                    'label' => _x('Fir Tree', 'shapes'),
                    'shape' => '<path d="M111.9,18.3v3.4H109v-3.4H111.9z M90.8,18.3v3.4H88v-3.4H90.8z M69.8,18.3v3.4' .
                    'h-2.9v-3.4H69.8z M48.8,18.3v3.4h-2.9v-3.4H48.8z M27.7,18.3v3.4h-2.9v-3.4H27.7z M6.7,18.3v3.4' .
                    'H3.8v-3.4H6.7z M46.4,4l4.3,4.8l-1.8,0l3.5,4.4l-2.2-.1l3,3.3l-11,.4l3.6-3.8l-2.9-.1l3.1-4.2' .
                    'l-1.9,0L46.4,4z M111.4,4l2.4,4.8l-1.8,0l3.5,4.4l-2.5-.1l3.3,3.3h-11l3.1-3.4l-2.5-.1l3.1-4.2' .
                    'l-1.9,0L111.4,4z M89.9,4l2.9,4.8l-1.9,0l3.2,4.2l-2.5,0l3.5,3.5l-11-.4l3-3.1l-2.4,0L88,8.8l' .
                    '-1.9,0L89.9,4z M68.6,4l3,4.4l-1.9,.1l3.4,4.1l-2.7,.1l3.8,3.7H63.8l2.9-3.6l-2.9,.1L67,8.7l-2,' .
                    '.1L68.6,4z M26.5,4l3,4.4l-1.9,.1l3.7,4.7l-2.5-.1l3.3,3.3H21l3.1-3.4l-2.5-.1l3.2-4.3l-2,.1L' .
                    '26.5,4z M4.9,4l3.7,4.8l-1.5,0l3.1,4.2L7.6,13l3.4,3.4H0l3-3.3l-2.3,.1l3.5-4.4l-2.3,0L4.9,4z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 126 26',
                ],
                'rounds_tribal' => [
                    'label' => _x('Half Rounds', 'shapes'),
                    'shape' => '<path d="M11.9,15.9L11.9,15.9L0,16c-.2-3.7,1.5-5.7,4.9-6C10,9.6,12.4,14.2,11.9,15.9z' .
                    'M26.9,15.9L26.9,15.9L15,16c.5-3.7,2.5-5.7,5.9-6C26,9.6,27.4,14.2,26.9,15.9z M37.1,10c3.4,.3,' .
                    '5.1,2.3,4.9,6H30.1C29.5,14.4,31.9,9.6,37.1,10z M57,15.9L57,15.9L45,16c0-3.4,1.6-5.4,4.9-5.9' .
                    'C54.8,9.3,57.4,14.2,57,15.9z M71.9,15.9L71.9,15.9L60,16c-.2-3.7,1.5-5.7,4.9-6C70,9.6,72.4,' .
                    '14.2,71.9,15.9z M82.2,10c3.4,.3,5,2.3,4.8,6H75.3C74,13,77.1,9.6,82.2,10zM101.9,15.9L101.9,' .
                    '15.9L90,16c-.2-3.7,1.5-5.7,4.9-6C100,9.6,102.4,14.2,101.9,15.9z M112.1,10.1c2.7,.5,4.3,2.5,' .
                    '4.9,5.9h-11.9l0,0C104.5,14.4,108,9.3,112.1,10.1z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 120 26',
                ],
                'leaves_tribal' => [
                    'label' => _x('Leaves', 'shapes'),
                    'shape' => '<path d="M3,1.5C5,4.9,6,8.8,6,13s-1.7,8.1-5,11.5C.3,21.1,0,17.2,0,13S1,4.9,3,1.5z' .
                    'M16,1.5c2,3.4,3,7.3,3,11.5s-1,8.1-3,11.5c-2-4.1-3-8.3-3-12.5S14,4.3,16,1.5z M29,1.5c2,4.8,3,' .
                    '9.3,3,13.5s-1,7.4-3,9.5c-2-3.4-3-7.3-3-11.5S27,4.9,29,1.5z M41.1,1.5C43.7,4.9,45,8.8,45,13' .
                    's-1,8.1-3,11.5c-2-3.4-3-7.3-3-11.5S39.7,4.9,41.1,1.5zM55,1.5c2,2.8,3,6.3,3,10.5s-1.3,8.4-4,' .
                    '12.5c-1.3-3.4-2-7.3-2-11.5S53,4.9,55,1.5z M68,1.5c2,3.4,3,7.3,3,11.5s-.7,8.1-2,11.5c-2.7-4.8' .
                    '-4-9.3-4-13.5S66,3.6,68,1.5z M82,1.5c1.3,4.8,2,9.3,2,13.5s-1,7.4-3,9.5c-2-3.4-3-7.3-3-11.5' .
                    'S79.3,4.9,82,1.5z M94,1.5c2,3.4,3,7.3,3,11.5s-1.3,8.1-4,11.5c-1.3-1.4-2-4.3-2-8.5S92,6.9,94,' .
                    '1.5z M107,1.5c2,2.1,3,5.3,3,9.5s-.7,8.7-2,13.5c-2.7-3.4-4-7.3-4-11.5S105,4.9,107,1.5z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 117 26',
                ],
                'stripes_tribal' => [
                    'label' => _x('Stripes', 'shapes'),
                    'shape' => '<path d="M54,1.6V26h-9V2.5L54,1.6z M69,1.6v23.3L60,26V1.6H69z M24,1.6v23.5l-9-.6V1.6' .
                    'H24z M30,0l9,.7v24.5h-9V0z M9,2.5v22H0V3.7L9,2.5z M75,1.6l9,.9v22h-9V1.6z M99,2.7v21.7h-9' .
                    'V3.8L99,2.7z M114,3.8v20.7l-9-.5V3.8L114,3.8z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 120 26',
                ],
                'squares_tribal' => [
                    'label' => _x('Squares', 'shapes'),
                    'shape' => '<path d="M46.8,7.8v11.5L36,18.6V7.8H46.8z M82.4,7.8L84,18.6l-12,.7L70.4,7.8H82.4z' .
                    'M0,7.8l12,.9v9.9H1.3L0,7.8z M30,7.8v10.8H19L18,7.8H30z M63.7,7.8L66,18.6H54V9.5L63.7,7.8z' .
                    'M89.8,7L102,7.8v10.8H91.2L89.8,7zM108,7.8l12,.9v8.9l-12,1V7.8z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 126 26',
                ],
                'trees_tribal' => [
                    'label' => _x('Trees', 'shapes'),
                    'shape' => '<path d="M6.4,2l4.2,5.7H7.7v2.7l3.8,5.2l-3.8,0v7.8H4.8v-7.8H0l4.8-5.2V7.7H1.1L6.4,2z' .
                    'M25.6,2L31,7.7h-3.7v2.7l4.8,5.2h-4.8v7.8h-2.8v-7.8l-3.8,0l3.8-5.2V7.7h-2.9L25.6,2z' .
                    'M47.5,2l4.2,5.7h-3.3v2.7l3.8,5.2l-3.8,0l.4,7.8h-2.8v-7.8H41l4.8-5.2V7.7h-3.7L47.5,2z' .
                    'M66.2,2l5.4,5.7h-3.7v2.7l4.8,5.2h-4.8v7.8H65v-7.8l-3.8,0l3.8-5.2V7.7h-2.9L66.2,2z' .
                    'M87.4,2l4.8,5.7h-2.9v3.1l3.8,4.8l-3.8,0v7.8h-2.8v-7.8h-4.8l4.8-4.8V7.7h-3.7L87.4,2z' .
                    'M107.3,2l5.4,5.7h-3.7v2.7l4.8,5.2h-4.8v7.8H106v-7.8l-3.8,0l3.8-5.2V7.7h-2.9L107.3,2z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 123 26',
                ],
                'planes_tribal' => [
                    'label' => _x('Tribal', 'shapes'),
                    'shape' => '<path d="M29.6,10.3l2.1,2.2l-3.6,3.3h7v2.9h-7l3.6,3.5l-2.1,1.7l-5.2-5.2h-5.8v-2.9h5.8' .
                    'L29.6,10.3z M70.9,9.6l2.1,1.7l-3.6,3.5h7v2.9h-7l3.6,3.3l-2.1,2.2l-5.2-5.5h-5.8v-2.9h5.8L' .
                    '70.9,9.6z M111.5,9.6l2.1,1.7l-3.6,3.5h7v2.9h-7l3.6,3.3l-2.1,2.2l-5.2-5.5h-5.8v-2.9h5.8L' .
                    '111.5,9.6z M50.2,2.7l2.1,1.7l-3.6,3.5h7v2.9h-7l3.6,3.3l-2.1,2.2L45,10.7h-5.8V7.9H45L50.2,' .
                    '2.7z M11,2l2.1,1.7L9.6,7.2h7V10h-7l3.6,3.3L11,15.5L5.8,10H0V7.2h5.8L11,2z M91.5,2l2.1,2.2l' .
                    '-3.6,3.3h7v2.9h-7l3.6,3.5l-2.1,1.7l-5.2-5.2h-5.8V7.5h5.8L91.5,2z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 121 26',
                ],
                'x_tribal' => [
                    'label' => _x('X', 'shapes'),
                    'shape' => '<path d="M10.7,6l2.5,2.6l-4,4.3l4,5.4l-2.5,1.9l-4.5-5.2l-3.9,4.2L.7,17L4,13.1L0,8.6' .
                    'l2.3-1.3l3.9,3.9L10.7,6z M23.9,6.6l4.2,4.5L32,7.2l2.3,1.3l-4,4.5l3.2,3.9L32,19.1l-3.9-3.3' .
                    'l-4.5,4.3l-2.5-1.9l4.4-5.1l-4.2-3.9L23.9,6.6zM73.5,6L76,8.6l-4,4.3l4,5.4l-2.5,1.9l-4.5-5.2' .
                    'l-3.9,4.2L63.5,17l4.1-4.7L63.5,8l2.3-1.3l4.1,3.6L73.5,6z M94,6l2.5,2.6l-4,4.3l4,5.4L94,20.1' .
                    'l-3.9-5l-3.9,4.2L84,17l3.2-3.9L84,8.6l2.3-1.3l3.2,3.9L94,6z M106.9,6l4.5,5.1l3.9-3.9l2.3,1.3' .
                    'l-4,4.5l3.2,3.9l-1.6,2.1l-3.9-4.2l-4.5,5.2l-2.5-1.9l4-5.4l-4-4.3L106.9,6z M53.1,6l2.5,2.6' .
                    'l-4,4.3l4,4.6l-2.5,1.9l-4.5-4.5l-3.5,4.5L43.1,17l3.2-3.9l-4-4.5l2.3-1.3l3.9,3.9L53.1,6z"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 126 26',
                ],
                'zigzag_tribal' => [
                    'label' => _x('Zigzag', 'shapes'),
                    'shape' => '<polygon points="0,14.4 0,21 11.5,12.4 21.3,20 30.4,11.1 40.3,20 51,12.4 60.6,20 ' .
                    '69.6,11.1 79.3,20 90.1,12.4 99.6,20 109.7,11.1 120,21 120,14.4 109.7,5 99.6,13 90.1,5 ' .
                    '79.3,14.5 71,5.7 60.6,12.4 51,5 40.3,14.5 31.1,5 21.3,13 11.5,5"/>',
                    'preserve_aspect_ratio' => true,
                    'supports_amount' => false,
                    'round' => false,
                    'group' => 'tribal',
                    'view_box' => '0 0 120 26',
                ],
            ]
        );
    }

    private function filterStylesBy($array, $key, $value)
    {
        return array_filter($array, function ($style) use ($key, $value) {
            return $value === $style[$key];
        });
    }

    private function getOptionsByGroups($styles, $group = false)
    {
        $groups = [
            'line' => [
                'label' => __('Line'),
                'options' => [
                    'solid' => __('Solid'),
                    'double' => __('Double'),
                    'dotted' => __('Dotted'),
                    'dashed' => __('Dashed'),
                ],
            ],
        ];
        foreach ($styles as $key => $style) {
            if (!isset($groups[$style['group']])) {
                $groups[$style['group']] = [
                    'label' => ucwords(str_replace('_', '', $style['group'])),
                    'options' => [],
                ];
            }
            $groups[$style['group']]['options'][$key] = $style['label'];
        }

        if ($group && isset($groups[$group])) {
            return $groups[$group];
        }

        return $groups;
    }

    /**
     * Register divider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $styles = $this->getSeparatorStyles();

        $this->startControlsSection(
            'section_divider',
            [
                'label' => __('Divider'),
            ]
        );

        $this->addControl(
            'style',
            [
                'label' => __('Style'),
                'type' => ControlsManager::SELECT,
                'groups' => array_values($this->getOptionsByGroups($styles)),
                'render_type' => 'template',
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-border-style: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'separator_type',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => 'pattern',
                'prefix_class' => 'elementor-widget-divider--separator-type-',
                'condition' => [
                    'style!' => [
                        '',
                        'solid',
                        'double',
                        'dotted',
                        'dashed',
                    ],
                ],
                'render_type' => 'template',
            ]
        );

        $this->addControl(
            'pattern_spacing_flag',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => 'no-spacing',
                'prefix_class' => 'elementor-widget-divider--',
                'condition' => [
                    'style' => array_keys($this->filterStylesBy($styles, 'supports_amount', false)),
                ],
                'render_type' => 'template',
            ]
        );

        $this->addControl(
            'pattern_round_flag',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => 'bg-round',
                'prefix_class' => 'elementor-widget-divider--',
                'condition' => [
                    'style' => array_keys($this->filterStylesBy($styles, 'round', true)),
                ],
            ]
        );

        $this->addResponsiveControl(
            'width',
            [
                'label' => __('Width'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-divider-separator' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addResponsiveControl(
            'align',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-divider' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .elementor-divider-separator' => 'margin: 0 auto; margin-{{VALUE}}: 0',
                ],
            ]
        );

        $this->addControl(
            'look',
            [
                'label' => __('Add Element'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'line' => [
                        'title' => __('None'),
                        'icon' => 'eicon-ban',
                    ],
                    'line_text' => [
                        'title' => __('Text'),
                        'icon' => 'eicon-t-letter-bold',
                    ],
                    'line_icon' => [
                        'title' => __('Icon'),
                        'icon' => 'eicon-star',
                    ],
                ],
                'separator' => 'before',
                'prefix_class' => 'elementor-widget-divider--view-',
                'render_type' => 'template',
            ]
        );

        $this->addControl(
            'view',
            [
                'label' => __('View'),
                'type' => ControlsManager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->addControl(
            'text',
            [
                'label' => __('Text'),
                'type' => ControlsManager::TEXT,
                'condition' => [
                    'look' => 'line_text',
                ],
                'default' => __('Divider'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->addControl(
            'icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'look' => 'line_icon',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_divider_style',
            [
                'label' => __('Divider'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'style!' => 'none',
                ],
            ]
        );

        $this->addControl(
            'color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ],
                'default' => '#000',
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-border-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'weight',
            [
                'label' => __('Weight'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'render_type' => 'template',
                'condition' => [
                    'style' => array_keys($this->getOptionsByGroups($styles, 'line')['options']),
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-border-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'pattern_height',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-pattern-height: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'step' => 0.1,
                    ],
                ],
                'condition' => [
                    'style!' => [
                        '',
                        'solid',
                        'double',
                        'dotted',
                        'dashed',
                    ],
                ],
            ]
        );

        $this->addControl(
            'pattern_size',
            [
                'label' => __('Amount'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['%', 'px'],
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-pattern-size: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'step' => 0.1,
                    ],
                    '%' => [
                        'step' => 0.01,
                    ],
                ],
                'condition' => [
                    'style!' => array_merge(array_keys($this->filterStylesBy($styles, 'supports_amount', false)), [
                        '',
                        'solid',
                        'double',
                        'dotted',
                        'dashed',
                    ]),
                ],
            ]
        );

        $this->addResponsiveControl(
            'gap',
            [
                'label' => __('Gap'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-divider' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_text_style',
            [
                'label' => __('Text'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'look' => 'line_text',
                ],
            ]
        );

        $this->addControl(
            'text_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-divider__text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-divider__text',
            ]
        );

        $this->addControl(
            'text_align',
            [
                'label' => __('Position'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'prefix_class' => 'elementor-widget-divider--element-align-',
            ]
        );

        $this->addResponsiveControl(
            'text_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-element-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_icon_style',
            [
                'label' => __('Icon'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'look' => 'line_icon',
                ],
            ]
        );

        $this->addControl(
            'icon_view',
            [
                'label' => __('View'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'default' => __('Default'),
                    'stacked' => __('Stacked'),
                    'framed' => __('Framed'),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-',
            ]
        );

        $this->addResponsiveControl(
            'icon_size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-icon-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'icon_padding',
            [
                'label' => __('Padding'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'condition' => [
                    'icon_view!' => 'default',
                ],
            ]
        );

        $this->addControl(
            'primary_color',
            [
                'label' => __('Primary Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ],
            ]
        );

        $this->addControl(
            'secondary_color',
            [
                'label' => __('Secondary Color'),
                'type' => ControlsManager::COLOR,
                'condition' => [
                    'icon_view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'icon_align',
            [
                'label' => __('Position'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'prefix_class' => 'elementor-widget-divider--element-align-',
            ]
        );

        $this->addResponsiveControl(
            'icon_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--divider-element-spacing: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addResponsiveControl(
            'rotate',
            [
                'label' => __('Rotate'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['deg'],
                'default' => [
                    'size' => 0,
                    'unit' => 'deg',
                ],
                'tablet_default' => [
                    'unit' => 'deg',
                ],
                'mobile_default' => [
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}})',
                ],
            ]
        );

        $this->addControl(
            'icon_border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'icon_view' => 'framed',
                ],
            ]
        );

        $this->addControl(
            'border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'icon_view!' => 'default',
                ],
            ]
        );

        $this->endControlsSection();
    }

    /**
     * Build SVG
     *
     * Build SVG element markup based on the widgets settings.
     *
     * @return string - An SVG element
     *
     * @since  2.7.0
     */
    private function buildSvg()
    {
        $settings = $this->getSettingsForDisplay();

        if ('pattern' !== $settings['separator_type'] || empty($settings['style'])) {
            return '';
        }

        $svg_shapes = $this->getSeparatorStyles();

        $selected_pattern = $svg_shapes[$settings['style']];
        $preserve_aspect_ratio = $selected_pattern['preserve_aspect_ratio'] ? 'xMidYMid meet' : 'none';
        $view_box = isset($selected_pattern['view_box']) ? $selected_pattern['view_box'] : '0 0 24 24';

        $attr = [
            'preserveAspectRatio' => $preserve_aspect_ratio,
            'overflow' => 'visible',
            'height' => '100%',
            'viewBox' => $view_box,
        ];

        if ('line' !== $selected_pattern['group']) {
            $attr['fill'] = $settings['color'];
            $attr['stroke'] = 'none';
        } else {
            $attr['stroke'] = $settings['color'];
            $attr['stroke-width'] = $settings['weight']['size'];
            $attr['fill'] = 'none';
            $attr['stroke-linecap'] = 'square';
            $attr['stroke-miterlimit'] = '10';
        }

        $this->addRenderAttribute('svg', $attr);

        $pattern_attribute_string = $this->getRenderAttributeString('svg');
        $shape = $selected_pattern['shape'];

        return '<svg xmlns="http://www.w3.org/2000/svg" ' . $pattern_attribute_string . '>' . $shape . '</svg>';
    }

    public function svgToDataUri($svg)
    {
        return str_replace(
            ['<', '>', '"', '#'],
            ['%3C', '%3E', "'", '%23'],
            $svg
        );
    }

    /**
     * Render divider widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $settings = $this->getSettingsForDisplay();
        $svg_code = $this->buildSvg();
        $has_icon = 'line_icon' === $settings['look'] && !empty($settings['icon']);
        $has_text = 'line_text' === $settings['look'] && !empty($settings['text']);

        $this->addRenderAttribute('wrapper', 'class', 'elementor-divider');

        $svg_code && $this->addRenderAttribute('wrapper', [
            'style' => '--divider-pattern-url: url("data:image/svg+xml,' . $this->svgToDataUri($svg_code) . '");',
        ]); ?>
        <div <?php $this->printRenderAttributeString('wrapper'); ?>>
            <span class="elementor-divider-separator">
            <?php if ($has_icon) { ?>
                <div class="elementor-icon elementor-divider__element">
                    <?php IconsManager::renderIcon($settings['icon'], ['aria-hidden' => 'true']); ?>
                </div>
            <?php } elseif ($has_text) {
                $this->addRenderAttribute('text', 'class', ['elementor-divider__text', 'elementor-divider__element']);
                $this->addInlineEditingAttributes('text'); ?>
                <span <?php $this->printRenderAttributeString('text'); ?>><?php echo $settings['text']; ?></span>
            <?php } ?>
            </span>
        </div>
        <?php
    }
}
