<?php

include_once( 'kernel/common/template.php' );
include_once( 'extension/ezpm/classes/ezpm.php' );

$Module =& $Params['Module'];

$messageID =& $Params['id'];

$user =& eZUser::currentUser();
$access = $user->hasAccessTo( 'pm', 'send_message' );
if ( $access['accessWord'] == 'yes' )
{


    // retrieving message data
    $Message =& eZPm::fetch( $messageID, false );

    if ( !$Message || $Message['owner_user_id'] != eZUser::currentUserID() )
    {
        $Module->redirectTo( '/pm/list' );
    }
    $tpl =& templateInit();
    $tpl->setVariable( 'title', 'Edit' );
    $tpl->setVariable( 'Message', $Message );
    $tpl->setVariable( 'messageID', $messageID );
    $tpl->setVariable( 'recipientID', $Message['recipient_id'] );
    $tpl->setVariable( 'recipientName', $Message['recipient_name'] );

    $Result = array();
    $Result['content'] =& $tpl->fetch( 'design:pm/create.tpl' );
    $Result['pagelayout'] = 'pm_pagelayout.tpl';
    $Result['path'] = array( array( 'url' => false,
                                    'text' => 'Reply' ) );

}
else
{
    return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}


?>
