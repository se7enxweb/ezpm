<?php

include_once( 'kernel/common/template.php' );
//include_once( 'extension/ezpm/modules/pm/classes/ezpm.php' );
include_once( 'extension/ezpm/classes/ezpmblacklist.php' );

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

$blacklist = eZPmBlackList::fetchBlackList( $limit, $Offset );

foreach ( $blacklist as $key => $blacklisted )
{
    $user = eZContentObject::fetch( $blacklisted['blocked_user_id'] );
    $blacklist[$key]['blocked_user_name'] = $user->Name;
}


$tpl = eZTemplate::factory();
$tpl->setVariable( 'blacklist', $blacklist );
$tpl->setVariable( 'blacklist_count', eZPmBlackList::itemCount() );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'limit', $limit );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/blacklist.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm', 'Blacklist' ) ) );

?>
