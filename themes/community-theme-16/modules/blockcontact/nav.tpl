<div id="contact-link" {if isset($is_logged) && $is_logged} class="is_logged"{/if}>
  <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}" title="{l s='Contact us' mod='blockcontact'}">{l s='Contact us' mod='blockcontact'}</a>
</div>
{if $telnumber}
  <span class="shop-phone{if isset($is_logged) && $is_logged} is_logged{/if}">
    <i class="icon-phone"></i>{l s='Call us now:' mod='blockcontact'} <strong>{$telnumber}</strong>
  </span>
{/if}
