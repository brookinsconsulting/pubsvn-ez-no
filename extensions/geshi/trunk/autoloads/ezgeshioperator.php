<?php
//
// Definition of eZGeSHiOperator class
//
// Created on: <14-Jan-2005 12:43:00 jb>
//
// Copyright (C) 1999-2005 eZ systems as. All rights reserved.
//
// This source file is part of the GeSHi extension for eZ publish.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE.GPL included in
// the packaging of this file.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//

/*! \file ezmostactiveoperator.php
*/

/*!
  \class eZGeSHiOperator ezgeshioperator.php
  \brief Template operator for code highlighting using GeSHi library

  Applies highlighting of code (e.g. PHP) inside a text string.
  \code
  {$text|geshi_hl( 'php' )}
  \endcode

*/
class eZGeSHiOperator
{
    /*!
    */
    function eZGeSHiOperator( $name = "geshi_hl" )
    {
        $this->Operators = array( $name );
    }

    /*!
     Returns the template operators.
    */
    function &operatorList()
    {
        return $this->Operators;
    }

    /*!
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array( "language" => array( "type" => "string",
                                           "required" => true,
                                           "default" => "" ) );
    }

    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        if ( $operatorName == 'geshi_hl' )
        {
            if ( strlen( $namedParameters['language'] ) == 0 )
            {
                $tpl->missingParameter( $operatorName, 'language' );
                return;
            }

            // Use GeSHi to highlight code
            include_once( 'extension/geshi/classes/geshi.php' );
            $geshi = new GeSHi( $operatorValue, $namedParameters['language'], 'extension/geshi/classes/geshi' );

            // We want to use CSS classes
            $geshi->enable_classes();
            $geshi->set_overall_class( $namedParameters['language'] . '_code' . ' geshi_code' );

            $operatorValue = $geshi->parse_code();
        }
   }
    var $Operators;
}
?>

