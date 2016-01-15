{if isset($orderProducts) && count($orderProducts) > 0}
  <div class="crossseling-content">
    <h2>{l s='Customers who bought this product also bought:' mod='blockcart'}</h2>
    <div id="blockcart_list">
      <ul id="blockcart_caroucel">
        {foreach from=$orderProducts item='orderProduct' name=orderProduct}
          <li>
            <div class="product-image-container">
              <a href="{$orderProduct.link|escape:'html':'UTF-8'}" title="{$orderProduct.name|htmlspecialchars}" class="lnk_img">
                <img class="img-responsive" src="{$orderProduct.image}" alt="{$orderProduct.name|htmlspecialchars}" />
              </a>
            </div>
            <p class="product-name">
              <a href="{$orderProduct.link|escape:'html':'UTF-8'}" title="{$orderProduct.name|htmlspecialchars}">
                {$orderProduct.name|truncate:15:'...'|escape:'html':'UTF-8'}
              </a>
            </p>
            {if $orderProduct.show_price == 1 AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
              <span class="price_display">
                <span class="price">{convertPrice price=$orderProduct.displayed_price}</span>
              </span>
            {/if}
          </li>
        {/foreach}
      </ul>
    </div>
  </div>
{/if}
