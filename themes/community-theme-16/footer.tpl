{if !isset($content_only) || !$content_only}
        </div><!-- #center_column -->
        {if isset($right_column_size) && !empty($right_column_size)}
          <div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
        {/if}
      </div><!-- .row -->
    </div><!-- #columns -->
  </div><!-- .columns-container -->
  {if isset($HOOK_FOOTER)}
    <!-- Footer -->
    <div class="footer-container">
      <footer id="footer"  class="container">
        <div class="row">{$HOOK_FOOTER}</div>
      </footer>
    </div><!-- #footer -->
  {/if}
  </div><!-- #page -->
{/if}
{include file="$tpl_dir./global.tpl"}
</body>
</html>
