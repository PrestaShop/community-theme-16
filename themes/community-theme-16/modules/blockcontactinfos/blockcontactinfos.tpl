<!-- MODULE Block contact infos -->
<section id="block_contact_infos" class="footer-block col-xs-12 col-sm-4">
  <div>
    <h4>{l s='Store Information' mod='blockcontactinfos'}</h4>
    <ul class="toggle-footer">
      {if $blockcontactinfos_company != ''}
        <li>
          <i class="icon-map-marker"></i>{$blockcontactinfos_company|escape:'html':'UTF-8'}{if $blockcontactinfos_address != ''}, {$blockcontactinfos_address|escape:'html':'UTF-8'}{/if}
        </li>
      {/if}
      {if $blockcontactinfos_phone != ''}
        <li>
          <i class="icon-phone"></i>{l s='Call us now:' mod='blockcontactinfos'}
          <span>{$blockcontactinfos_phone|escape:'html':'UTF-8'}</span>
        </li>
      {/if}
      {if $blockcontactinfos_email != ''}
        <li>
          <i class="icon-envelope-alt"></i>{l s='Email:' mod='blockcontactinfos'}
          <span>{mailto address=$blockcontactinfos_email|escape:'html':'UTF-8' encode="hex"}</span>
        </li>
      {/if}
    </ul>
  </div>
</section>
<!-- /MODULE Block contact infos -->
