{capture name=path}{l s='Manufacturers:'}{/capture}

<h1 class="page-heading product-listing">
  {l s='Brands'}
  <div class="pull-right">
    <span class="heading-counter badge">
      {if $nbManufacturers == 0}
        {l s='There are no manufacturers.'}
      {else}
        {if $nbManufacturers == 1}
          {l s='There is 1 brand'}
        {else}
          {l s='There are %d brands' sprintf=$nbManufacturers}
        {/if}
      {/if}
    </span>
  </div>
</h1>
{if isset($errors) AND $errors}
  {include file="$tpl_dir./errors.tpl"}
{else}
  {if $nbManufacturers > 0}
    <div class="content_sortPagiBar">
      <div class="sortPagiBar clearfix">
        {if isset($manufacturer) && isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
          <ul class="display hidden-xs">
            <li class="display-title">
              {l s='View:'}
            </li>
            <li id="grid">
              <a rel="nofollow" href="#" title="{l s='Grid'}">
                <i class="icon icon-th-large"></i> {l s='Grid'}
              </a>
            </li>
            <li id="list">
              <a rel="nofollow" href="#" title="{l s='List'}">
                <i class="icon icon-th-list"></i> {l s='List'}
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

    <ul id="manufacturers_list" class="list row">
      {foreach from=$manufacturers item=manufacturer name=manufacturers}
        <li class="col-xs-12">
          <div class="mansup-container">
            <div class="row">
              <div class="left-side col-xs-12 col-sm-3">
                <div class="logo">
                  {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                  <a
                    class="lnk_img"
                    href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}"
                    title="{$manufacturer.name|escape:'html':'UTF-8'}" >
                    {/if}
                    <img src="{$img_manu_dir}{$manufacturer.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="" />
                    {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                  </a>
                  {/if}
                </div> <!-- .logo -->
              </div> <!-- .left-side -->

              <div class="middle-side col-xs-12 col-sm-5">
                <h3>
                  {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                  <a
                    class="product-name"
                    href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
                    {/if}
                    {$manufacturer.name|truncate:60:'...'|escape:'html':'UTF-8'}
                    {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                  </a>
                  {/if}
                </h3>
                <div class="description rte">
                  {$manufacturer.short_description}
                </div>
              </div> <!-- .middle-side -->

              <div class="right-side col-xs-12 col-sm-4">
                <div class="right-side-content">
                  <p class="product-counter">
                    {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                    <a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
                      {/if}
                      {if isset($manufacturer.nb_products) && $manufacturer.nb_products == 1}
                        {l s='%d product' sprintf=$manufacturer.nb_products|intval}
                      {else}
                        {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                          {l s='%d products' sprintf=$manufacturer.nb_products|intval}
                        {/if}
                      {/if}
                      {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                    </a>
                    {/if}
                  </p>
                  {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                    <a
                      class="btn btn-lg btn-default"
                      href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
                      <span>
                        {l s='view products'} <i class="icon icon-chevron-right"></i>
                      </span>
                    </a>
                  {/if}
                </div>
              </div> <!-- .right-side -->
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
