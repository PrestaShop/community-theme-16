{if isset($htmlitems) && $htmlitems}
<div id="htmlcontent_{$hook|escape:'htmlall':'UTF-8'}"{if $hook == 'footer'} class="footer-block col-xs-12 col-sm-4"{/if}>
	<ul class="htmlcontent-home clearfix row">
		{foreach name=items from=$htmlitems item=hItem}
			{if $hook == 'left' || $hook == 'right'}
				<li class="htmlcontent-item-{$smarty.foreach.items.iteration|escape:'htmlall':'UTF-8'} col-xs-12">
			{else}
				<li class="htmlcontent-item-{$smarty.foreach.items.iteration|escape:'htmlall':'UTF-8'} col-xs-4">
			{/if}
					{if $hItem.url}
						<a href="{$hItem.url|escape:'htmlall':'UTF-8'}" class="item-link"{if $hItem.target == 1} onclick="return !window.open(this.href);"{/if} title="{$hItem.title|escape:'htmlall':'UTF-8'}">
					{/if}
						{if $hItem.image}
							<img src="{$link->getMediaLink("`$module_dir`img/`$hItem.image`")}" class="item-img {if $hook == 'left' || $hook == 'right'}img-responsive{/if}" title="{$hItem.title|escape:'htmlall':'UTF-8'}" alt="{$hItem.title|escape:'htmlall':'UTF-8'}" width="{if $hItem.image_w}{$hItem.image_w|intval}{else}100%{/if}" height="{if $hItem.image_h}{$hItem.image_h|intval}{else}100%{/if}"/>
						{/if}
						{if $hItem.title && $hItem.title_use == 1}
							<h3 class="item-title">{$hItem.title|escape:'htmlall':'UTF-8'}</h3>
						{/if}
						{if $hItem.html}
							<div class="item-html">
								{$hItem.html}
							</div>
						{/if}
					{if $hItem.url}
						</a>
					{/if}
				</li>
		{/foreach}
	</ul>
</div>
{/if}
