<!-- Block tags module -->
<div id="tags_block_left" class="block tags_block">
  <p class="title_block">
    {l s='Tags' mod='blocktags'}
  </p>
  <div class="block_content">
    {if $tags}
      {foreach from=$tags item=tag name=myLoop}
        <a
          class="{$tag.class} {if $smarty.foreach.myLoop.last}last_item{elseif $smarty.foreach.myLoop.first}first_item{else}item{/if}"
          href="{$link->getPageLink('search', true, NULL, "tag={$tag.name|urlencode}")|escape:'html':'UTF-8'}"
          title="{l s='More about' mod='blocktags'} {$tag.name|escape:'html':'UTF-8'}"
        >
          {$tag.name|escape:'html':'UTF-8'}
        </a>
      {/foreach}
    {else}
      {l s='No tags specified yet' mod='blocktags'}
    {/if}
  </div>
</div>
<!-- /Block tags module -->
