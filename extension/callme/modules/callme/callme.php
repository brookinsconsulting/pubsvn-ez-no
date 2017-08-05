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
Version:      $Id: callme.php,v 1.3 2003/11/06 09:49:58 tony Exp $
*/

include_once( 'kernel/classes/ezcontentobject.php' );
include_once( 'kernel/classes/ezcontentobjecttreenode.php' );
include_once( "kernel/common/template.php" );
include_once( "lib/ezutils/classes/ezhttptool.php" );

$Module =& $Params["Module"];
$Module->setTitle( "Callme" );
	
$http =& eZHTTPTool::instance();
// Fetching a get or post variable
if ( $http->hasVariable( "about" ) )
    $callme_about =& $http->variable( "about" );
	

// Template handling
$tpl =& templateInit();

$tpl->setVariable( "module", $Module );
$tpl->setVariable( "callme_about", $callme_about);

$Result = array();
$Result['path'] = array( array( 'url' => '/callme/callme',
												'test' => "Call me") );
$Result['content'] =& $tpl->fetch( "design:callme.tpl" );

?>
