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
Author:       Tony Wood, Paul Forsyth
Version:      $Id: callback.php,v 1.8 2003/12/16 10:42:58 tony Exp $
*/

$module =& $Params["Module"];

include_once( "lib/ezutils/classes/ezhttptool.php" );
include_once( "lib/ezutils/classes/ezoperationhandler.php" );
include_once( 'extension/worldpay/eventtypes/event/worldpay/worldpaydb.php' );
include_once( "lib/ezutils/classes/ezini.php" );
include_once( 'kernel/classes/ezorder.php' );
include_once( "kernel/common/template.php" );

define( "VWT_PAYMENT_INVALID", 0 );
define( "VWT_PAYMENT_OK", 1 );
define( "VWT_PAYMENT_FAILED", 2 );

// -----------------------------------------------------------------------------------------
// isWorldpayIPOK
// Is the IP address of the call from worldpay
// -----------------------------------------------------------------------------------------

function isWorldpayIPOK ( $ini )
{
	
	//Get valid Worldpay server IP range array
	if ( $ini->hasVariable( "Worldpay", "WPServer" ) )
	$wpServer = $ini->variableArray( "Worldpay", "WPServer" );
	
	//Get IP address of calling system
	$remoteIP=ip2long(getenv('REMOTE_ADDR'));
	
	eZDebug::writeDebug( $remoteIP, "Calling IP" );
	
	// loop thru ranges in ini to check for valid ip		
	foreach ( $wpServer as $ip  )
	{
		$wpServerRange=explode("-",$ip[0]);
		eZDebug::writeDebug( $wpServerRange, "wp Server Range " );
		$wpServerStart = ip2long($wpServerRange[0]);
		$wpServerEnd = ip2long($wpServerRange[1]);

		eZDebug::writeDebug( $ip[0], "Calling IP, Start: $wpServerStart End: $wpServerEnd " );

		
    	if ( $remoteIP >= $wpServerStart and $remoteIP <= $wpServerEnd)
    	{
    		eZDebug::writeDebug( "Worldpay", "The IP address is within range" );
    		return true; 
    	}
    	
	}
	
	// IP is not in the required ranges
	return false;
	
}

// -----------------------------------------------------------------------------------------
// isWorldPayCall
// Check to ensure the URL is from worldpay
// -----------------------------------------------------------------------------------------
		
function isWorldPayCall( $ini, $http )
{
	//Check for valid IP address from worldpay servers.
    if ( !isWorldpayIPOK ( $ini ) )
    {
    	// This call is not from worldpay
   		eZDebug::writeDebug( "Worldpay", "The IP address is not a valid worldpay one" );
   		return false;
    }	
    
    // Fetching a get or post variables from worldpay
    //Check for installid .
    if ( $http->hasVariable( "instId" ) )
   	{
       	//Install ID from WorldPay
       	$wpinst_id =& $http->variable( "instId" );
       	
       	//Local ini file installationID
       	if ( $ini->hasVariable( "Worldpay", "InstallID" ) )
			$local_install_id = $ini->variableArray( "Worldpay", "InstallID" );
       	
       	//Make sure they match
       	if ( $wpinst_id == $local_install_id )
   	    return true;	
   	}
   	else
   	{
   		// This is not a call from worldpay
   		eZDebug::writeDebug( "Worldpay", "This installation ID does not match" );
   		return false;
   	}

}


// -----------------------------------------------------------------------------------------
// isPriceDifferenceOK
// Is the difference between exchange prices acceptable
// -----------------------------------------------------------------------------------------

function isPriceDifferenceOK( $WPamount, $localAmount, $pricedifference, $rate)
{

    // Convert local amount into the payment currency for conversion	
    $localPrice= $localAmount * $rate;
    
    if ( $WPamount >= $localPrice - $pricedifference and $WPamount <= $localPrice + $pricedifference )
    {
    	//price is within range
    	eZDebug::writeDebug(  $rate, "Price is within range" );
    	return true;
    } else {
    	//price is not within range somethings up!
    	eZDebug::writeDebug( "Worldpay", "Price is NOT within range" );
    	return false;	 
    }

}

