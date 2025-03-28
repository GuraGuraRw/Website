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

use CE\CoreXFilesXCSSXBase as Base;
use CE\CoreXFilesXCSSXGlobalCSS as GlobalCSS;
use CE\CoreXSettingsXBaseXCssManager as CSSManager;
use CE\CoreXSettingsXBaseXModel as BaseModel;
use CE\CoreXSettingsXGeneralXModel as Model;

/**
 * Elementor general settings manager.
 *
 * Elementor general settings manager handler class is responsible for registering
 * and managing Elementor general settings managers.
 *
 * @since 1.6.0
 */
class CoreXSettingsXGeneralXManager extends CSSManager
{
    /**
     * Lightbox panel tab.
     */
    const PANEL_TAB_LIGHTBOX = 'lightbox';

    /**
     * Meta key for the general settings.
     */
    const META_KEY = '_elementor_general_settings';

    /**
     * General settings manager constructor.
     *
     * Initializing Elementor general settings manager.
     *
     * @since 1.6.0
     */
    public function __construct()
    {
        parent::__construct();

        $this->addPanelTabs();
    }

    /**
     * Get manager name.
     *
     * Retrieve general settings manager name.
     *
     * @since 1.6.0
     *
     * @return string Manager name
     */
    public function getName()
    {
        return 'general';
    }

    /**
     * Get model for config.
     *
     * Retrieve the model for settings configuration.
     *
     * @since 1.6.0
     *
     * @return BaseModel The model object
     */
    public function getModelForConfig()
    {
        return $this->getModel();
    }

    /**
     * Get saved settings.
     *
     * Retrieve the saved settings from the site options.
     *
     * @since 1.6.0
     *
     * @param int $id Post ID
     *
     * @return array Saved settings
     */
    protected function getSavedSettings($id)
    {
        $model_controls = Model::getControlsList();

        $settings = [];

        foreach ($model_controls as $tab_name => $sections) {
            foreach ($sections as $section_name => $section_data) {
                foreach ($section_data['controls'] as $control_name => $control_data) {
                    $saved_setting = get_option($control_name, null);

                    if (null !== $saved_setting) {
                        $settings[$control_name] = $saved_setting;
                    }
                }
            }
        }

        return $settings;
    }

    /**
     * Get CSS file name.
     *
     * Retrieve CSS file name for the general settings manager.
     *
     * @since 1.6.0
     *
     * @return string
     * @return string CSS file name
     */
    protected function getCssFileName()
    {
        return 'global';
    }

    /**
     * Save settings to DB.
     *
     * Save general settings to the database, as site options.
     *
     * @since 1.6.0
     *
     * @param array $settings Settings
     * @param int $id Post ID
     */
    protected function saveSettingsToDb(array $settings, $id)
    {
        $model_controls = Model::getControlsList();

        $one_list_settings = [];

        foreach ($model_controls as $tab_name => $sections) {
            foreach ($sections as $section_name => $section_data) {
                foreach ($section_data['controls'] as $control_name => $control_data) {
                    if (isset($settings[$control_name])) {
                        $one_list_control_name = str_replace('elementor_', '', $control_name);

                        $one_list_settings[$one_list_control_name] = $settings[$control_name];

                        update_option($control_name, $settings[$control_name]);
                    } else {
                        delete_option($control_name);
                    }
                }
            }
        }

        // Save all settings in one list for a future usage
        if (!empty($one_list_settings)) {
            update_option(self::META_KEY, $one_list_settings);
        } else {
            delete_option(self::META_KEY);
        }
    }

    /**
     * Get model for CSS file.
     *
     * Retrieve the model for the CSS file.
     *
     * @since 1.6.0
     *
     * @param Base $css_file The requested CSS file
     *
     * @return BaseModel The model object
     */
    protected function getModelForCssFile(Base $css_file)
    {
        return $this->getModel();
    }

    /**
     * Get CSS file for update.
     *
     * Retrieve the CSS file before updating the it.
     *
     * @since 1.6.0
     *
     * @param int $id Post ID
     *
     * @return GlobalCSS The global CSS file object
     */
    protected function getCssFileForUpdate($id)
    {
        $id_shop = (int) $GLOBALS['context']->shop->id;

        return GlobalCSS::create("$id_shop-global.css");
    }

    /**
     * Add panel tabs.
     *
     * Register new panel tab for the lightbox settings.
     *
     * @since 1.6.0
     */
    private function addPanelTabs()
    {
        ControlsManager::addTab(self::PANEL_TAB_LIGHTBOX, __('Lightbox'));
    }
}
