<?php
//
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
Version:      $Id: module.php,v 1.3 2003/11/06 09:49:58 tony Exp $
*/

$Module = array( "name" => "Callme",
                 "variable_params" => true );

$ViewList = array();
$ViewList["callme"] = array(
    "functions" => array( 'view' ),
     "script" => "callme.php");
    
    
$ViewList["thankyou"] = array(
    "functions" => array( 'view' ),
    "script" => "thankyou.php");
    
$FunctionList['view'] = array( );

?>