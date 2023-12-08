<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

<div class="content-view-full">
    <div class="class-folder">

{def $message=fetch( 'pm', 'view_message', hash( 'id', $messageID ) )}

        <div class="attribute-header">
            <h1>{$message.subject|wash}</h1>
        </div>


<form name="message" action={"/pm/action/"|ezurl} method="post" >
{*$message|attribute(show)*}

<div class="block">
    <label>{'From'|i18n( 'design/standard/ezpm' )}</label>
    {$message.sender_name}
</div>

{if eq( $message.recipient_id, $user_id)}
    
    <div class="block">
        <label>{'To'|i18n( 'design/standard/ezpm' )}</label>
        {$message.recipient_name}
    </div>
{/if}

<div class="block">
    <label>{'Date received'|i18n( 'design/standard/ezpm' )}</label>
    {$message.date_sent|datetime( 'custom', '%h:%i %a %d %M %Y' )}
</div>

<div class="block">{$message.text|nl2br}</div>


<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block">
    <input type="hidden" name="blockUserID" value="{$message.sender_id}" />
    <input type="hidden" name="MessageID" value="{$messageID}" />
{def $access_contact=fetch( 'user', 'has_access_to', hash( 'module',   'pm', 'function', 'add_contact' ) )
     $access_write_message=fetch( 'user', 'has_access_to', hash( 'module',   'pm', 'function', 'create' ) )
}

{* Checking if current user is creator this message
 * If yes, don't show any actions buttons.
 *}
{if ne( $message.sender_id, $user_id )}

{* Checking if user can add to contacts and if sender is already on contact list *}
  {if and( $access_contact, eq( $is_contact, 0 ) )}
    <input type="hidden" name="contactUserID" value="{$message.sender_id}" />
    <input class="button" type="submit" name="AddToContactsButton" value="{'Add to contacts'|i18n( 'design/standard/ezpm' )}" title="" />
  {/if}

    <input class="button" type="submit" name="AddToBlacklistButton" value="{'Add to blacklist'|i18n( 'design/standard/ezpm' )}" title="" />

  {if $access_write_message}
    <input class="button" type="submit" name="ReplyButton" value="{'Reply'|i18n( 'design/standard/ezpm' )}" title="" />
  {/if}
  


{/if}
</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>



</form>
    </div>
</div>

</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>

