<?php
//
// Definition of Worldpay module
//
// Created on: <30-August-2003 TW>
//
// Copyright (C) 1999-2003 Vision with Technology, All rights reserved.
// http://www.visionwt.com
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation 
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@visionwt.com if any conditions of this licencing isn't clear to
// you.
//
/*
Author:       Tony Wood
Version:      $Id: worldpaydb.php,v 1.2 2003/12/09 11:14:49 tony Exp $
*/


include_once( "kernel/classes/ezpersistentobject.php" );

define( "VWT_NOT_PAYED", false );
define( "VWT_HAS_PAYED", true );

class WorldPayDB extends eZPersistentObject
{
    /*!
    */
    function WorldPayDB( $row )
    {
        $this->eZPersistentObject( $row );
    }

    function &definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "order_id" => array( 'name' => "OrderID",
                                                          'datatype' => 'integer',
                                                          'default' => 0,
                                                          'required' => true ),
                                         "user_id" => array( 'name' => "UserID",
                                                          'datatype' => 'integer',
                                                          'default' => 0,
                                                          'required' => true ),
										"price" => array( 'name' => "Price",
                                                          'datatype' => 'double',
                                                          'default' => NULL,
                                                          'required' => true ),                                                                                                   
										"postcode" => array( 'name' => "Postcode",
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "email" => array( 'name' => "Email",
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "payed" => array( 'name' => "Payed",
                                                          'datatype' => 'integer',
                                                          'default' => VWT_NOT_PAYED,
                                                          'required' => true ),
                                         "created" => array( 'name' => "Created",
                                                          'datatype' => 'integer',
                                                          'default' => 0,
                                                          'required' => true ),
                                         "session" => array( 'name' => "Session",
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true )),
                      "keys" => array( "id" ),
                      "increment_key" => "id",
                      "class_name" => "WorldPayDB",
                      "name" => "worldpay" );
    }

	//Get a worldpay row
    function &fetch( $id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( WorldPayDB::definition(),
                                                null,
                                                array( "id" => $id
                                                      ),
                                                $asObject );
    }
    
    //Check to see if a order exists
    function &checkfororder( $order_id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( WorldPayDB::definition(),
                                                null,
                                                array( "order_id" => $order_id
                                                      ),
                                                $asObject );
    }
       
    
    function &fetchList( $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( WorldPayDB::definition(),
                                                    null, null, null, null,
                                                    $asObject );
    }

	//Create new payment record
    function &create()
    {
        $row = array(
            "id" => null,
            "order_id" => null,
            "user_id" => null,
            "price" => null,
            "postcode" => "",
            "email" => "",
            "payed" => VWT_NOT_PAYED,
            "created" => null,
            "session" => "" );
        return new WorldPayDB( $row );
    }

	//remove my info
    function &remove ( $id )
    {
        eZPersistentObject::removeObject( WorldPayDB::definition(),
                                          array( "id" => $id ) );
    }
    
    // update payed status for item
    function &payed ( $id )
    {
 		$db =& eZDB::instance();
        $query = "UPDATE  worldpay  SET payed = ". VWT_HAS_PAYED ." WHERE id = " . $id;
        $db->query( $query );
         
    }
} 
?>
