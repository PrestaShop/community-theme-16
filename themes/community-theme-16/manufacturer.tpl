{include file="$tpl_dir./errors.tpl"}

{if !isset($errors) OR !sizeof($errors)}
  <h1 class="page-heading product-listing">
    {l s='List of products by manufacturer'}&nbsp;{$manufacturer->name|escape:'html':'UTF-8'}
  </h1>
  {if !empty($manufacturer->description) || !empty($manufacturer->short_description)}
    <div class="description_box rte">
      {if !empty($manufacturer->short_description)}
        <div class="short_desc">
          {$manufacturer->short_description}
        </div>
        <div class="hide_desc">
          {$manufacturer->description}
        </div>
        {if !empty($manufacturer->description)}
          <a href="#" class="lnk_more" onclick="$(this).prev().slideDown('slow'); $(this).hide();$(this).prev().prev().hide(); return false;">
            {l s='More'}
          </a>
        {/if}
      {else}
        <div>
          {$manufacturer->description}
        </div>
      {/if}
    </div>
  {/if}

  {if $products}
    <div class="content_sortPagiBar">
      <div class="sortPagiBar clearfix">
        {include file="./product-sort.tpl"}
        {include file="./nbr-product-page.tpl"}
      </div>
      <div class="top-pagination-content clearfix">
        {include file="./product-compare.tpl"}
        {include file="$tpl_dir./pagination.tpl" no_follow=1}
      </div>
    </div>

    {include file="./product-list.tpl" products=$products}

    <div class="content_sortPagiBar">
      <div class="bottom-pagination-content clearfix">
        {include file="./product-compare.tpl"}
        {include file="./pagination.tpl" no_follow=1 paginationId='bottom'}
      </div>
    </div>
  {else}
    <div class="alert alert-warning">{l s='No products for this manufacturer.'}</div>
  {/if}
{/if}
