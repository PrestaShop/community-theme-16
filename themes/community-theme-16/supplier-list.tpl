{capture name=path}{l s='Suppliers:'}{/capture}

<h1 class="page-heading product-listing">{l s='Suppliers:'}
  {strip}
    <span class="heading-counter">
      {if $nbSuppliers == 0}{l s='There are no suppliers.'}
      {else}
        {if $nbSuppliers == 1}
          {l s='There is %d supplier.' sprintf=$nbSuppliers}
        {else}
          {l s='There are %d suppliers.' sprintf=$nbSuppliers}
        {/if}
      {/if}
    </span>
  {/strip}
</h1>

{if isset($errors) AND $errors}
  {include file="$tpl_dir./errors.tpl"}
{else}

  {if $nbSuppliers > 0}
    <div class="content_sortPagiBar">
      <div class="sortPagiBar clearfix">
        {if isset($supplier) && isset($supplier.nb_products) && $supplier.nb_products > 0}
          <ul class="display hidden-xs">
            <li class="display-title">
              {l s='View:'}
            </li>
            <li id="grid">
              <a rel="nofollow" href="#" title="{l s='Grid'}">
                <i class="icon-th-large"></i>{l s='Grid'}
              </a>
            </li>
            <li id="list">
              <a rel="nofollow" href="#" title="{l s='List'}">
                <i class="icon-th-list"></i>{l s='List'}
              </a>
            </li>
          </ul>
        {/if}
        {include file="./nbr-product-page.tpl"}
      </div>
      <div class="top-pagination-content clearfix bottom-line">
        {include file="$tpl_dir./pagination.tpl" no_follow=1}
      </div>
    </div> <!-- .content_sortPagiBar -->

    <ul id="suppliers_list" class="list row">
      {foreach from=$suppliers_list item=supplier name=supplier}
        <li class="col-xs-12">
          <div class="mansup-container">
            <div class="row">
              <div class="left-side col-xs-12 col-sm-3">
                <!-- logo -->
                <div class="logo">
                  {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                  <a href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}" title="{$supplier.name|escape:'html':'UTF-8'}">
                    {/if}
                    <img src="{$img_sup_dir}{$supplier.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="" width="{$mediumSize.width}" height="{$mediumSize.height}" />
                    {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                  </a>
                  {/if}
                </div> <!-- .logo -->
              </div> <!-- .left-side -->

              <div class="middle-side col-xs-12 col-sm-5">
                <h3>
                  {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                  <a class="product-name" href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}">
                    {/if}
                    {$supplier.name|truncate:60:'...'|escape:'html':'UTF-8'}
                    {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                  </a>
                  {/if}
                </h3>
                <div class="description">
                  {$supplier.description|truncate:180:'...'}
                </div>
              </div><!-- .middle-side -->

              <div class="right-side col-xs-12 col-sm-4">
                <div class="right-side-content">
                  <p class="product-counter">
                    {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                    <a href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}">
                      {/if}
                      {if isset($supplier.nb_products) && $supplier.nb_products == 1}{l s='%d product' sprintf=$supplier.nb_products|intval}{else}{l s='%d products' sprintf=$supplier.nb_products|intval}{/if}
                      {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                    </a>
                    {/if}
                  </p>
                  {if isset($supplier.nb_products) && $supplier.nb_products > 0}
                    <a class="btn btn-lg btn-default" href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}"><span>{l s='View products'} <i class="icon-chevron-right right"></i></span></a>
                  {/if}
                </div>
              </div><!-- .right-side -->
            </div>
          </div>
        </li>
      {/foreach}
    </ul>
    <div class="content_sortPagiBar">
      <div class="bottom-pagination-content clearfix">
        {include file="$tpl_dir./pagination.tpl" no_follow=1 paginationId='bottom'}
      </div>
    </div>
  {/if}
{/if}