// -----------------------------------------------------------------------------------------
// isAmountOK
// Is the amount passed back by worldpay ok, this is important as it could have been changed by a blackhat.
// -----------------------------------------------------------------------------------------

function isAmountOK ( $auth_currency, $amount, $localAmount, $ini )
{

if ( $ini->hasVariable( "Worldpay", "PriceDifference" ) )
	$price_difference = $ini->variable( "Worldpay", "PriceDifference" );


// Get exchange rates from Worldpay downloaded ini file
$inix =& eZINI::instance( "xrate.ini" );

if ( $inix->hasVariable( "", "GBP_GBP" ) )
	{
	$GBP_GBP = $inix->variable( "", "GBP_GBP" );
	} else { return false; }
if ( $inix->hasVariable( "", "GBP_EUR" ) )
	{
	$GBP_EUR = $inix->variable( "", "GBP_EUR" );
	} else { return false; }
if ( $inix->hasVariable( "", "GBP_USD" ) )
	{
	$GBP_USD = $inix->variable( "", "GBP_USD" );
	} else { return false;}
	
// based on the passed back currency run the currency check 		
switch( $auth_currency )
        {
            case "GBP":
            {
            	return isPriceDifferenceOK($amount, $localAmount, $price_difference, $GBP_GBP);
            } break;
            case "EUR":
            {
            	return isPriceDifferenceOK($amount, $localAmount, $price_difference, $GBP_EUR);
            	 
            } break;
             case "USD":
            {
                return isPriceDifferenceOK($amount, $localAmount, $price_difference, $GBP_USD);
            } break;
            
            default:
                return false;
        }
}

// -----------------------------------------------------------------------------------------
// isPaymentOK
// -----------------------------------------------------------------------------------------
function  isPaymentOK( $ini, $http )
{
    		
    //order number
    if ( $http->hasVariable( "cartId" ) )
        $order_id =& $http->variable( "cartId" );
       
    //Userid
    if ( $http->hasVariable( "M_USERID" ) )
        $user_id =& $http->variable( "M_USERID" );
    
    //price
    if ( $http->hasVariable( "amount" ) )
        $amount =& $http->variable( "amount" );
    
    //postcode
    if ( $http->hasVariable( "postcode" ) )
        $postcode =& $http->variable( "postcode" );
    
    //email
    if ( $http->hasVariable( "email" ) )
        $email =& $http->variable( "email" );
    
    // order created
    if ( $http->hasVariable( "M_ORDERCREATED" ) )
        $order_created =& $http->variable( "M_ORDERCREATED" );
        
    //session
    if ( $http->hasVariable( "M_PHPSESSID" ) )
    {
        $sessionid =& $http->variable( "M_PHPSESSID" );
    }
    
    //Authorised currency
    if ( $http->hasVariable( "authCurrency" ) )
        $auth_currency =& $http->variable( "authCurrency" );
    
    //worldpay password
    if ( $http->hasVariable( "callbackPW" ) )
        $password =& $http->variable( "callbackPW" );
    
    
    //worldpay authcode "A" = authorised
    if ( $http->hasVariable( "rawAuthCode" ) )
        $authcode =& $http->variable( "rawAuthCode" );
    
    // Check values with persistant object
    $worldpaydb =& WorldPayDB::checkfororder($order_id);
    
    if ( !$worldpaydb )
    {	
    	//Create no order for this payment
          	
        //no matching order for worldpay callback
    	eZDebug::writeDebug( "Worldpay", "no matching order for worldpay callback" );
        //Email admin
    	return false;
    
    }

    // Get record ID for this payment
    $id = $worldpaydb->attribute( 'id' );
    
    //Order found and has been payed  this is a problem
    if ( $worldpaydb->attribute( 'payed') == VWT_HAS_PAYED )
    {
    	// email admin
    	eZDebug::writeDebug( "Worldpay", "Order has already been payed" );
    	return false;
    }
    
    // Check order details
    if ( $worldpaydb->attribute( 'user_id' ) == $user_id and 
    		 $worldpaydb->attribute( 'postcode' ) == $postcode and 
    		 $worldpaydb->attribute( 'created' ) == $order_created and
    		 $worldpaydb->attribute( 'session' ) == $sessionid and
    		 $worldpaydb->attribute( 'email' ) == $email)
	{
    	$localAmount=$worldpaydb->attribute( 'price' );
    	if ( !isAmountOK ( $auth_currency, $amount, $localAmount, $ini ) )
    	{
    		// Value is incorrect
    		eZDebug::writeDebug( "Worldpay", "Value is incorrect" );
    		return false;
    	}
    	// Order info matches, this is the right order.
    	// Now check for password match
		if ( $ini->hasVariable( "Worldpay", "Password" ) )
			$worldpaypassword = $ini->variable( "Worldpay", "Password" );

		if ( $password != $worldpaypassword )
		{	
			eZDebug::writeDebug( "Worldpay", "Passwords do not match" );
			return false;
		}
		
		// Now check for authorisation.
    	if ( $authcode == "A" )
    	{
    		// **** An accepted payment so lets mark the db as payed ***
    		eZDebug::writeDebug( "Worldpay", "Payment passes check and is authorised by worldpay" );
    		$worldpaypayed =& WorldPayDB::payed($id);
    		return true;
    	}
    	if ( $authcode != "A" )
    	{
    		// **** Payment cancelled ***
    		eZDebug::writeDebug( "Worldpay", "Payment not authorised by Worldpay" );
    		return false;
    	}
    	
	}
	else
	{
    	// Order details do not match
    	eZDebug::writeDebug( "Worldpay", "Order details do not match" );
    	return false;
	}
}

