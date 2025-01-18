{**
* Cash On Delivery With Fee
*
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate
*  @copyright 2017 idnovate
*  @license   See above
*}


<div class="codfee_show_product17 alert alert-info">
    <img src="{$icon|escape:'htmlall':'UTF-8'}" />
    <span class="codfee_show_product_text17">
        {if $codfee_type == '3'}
            {l s='This product can be bought upon cash on pickup' mod='codfee'}
        {else}
            {l s='This product can be bought with COD' mod='codfee'}
        {/if}
    </span>
</div>
