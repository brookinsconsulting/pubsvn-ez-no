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
Version:      $Id: worldpaytype.php,v 1.3 2003/12/09 11:14:49 tony Exp $
*/


include_once( 'extension/worldpay/eventtypes/event/worldpay/worldpaydb.php' );
include_once( 'kernel/classes/ezorder.php' );
include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
include_once( "lib/ezutils/classes/ezhttptool.php" );

// debug
include_once( "lib/ezutils/classes/ezdebug.php" );

// User detail defines
define( "VWT_FIRST_NAME", 0 );
define( "VWT_LAST_NAME", 1 );
define( "VWT_USER", 2 );
define( "VWT_COMPANY", 3 );
define( "VWT_ADDRESS", 4 );
define( "VWT_TEL", 5 );
define( "VWT_COUNTRY", 6 );


define( "EZ_WORKFLOW_TYPE_WORLDPAY_ID", "worldpay" );

class WorldpayType extends eZWorkflowEventType
{
    /*!
     Constructor
    */
    function WorldpayType()
    {
        $this->eZWorkflowEventType( EZ_WORKFLOW_TYPE_WORLDPAY_ID, "Worldpay" );
    }

    function execute( &$process, &$event )
    {
		$debug = false;
		
        if ($debug) eZDebug::writeNotice( $process, "process" );
        
        $processParameters =& $process->attribute( 'parameter_list' );


		// We now need to get the order and session details, If this has been called from worldpay, these will not exist so we must 
		// use the post variables
       	$http =& eZHTTPTool::instance();
       	
       	//Get order
		if ( $http->hasVariable( "cartId" ) )
		{
            $order_id =& $http->variable( "cartId" );       
		} else {
			$order_id = eZHTTPTool::sessionVariable( 'MyTemporaryOrderID' );	     
		}
		// get session details
     	if ( $http->hasVariable( "M_PHPSESSID" ) )
    	{
			//get session and set session as callback session
        	$mysessionid =& $http->variable( "M_PHPSESSID" );
        	//eZHTTPTool::setSessionKey($mysessionid); attempt to get basket to clear.. it failed in test, revist it later
        	
    	} else {
			$mysessionid=eZHTTPTool::getSessionKey();
				
		}
		// User id
       	if ( $http->hasVariable( "M_USERID" ) )
       	{
        	$user_id =& $http->variable( "M_USERID" );
        	        	
       	} else {
       		$user =& eZUser::currentUser();	
       		$user_id = $user->attribute( "contentobject_id" );
       	}    
	
		// email
		if ( $http->hasVariable( "email" ) )
		{
        	$email =& $http->variable( "email" );
		} else {
			$email = $user->attribute( "email" );
		}
             
		//open template
		include_once( "kernel/common/template.php" );
		$tpl =& templateInit();
		
		//Set status
		$status= "Unknown";

		 
		//Get order details
		 
		$order = eZOrder::fetch( $order_id );
		$order_created = $order->attribute( "created" );
		$price = $order->attribute( "total_inc_vat" );
		$desc = "Order number: ".$order_id;
				
		// Get user obj and attributes
		$contentobject =& eZContentObject::fetch( $user_id );
		$contentobjectAttributes =& $contentobject->attribute( 'contentobject_attributes' );
		
		$name = $contentobjectAttributes[VWT_FIRST_NAME]->attribute( "content") . " " .$contentobjectAttributes[VWT_LAST_NAME]->attribute( "content");
		$company = $contentobjectAttributes[VWT_COMPANY]->attribute( "content");

		$addressContent = $contentobjectAttributes[VWT_ADDRESS]->attribute( "content");

		$addressMatrix =& $addressContent ->attribute( "matrix" );
		$addressColumnsArray =& $addressContent->attribute( "columns" );

		if ($debug) 
		{
			while( list ($key, $value) = each($addressColumnsArray) )
			{
				eZDebug::writeDebug( "Outputing key: ".$key.", value: ".$value);
			}
		}	

		$addressColumns =& $addressColumnsArray["sequential"];
		$addressColumn =& $addressColumns[1];
		$addressRow =& $addressColumn["rows"];

		if ($debug) 
		{
			eZDebug::writeDebug( "Sequential array");
			while( list ($key, $value) = each($addressColumns) )
			{
				eZDebug::writeDebug( "Outputing key: ".$key.", value: ".$value);
			}

			eZDebug::writeDebug( "sequential [1][rows] array");
			$addressColumn2 =& $addressColumns[1];
			$addressRow2 =& $addressColumn["rows"];
			while( list ($key, $value) = each($addressRow2) )
			{
				eZDebug::writeDebug( "Outputing key: ".$key.", value: ".$value);
			}

		}	

		// Fill the address information with the matrix information
		$address1 = $addressRow[0];
		$address2 = $addressRow[1];
		$address2 = $addressRow[2];
		$address2 = $addressRow[3];
		$postcode = $addressRow[4];
		
		$country = $contentobjectAttributes[VWT_COUNTRY]->attribute( "content");
		$tel = $contentobjectAttributes[VWT_TEL]->attribute( "content");
		
		/* Left in as a reminder of how to do it
		//select the correct attribute
		$contentobjectAttribute = $contentobjectAttributes[VWT_POSTCODE];
		//Assign postcode
		$postcode = $contentobjectAttribute->attribute( "content");
		*/

		//Check to see if an order row already exist for this order 
		$worldpaydb =& WorldPayDB::checkfororder($order_id);
		if ( !$worldpaydb )
		{	
			//Create
			$worldpaydb =& WorldPayDB::create();
		
			$worldpaydb->setAttribute( 'order_id', $order->attribute( 'id' ));
			$worldpaydb->setAttribute( 'user_id', $user_id );
        	$worldpaydb->setAttribute( 'price', $price );
        	$worldpaydb->setAttribute( 'postcode', $postcode );
        	$worldpaydb->setAttribute( 'email', $email );
        	$worldpaydb->setAttribute( 'payed', VWT_NOT_PAYED );
        	$worldpaydb->setAttribute( 'created', $order_created );
        	$worldpaydb->setAttribute( 'session', $mysessionid );
        	$worldpaydb->store();
        	
        	$status="Persistent order created";
		}
		else
		{
			$status="Order already exists";
			
			// If payed is yes then mark this transcation as complete
			if ( $worldpaydb->attribute( "payed") == VWT_HAS_PAYED )
			{
					//delete object we dont need it anymore
					$tempid= $worldpaydb->attribute( "id");
					$worldpaydb =& WorldPayDB::remove( $tempid );
					
					eZDebug::writeDebug( "Worldpayevent", "Payment authorised" );
					return EZ_WORKFLOW_TYPE_STATUS_ACCEPTED;
			}
			
		}
		
		//place in template
		$tpl->setVariable( "name", $name );
		$tpl->setVariable( "status", $status );
  		$tpl->setVariable( "sessionid", $mysessionid );
		$tpl->setVariable( "order_id", $order_id );
		$tpl->setVariable( "order_created", $order_created );
		$tpl->setVariable( "user", $user );
		$tpl->setVariable( "country", $country );
		$tpl->setVariable( "tel", $tel );
		$tpl->setVariable( "desc", $desc );
		$tpl->setVariable( "company", $company );
		$tpl->setVariable( "price", $price );
		$tpl->setVariable( "user_id", $user_id );
		$tpl->setVariable( "order", $order );
		$tpl->setVariable( "address", $address1.",".$address2.",".$address3.",".$address4 );
		$tpl->setVariable( "postcode", $postcode );
		$tpl->setVariable( "email", $email );

        $node =& eZContentObjectTreeNode::fetch(  $processParameters['node_id'] );
        $requestUri = eZSys::requestUri();
        $process->Template = array( 'templateName' => 'design:workflow/eventtype/result/' . 'event_worldpay' . '.tpl',
                                     'templateVars' => array( 'node' => $node,
                                                              'viewmode' => 'full',
                                                              'request_uri' => $requestUri )
                                     );
        return EZ_WORKFLOW_TYPE_STATUS_FETCH_TEMPLATE_REPEAT;
    }


    function initializeEvent( &$event )
    {
    }
    
}
eZWorkflowEventType::registerType( EZ_WORKFLOW_TYPE_WORLDPAY_ID, "worldpaytype" );
?>
