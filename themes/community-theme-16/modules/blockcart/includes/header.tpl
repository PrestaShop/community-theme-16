<a href="{$link->getPageLink($order_process, true)|escape:'html':'UTF-8'}" title="{l s='View my shopping cart' mod='blockcart'}" rel="nofollow">
  <i class="icon icon-shopping-cart"></i>
  <b>{l s='Cart' mod='blockcart'}</b>
  <span class="ajax_cart_quantity{if $cart_qties == 0} unvisible{/if}">{$cart_qties}</span>
  <span class="ajax_cart_product_txt{if $cart_qties != 1} unvisible{/if}">{l s='Product' mod='blockcart'}</span>
  <span class="ajax_cart_product_txt_s{if $cart_qties < 2} unvisible{/if}">{l s='Products' mod='blockcart'}</span>
      <span class="ajax_cart_total{if $cart_qties == 0} unvisible{/if}">
        {if $cart_qties > 0}
          {if $priceDisplay == 1}
            {assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
            {convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}
          {else}
            {assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
            {convertPrice price=$cart->getOrderTotal(true, $blockcart_cart_flag)}
          {/if}
        {/if}
      </span>
  <span class="ajax_cart_no_product{if $cart_qties > 0} unvisible{/if}">{l s='(empty)' mod='blockcart'}</span>
  {if $ajax_allowed && isset($blockcart_top) && !$blockcart_top}
    <span class="block_cart_expand{if !isset($colapseExpandStatus) || (isset($colapseExpandStatus) && $colapseExpandStatus eq 'expanded')} unvisible{/if}">&nbsp;</span>
    <span class="block_cart_collapse{if isset($colapseExpandStatus) && $colapseExpandStatus eq 'collapsed'} unvisible{/if}">&nbsp;</span>
  {/if}
</a>
