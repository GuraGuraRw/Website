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
 * Elementor embed.
 *
 * Elementor embed handler class is responsible for Elementor embed functionality.
 * The class holds the supported providers with their embed patters, and handles
 * their custom properties to create custom HTML with the embeded content.
 *
 * @since 1.5.0
 */
class Embed
{
    /**
     * Provider match masks.
     *
     * Holds a list of supported providers with their URL structure in a regex format.
     *
     * @since 1.5.0
     * @static
     *
     * @var array Provider URL structure regex
     */
    private static $provider_match_masks = [
        'youtube' => '/^.*(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^\?&\"\'>]+)/',
        'vimeo' => "/^.*vimeo\\.com\\/(?:[a-z]*\\/)*([‌\u{200b}0-9]{6,11})[?]?.*/",
        'dailymotion' => '/^.*dailymotion.com\/(?:video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/',
    ];

    /**
     * Embed patterns.
     *
     * Holds a list of supported providers with their embed patters.
     *
     * @since 1.5.0
     * @static
     *
     * @var array Embed patters
     */
    private static $embed_patterns = [
        'youtube' => 'https://www.youtube{NO_COOKIE}.com/embed/{VIDEO_ID}?feature=oembed',
        'vimeo' => 'https://player.vimeo.com/video/{VIDEO_ID}#t={TIME}',
        'dailymotion' => 'https://dailymotion.com/embed/video/{VIDEO_ID}',
    ];

    /**
     * Get video properties.
     *
     * Retrieve the video properties for a given video URL.
     *
     * @since 1.5.0
     * @static
     *
     * @param string $video_url Video URL
     *
     * @return array|null The video properties, or null
     */
    public static function getVideoProperties($video_url)
    {
        foreach (self::$provider_match_masks as $provider => $match_mask) {
            preg_match($match_mask, $video_url, $matches);

            if ($matches) {
                return [
                    'provider' => $provider,
                    'video_id' => $matches[1],
                ];
            }
        }

        return null;
    }

    /**
     * Get embed URL.
     *
     * Retrieve the embed URL for a given video.
     *
     * @since 1.5.0
     * @static
     *
     * @param string $video_url Video URL
     * @param array $embed_url_params Optional. Embed parameters. Default is an
     *                                empty array.
     * @param array $options Optional. Embed options. Default is an
     *                       empty array.
     *
     * @return array|null The video properties, or null
     */
    public static function getEmbedUrl($video_url, array $embed_url_params = [], array $options = [])
    {
        $video_properties = self::getVideoProperties($video_url);

        if (!$video_properties) {
            return null;
        }

        $embed_pattern = self::$embed_patterns[$video_properties['provider']];

        $replacements = [
            '{VIDEO_ID}' => $video_properties['video_id'],
        ];

        if ('youtube' === $video_properties['provider']) {
            $replacements['{NO_COOKIE}'] = !empty($options['privacy']) ? '-nocookie' : '';
        } elseif ('vimeo' === $video_properties['provider']) {
            $time_text = '';

            if (!empty($options['start'])) {
                $time_text = date('H\hi\ms\s', $options['start']);
            }

            $replacements['{TIME}'] = $time_text;
            // Fix: Insert $embed_url_params before #t={TIME}
            $replacements['{VIDEO_ID}'] .= '?' . http_build_query($embed_url_params);
            $embed_url_params = [];
        }

        $embed_pattern = str_replace(array_keys($replacements), $replacements, $embed_pattern);

        return add_query_arg($embed_url_params, $embed_pattern);
    }

    /**
     * Get embed HTML.
     *
     * Retrieve the final HTML of the embedded URL.
     *
     * @since 1.5.0
     * @static
     *
     * @param string $video_url Video URL
     * @param array $embed_url_params Optional. Embed parameters. Default is an
     *                                empty array.
     * @param array $options Optional. Embed options. Default is an
     *                       empty array.
     * @param array $frame_attributes Optional. Frame attributes. Default is an
     *                                empty array.
     *
     * @return string The embed HTML
     */
    public static function getEmbedHtml($video_url, array $embed_url_params = [], array $options = [], array $frame_attributes = [])
    {
        $video_properties = self::getVideoProperties($video_url);

        $default_frame_attributes = [
            'class' => "elementor-video-\x69frame",
            'allowfullscreen',
            'title' => sprintf(
                /* translators: %s: Video provider */
                __('%s Video Player'),
                $video_properties['provider']
            ),
        ];

        $video_embed_url = self::getEmbedUrl($video_url, $embed_url_params, $options);
        if (!$video_embed_url) {
            return null;
        }
        if (!$options['lazy_load']) {
            $default_frame_attributes['src'] = $video_embed_url;
            $default_frame_attributes['loading'] = 'lazy';
        } else {
            $default_frame_attributes['data-lazy-load'] = $video_embed_url;
        }

        $frame_attributes = array_merge($default_frame_attributes, $frame_attributes);

        $attributes_for_print = [];

        foreach ($frame_attributes as $attribute_key => $attribute_value) {
            $attribute_value = esc_attr($attribute_value);

            if (is_numeric($attribute_key)) {
                $attributes_for_print[] = $attribute_value;
            } else {
                $attributes_for_print[] = "$attribute_key=\"$attribute_value\"";
            }
        }

        $attributes_for_print = implode(' ', $attributes_for_print);

        // $embed_html = "<embed $attributes_for_print></embed>";
        /* This filter is documented in wp-includes/class-oembed.php */
        // return apply_filters('oembed_result', $embed_html, $video_url, $frame_attributes);
        return "<\x69frame $attributes_for_print></\x69frame>";
    }
}
