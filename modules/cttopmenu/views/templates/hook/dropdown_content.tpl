<ul>
  {foreach from=$menu_item.sub_items item=sub_item}
    {include file='./tree_item.tpl' item=$sub_item}
  {/foreach}
</ul>
