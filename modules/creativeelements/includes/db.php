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
 * Elementor database.
 *
 * Elementor database handler class is responsible for communicating with the
 * DB, save and retrieve Elementor data and meta data.
 *
 * @since 1.0.0
 */
class DB
{
    /**
     * Current DB version of the editor.
     */
    const DB_VERSION = '0.4';

    /**
     * Post publish status.
     */
    const STATUS_PUBLISH = 'publish';

    /**
     * Post draft status.
     */
    const STATUS_DRAFT = 'draft';

    /**
     * Post private status.
     */
    const STATUS_PRIVATE = 'private';

    /**
     * Post autosave status.
     */
    const STATUS_AUTOSAVE = 'autosave';

    // const STATUS_PENDING = 'pending';

    /**
     * Switched post data.
     *
     * Holds the switched post data.
     *
     * @since 1.5.0
     *
     * @var array Switched post data. Default is an empty array
     */
    protected $switched_post_data = [];

    /**
     * Switched data.
     *
     * Holds the switched data.
     *
     * @since 2.0.0
     *
     * @var array Switched data. Default is an empty array
     */
    protected $switched_data = [];

    /**
     * Get builder.
     *
     * Retrieve editor data from the database.
     *
     * @since 1.0.0
     *
     * @param int $post_id Post ID
     * @param string $status Optional. Post status. Default is `publish`
     *
     * @return array Editor data
     */
    public function getBuilder($post_id, $status = self::STATUS_PUBLISH)
    {
        if (self::STATUS_DRAFT === $status) {
            $document = Plugin::$instance->documents->getDocOrAutoSave($post_id);
        } else {
            $document = Plugin::$instance->documents->get($post_id);
        }

        if ($document) {
            $editor_data = $document->getElementsRawData(null, true);
        } else {
            $editor_data = [];
        }

        return $editor_data;
    }

    // protected function _getJsonMeta($post_id, $key)

    /**
     * Is using Elementor.
     *
     * Set whether the page is using Elementor or not.
     *
     * @since 1.5.0
     *
     * @param int $post_id Post ID
     * @param bool $is_elementor Optional. Whether the page is elementor page
     *                           Default is true.
     */
    public function setIsElementorPage($post_id, $is_elementor = true)
    {
        if ($is_elementor) {
            // Use the string `builder` and not a boolean for rollback compatibility
            update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        } else {
            delete_post_meta($post_id, '_elementor_edit_mode');
        }
    }

    /**
     * Render element plain content.
     *
     * When saving data in the editor, this method renders recursively the plain
     * content containing only the content and the HTML. No CSS data.
     *
     * @since 2.0.0
     *
     * @param array $element_data Element data
     */
    private function renderElementPlainContent($element_data)
    {
        if ('widget' === $element_data['elType']) {
            /* @var WidgetBase $widget */
            $widget = Plugin::$instance->elements_manager->createElementInstance($element_data);

            if ($widget) {
                $widget->renderPlainContent();
            }
        }

        if (!empty($element_data['elements'])) {
            foreach ($element_data['elements'] as $element) {
                $this->renderElementPlainContent($element);
            }
        }
    }

    /**
     * Save plain text.
     *
     * Retrieves the raw content, removes all kind of unwanted HTML tags and saves
     * the content as the `post_content` field in the database.
     *
     * @since 1.9.0
     *
     * @param int $post_id Post ID
     */
    public function savePlainText($post_id)
    {
        // Switch $dynamic_tags to parsing mode = remove.
        $dynamic_tags = Plugin::$instance->dynamic_tags;
        $parsing_mode = $dynamic_tags->getParsingMode();
        $dynamic_tags->setParsingMode('remove');

        $plain_text = $this->getPlainText($post_id);

        wp_update_post(
            [
                'ID' => $post_id,
                // Fix: purify HTML
                'post_content' => wp_kses_post($plain_text),
            ]
        );

        // Restore parsing mode.
        $dynamic_tags->setParsingMode($parsing_mode);
    }

    /**
     * Iterate data.
     *
     * Accept any type of Elementor data and a callback function. The callback
     * function runs recursively for each element and his child elements.
     *
     * @since 1.0.0
     *
     * @param array $data_container Any type of elementor data
     * @param callable $callback A function to iterate data by
     * @param array $args Array of args pointers for passing parameters in & out of the callback
     *
     * @return mixed Iterated data
     */
    public function iterateData($data_container, $callback, $args = [])
    {
        if (isset($data_container['elType'])) {
            if (!empty($data_container['elements'])) {
                $data_container['elements'] = $this->iterateData($data_container['elements'], $callback, $args);
            }

            return $callback($data_container, $args);
        }

        foreach ($data_container as $element_key => $element_value) {
            $element_data = $this->iterateData($data_container[$element_key], $callback, $args);

            if (null === $element_data) {
                continue;
            }

            $data_container[$element_key] = $element_data;
        }

        return $data_container;
    }

