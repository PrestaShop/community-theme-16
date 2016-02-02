<li>
  <a id="cttm-item-{$item.id|escape:'html':'UTF-8'}" href="{$item.url|escape:'html':'UTF-8'}" class="cttm-item-{$item.type|escape:'html':'UTF-8'}" title="{$item.title|escape:'html':'UTF-8'}"{if $item.no_follow} rel="nofollow"{/if}>
    {if !empty($item.icon)}<i class="icon icon-{$item.icon|escape:'html':'UTF-8'}"></i>{/if}
    {$item.name|escape:'html':'UTF-8'}
  </a>
  {if !empty($item.sub_items)}
    <ul>
      {foreach from=$item.sub_items item=sub_item}
        {include file='./tree_item.tpl' item=$sub_item}
      {/foreach}
    </ul>
  {/if}
</li>
