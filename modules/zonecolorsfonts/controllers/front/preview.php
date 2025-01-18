<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

class ZOneColorsFontsPreviewModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        require_once $this->module->getLocalPath().'classes/ZColorsFonts.php';
        require_once $this->module->getLocalPath().'classes/ZCSSColor.php';

        $settings = ZColorsFonts::getSettingsByShop();
        $xml_colors = Tools::simplexml_load_file($this->module->getLocalPath().'selector.xml');
        $colorClass = new ZCSSColor();
        $variables = false;
        $new_colors = false;
        $group = 'general';

        if (isset($xml_colors->$group)) {
            $xml_group = $xml_colors->$group;
            $variables = array();
            if (isset($settings->$group)) {
                $new_colors = $settings->$group;
            }

            foreach ($xml_group->variable as $v) {
                $default = (isset($new_colors[(string) $v['name']])) ? $new_colors[(string) $v['name']] : (string) $v['default'];
                $styles = array();
                foreach ($v->style as $s) {
                    $style = array();
                    if ($s->property && $s->selector) {
                        $style['property'] = (string) $s->property;
                        $style['selector'] = (string) $s->selector;

                        if (isset($s['lighten'])) {
                            $style['lighten'] = $colorClass->lighten($default, (int) $s['lighten']);
                        }
                        if (isset($s['darken'])) {
                            $style['darken'] = $colorClass->darken($default, (int) $s['darken']);
                        }
                        if (isset($s['box-shadow'])) {
                            $style['boxShadow'] = (string) $s['box-shadow'];
                        }

                        $styles[] = $style;
                    }
                }

                $variables[(string) $v['name']] = array(
                    'default' => $default,
                    'label' => (string) $v['label'],
                    'desc' => (string) $v['desc'],
                    'styles' => $styles,
                );
            }
        }

        $zonethememanager = ModuleCore::getInstanceByName('zonethememanager');
        $boxed_bg_css = $zonethememanager->getBoxedBackgroundCSS(true);

        $templateFile = 'module:zonecolorsfonts/views/templates/hook/live_colors_preview.tpl';
        $tpl = $this->context->smarty->createTemplate($templateFile, $this->context->smarty);
        $tpl->assign(array(
            'variables' => $variables,
            'boxed_bg_css' => $boxed_bg_css,
        ));

        die($tpl->fetch());
    }
}
