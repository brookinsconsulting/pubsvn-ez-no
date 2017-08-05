<?php
//
// Created on: <02-Apr-2004 00:00:00 Jan Kudlicka>
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

/*! \file eztemplateautoload.php
*/

$eZTemplateFunctionArray[] = array( 'function' => 'eZSurveyForwardInit',
                                    'function_names' => array( 'survey_question_edit_gui',
                                                               'survey_question_view_gui',
                                                               'survey_question_result_gui' ) );

if ( !function_exists( 'eZSurveyForwardInit' ) )
{
    function &eZSurveyForwardInit()
    {
        include_once( 'kernel/common/ezobjectforwarder.php' );

        $forward_rules = array(
            'survey_question_edit_gui' => array( 'template_root' => 'survey/edit',
                                                 'input_name' => 'question',
                                                 'output_name' => 'question',
                                                 'namespace' => 'SurveyQuestion',
                                                 'attribute_access' => array( array( 'template_name' ) ),
                                                 'use_views' => false ),

            'survey_question_view_gui' => array( 'template_root' => 'survey/view',
                                                 'input_name' => 'question',
                                                 'output_name' => 'question',
                                                 'namespace' => 'SurveyQuestion',
                                                 'attribute_access' => array( array( 'template_name' ) ),
                                                 'use_views' => false ),

            'survey_question_result_gui' => array( 'template_root' => 'survey/result',
                                                   'input_name' => 'question',
                                                   'output_name' => 'question',
                                                   'namespace' => 'SurveyQuestion',
                                                   'attribute_access' => array( array( 'template_name' ) ),
                                                   'use_views' => 'view' ) );

        return new eZObjectForwarder( $forward_rules );
    }
}

?>
