<?php
//
// Created on: <24-May-2006 16:45:07 Bartek Modzelewski>


/*! \file function_definition.php
*/

$FunctionList = array();

$FunctionList['view_message'] = array( 'name' => 'view_message',
                                 'call_method' => array( 'class' => 'eZPm',
                                                         'method' => 'fetchMessage' ),
                                 'parameter_type' => 'standard',
                                 'parameters' => array ( array ( 'name' => 'id',
                                                                 'type' => 'integer',
                                                                 'required' => true ) ) );

$FunctionList['list'] = array( 'name' => 'list',
                                 'call_method' => array( 'class' => 'eZPm',
                                                         'method' => 'fetchMessageList' ),
                                 'parameter_type' => 'standard',
                                 'parameters' => array ( array ( 'name' => 'offset',
                                                                 'type' => 'integer',
                                                                 'required' => false ),
                                                         array ( 'name' => 'limit',
                                                                 'type' => 'integer',
                                                                 'required' => false ),
                                                         array ( 'name' => 'sort',
                                                                 'type' => 'string',
                                                                 'required' => false ),
                                                         array ( 'name' => 'type',
                                                                 'type' => 'string',
                                                                 'required' => true ) ) );

$FunctionList['messages_stats'] = array( 'name' => 'messages_stats',
								 'operation_types' => array( 'read' ),
                                 'call_method' => array( 
                                                         'class' => 'eZPm',
                                                         'method' => 'messagesStats' ),
                                 'parameter_type' => 'standard',
                                 'parameters' => array () );


$FunctionList['check_contact'] = array( 'name' => 'check_contact',
                                 'call_method' => array( 'class' => 'eZContact',
                                                         'method' => 'checkIsOnContactList' ),
                                 'parameter_type' => 'standard',
                                 'parameters' => array ( array ( 'name' => 'user_id',
                                                                 'type' => 'integer',
                                                                 'required' => true ) ) );



?>
