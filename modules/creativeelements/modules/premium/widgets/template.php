<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2024 WebshopWorks.com
 * @license   One domain support license
 */
namespace CE;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ModulesXPremiumXWidgetsXTemplate extends WidgetBase
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'template';
    }

    public function getTitle()
    {
        return __('Template');
    }

    public function getIcon()
    {
        return 'eicon-document-file';
    }

    public function getCategories()
    {
        return ['premium'];
    }

    public function getKeywords()
    {
        return ['template', 'library', 'block', 'page', 'content', 'anywhere'];
    }

    protected function getTemplateOptions()
    {
        $options = [];
        $rows = \Db::getInstance()->executeS('
            SELECT `id_ce_template` AS id, `title`, `type` FROM ' . _DB_PREFIX_ . 'ce_template
            WHERE `active` = 1 AND `type` IN ("section", "page")
        ');
        if ($rows) {
            $types = [
                'section' => __('Section'),
                'page' => __('Page'),
            ];
            foreach ($rows as &$row) {
                $options[$row['id']] = "#{$row['id']} {$row['title']} ({$types[$row['type']]})";
            }
        }

        return $options;
    }

    protected function getContentOptions()
    {
        $options = [];
        $id_lang = $GLOBALS['language']->id;
        $id_shop = $GLOBALS['context']->shop->id;
        $rows = \Db::getInstance()->executeS('
            SELECT c.`id_ce_content` AS id, cl.`title`, c.`hook` FROM ' . _DB_PREFIX_ . 'ce_content c
            INNER JOIN ' . _DB_PREFIX_ . 'ce_content_lang cl ON cl.`id_ce_content` = c.`id_ce_content` AND cl.`id_lang` = ' . (int) $id_lang . ' AND cl.`id_shop` = ' . (int) $id_shop . '
            WHERE c.`active` = 1 AND c.`id_product` = 0
        ');
        if ($rows) {
            foreach ($rows as &$row) {
                $options[$row['id']] = "#{$row['id']} {$row['title']} ({$row['hook']})";
            }
        }

        return $options;
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_template',
            [
                'label' => __('Template'),
            ]
        );

        $this->addControl(
            'type',
            [
                'label' => __('Type'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'cms' => 'CMS',
                    'content' => __('Content Anywhere'),
                    'template' => __('Saved Templates'),
                ],
                'default' => 'template',
            ]
        );

        $this->addControl(
            'template_id',
            [
                'show_label' => false,
                'label_block' => true,
                'type' => ControlsManager::SELECT2,
                'select2options' => [
                    'placeholder' => __('Select...'),
                ],
                'options' => _CE_ADMIN_ ? $this->getTemplateOptions() : [],
                'condition' => [
                    'type' => 'template',
                ],
            ]
        );

        $this->addControl(
            'content_id',
            [
                'show_label' => false,
                'label_block' => true,
                'type' => ControlsManager::SELECT2,
                'select2options' => [
                    'placeholder' => __('Select...'),
                ],
                'options' => _CE_ADMIN_ ? $this->getContentOptions() : [],
                'condition' => [
                    'type' => 'content',
                ],
            ]
        );

        $this->addControl(
            'cms_id',
            [
                'show_label' => false,
                'label_block' => true,
                'type' => ControlsManager::SELECT2,
                'select2options' => [
                    'placeholder' => __('Search & Select'),
                    'ajax' => [
                        'get' => 'Cms',
                    ],
                ],
                'condition' => [
                    'type' => 'cms',
                ],
            ]
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettingsForDisplay();

        if ('template' === $settings['type']) {
            $uid = new UId($settings['template_id'], UId::TEMPLATE);
        } else {
            $id_type = 'cms' === $settings['type'] ? UId::CMS : UId::CONTENT;
            $uid = new UId($settings["{$settings['type']}_id"], $id_type, $GLOBALS['language']->id, $GLOBALS['context']->shop->id);
        }

        $uid->id && print Plugin::$instance->frontend->getBuilderContentForDisplay($uid);
    }

    public function renderPlainContent()
    {
    }
}
