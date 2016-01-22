{if isset($HOOK_HOME_TAB_CONTENT) && $HOOK_HOME_TAB_CONTENT|trim}
  {if isset($HOOK_HOME_TAB) && $HOOK_HOME_TAB|trim}
    <ul id="home-page-tabs" class="nav nav-tabs clearfix">
      {$HOOK_HOME_TAB}
    </ul>
  {/if}
  <div class="tab-content">{$HOOK_HOME_TAB_CONTENT}</div>
{/if}
{if isset($HOOK_HOME) && $HOOK_HOME|trim}
  <div class="clearfix">{$HOOK_HOME}</div>
{/if}
