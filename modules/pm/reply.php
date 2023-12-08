<?php

include_once( 'kernel/common/template.php' );
include_once( 'extension/ezpm/classes/ezpm.php' );

$Module =& $Params['Module'];

$messageID =& $Params['id'];

$user = eZUser::currentUser();
$access = $user->hasAccessTo( 'pm', 'send_message' );
if ( $access['accessWord'] != 'yes' )
{
	return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}

$messageObject = eZPm::fetch( $messageID, true );
$userID = $messageObject->SenderUserID;
$userObject = eZUser::fetch( $userID );
if ( !is_object( $userObject ) )
{
    eZDebug::writeError( "User " . eZUser::currentUserID() . " was trying to create message to unknown user, userID: ".$userID );
    $Module->redirectTo( '/pm/list_inbox' );
}

// retrieving message data
$Message = eZPm::fetch( $messageID, false );

if ( !$Message || $Message['owner_user_id'] != eZUser::currentUserID() )
{
    $Module->redirectTo( '/pm/list_inbox' );
}

// adding Re: to reply message, but only once
// not sure if this is ok, can be a problem when users are using different lang
$reply = ezi18n( 'design/standard/ezpm', 'Re: ' );
if ( substr ( $Message['subject'], 0, 4 ) != $reply )
{
    $Message['subject'] = $reply . $Message['subject'];
}

$tpl = templateInit();
$tpl->setVariable( 'Message', $Message );
$tpl->setVariable( 'recipientID', $userID );
$tpl->setVariable( 'recipientName', $userID );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/create.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => ezi18n( 'design/standard/ezpm', 'Reply' ) ) );


?>