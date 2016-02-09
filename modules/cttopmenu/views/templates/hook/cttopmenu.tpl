{* @TODO Sort trees into 4 columns *}
{* @TODO Output max depth *}

{if !empty($menu_items) || $show_search_form}

  <div id="cttopmenu" class="col-xs-12{if $use_hover} js-use-hover{/if}{if $show_search_form} with-search-form{/if}">
    <div class="navbar navbar-default yamm">

      <div class="navbar-header">
        <button type="button" data-toggle="collapse" data-target="#cttopmenu-navbar-collapse" class="navbar-toggle">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="#" class="navbar-brand visible-xs">{l s='Menu' mod='cttopmenu'}</a>
      </div>

      <div id="cttopmenu-navbar-collapse" class="navbar-collapse collapse">

        {if !empty($menu_items)}
          <ul class="nav navbar-nav">
            {foreach from=$menu_items item=menu_item}
              {if empty($menu_item.sub_items)}

                <li class="cttm-item-{$menu_item.type|escape:'html':'UTF-8'}{if !empty($menu_item.class)} {$menu_item.class|escape:'html':'UTF-8'}{/if}">
                  <a id="cttm-item-{$menu_item.id|escape:'html':'UTF-8'}" href="{$menu_item.url|escape:'html':'UTF-8'}" class="cttm-link" title="{$menu_item.title|escape:'html':'UTF-8'}"{if $menu_item.no_follow} rel="nofollow"{/if}>
                    {if !empty($menu_item.icon)}<i class="icon icon-fw icon-{$menu_item.icon|escape:'html':'UTF-8'}"></i>{/if}
                    {$menu_item.name|escape:'html':'UTF-8'}
                  </a>
                </li>

              {else}

                <li class="dropdown yamm-fw cttm-item-{$menu_item.type|escape:'html':'UTF-8'}{if !empty($menu_item.class)} {$menu_item.class|escape:'html':'UTF-8'}{/if}">
                  <a id="cttm-item-{$menu_item.id|escape:'html':'UTF-8'}" href="{$menu_item.url|escape:'html':'UTF-8'}" data-toggle="dropdown" class="dropdown-toggle cttm-link" aria-expanded="false" title="{$menu_item.title|escape:'html':'UTF-8'}"{if $menu_item.no_follow} rel="nofollow"{/if}>
                    {if !empty($menu_item.icon)}<i class="icon icon-fw icon-{$menu_item.icon|escape:'html':'UTF-8'}"></i>{/if}
                    {$menu_item.name|escape:'html':'UTF-8'}<b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <div class="dropdown-content">
                        {include file='./dropdown_content.tpl'}
                      </div>
                    </li>
                  </ul>
                </li>

              {/if}
            {/foreach}
          </ul>
        {/if}

        {if $show_search_form}
          <form id="search_block_cttopmenu" class="navbar-form navbar-right" role="search" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}">
            <input type="hidden" name="controller" value="search" />
            <input type="hidden" name="orderby" value="position" />
            <input type="hidden" name="orderway" value="desc" />
            <div class="form-group">
              <div class="input-group">
                <input id="search_query_cttopmenu" type="search" name="search_query" class="form-control" placeholder="{l s='Search' mod='cttopmenu'}" value="" required>
                <span class="input-group-btn">
                  <button type="submit" name="submit_search" class="btn btn-primary" title="{l s='Search' mod='cttopmenu'}">
                    <i class="icon icon-search"></i>
                  </button>
                </span>
              </div>
            </div>
          </form>
        {/if}

      </div>
    </div>
  </div>

{/if}
