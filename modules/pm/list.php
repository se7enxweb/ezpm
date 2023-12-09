<?php

include_once( 'kernel/common/template.php' );
include_once( 'extension/ezpm/classes/ezpm.php' );

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


$tpl = eZTemplate::factory();
$tpl->setVariable( 'type', 'inbox' );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'list_count', eZPm::itemCount( 'inbox' ) );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/list_inbox.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'design/standard/ezpm', 'Inbox' ) ) );

?>
