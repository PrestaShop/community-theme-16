<section id="blocksocial" class="col-xs-12 col-sm-2">
  <h4>{l s='Follow us' mod='blocksocial'}</h4>
  <ul class="list-inline">

    {if !empty($facebook_url)}
      <li>
        <a href="{$facebook_url|escape:html:'UTF-8'}" title="{l s='Facebook' mod='blocksocial'}">
          <i class="icon icon-facebook icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($twitter_url)}
      <li>
        <a href="{$twitter_url|escape:html:'UTF-8'}" title="{l s='Twitter' mod='blocksocial'}">
          <i class="icon icon-twitter icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($rss_url)}
      <li>
        <a href="{$rss_url|escape:html:'UTF-8'}" title="{l s='RSS' mod='blocksocial'}">
          <i class="icon icon-rss icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($youtube_url)}
      <li>
        <a href="{$youtube_url|escape:html:'UTF-8'}" title="{l s='Youtube' mod='blocksocial'}">
          <i class="icon icon-youtube icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($google_plus_url)}
      <li>
        <a href="{$google_plus_url|escape:html:'UTF-8'}" title="{l s='Google Plus' mod='blocksocial'}">
          <i class="icon icon-google-plus icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($pinterest_url)}
      <li>
        <a href="{$pinterest_url|escape:html:'UTF-8'}" title="{l s='Pinterest' mod='blocksocial'}">
          <i class="icon icon-pinterest icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($vimeo_url)}
      <li>
        <a href="{$vimeo_url|escape:html:'UTF-8'}" title="{l s='Vimeo' mod='blocksocial'}">
          <i class="icon icon-vimeo icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

    {if !empty($instagram_url)}
      <li>
        <a href="{$instagram_url|escape:html:'UTF-8'}" title="{l s='Instagram' mod='blocksocial'}">
          <i class="icon icon-instagram icon-2x icon-fw"></i>
        </a>
      </li>
    {/if}

  </ul>
</section>
