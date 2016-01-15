<!-- Block Newsletter module-->
<div id="newsletter_block_left" class="block">
  <h4>{l s='Newsletter' mod='blocknewsletter'}</h4>
  <div class="block_content">
    <form action="{$link->getPageLink('index', null, null, null, false, null, true)|escape:'html':'UTF-8'}" method="post">
      <div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}" >
        <input class="inputNew form-control grey newsletter-input" id="newsletter-input" type="text" name="email" size="18" value="{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{else}{l s='Enter your e-mail' mod='blocknewsletter'}{/if}" />
        <button type="submit" name="submitNewsletter" class="btn btn-default button button-small">
          <span>{l s='Ok' mod='blocknewsletter'}</span>
        </button>
        <input type="hidden" name="action" value="0" />
      </div>
    </form>
  </div>
  {hook h="displayBlockNewsletterBottom" from='blocknewsletter'}
</div>
<!-- /Block Newsletter module-->
{strip}
  {if isset($msg) && $msg}
    {addJsDef msg_newsl=$msg|@addcslashes:'\''}
  {/if}
  {if isset($nw_error)}
    {addJsDef nw_error=$nw_error}
  {/if}
  {addJsDefL name=placeholder_blocknewsletter}{l s='Enter your e-mail' mod='blocknewsletter' js=1}{/addJsDefL}
  {if isset($msg) && $msg}
    {addJsDefL name=alert_blocknewsletter}{l s='Newsletter : %1$s' sprintf=$msg js=1 mod="blocknewsletter"}{/addJsDefL}
  {/if}
{/strip}
