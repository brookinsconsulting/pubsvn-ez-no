<?php
//
// Created on: <24-Jan-2005 15:25:10 jb>
//
// Copyright (C) 1999-2005 eZ systems as. All rights reserved.
//
// This source file is part of the GeSHi extension for eZ publish.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//

/*! \file geshi_functions.php
  Helper functions which can be used by the 'simpletags' operator.
*/

function geshi_hl_common( $text, $mode )
{
    // Use GeSHi to highlight code
    include_once( 'extension/geshi/classes/geshi.php' );
    $geshi = new GeSHi( trim( $text, "\n\r" ), $mode, 'extension/geshi/classes/geshi' );

    // We want to use CSS classes
    $geshi->enable_classes();
    $geshi->set_overall_class( $mode . '_code geshi_code' );

    return $geshi->parse_code();
}

function geshi_hl_php( $text )
{
    return geshi_hl_common( $text, 'php' );
}

function geshi_hl_shell( $text )
{
    return geshi_hl_common( $text, 'shell' );
}

function geshi_hl_c( $text )
{
    return geshi_hl_common( $text, 'c' );
}

function geshi_hl_cpp( $text )
{
    return geshi_hl_common( $text, 'cpp' );
}

function geshi_hl_css( $text )
{
    return geshi_hl_common( $text, 'css' );
}

function geshi_hl_html( $text )
{
    return geshi_hl_common( $text, 'html' );
}

function geshi_hl_js( $text )
{
    return geshi_hl_common( $text, 'js' );
}

function geshi_hl_java( $text )
{
    return geshi_hl_common( $text, 'java' );
}

function geshi_hl_lisp( $text )
{
    return geshi_hl_common( $text, 'lisp' );
}

function geshi_hl_perl( $text )
{
    return geshi_hl_common( $text, 'perl' );
}

function geshi_hl_python( $text )
{
    return geshi_hl_common( $text, 'python' );
}

function geshi_hl_sql( $text )
{
    return geshi_hl_common( $text, 'sql' );
}

function geshi_hl_xml( $text )
{
    return geshi_hl_common( $text, 'xml' );
}

function geshi_hl_eztemplate( $text )
{
    return geshi_hl_common( $text, 'eztemplate' );
}

?>
