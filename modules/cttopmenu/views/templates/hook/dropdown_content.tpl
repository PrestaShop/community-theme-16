{* @TODO More elegant solution? *}

{$total_items = count($menu_item.sub_items)}
{$column_count = min(4, $total_items)}

{if $column_count == 4}
  {$column_class = 'col-xs-12 col-sm-6 col-md-3'}
{elseif $column_count == 3}
  {$column_class = 'col-xs-12 col-sm-6 col-md-4'}
{elseif $column_count == 2}
  {$column_class = 'col-xs-12 col-sm-6'}
{else}
  {$column_class = 'col-xs-12'}
{/if}

{$per_column = ($total_items / $column_count)}

<div class="row">
  {$i = 1}
  {$column = 1}
  <div class="col-xs-12 {$column_class}">
    <ul>
      {foreach from=$menu_item.sub_items item=sub_item}

        {if $i > $column * $per_column}
            </ul>
          </div>
          <div class="col-xs-12 {$column_class}">
            <ul>
          {$column = $column + 1}
        {/if}

        {include file='./tree_item.tpl' item=$sub_item}
        {$i = $i + 1}

      {/foreach}
    </ul>
  </div>
</div>
