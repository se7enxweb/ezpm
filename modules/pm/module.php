<?php

$Module = array( 'name' => 'Personal Messager' );

$ViewList = array();

$ViewList['message'] = array(
    'script' => 'view_message.php',
    'params' => array ( "id" => "id" ) );

$ViewList['list'] = array(
    'script' => 'list.php',
    'params' => array () );

$ViewList['list_inbox'] = array(
    'script' => 'list.php',
    'params' => array ( ) );

$ViewList['list_sent'] = array(
    'script' => 'list_sent.php',
    'params' => array ( ) );

$ViewList['list_drafts'] = array(
    'script' => 'list_drafts.php',
    'params' => array ( ) );

$ViewList['create'] = array(
    'script' => 'create.php',
    'params' => array () );

$ViewList['reply'] = array(
    'script' => 'reply.php',
    'params' => array ( "id" => "id" ) );

$ViewList['edit'] = array(
    'script' => 'edit.php',
    'params' => array ( "id" => "id" ) );

$ViewList['add'] = array(
    'script' => 'add.php',
    'single_post_actions' => array( 'SendButton' => 'SendMessage',
                                    'StoreButton' => 'StoreMessage',
                                    'DiscardButton' => 'DiscardMessage'),
    'params' => array () );

$ViewList['action'] = array(
    'script' => 'action.php',
    'single_post_actions' => array( 'RemoveButton' => 'RemoveMessage',
                                    'ReplyButton' => 'Reply',
                                    'SendButton' => 'SendMessage',
                                    'StoreButton' => 'StoreMessage',
                                    'DiscardButton' => 'DiscardMessage',
                                    'AddToBlacklistButton' => 'AddToBlacklist',
                                    'RemoveFromBlackListButton' => 'RemoveFromBlacklist',
                                    'AddToContactsButton' => 'AddToContacts',
                                    'RemoveFromContactListButton' => 'RemoveFromContactList'),
    'params' => array () );

$ViewList['blacklist'] = array(
    'script' => 'blacklist.php',
    'params' => array () );

$ViewList['contacts'] = array(
    'script' => 'contact_list.php',
    'params' => array () );

$FunctionList['list'] = array( );
$FunctionList['blacklist'] = array( );
$FunctionList['contacts'] = array( );
$FunctionList['send_message'] = array( );
$FunctionList['add_contact'] = array( );
$FunctionList['stats'] = array( );

?>