    /**
     * Safely copy Elementor meta.
     *
     * Make sure the original page was built with Elementor and the post is not
     * auto-save. Only then copy elementor meta from one post to another using
     * `copy_elementor_meta()`.
     *
     * @since 1.9.2
     *
     * @param int $from_post_id Original post ID
     * @param int $to_post_id Target post ID
     */
    public function safeCopyElementorMeta($from_post_id, $to_post_id)
    {
        // It's from Admin & not from Elementor.
        if (!did_action('elementor/db/before_save')) {
            if (!Plugin::$instance->db->isBuiltWithElementor($from_post_id)) {
                return;
            }

            // It's an exited Elementor auto-save
            if (get_post_meta($to_post_id, '_elementor_data', true)) {
                return;
            }
        }

        $this->copyElementorMeta($from_post_id, $to_post_id);
    }

    /**
     * Copy Elementor meta.
     *
     * Duplicate the data from one post to another.
     *
     * Consider using `safe_copy_elementor_meta()` method instead.
     *
     * @since 1.1.0
     *
     * @param int $from_post_id Original post ID
     * @param int $to_post_id Target post ID
     */
    public function copyElementorMeta($from_post_id, $to_post_id)
    {
        $from_post_meta = get_post_meta($from_post_id);
        $core_meta = [
            '_wp_page_template',
            // '_thumbnail_id',
            '_og_image',
        ];

        foreach ($from_post_meta as $meta_key => $values) {
            // Copy only meta with the `_elementor` prefix
            if (0 === strpos($meta_key, '_elementor') || in_array($meta_key, $core_meta, true)) {
                $value = $values[0];

                // The elementor JSON needs slashes before saving
                // if ('_elementor_data' === $meta_key) {
                //     $value = wp_slash($value);
                // } else {
                //     $value = maybe_unserialize($value);
                // }

                update_post_meta($to_post_id, $meta_key, $value);
            }
        }
    }

    /**
     * Is built with Elementor.
     *
     * Check whether the post was built with Elementor.
     *
     * @since 1.0.10
     *
     * @param int $post_id Post ID
     *
     * @return bool Whether the post was built with Elementor
     */
    public function isBuiltWithElementor($post_id)
    {
        $id_type = (int) substr($post_id, -6, 2);

        if (in_array($id_type, [UId::REVISION, UId::TEMPLATE, UId::CONTENT, UId::THEME])) {
            return true;
        }
        return (bool) get_post_meta($post_id, '_elementor_edit_mode', true);
    }

    /**
     * Switch to post.
     *
     * Change the global Wrapper post to the requested post.
     *
     * @since 1.5.0
     *
     * @param int $post_id Post ID to switch to
     */
    public function switchToPost($post_id)
    {
        $post_id = absint($post_id);
        // If is already switched, or is the same post, return.
        if (get_the_ID() == "$post_id") {
            $this->switched_post_data[] = false;

            return;
        }

        $this->switched_post_data[] = [
            'switched_id' => $post_id,
            'original_id' => get_the_ID(), // Note, it can be false if the global isn't set
        ];

        // $GLOBALS['post'] = get_post($post_id);

        setup_postdata($post_id);
    }

    /**
     * Restore current post.
     *
     * Rollback to the previous global post, rolling back from `DB::switchToPost()`.
     *
     * @since 1.5.0
     */
    public function restoreCurrentPost()
    {
        $data = array_pop($this->switched_post_data);

        // If not switched, return.
        if (!$data) {
            return;
        }

        // It was switched from an empty global post, restore this state and unset the global post
        if (false === $data['original_id']) {
            // unset($GLOBALS['post']);

            return;
        }

        // $GLOBALS['post'] = get_post($data['original_id']);

        setup_postdata($data['original_id']);
    }

    // public function switchToQuery($query_vars, $force_global_post = false)

    // public function restoreCurrentQuery()

    /**
     * Get plain text.
     *
     * Retrieve the post plain text.
     *
     * @since 1.9.0
     *
     * @param int $post_id Post ID
     *
     * @return string Post plain text
     */
    public function getPlainText($post_id)
    {
        $document = Plugin::$instance->documents->get($post_id);
        $data = $document ? $document->getElementsData() : [];

        return $this->getPlainTextFromData($data);
    }

    /**
     * Get plain text from data.
     *
     * Retrieve the post plain text from any given Elementor data.
     *
     * @since 1.9.2
     *
     * @param array $data Post ID
     *
     * @return string Post plain text
     */
    public function getPlainTextFromData($data)
    {
        ob_start();

        if ($data) {
            foreach ($data as $element_data) {
                $this->renderElementPlainContent($element_data);
            }
        }

        $plain_text = ob_get_clean();

        // Remove unnecessary tags.
        $plain_text = preg_replace('`</?(?:div|span)[^>]*\>`i', '', $plain_text);
        $plain_text = preg_replace('`<script(.*?)>(.*?)</script>`is', '', $plain_text);
        $plain_text = preg_replace('`<i [^>]*></i[^>]*>`', '', $plain_text);
        $plain_text = preg_replace('/ class=".*?"/', '', $plain_text);

        // Remove empty lines.
        $plain_text = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', "\n", $plain_text);

        $plain_text = trim($plain_text);

        return $plain_text;
    }
}
