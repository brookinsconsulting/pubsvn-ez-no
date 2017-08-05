<?php
//
/*
    XSLT Template Operator extension for eZ publish 3.x
    Copyright (C) 2003  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
/*!
  \class   TemplateXsltOperator templatexsltoperator.php
  \ingroup eZTemplateOperators
  \brief   Handles template operator xslt

  \version 1.0
  \date    Thursday 28 August 2003 8:13:33 am


  \author  Tom Couwberghs



  By using xslt you can parse xml data by a given xslt-file



  Example:
\code
{$xml|xslt(hash(xslt_file, $filename))}
\endcode


*/

/*
If you want to have autoloading of this operator you should create
a eztemplateautoload.php file and add the following code to it.
The autoload file must be placed somewhere specified in AutoloadPath
under the group TemplateSettings in settings/site.ini

$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'templatexsltoperator.php',
                                    'class' => '$full_class_name',
                                    'operator_names' => array( 'xslt' ) );

*/


class TemplateXsltOperator
{
    /*!
      Constructor, does nothing by default.
    */
    function TemplateXsltOperator()
    {
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'xslt' );
    }


    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }



    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 	'xslt' => array(  'params' => array('type' => 'array',
											'required' => true,
											'default' => '')));

    }


    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {


      	$xslt_file = $namedParameters['params']['xslt_file'];
		$parameters = $namedParameters['params']['xslt_params'];

        // Example code, this code must be modified to do what the operator should do, currently it only trims text.
        switch ( $operatorName )
        {
            case 'xslt':
            {

				$xsltINI =& eZINI::instance( 'xslt.ini' );
				$xh = xslt_create();


                		$args    = array ( '/_xml' => $operatorValue );

				// Process the document, returning the result into the $result variable
				$basedir = $xsltINI->variable('DirectorySettings','basedir');

				xslt_set_base($xh, $basedir);

				/*$xslt_params = array();
				$xslt_params["param"] = 16;*/

				

				$result = xslt_process($xh, 'arg:/_xml', $xslt_file, NULL, $args, $parameters);

				if(!$result){
					$operatorValue= "<p>Cannot process XSLT-template<br/><b>Error nr. ".xslt_errno($xh).": </b>".xslt_error($xh)."</p>";
				}else{
					$operatorValue = $result;
				}

				xslt_free($xh);

            } break;
        }


    }
}
?>