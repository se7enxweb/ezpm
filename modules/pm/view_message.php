<?php

include_once( 'kernel/common/template.php' );
include_once( 'extension/ezpm/classes/ezpm.php' );
include_once( 'extension/ezpm/classes/ezcontact.php' );

$Module =& $Params['Module'];

$currentUserID = eZUser::currentUserID();

$messageID =& $Params['Parameters'][0]; // first parameter from link is message id
$message = eZPm::fetch( $messageID, true );


// check if user is the owner of current message
if ( $message->attribute( 'owner_user_id' ) != $currentUserID )
{
    $Module->redirectTo( '/pm/list_inbox' );
}

/*
echo '<pre>';
print_r($message);
echo '</pre>';
*/

eZPm::markMessageAsRead( $messageID );

$is_contact = eZContact::isOnContactList( $message->SenderUserID );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'user_id', $currentUserID );
$tpl->setVariable( 'messageID', $messageID );
$tpl->setVariable( 'is_contact', $is_contact );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/pm.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => $message->Subject ) );

?>