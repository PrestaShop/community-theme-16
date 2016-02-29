{* @TODO More elegant solution? *}

{$total_items = count($menu_item.sub_items)}

{if $total_items > 4}
  {$column_count = 6}
  {$column_class = 'col-xs-12 col-sm-4 col-md-2'}
{else}
  {$column_count = 4}
  {$column_class = 'col-xs-12 col-sm-4 col-md-3'}
{/if}

{$per_column = ($total_items / $column_count)}

<div class="row">
  {$i = 0}
  {$column = 1}
  <div class="{$column_class}">
    <ul class="list-unstyled">
      {foreach from=$menu_item.sub_items item=sub_item}

        {if $i >= $column * $per_column}
            </ul>
          </div>
          <div class="{$column_class}">
            <ul class="list-unstyled">
          {$column = $column + 1}
        {/if}

        {include file='./tree_item.tpl' item=$sub_item}
        {$i = $i + 1}

      {/foreach}
    </ul>
  </div>
</div>
