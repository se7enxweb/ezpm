<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

<div class="content-view-full">
    <div class="class-folder">


        <div class="attribute-header">
            <h1>{'Contact list'|i18n( 'design/standard/ezpm' )}</h1>
        </div>

<form name="contacts" action={"/pm/action/"|ezurl} method="post" >
<table class="list" cellspacing="0">
    <tr>
        <th class="tight"><img src={"toggle-button-16x16.gif"|ezimage} alt="{'Toggle selection'|i18n( 'design/admin/role/list')}" onclick="ezjs_toggleCheckboxes( document.contacts, 'DeleteIDArray[]' ); return false;"/></th>
        <th>{'User name'|i18n( 'design/standard/ezpm' )}</th>
        <th class="tight"></th>
    </tr>

{section var=user loop=$contacts sequence=array( bglight, bgdark )}
    <tr class="{$user.sequence}">
        <td class="tight"><input type="checkbox" name="DeleteIDArray[]" value="{$user.contact_user_id}" title="" /></td>
        <td>{$user.contact_user_name|wash}</td>
        <td><a href={concat( "/pm/create/", $user.contact_user_id )|ezurl}>{'Send message'|i18n( 'design/standard/ezpm' )}</a></td>

    </tr>
{/section}
</table>

<div class="context-toolbar">
{include name=navigator
         uri='design:navigator/google.tpl'
         page_uri='/pm/contacts'
         item_count=$list_count
         view_parameters=$view_parameters
         item_limit=$limit}

</div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block">
    <input class="button" type="submit" name="RemoveFromContactListButton" value="{'Remove selected'|i18n( 'design/standard/ezpm' )}" title="" />
</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</form>

    </div>
</div>

</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>
