<div id="layer_cart">
  <div class="clearfix">
    <div class="layer_cart_product col-xs-12 col-md-6">
      <span class="cross" title="{l s='Close window' mod='blockcart'}"></span>
      <span class="title">
        <i class="icon icon-check"></i> {l s='Product successfully added to your shopping cart' mod='blockcart'}
      </span>
      <div class="product-image-container layer_cart_img">
      </div>
      <div class="layer_cart_product_info">
        <span id="layer_cart_product_title" class="product-name"></span>
        <span id="layer_cart_product_attributes"></span>
        <div>
          <strong>{l s='Quantity' mod='blockcart'}</strong>
          <span id="layer_cart_product_quantity"></span>
        </div>
        <div>
          <strong>{l s='Total' mod='blockcart'}</strong>
          <span id="layer_cart_product_price"></span>
        </div>
      </div>
    </div>
    <div class="layer_cart_cart col-xs-12 col-md-6">
        <span class="title">
          <!-- Plural Case [both cases are needed because page may be updated in Javascript] -->
          <span class="ajax_cart_product_txt_s {if $cart_qties < 2} unvisible{/if}">
              {l s='There are [1]%d[/1] items in your cart.' mod='blockcart' sprintf=[$cart_qties] tags=['<span class="ajax_cart_quantity">']}
          </span>
          <!-- Singular Case [both cases are needed because page may be updated in Javascript] -->
          <span class="ajax_cart_product_txt {if $cart_qties > 1} unvisible{/if}">
              {l s='There is 1 item in your cart.' mod='blockcart'}
          </span>
        </span>
      <div class="layer_cart_row">
        <strong>
          {l s='Total products' mod='blockcart'}
          {if $use_taxes && $display_tax_label && $show_tax}
            {if $priceDisplay == 1}
              {l s='(tax excl.)' mod='blockcart'}
            {else}
              {l s='(tax incl.)' mod='blockcart'}
            {/if}
          {/if}
        </strong>
        <span class="ajax_block_products_total">
          {if $cart_qties > 0}
            {convertPrice price=$cart->getOrderTotal(false, Cart::ONLY_PRODUCTS)}
          {/if}
        </span>
      </div>

      {if $show_wrapping}
        <div class="layer_cart_row">
          <strong>
            {l s='Wrapping' mod='blockcart'}
            {if $use_taxes && $display_tax_label && $show_tax}
              {if $priceDisplay == 1}
                {l s='(tax excl.)' mod='blockcart'}
              {else}
                {l s='(tax incl.)' mod='blockcart'}
              {/if}
            {/if}
          </strong>
          <span class="price cart_block_wrapping_cost">
            {if $priceDisplay == 1}
              {convertPrice price=$cart->getOrderTotal(false, Cart::ONLY_WRAPPING)}
            {else}
              {convertPrice price=$cart->getOrderTotal(true, Cart::ONLY_WRAPPING)}
            {/if}
          </span>
        </div>
      {/if}
      <div class="layer_cart_row">
        <strong class="{if $shipping_cost_float == 0 && (!$cart_qties || $cart->isVirtualCart() || !isset($cart->id_address_delivery) || !$cart->id_address_delivery)} unvisible{/if}">
          {l s='Total shipping' mod='blockcart'}&nbsp;{if $use_taxes && $display_tax_label && $show_tax}{if $priceDisplay == 1}{l s='(tax excl.)' mod='blockcart'}{else}{l s='(tax incl.)' mod='blockcart'}{/if}{/if}
        </strong>
          <span class="ajax_cart_shipping_cost{if $shipping_cost_float == 0 && (!$cart_qties || $cart->isVirtualCart() || !isset($cart->id_address_delivery) || !$cart->id_address_delivery)} unvisible{/if}">
            {if $shipping_cost_float == 0}
              {if (!isset($cart->id_address_delivery) || !$cart->id_address_delivery)}{l s='To be determined' mod='blockcart'}{else}{l s='Free shipping!' mod='blockcart'}{/if}
            {else}
              {$shipping_cost}
            {/if}
          </span>
      </div>
      {if $show_tax && isset($tax_cost)}
        <div class="layer_cart_row">
          <strong>{l s='Tax' mod='blockcart'}</strong>
          <span class="price cart_block_tax_cost ajax_cart_tax_cost">{$tax_cost}</span>
        </div>
      {/if}
      <div class="layer_cart_row">
        <strong>
          {l s='Total' mod='blockcart'}
          {if $use_taxes && $display_tax_label && $show_tax}
            {if $priceDisplay == 1}
              {l s='(tax excl.)' mod='blockcart'}
            {else}
              {l s='(tax incl.)' mod='blockcart'}
            {/if}
          {/if}
        </strong>
        <span class="ajax_block_cart_total">
          {if $cart_qties > 0}
            {if $priceDisplay == 1}
              {convertPrice price=$cart->getOrderTotal(false)}
            {else}
              {convertPrice price=$cart->getOrderTotal(true)}
            {/if}
          {/if}
        </span>
      </div>
      <div class="button-container">
        <span class="btn btn-lg btn-default continue" title="{l s='Continue shopping' mod='blockcart'}">
          <span>
              <i class="icon icon-chevron-left"></i> {l s='Continue shopping' mod='blockcart'}
          </span>
        </span>
        <a class="btn btn-lg btn-success" href="{$link->getPageLink("$order_process", true)|escape:"html":"UTF-8"}" title="{l s='Proceed to checkout' mod='blockcart'}" rel="nofollow">
          <span>
            {l s='Proceed to checkout' mod='blockcart'} <i class="icon icon-chevron-right"></i>
          </span>
        </a>
      </div>
    </div>
  </div>
  <div class="crossseling"></div>
</div>

<div class="layer_cart_overlay"></div>
