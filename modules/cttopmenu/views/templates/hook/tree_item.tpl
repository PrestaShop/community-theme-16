<li>
  <a{if !empty($item.id)} id="cttm-item-{$item.id|escape:'html':'UTF-8'}"{/if} href="{if !empty($item.url)}{$item.url|escape:'html':'UTF-8'}{else}#{/if}" class="cttm-item-{$item.type|escape:'html':'UTF-8'}{if !empty($item.entity_id)} cttm-entity-{$item.entity_id|escape:'html':'UTF-8'}{/if}" title="{$item.title|escape:'html':'UTF-8'}"{if $item.no_follow} rel="nofollow"{/if}>
    {if !empty($item.icon)}<i class="icon icon-{$item.icon|escape:'html':'UTF-8'}"></i>{/if}
    {$item.name|escape:'html':'UTF-8'}
  </a>
  {if !empty($item.sub_items)}
    <ul class="sub-list">
      {foreach from=$item.sub_items item=sub_item}
        {include file='./tree_item.tpl' item=$sub_item}
      {/foreach}
    </ul>
  {/if}
</li>
