{*def $access=fetch( 'user', 'has_access_to',
                    hash( 'module',   'pm',
                          'function', 'list' ) )}

{if $access}
    Access is allowed.
{else}
    Access is denied.
{/if*}


<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

<div class="content-view-full">
    <div class="class-folder">

        <div class="attribute-header">
            <h1>{'Inbox'|i18n('design/standard/ezpm')}</h1>
        </div>


    <script type="text/javascript" src={'javascript/tools/ezjsselection.js'|ezdesign}></script>
    
    
    {def $limit=10
         $sorting=ezpreference( 'messages_list_sorting' )
         $list=fetch( 'pm', 'list', hash( 'offset', $view_parameters.offset,
                                          'limit', $limit,
                                          'sort', $sorting,
                                          'type', $type ) ) }
    
    <form name="messages" action={"/pm/action/"|ezurl} method="post" >
    <table class="list" cellspacing="0">
        <tr>
            <th class="tight"><img src={"toggle-button-16x16.gif"|ezimage} alt="{'Toggle selection'|i18n( 'design/admin/role/list')}" onclick="ezjs_toggleCheckboxes( document.messages, 'DeleteIDArray[]' ); return false;"/></th>
            <th>{if eq( $sorting, 'sender_asc' )}<a href={'/user/preferences/set/messages_list_sorting/sender_desc/'|ezurl}>{else}<a href={'/user/preferences/set/messages_list_sorting/sender_asc/'|ezurl}>{/if}{'From'|i18n( 'design/standard/ezpm' )}</a></th>
            <th>{if eq( $sorting, 'subject_asc' )}<a href={'/user/preferences/set/messages_list_sorting/subject_desc/'|ezurl}>{else}<a href={'/user/preferences/set/messages_list_sorting/subject_asc/'|ezurl}>{/if}{'Subject'|i18n( 'design/standard/ezpm' )}</a></th>
            <th>{if eq( $sorting, 'date_asc' )}<a href={'/user/preferences/set/messages_list_sorting/date_desc/'|ezurl}>{else}<a href={'/user/preferences/set/messages_list_sorting/date_asc/'|ezurl}>{/if}{'Date received'|i18n( 'design/standard/ezpm' )}</a></th>
            <th class="tight">&nbsp;</th>
        </tr>
    
    {def $new=''}
    {section var=Message loop=$list sequence=array( bglight, bgdark )}
        {if eq($Message.date_read, 0)}
          {set $new='font-weight: bold;'}
        {else}
          {set $new=''}
        {/if}
        <tr class="{$Message.sequence}">
            <td class="tight"><input type="checkbox" name="DeleteIDArray[]" value="{$Message.item.id}" title="{'Select message for removal.'|i18n( 'design/standard/ezpm' )}" /></td>
            <td style="cursor:pointer;{$new}" onclick="document.location.href='{concat( '/pm/message/', $Message.item.id)|ezurl('no')}'" title="{'Click here to read this message'|i18n( 'design/standard/ezpm' )}">{$Message.sender_name|wash}</td>
            <td style="cursor:pointer;{$new}" onclick="document.location.href='{concat( '/pm/message/', $Message.item.id)|ezurl('no')}'" title="{'Click here to read this message'|i18n( 'design/standard/ezpm' )}">{$Message.subject|shorten( 40, '...' )|wash}</td>
            <td style="cursor:pointer;{$new}" onclick="document.location.href='{concat( '/pm/message/', $Message.item.id)|ezurl('no')}'" title="{'Click here to read this message'|i18n( 'design/standard/ezpm' )}">{$Message.date_sent|l10n( 'shortdatetime' )}</td>
            <td>
                <a href={concat( '/pm/reply/', $Message.item.id)|ezurl}>{'Reply'|i18n( 'design/standard/ezpm' )}</a>
                {*<a href={concat( '/pm/message/', $Message.item.id)|ezurl}>read</a>*}
            </td>
        </tr>
    {/section}
    </table>
    
    
    <div class="context-toolbar">
    {include name=navigator
             uri='design:navigator/google.tpl'
             page_uri='/pm/list_inbox'
             item_count=$list_count
             view_parameters=$view_parameters
             item_limit=$limit}
    
    </div>
    
    <div class="controlbar">
    {* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
    <div class="block">
        <input class="button" type="submit" name="RemoveButton" value="{'Remove selected'|i18n( 'design/standard/ezpm' )}" title="{'Remove selected messages.'|i18n( 'design/standard/ezpm' )}" />
    </div>
    {* DESIGN: Control bar END *}</div></div></div></div></div></div>
    </div>
    
    </form>
    
    
    
    
    </div>
</div>

</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>
