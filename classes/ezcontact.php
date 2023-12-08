<?php
//
// Created on: <11-Sep-2006 00:00:00 Bartek Modzelewski>
//

/*! \file ezcontact.php
*/

//include_once( 'kernel/classes/ezpersistentobject.php' );
//include_once( 'kernel/classes/ezcontentobject.php' );




class eZContact extends eZPersistentObject
{
    function eZContact( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( 'fields' => array( 'user_id' => array( 'name' => 'UserID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'contact_user_id' => array( 'name' => 'ContactUserID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true )
                                        ),
                      'keys' => array( 'user_id', 'contact_user_id' ),
                      'function_attributes' => array(  ),
                      'class_name' => 'eZContact',
                      'name' => 'ezpm_contact' );
    }


    /*!
      Fetch eZContact object
    */
    static function fetch( $ContactUserID, $asObject = false )
    {
        $conds = array( 'contact_user_id' => $ContactUserID,
                        'user_id' => eZUser::currentUserID() );
        return eZPersistentObject::fetchObject( eZContact::definition(),
                                                null,
                                                $conds,
                                                $asObject );
    }


    static function isOnContactList( $checkUserID, $asObject = false )
    {
        $userID = eZUser::currentUserID();
        $conds = array( 'contact_user_id' => $checkUserID,
                        'user_id' => $userID );
        $rows = eZPersistentObject::fetchObjectList( eZContact::definition(),
                                                     null,
                                                     $conds,
                                                     null,
                                                     null,
                                                     $asObject );
        if ( count( $rows ) > 0 ) return true;
        return false;
    }


    static function checkIsOnContactList( $checkUserID, $asObject = false )
    {
        $userID = eZUser::currentUserID();
        $conds = array( 'contact_user_id' => $checkUserID,
                        'user_id' => $userID );
        $rows = eZPersistentObject::fetchObjectList( eZContact::definition(),
                                                     null,
                                                     $conds,
                                                     null,
                                                     null,
                                                     $asObject );
        if ( count( $rows ) > 0 )
        {
            $is_contact = 1;
        }
        else
        {
            $is_contact = 0;
        }

        return array( 'result' =>  array( 'data_int' => $is_contact ) );
    }


    static function fetchContactList( $limit = 10, $offset, $asObject = false )
    {
        $userID = eZUser::currentUserID();
        $conds = array( 'user_id' => $userID  );
        $limit = array( 'offset' => $offset, 'length' => $limit );
        $rows = eZPersistentObject::fetchObjectList( eZContact::definition(),
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
        $custom = array( array( 'operation' => 'count( contact_user_id )',
                                'name' => 'count' ) );
        $countRes = eZPersistentObject::fetchObjectList( eZContact::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );
        return $countRes[0]['count'];
    }

    static function addToContactList( $contactUserID )
    {
        $userID =& eZUser::currentUserID();
        $conds = array( 'contact_user_id' => $contactUserID,
                        'user_id' => $userID );

        $contact = new eZContact( array( 'contact_user_id' => $contactUserID,
                                         'user_id' => $userID  ) );
        $contact->store();
        return $contact;
    }





}



?>
