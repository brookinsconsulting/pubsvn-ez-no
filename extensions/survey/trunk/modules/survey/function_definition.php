<?php
//
// Created on: <23-May-2003 16:45:07 amos>
//
// Copyright (C) 1999-2004 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE.GPL included in
// the packaging of this file.
//
// Licencees holding valid "eZ publish professional licences" may use this
// file in accordance with the "eZ publish professional licence" Agreement
// provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" is available at
// http://ez.no/products/licences/professional/. For pricing of this licence
// please contact us via e-mail to licence@ez.no. Further contact
// information is available at http://ez.no/home/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

/*! \file function_definition.php
*/

$FunctionList = array();

$FunctionList['multiple_choice_result'] = array( 'name' => 'multiple_choice_result' ,
                                                 'call_method' => array( 'include_file' => 'extension/survey/modules/survey/classes/ezsurveymultiplechoice.php',
                                                                         'class' => 'eZSurveyMultipleChoice',
                                                                         'method' => 'fetchResult' ),
                                                 'parameter_type' => 'standard',
                                                 'parameters' => array( array( 'name' => 'question',
                                                                               'type' => 'object',
                                                                               'required' => true ),
                                                                        array( 'name' => 'metadata',
                                                                               'type' => 'array',
                                                                               'default' => false,
                                                                               'required' => false ) ) );

$FunctionList['text_entry_result'] = array( 'name' => 'text_entry_result',
                                            'call_method' => array( 'include_file' => 'extension/survey/modules/survey/classes/ezsurveytextentry.php',
                                                                    'class' => 'eZSurveyTextEntry',
                                                                    'method' => 'fetchResult' ),
                                            'parameter_type' => 'standard',
                                            'parameters' => array( array( 'name' => 'question',
                                                                          'type' => 'object',
                                                                          'required' => true ),
                                                                   array( 'name' => 'metadata',
                                                                          'type' => 'array',
                                                                          'default' => false,
                                                                          'required' => false ),
                                                                   array( 'name' => 'limit',
                                                                          'type' => 'integer',
                                                                          'default' => false,
                                                                          'required' => false ) ) );

$FunctionList['multiple_choice_result_item'] = array( 'name' => 'multiple_choice_result_item' ,
                                                      'call_method' => array( 'include_file' => 'extension/survey/modules/survey/classes/ezsurveymultiplechoice.php',
                                                                              'class' => 'eZSurveyMultipleChoice',
                                                                              'method' => 'fetchResultItem' ),
                                                      'parameter_type' => 'standard',
                                                      'parameters' => array( array( 'name' => 'question',
                                                                                    'type' => 'object',
                                                                                    'required' => true ),
                                                                             array( 'name' => 'result_id',
                                                                                    'type' => 'integer',
                                                                                    'required' => true ),
                                                                             array( 'name' => 'metadata',
                                                                                    'type' => 'array',
                                                                                    'default' => false,
                                                                                    'required' => false ) ) );

$FunctionList['text_entry_result_item'] = array( 'name' => 'text_entry_result_item',
                                                 'call_method' => array( 'include_file' => 'extension/survey/modules/survey/classes/ezsurveytextentry.php',
                                                                    'class' => 'eZSurveyTextEntry',
                                                                    'method' => 'fetchResultItem' ),
                                                 'parameter_type' => 'standard',
                                                 'parameters' => array( array( 'name' => 'question',
                                                                               'type' => 'object',
                                                                               'required' => true ),
                                                                        array( 'name' => 'result_id',
                                                                               'type' => 'integer',
                                                                               'required' => true ),
                                                                        array( 'name' => 'metadata',
                                                                               'type' => 'array',
                                                                               'default' => false,
                                                                               'required' => false ) ) );
?>
