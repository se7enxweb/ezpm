<?php

include_once( 'kernel/classes/ezcontentobject.php' );
include_once( 'kernel/classes/ezcontentclass.php' );
include_once( "lib/ezdb/classes/ezdb.php" );
include_once( "lib/ezutils/classes/ezhttptool.php" );
include_once( 'extension/ezpm/classes/ezpm.php' );
include_once( 'extension/ezpm/classes/ezpmblacklist.php' );
include_once( 'extension/ezpm/classes/ezcontact.php' );
//include_once( "lib/ezutils/classes/ezini.php" );
//include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
include_once( 'kernel/common/template.php' );

$http = eZHTTPTool::instance();
$Module = $Params["Module"];


if ( $Module->isCurrentAction( 'StoreMessage' ) )
{
    // If message is already in drafts, we just update it with new data ...
    if ( $http->hasPostVariable( 'message_id' ) && $http->postVariable( 'message_id' ) > 0 )
    {
        $message = eZPm::fetch( $http->postVariable( 'message_id' ), true );
        if ( is_object( $message ) )
        {
            $message->Subject = $http->postVariable( 'subject' );
            $message->Text = $http->postVariable( 'text' );
            $message->store();
        }
    }
    // ... if not, we are creating new message in drafts folder
    else
    {
        eZPm::createNewMessage( eZUser::currentUserID(), $http->postVariable( 'recipient' ), $http->postVariable( 'subject' ), $http->postVariable( 'text' ) );
    }
    
    $Module->redirectTo( '/pm/list_drafts' );
}

else if ( $Module->isCurrentAction( 'SendMessage' ) )
{
    // if message is send from drafts, message have to be removed from drafts
    if ( $http->hasPostVariable( 'message_id' ) && $http->postVariable( 'message_id' ) > 0 )
    {
        $message = eZPm::fetch( $http->postVariable( 'message_id' ), true );
        if ( is_object( $message ) )
        {
            $message->remove();
            unset( $message );
        }
    }
    // now we send message
    $message = eZPm::sendNewMessage( eZUser::currentUserID(), $http->postVariable( 'recipient' ), $http->postVariable( 'subject' ), $http->postVariable( 'text' ) );


	// email notification about new message if enabled
	$eZPmINI = eZINI::instance( 'ezpm.ini' );
	if (  $eZPmINI->variable( 'GeneralSettings', 'EmailNotification' ) == 'enabled' )
	{
		// get receiver data
		$userObject = eZContentObject::fetch( $http->postVariable( 'recipient' ) );
		if ( !is_object( $userObject ) )
		{
			$Module->redirectTo( '/pm/list_sent' );
		}
		$userDataMap = $userObject->DataMap();
		
		$firstName = $userDataMap['first_name']->Content();
		$ezuser = $userDataMap['user_account']->Content();
		
	     $receiver   = $ezuser->attribute( 'email' );
	    //$subject     = $http->postVariable( 'subject' );
	    //$messageText = $http->postVariable( 'text' );
	    
	    $hostname = eZSys::hostname();
	
	    $tpl = eZTemplate::factory();
	    $tpl->setVariable( 'recipient', $receiver );
	    //$tpl->setVariable( 'subject', $subject );
	    //$tpl->setVariable( 'text', $messageText );
	    $tpl->setVariable( 'hostname', $hostname );
	    $tpl->setVariable( 'first_name', $firstName );
	    $tpl->setVariable( 'messageID', $message->attribute( 'id' ) );
	
	    $ini = eZINI::instance();
	    $emailSender = $ini->variable( 'MailSettings', 'EmailSender' );
	    if ( !$emailSender )
	    {
	        $emailSender = $ini->variable( 'MailSettings', 'AdminEmail' );
		}
	
	    $templateResult = $tpl->fetch( 'design:pm/notification_email.tpl' );
	
	    $subject = $tpl->variable( 'subject' );
	
	    $mail = new eZMail();
	    $mail->setSender( $emailSender );
	    $mail->setReceiver( $receiver );
	    $mail->setSubject( $subject );
	    $mail->setBody( $templateResult );
	
	    $mailResult = eZMailTransport::send( $mail );
		
	}

    $Module->redirectTo( '/pm/list_sent' );
}


else if ( $http->hasPostVariable( 'CancelButton' ) )
{
        //return $module->redirectTo( $http->postVariable( 'CancelURI' ) );
}

else if ( $Module->isCurrentAction( 'Reply' ) )
{
    if ( $http->hasPostVariable( 'MessageID' ) )
    {
        $Module->redirectTo( '/pm/reply/' . $http->postVariable( 'MessageID' ) );
    }
    else
    {
        $Module->redirectTo( '/pm/list_inbox' );
    }
}

else if ( $Module->isCurrentAction( 'RemoveMessage' ) )
{

    $deleteIDArray = $http->postVariable( 'DeleteIDArray' );
    foreach ($deleteIDArray as $messageID)
    {
        $message = eZPm::fetch( $messageID, true );
        $message->remove();
    }
    
    $Module->redirectTo( '/pm/list' );
}

// blacklist actions

else if ( $Module->isCurrentAction( 'AddToBlacklist' ) )
{
    if ( $http->hasPostVariable( 'blockUserID' ) )
    {
        $blockUserID = $http->postVariable( 'blockUserID' );
        eZPmBlackList::addToBlackList( $blockUserID );
    }

    $Module->redirectTo( '/pm/blacklist' );
}


else if ( $Module->isCurrentAction( 'RemoveFromBlacklist' ) )
{
    $deleteIDArray = $http->postVariable( 'DeleteIDArray' );
    foreach ( $deleteIDArray as $blockedUserID )
    {
        $blockade = eZPmBlackList::fetch( $blockedUserID, true );
        if ( is_object( $blockade ) )
        {
            $blockade->remove();
        }
    }

    $Module->redirectTo( '/pm/blacklist' );
}


// contact list actions

else if ( $Module->isCurrentAction( 'AddToContacts' ) )
{
    if ( $http->hasPostVariable( 'contactUserID' ) )
    {
        $contactUserID = $http->postVariable( 'contactUserID' );
        eZContact::addToContactList( $contactUserID );
    }

    $Module->redirectTo( '/pm/contacts' );
}


else if ( $Module->isCurrentAction( 'RemoveFromContactList' ) )
{
    $deleteIDArray = $http->postVariable( 'DeleteIDArray' );
    foreach ( $deleteIDArray as $contactUserID )
    {
        $contact = eZContact::fetch( $contactUserID, true );
        if ( is_object( $contact ) )
        {
            $contact->remove();
        }
    }

    $Module->redirectTo( '/pm/contacts' );
}

else
{
    $Module->redirectTo( '/pm/contacts' );
}



?>
