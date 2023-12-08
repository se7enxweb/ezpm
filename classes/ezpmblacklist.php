<?php
//
// Created on: <10-Sep-2006 00:00:00 Bartek Modzelewski>
//

/*! \file ezpmblacklist.php
*/

//include_once( 'kernel/classes/ezpersistentobject.php' );
//include_once( 'kernel/classes/ezcontentobject.php' );




class eZPmBlackList extends eZPersistentObject
{
    function eZPmBlackList( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( 'fields' => array( 'user_id' => array( 'name' => 'UserID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                          'blocked_user_id' => array( 'name' => 'BlockedUserID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true )
                                        ),
                      'keys' => array( 'user_id', 'blocked_user_id' ),
                      'function_attributes' => array( 'add' => 'addUser',
                                                      'delete' => 'deleteUser' ),
                      'class_name' => 'eZPmBlackList',
                      'name' => 'ezpm_blacklist' );
    }


    /*!
      Fetch eZPmBlackList object - blockade
    */
    static function fetch( $blockedUserID, $asObject = false )
    {
        $conds = array( 'blocked_user_id' => $blockedUserID,
                        'user_id' => eZUser::currentUserID() );
        return eZPersistentObject::fetchObject( eZPmBlackList::definition(),
                                                null,
                                                $conds,
                                                $asObject );
    }


    static function isBlackListed( $checkUserID, $asObject = false )
    {
        $userID = eZUser::currentUserID();
        $conds = array( 'blocked_user_id' => $userID,
                        'user_id' => $checkUserID  );
        $rows = eZPersistentObject::fetchObjectList( eZPmBlackList::definition(),
                                                     null,
                                                     $conds,
                                                     null,
                                                     null,
                                                     $asObject );
        if ( count( $rows ) > 0 ) return true;
        return false;
    }


    static function fetchBlackList( $limit = 10, $offset, $asObject = false )
    {
        $userID = eZUser::currentUserID();
        $conds = array( 'user_id' => $userID  );
        $limit = array( 'offset' => $offset, 'length' => $limit );
        $rows = eZPersistentObject::fetchObjectList( eZPmBlackList::definition(),
                                                     null,
                                                     $conds,
                                                     null,
                                                     $limit,
                                                     $asObject );
        return $rows;
    }

    static function itemCount()
    {
        $userID = eZUser::currentUserID();
        $conds = array( 'user_id' => $userID );
        $custom = array( array( 'operation' => 'count( blocked_user_id )',
                                'name' => 'count' ) );
        $countRes = eZPersistentObject::fetchObjectList( eZPmBlackList::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );
        return $countRes[0]['count'];
    }

    static function addToBlackList( $blockUserID )
    {
        $userID = eZUser::currentUserID();
        $blockade = new eZPmBlackList( array( 'blocked_user_id' => $blockUserID,
                                              'user_id' => $userID  ) );
        $blockade->store();
        return $blockade;
    }





}



?>
