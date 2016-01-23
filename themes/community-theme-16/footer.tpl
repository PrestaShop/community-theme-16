{if !isset($content_only) || !$content_only}
      </div><!-- #center_column -->
    {if isset($right_column_size) && !empty($right_column_size)}
      <aside id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</aside>
    {/if}
    </div><!-- .row -->
  </div><!-- #columns -->

  <footer id="footer">

    {if isset($HOOK_FOOTER)}
      <div class="container">
        <div class="row">{$HOOK_FOOTER}</div>
      </div>
    {/if}

    {* @TODO Use a setting from community theme configuration module to toggle this *}
    {if 1 || !empty($display_copyright) && $display_copyright}
      <div id="copyright-footer">
          {l s='[1] %3$s %2$s - Ecommerce software by %1$s [/1]' mod='blockcms' sprintf=['PrestaShop™', 'Y'|date, '©'] tags=['<a class="_blank" href="http://www.prestashop.com">'] nocache}
      </div>
    {/if}

  </footer>

{/if}
{include file="$tpl_dir./global.tpl"}
</body>
</html>
