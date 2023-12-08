<?php

include_once( 'kernel/common/template.php' );
include_once( 'extension/ezpm/classes/ezpm.php' );

$Module =& $Params['Module'];

$userID = $Params['Parameters'][0];

$user = eZUser::currentUser();
$access = $user->hasAccessTo( 'pm', 'send_message' );
if ( $access['accessWord'] != 'yes' )
{
	return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}
   
$userObject = eZUser::fetch( $userID );

if ( !is_object( $userObject ) )
{
    eZDebug::writeError( "User " . eZUser::currentUserID() . " was trying to create message to unknown user, userID: ".$userID );
    $Module->redirectTo( '/pm/contacts' );
}



$tpl = templateInit();
$tpl->setVariable( 'recipientID', $userID );
$tpl->setVariable( 'recipientName', $userID );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/create.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => ezi18n( 'design/standard/ezpm', 'Create new message' ) ) );




?>
