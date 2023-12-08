<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

<div class="content-view-full">
    <div class="class-folder">



    {def $user=fetch( 'content', 'object', hash( 'object_id', $recipientID ) ) }


        <div class="attribute-header">
            <h1>{'Create new message'|i18n( 'design/standard/ezpm' )}</h1>
        </div>

    <form action={"pm/action"|ezurl} method="post">
        <input type="hidden" name="recipient" value="{$recipientID}" />
        <input type="hidden" name="message_id" value="{$messageID}" />
        <div class="block">
        	<label>{'Recipient'|i18n( 'design/standard/ezpm' )}</label>
        	{$user.name|wash()}
        </div>
        <div class="block">
        	<label>{'Subject'|i18n( 'design/standard/ezpm' )}</label>
        	<input class="box" type="text" name="subject" value="{$Message.subject|wash}" />
		</div>
		
        <div class="block">
        	<label>{'Body'|i18n( 'design/standard/ezpm' )}</label>
        	<textarea class="box" name="text">{$Message.text}</textarea>
        </div>
        <input class="button" type="submit" name="SendButton" value="{'Send'|i18n( 'design/standard/ezpm' )}" />
        <input class="button" type="submit" name="StoreButton" value="{'Store draft'|i18n( 'design/standard/ezpm' )}" />
        <input class="button" type="submit" name="DiscardButton" value="{'Discard draft'|i18n( 'design/standard/ezpm' )}" />
    </form>

    </div>
</div>

</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>