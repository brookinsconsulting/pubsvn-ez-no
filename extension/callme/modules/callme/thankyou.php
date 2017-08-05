<?php
//
// Definition of Callme module
//
// Created on: <30-June-2003 TW>
//
// Copyright (C) 1999-2003 Vision with Technology, All rights reserved.
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
Version:      $Id: thankyou.php,v 1.4 2003/11/06 11:07:27 paulf Exp $
*/


include_once( 'lib/ezutils/classes/ezmail.php' );
include_once( 'lib/ezutils/classes/ezmailtransport.php' );
include_once( "kernel/common/template.php" );
include_once( "lib/ezutils/classes/ezhttptool.php" );

$Module =& $Params["Module"];
$Module->setTitle( "Thankyou" );

$ini =& eZINI::instance();	
$http =& eZHTTPTool::instance();

// Fetching a get or post variable
$name="";
if ( $http->hasVariable( "name" ) )
    $name =& $http->variable( "name" );
$email="";
if ( $http->hasVariable( "email" ) )
    $email =& $http->variable( "email" );
$tel="";
if ( $http->hasVariable( "tel" ) )
    $tel =& $http->variable( "tel" );
$company="";
if ( $http->hasVariable( "company" ) )
    $company =& $http->variable( "company" );
$website="";
if ( $http->hasVariable( "website" ) )
    $website =& $http->variable( "website" );
$interest="";
if ( $http->hasVariable( "interest" ) )
    $interest =& $http->variable( "interest" );

//create mail object
$mail = new eZMail();	

//Grab Email sender from ini file
$sender = $ini->variable( "MailSettings", "EmailSender" );
	
// Setup email template
$tpl =& templateInit();	
$tpl->setVariable( 'name', $name );
$tpl->setVariable( 'email', $email );
$tpl->setVariable( 'tel', $tel );
$tpl->setVariable( 'company', $company );
$tpl->setVariable( 'website', $website );
$tpl->setVariable( 'interest', $interest );
    
$subject = "Company: Callme feedback";

$templateResult =& $tpl->fetch( 'design:email.tpl' );
$receiver= $tpl->variable( 'email_receiver' );
if ( !$mail->validate( $receiver ) )
	{
       // receiver does not contain a valid email address, get the default one
       $receiver = $ini->variable( "InformationCollectionSettings", "EmailReceiver" );
	}

// Fill variables and send email
$mail->setReceiver( $receiver );
$mail->setSender( $sender );
$mail->setSubject( $subject );
$mail->setBody( $templateResult );
$mailResult = eZMailTransport::send( $mail );


// Setup template for Thank you screen
$tpl =& templateInit();

$tpl->setVariable( "module", $Module );

//display thank you
$Result = array();
$Result['content'] =& $tpl->fetch( "design:thankyou.tpl" );

?>
