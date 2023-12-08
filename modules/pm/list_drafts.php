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


$tpl = templateInit();
$tpl->setVariable( 'type', 'drafts' );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'list_count', eZPm::itemCount( 'drafts' ) );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:pm/list_drafts.tpl' );
$Result['pagelayout'] = 'pm_pagelayout.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'design/standard/ezpm', 'Private messaging' ) ),
                         array( 'url' => false,
                                'text' => ezi18n( 'design/standard/ezpm', 'Drafts' ) ) );

?>