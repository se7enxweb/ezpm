<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

<div class="content-view-full">
    <div class="class-folder">


        <div class="attribute-header">
            <h1>{'Blacklist'|i18n( 'design/standard/ezpm' )}</h1>
        </div>


    <script type="text/javascript" src={'javascript/tools/ezjsselection.js'|ezdesign}></script>

    <form name="blacklist" action={"/pm/action/"|ezurl} method="post" >
    <table class="list" cellspacing="0">
        <tr>
            <th class="tight"><img src={"toggle-button-16x16.gif"|ezimage} alt="{'Toggle selection'|i18n( 'design/admin/role/list')}" onclick="ezjs_toggleCheckboxes( document.blacklist, 'DeleteIDArray[]' ); return false;"/></th>
            <th>{'User name'|i18n( 'design/standard/ezpm' )}</th>
        </tr>

    {foreach $blacklist as $user sequence array( bglight, bgdark ) as $sequence}
        <tr class="{$sequence}">
            <td class="tight"><input type="checkbox" name="DeleteIDArray[]" value="{$user.blocked_user_id}" title="" /></td>
            <td>{$user.blocked_user_name|wash}</td>
        </tr>
    {/foreach}
    </table>

    <div class="context-toolbar">
    {include name=navigator
             uri='design:navigator/google.tpl'
             page_uri='/pm/blacklist'
             item_count=$blacklist_count
             view_parameters=$view_parameters
             item_limit=$limit}
    </div>

    <div class="controlbar">
    {* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
    <div class="block">
        <input class="button" type="submit" name="RemoveFromBlackListButton" value="{'Remove selected'|i18n( 'design/standard/ezpm' )}" title="" />
    </div>
    {* DESIGN: Control bar END *}</div></div></div></div></div></div>
    </div>

    </form>

    </div>
</div>

</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>
