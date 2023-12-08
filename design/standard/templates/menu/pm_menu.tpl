<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc">

        <h4>PM menu</h4>
     {def $stats=fetch( 'pm', 'messages_stats', hash() )
     	  $inbox_total=sum( $stats.inbox_new, $stats.inbox_old )}

        <ul class="menu-list">

          <li class="firstli"><a style="display: inline;" href={"/pm/list_inbox"|ezurl}>{'Inbox'|i18n( 'design/standard/ezpm' )}</a> ({if gt( $stats.inbox_new, 0 )}<strong>{$stats.inbox_new}</strong>/{/if}{$inbox_total})</li>
          <li><a style="display: inline;" href={"/pm/list_sent"|ezurl}>{'Sent'|i18n( 'design/standard/ezpm' )}</a> ({$stats.sent})</li>
          <li><a style="display: inline;" href={"/pm/list_drafts"|ezurl}>{'Drafts'|i18n( 'design/standard/ezpm' )}</a> ({$stats.drafts})</li>
        
        </ul>

        <hr />

        <ul class="menu-list">
        
          <li><a href={"/pm/contacts"|ezurl}>{'Contacts'|i18n( 'design/standard/ezpm' )}</a></li>
          <li><a href={"/pm/blacklist"|ezurl}>{'Blacklist'|i18n( 'design/standard/ezpm' )}</a></li>
        
        </ul>        
        
        
</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>        
