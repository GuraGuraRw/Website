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

{extends file='checkout/checkout.tpl'}

{block name='content'}

    {if $fee_type == '3'}
        {capture name=path}{l s='Cash on pickup' mod='codfee'}{/capture}
    {else}
        {capture name=path}{l s='Cash on delivery with fee' mod='codfee'}{/capture}
    {/if}

    {if $nbProducts <= 0}
        <p class="warning">{l s='Your cart is empty.' mod='codfee'}</p>
    {else}
    <div class="codfee-payment-confirm">
        <form action="{if version_compare($smarty.const._PS_VERSION_, '1.5', '<')}{$this_path_ssl|escape:'htmlall':'UTF-8'}payment.php{else}{$validation_ctrl|escape:'htmlall':'UTF-8'}{/if}" method="post">
            <div class="d-flex align-items-center">
                <img class="codfee-logo" src="{$payment_logo|escape:'htmlall':'UTF-8'}" alt="{l s='Cash on delivery with fee payment' mod='codfee'}" />
                {if $fee_type == '3'}
                    <h4>{l s='You have chosen the cash on pickup method.' mod='codfee'}</h4>
                {else}
                    <h4>{l s='You have chosen the cash on delivery method.' mod='codfee'}</h4>
                {/if}
            </div>
            <br /><br />
            <table id="cart_summary" class="table table-bordered footab default footable-loaded footable">
                <thead>
                    <tr>
                        <th class="cart_product first_item" colspan="7">{l s='Details of your order' mod='codfee'} {$taxes_included|escape:'htmlall':'UTF-8'}</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="cart_total_price">
                        <td colspan="6">{l s='Order:' mod='codfee'}</td>
                        <td colspan="1" class="price price-normal" id="total_product">{$cartwithoutshipping|escape:'quotes':'UTF-8'}</td>
                    </tr>
                    <tr class="cart_total_delivery">
                        <td colspan="6">{l s='Shipping cost:' mod='codfee'}</td>
                        <td colspan="1" class="price price-normal" id="total_shipping">{$shipping_cost|escape:'quotes':'UTF-8'}</td>
                    </tr>
                    {if $wrapping_val > 0}
                        <tr class="cart_total_wrapping">
                            <td colspan="6">{l s='Gift wrapping:' mod='codfee'}</td>
                            <td colspan="1" class="price price-normal" id="total_wrapping">{$wrapping|escape:'quotes':'UTF-8'}</td>
                        </tr>
                    {/if}
                    {if $discounts_val > 0}
                        <tr class="cart_total_discounts">
                            <td colspan="6">{l s='Discounts:' mod='codfee'}</td>
                            <td colspan="1" class="price price-normal" id="total_discounts">{$discounts|escape:'quotes':'UTF-8'}</td>
                        </tr>
                    {/if}
                    {if $fee_type != '3'}
                        <tr class="cart_total_tax">
                            {if $fee_amount != 0}
                                <td colspan="6">{l s='Cash on delivery fee:' mod='codfee'}</td>
                                <td colspan="1" class="price price-normal" id="total_tax">{$fee|escape:'quotes':'UTF-8'}</td>
                            {elseif $free_on_freeshipping == '1'}
                                <td colspan="6">{l s='Cash on delivery fee (free on free shipping orders!)' mod='codfee'}</td>
                                <td colspan="1" class="price price-normal" id="total_tax">{$fee|escape:'quotes':'UTF-8'}</td>
                            {else}
                                <td colspan="6">{l s='Cash on delivery fee (free from' mod='codfee'} {$free_fee|escape:'quotes':'UTF-8'} {l s='of purchase):' mod='codfee'}</td>
                                <td colspan="1" class="price price-normal" id="total_tax">{$fee|escape:'quotes':'UTF-8'}</td>
                            {/if}
                        </tr>
                    {/if}
                    <tr class="cart_total_price">
                        <td colspan="6">
                            {if $fee_amount != 0}
                                {l s='*COD fee will be added to the shipping cost.' mod='codfee'}
                            {/if}
                        </td>
                        <td colspan="1" class="price total_price_container" id="total_price_container">
                            <span>{l s='Total:' mod='codfee'}</span> <span id="total_price" class="product-price">{$total|escape:'quotes':'UTF-8'}</span>
                            
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br /><br />
            <div class="row justify-content-between align-items-end">
                <div class="col-12 col-lg-7 my-2">
                    <div class="light-box-bg text-center">
                        <p><strong>{l s='Please confirm your order by clicking \'Confirm my order\'' mod='codfee'}.</strong></p>
                        <p class="cart_navigation" id="cart_navigation">
                            <button type="submit" class="btn btn-primary">
                                <span>{l s='Confirm my order' mod='codfee'}<i class="icon-chevron-right right"></i></span>
                            </button>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 text-end my-2">
                    <a href="{$link->getPageLink('order', true, null, "step=3")|escape:'htmlall':'UTF-8'}" class="btn btn-secondary text-nowrap">
                        <i class="icon-chevron-left"></i>{l s='Other payment methods' mod='codfee'}
                    </a>
                </div>
            </div>
        </form>
    </div>
    {/if}

{/block}