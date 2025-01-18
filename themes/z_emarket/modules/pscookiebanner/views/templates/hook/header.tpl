{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}

{literal}
<script type="text/javascript">
    var cb_settings = {
        cb_bg_color:"{/literal}{$CB_BG_COLOR|escape:'htmlall':'UTF-8'}{literal}",
        cb_font_style:"{/literal}{$CB_FONT_STYLE|escape:'htmlall':'UTF-8'}{literal}",
        cb_text_color:"{/literal}{$CB_TEXT_COLOR|escape:'htmlall':'UTF-8'}{literal}",
        cb_inf_text_color:"{/literal}{$CB_MORE_INF_LINK_COLOR|escape:'htmlall':'UTF-8'}{literal}",
        cb_loop:"{/literal}{$CB_FONT_LOOP|escape:'htmlall':'UTF-8'}{literal}",
        cb_font_size:"{/literal}{$CB_FONT_SIZE|escape:'htmlall':'UTF-8'}{literal}",
        cb_button_bg_color:"{/literal}{$CB_BUTTON_BG_COLOR|escape:'htmlall':'UTF-8'}{literal}",
        cb_button_bg_color_hover:"{/literal}{$CB_BUTTON_BG_COLOR_HOVER|escape:'htmlall':'UTF-8'}{literal}",
        cb_button_text_color:"{/literal}{$CB_BUTTON_TEXT_COLOR|escape:'htmlall':'UTF-8'}{literal}",
    };

    var cb_cms_url = "{/literal}{$CB_CMS_URL}{literal}";
    var cb_position = "{/literal}{$CB_POSITION|escape:'htmlall':'UTF-8'}{literal}";
    var cb_text = "{/literal}{$CB_TEXT.$current_language|escape:'htmlall':'UTF-8'}{literal}";
    var cb_link_text = "{/literal}{$CB_LINK_TEXT.$current_language|escape:'htmlall':'UTF-8'}{literal}";
    var cd_button_text = "{/literal}{$CB_BUTTON_TEXT.$current_language|escape:'htmlall':'UTF-8'}{literal}";
</script>
{/literal}
