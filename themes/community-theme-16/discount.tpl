{capture name=path}<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">{l s='My account'}</a><span class="navigation-pipe">{$navigationPipe}</span><span class="navigation_page">{l s='My vouchers'}</span>{/capture}

<h1 class="page-heading">
  {l s='My vouchers'}
</h1>

{if isset($cart_rules) && count($cart_rules) && $nb_cart_rules}
  <table class="discount table table-bordered">
    <thead>
    <tr>
      <th class="discount_code first_item">{l s='Code'}</th>
      <th class="discount_description item">{l s='Description'}</th>
      <th class="discount_quantity item">{l s='Quantity'}</th>
      <th class="discount_value item">{l s='Value'}*</th>
      <th class="discount_minimum item">{l s='Minimum'}</th>
      <th class="discount_cumulative item">{l s='Cumulative'}</th>
      <th class="discount_expiration_date last_item">{l s='Expiration date'}</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$cart_rules item=discountDetail name=myLoop}
      <tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
        <td class="discount_code">{$discountDetail.code}</td>
        <td class="discount_description">{$discountDetail.name}</td>
        <td class="discount_quantity">{$discountDetail.quantity_for_user}</td>
        <td class="discount_value">
          {if $discountDetail.id_discount_type == 1}
            {$discountDetail.value|escape:'html':'UTF-8'}%
          {elseif $discountDetail.id_discount_type == 2}
            {convertPrice price=$discountDetail.value} ({if $discountDetail.reduction_tax == 1}{l s='Tax included'}{else}{l s='Tax excluded'}{/if})
          {elseif $discountDetail.id_discount_type == 3}
            {l s='Free shipping'}
          {else}
            -
          {/if}
        </td>
        <td class="discount_minimum">
          {if $discountDetail.minimal == 0}
            {l s='None'}
          {else}
            {convertPrice price=$discountDetail.minimal}
          {/if}
        </td>
        <td class="discount_cumulative">
          {if $discountDetail.cumulable == 1}
            <i class="icon-ok icon"></i> {l s='Yes'}
          {else}
            <i class="icon-remove icon"></i> {l s='No'}
          {/if}
        </td>
        <td class="discount_expiration_date">
          {dateFormat date=$discountDetail.date_to}
        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{else}
  <p class="alert alert-warning">{l s='You do not have any vouchers.'}</p>
{/if}

<ul class="footer_links clearfix">
  <li>
    <a class="btn btn-default" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
      <span>
        <i class="icon-chevron-left"></i> {l s='Back to your account'}
      </span>
    </a>
  </li>
  <li>
    <a class="btn btn-default" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">
      <span>
        <i class="icon-chevron-left"></i> {l s='Home'}
      </span>
    </a>
  </li>
</ul>
