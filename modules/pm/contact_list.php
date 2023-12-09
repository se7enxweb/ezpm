<?php

include_once( 'kernel/common/template.php' );
//include_once( 'extension/ezpm/classes/ezpm.php' );
include_once( 'extension/ezpm/classes/ezcontact.php' );

$Module =& $Params['Module'];
if ( !empty( $Params['UserParameters']['offset'] ) )
{
    $Offset = $Params['UserParameters']['offset'];
}
else
{
    $Offset = 0;
}
$viewParameters = array( 'offset' => $Offset );
$limit = 10;

$user = eZUser::currentUser();
$access = $user->hasAccessTo( 'pm', 'contacts' );
if ( $access['accessWord'] != 'yes' )
{
    return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}

$contacts = eZContact::fetchContactList( $limit, $Offset );

foreach ( $contacts as $key => $contact )
{
    $user = eZContentObject::fetch( $contact['contact_user_id'] );
    $contacts[$key]['contact_user_name'] = $user->Name;
}

$tpl = eZTemplate::factory();
$tpl->setVariable( 'contacts', $contacts );
$tpl->setVariable( 'list_count', eZContact::itemCount() );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'limit', $limit );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/contact_list.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm','Contact list' ) ) );



?>
