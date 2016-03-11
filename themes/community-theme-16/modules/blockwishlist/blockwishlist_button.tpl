{if isset($wishlists) && count($wishlists) > 1}
  <div class="wishlist">
    {foreach name=wl from=$wishlists item=wishlist}
      {if $smarty.foreach.wl.first}
        <a class="wishlist_button_list" tabindex="0" data-toggle="popover" data-trigger="focus" title="{l s='Wishlist' mod='blockwishlist'}" data-placement="bottom">{l s='Add to wishlist' mod='blockwishlist'}</a>
        <div hidden class="popover-content">
        <table class="table" border="1">
        <tbody>
      {/if}
      <tr title="{$wishlist.name}" value="{$wishlist.id_wishlist}" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', false, 1, '{$wishlist.id_wishlist}');">
        <td>
          {l s='Add to %s' sprintf=[$wishlist.name] mod='blockwishlist'}
        </td>
      </tr>
      {if $smarty.foreach.wl.last}
        </tbody>
        </table>
        </div>
      {/if}
      {foreachelse}
      <a href="#" id="wishlist_button_nopop" onclick="WishlistCart('wishlist_block_list', 'add', '{$id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;" rel="nofollow"  title="{l s='Add to my wishlist' mod='blockwishlist'}">
        <i class="icon icon-star-o"></i> {l s='Add to wishlist' mod='blockwishlist'}
      </a>
    {/foreach}
  </div>
{else}
  <div class="wishlist">
    <a class="addToWishlist wishlistProd_{$product.id_product|intval}" href="#" rel="{$product.id_product|intval}" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', false, 1); return false;">
      <i class="icon icon-star-o"></i> {l s="Add to Wishlist" mod='blockwishlist'}
    </a>
  </div>
{/if}
