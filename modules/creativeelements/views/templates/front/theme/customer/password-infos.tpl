{**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2024 WebshopWorks.com
 * @license   One domain support license
 *}
{if isset($CE_PAGE_PASSWORD)}
  {$ce_layout=$layout}
{elseif file_exists("{$smarty.const._PS_THEME_DIR_}templates/customer/password-infos.tpl")}
  {$ce_layout='[1]customer/password-infos.tpl'}
{elseif $smarty.const._PARENT_THEME_NAME_}
  {$ce_layout='parent:customer/password-infos.tpl'}
{/if}

{extends $ce_layout}

{if isset($CE_PAGE_PASSWORD)}
  {block name='content'}<section id="content">{$CE_PAGE_PASSWORD|cefilter}</section>{/block}
{/if}