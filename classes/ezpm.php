<?php
//
// Created on: <24-Aug-2006 00:00:00 Bartek Modzelewski>
//

/*! \file ezpm.php
*/

//include_once( 'kernel/classes/ezpersistentobject.php' );
//include_once( 'kernel/classes/ezcontentobject.php' );




class eZPm extends eZPersistentObject
{
    function eZPm( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => false ),
                                         'subject' => array( 'name' => 'Subject',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => false ),
                                         'text' => array( 'name' => 'Text',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => false ),
                                         'date_read' => array( 'name' => 'DateRead',
                                                             'datatype' => 'integer',
                                                             'default' => '0',
                                                             'required' => false ),
                                         'date_sent' => array( 'name' => 'DateSent',
                                                               'datatype' => 'integer',
                                                               'default' => '0',
                                                               'required' => false ),
                                         'sender_id' => array( 'name' => 'SenderUserID',
                                                                'datatype' => 'integer',
                                                                'default' => '0',
                                                                'required' => true ),
                                         'sender_name' => array( 'name' => 'SenderName',
                                                                'datatype' => 'string',
                                                                'default' => '',
                                                                'required' => false ),
                                         'recipient_id' => array( 'name' => 'RecipientUserID',
                                                                'datatype' => 'integer',
                                                                'default' => '0',
                                                                'required' => true ),
                                         'recipient_name' => array( 'name' => 'RecipientName',
                                                                'datatype' => 'name',
                                                                'default' => '',
                                                                'required' => false ),
                                         'owner_user_id' => array( 'name' => 'OwnerUserID',
                                                              'datatype' => 'integer',
                                                              'default' => '0',
                                                              'required' => false ),
                                         'remote_id' => array( 'name' => 'RemoteID',
                                                              'datatype' => 'string',
                                                              'default' => '',
                                                              'required' => true )
                              ),
                      'keys' => array( 'id' ),
                      'function_attributes' => array( 'messages' => 'messages',
                                                      'send' => 'sendPmToUser',
                                                      'read' => 'markAsRead',
                                                      'delete' => 'deletePm' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZPm',
                      'sort' => array( 'id' => 'asc' ),
                      'name' => 'ezpm' );
    }


    /*!
      Fetch eZPm object
    */
    static function fetch( $id, $asObject = false )
    {
        return eZPersistentObject::fetchObject( eZPm::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                $asObject );
    }

    static function fetchByRemoteID( $remote_id, $currentUserAsRecipient = true , $asObject = true )
    {
        $owner = eZUser::currentUserID();
        if ( $currentUserAsRecipient === true )
        {
            $conds = array( 'remote_id' => $remote_id,
                            'owner_user_id' => array( '!=', $owner )  );
        }
        else
        {
            $conds = array( 'remote_id' => $remote_id,
                            'owner_user_id' => $owner );
        }

        return eZPersistentObject::fetchObject( eZPm::definition(),
                                                null,
                                                $conds,
                                                $asObject );
    }

    static function fetchMessage( $id, $asObject = false )
    {
        $message = eZPm::fetch( $id, $asObject );
        return array( 'result' => $message );
    }


    static function fetchMessageList( $offset = 0, $limit = 10, $sort = 'date_desc' ,$type = "inbox", $asObject = false )
    {
        $owner = eZUser::currentUserID();
        if ( $type == "inbox" )
        {
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => array( '!=', 0 ),
                            'sender_id' => array( '!=', $owner )  );
        }
        elseif ( $type == "sent" )
        {
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => array( '!=', 0 ),
                            'sender_id' =>  $owner );
        }
        elseif ( $type == "drafts" )
        {
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => '0',
                            'sender_id' =>  $owner );
        }

        // sorting
        $sort = explode( '_', $sort );
        if ( $sort[0] == 'date' )
        {
            $sorts = array( 'date_sent' => $sort[1] );
        }
        else if ( $sort[0] == 'subject' )
        {
            $sorts = array( 'subject' => $sort[1] );
        }
        else if ( $sort[0] == 'sender' )
        {
            $sorts = array( 'sender_name' => $sort[1] );
        }
        else
        {
            $sorts = array( 'date_sent' => 'desc' );
        }

        $rows = eZPersistentObject::fetchObjectList( eZPm::definition(),
                                                     null,
                                                     $conds,
                                                     $sorts,
                                                     array( 'offset' => $offset,
                                                            'length' => $limit ),
                                                     $asObject );

        return array( 'result' => $rows );
    }

    static function itemCount( $type = "inbox" )
    {
        $owner = eZUser::currentUserID();
        if ( $type == "inbox" )
        {
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => array( '!=', 0 ),
                            'sender_id' => array( '!=', $owner )  );
        }
        elseif ( $type == "sent" )
        {
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => array( '!=', 0 ),
                            'sender_id' =>  $owner );
        }
        elseif ( $type == "drafts" )
        {
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => '0',
                            'sender_id' =>  $owner );
        }

        $custom = array( array( 'operation' => 'count( id )',
                                'name' => 'count' ) );
        $countRes = eZPersistentObject::fetchObjectList( eZPm::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );
        return $countRes[0]['count'];
    }

    // returns messages statistics for current user - template fetch function
    static function messagesStats()
    {
        //$pm = new eZPm();
        
        $owner  = eZUser::currentUserID();
        $custom = array( array( 'operation' => 'count( id )',
                                'name' => 'count' ) );

        // inbox new count
        $conds = array( 'owner_user_id' => $owner,
                        'date_sent' => array( '!=', 0 ),
                        'date_read' => 0,
                        'sender_id' => array( '!=', $owner )  );
        $countResInboxNew = eZPersistentObject::fetchObjectList( eZPm::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );
        // inbox old count
        $conds = array( 'owner_user_id' => $owner,
                        'date_sent' => array( '!=', 0 ),
                        'date_read' => array( '!=', 0 ),
                        'sender_id' => array( '!=', $owner )  );
        $countResInboxOld = eZPersistentObject::fetchObjectList( eZPm::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );
        // sentbox
        $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => array( '!=', 0 ),
                            'sender_id' =>  $owner );
        $countResSentbox = eZPersistentObject::fetchObjectList( eZPm::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );
        //drafts
            $conds = array( 'owner_user_id' => $owner,
                            'date_sent' => '0',
                            'sender_id' =>  $owner );
        $countResDrafts = eZPersistentObject::fetchObjectList( eZPm::definition(),
                                                       array(),
                                                       $conds,
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       $custom );

        return array( 'result' => array ( 'inbox_new' => $countResInboxNew[0]['count'],
                                          'inbox_old' => $countResInboxOld[0]['count'],
                                          'sent' => $countResSentbox[0]['count'],
                                          'drafts' => $countResDrafts[0]['count'] ) );
    }


    static function createNewMessage( $userID, $recipientID, $subject, $text )
    {
        $user = eZContentObject::fetch( $userID );
        $userName = $user->Name;
        $recipient = eZContentObject::fetch( $recipientID );
        $recipientName = $recipient->Name;

        $currentUnixTime = time();
        $remote_id = eZPm::generateRemoteID( $currentUnixTime );

        $message = new eZPm( array( 'sender_id' => $userID,
                                    'sender_name' => $userName,
                                    'recipient_id' => $recipientID,
                                    'recipient_name' => $recipientName,
                                    'owner_user_id' => $userID,
                                    'date_sent' => 0,
                                    'date_read' => 0,
                                    'remote_id' => $remote_id,
                                    'subject' => $subject,
                                    'text' => $text ) );
        $message->store();
        return $message;
    }

    static function sendNewMessage( $userID, $recipientID, $subject, $text )
    {
        include_once( 'extension/ezpm/classes/ezpmblacklist.php' );

        $user = eZContentObject::fetch( $userID );
        $userName = $user->Name;
        $recipient = eZContentObject::fetch( $recipientID );
        $recipientName = $recipient->Name;
        $currentUnixTime = time();
        $remote_id = eZPm::generateRemoteID( $currentUnixTime );

        // storing in sent list of sender user
        $message = new eZPm( array( 'sender_id' => $userID,
                                    'sender_name' => $userName,
                                    'recipient_id' => $recipientID,
                                    'recipient_name' => $recipientName,
                                    'owner_user_id' => $userID,
                                    'date_sent' => $currentUnixTime,
                                    'date_read' => 0,
                                    'remote_id' => $remote_id,
                                    'subject' => $subject,
                                    'text' => $text ) );
        $message->store();

        // storing in recipient list in inbox list, if sender is not blacklisted
        if ( !eZPmBlackList::isBlackListed( $recipientID ) )
        {
            $message = new eZPm( array( 'sender_id' => $userID,
                                    'sender_name' => $userName,
                                    'recipient_id' => $recipientID,
                                    'recipient_name' => $recipientName,
                                    'owner_user_id' => $recipientID,
                                    'date_sent' => $currentUnixTime,
                                    'date_read' => 0,
                                    'remote_id' => $remote_id,
                                    'subject' => $subject,
                                    'text' => $text ) );
            $message->store();
        }

        return $message;
    }

    static function markMessageAsRead( $messageID = null )
    {
        if ( $messageID === null )
        {
            return false;
        }
        $currentUnixTime = time();
        $message = eZPm::fetch( $messageID, true );
        if ( is_object( $message ) && $message->DateRead == 0 )
        {
            $message->DateRead = $currentUnixTime;
            $message->store();
        }
        /*
        if ( $this->DateRead == 0 )
        {
            $this->DateRead = $currentUnixTime;
            $this->store();
        }
        */
    }

    static function generateRemoteID( $inputString )
    {
        return md5( $inputString );
    }

    static function removeMessage( $messageID )
    {
        $db = eZDB::instance();
        $db->begin();



        $db->commit();

    }


}



?>