// ------------------------------------------------------------------------------------------------------------------------------------
// Main program
// ------------------------------------------------------------------------------------------------------------------------------------

$ini =& eZINI::instance( "worldpay.ini" );
$http =& eZHTTPTool::instance();
$tpl =& templateInit();
$status=VWT_PAYMENT_FAILED;


if (  !isWorldPayCall( $ini, $http ) )
{	
	eZDebug::writeDebug( "Worldpay", "not a worldpay call" );
	$status=VWT_PAYMENT_INVALID;
	$tpl->setVariable( "Status", $status  );
	
	$Result = array();
	$Result['pagelayout'] = 'wp_pagelayout.tpl';
	$Result['content'] =& $tpl->fetch( "design:callback.tpl" );
	return true;
}
else
{
	if (  !isPaymentOK( $ini, $http ) )
	{
		eZDebug::writeDebug( "Worldpay", "Payment is not ok" );
		$status=VWT_PAYMENT_FAILED;
		$tpl->setVariable( "Status", $status  );
	
		$Result = array();
		$Result['pagelayout'] = 'wp_pagelayout.tpl';
		$Result['content'] =& $tpl->fetch( "design:callback.tpl" );
		return true;
	}
	else
	{
		$status=VWT_PAYMENT_OK;
        eZDebug::writeDebug( "Worldpay", "Performing workflow" );
        
        //Get order so we can run workflow
        if ( $http->hasVariable( "cartId" ) )
            $order_id =& $http->variable( "cartId" );
        if ( $http->hasVariable( "amount" ) )
        	$amount =& $http->variable( "amount" );
        if ( $http->hasVariable( "name" ) )
        	$name =& $http->variable( "name" );
             
        // Run workflow for this order
        $operationResult = eZOperationHandler::execute( 'shop', 'checkout', array( 'order_id' => $order_id ) );
               
                  
        $tpl->setVariable( "status", $status  );
        $tpl->setVariable( "amount", $amount  );
        $tpl->setVariable( "name", $name  );
        $tpl->setVariable( "order_id", $order_id  );

		$Result = array();
		$Result['pagelayout'] = 'wp_pagelayout.tpl';
		$Result['content'] =& $tpl->fetch( "design:callback.tpl" );
		return true;
        

	}
}


// Template handling

/* check calling paremeters
$y="";
foreach ($_POST as $x)
{
	$y=$y.", ".$x;	
}
$tpl->setVariable( "Params", $y);
*/



	
return;	
	
?>
