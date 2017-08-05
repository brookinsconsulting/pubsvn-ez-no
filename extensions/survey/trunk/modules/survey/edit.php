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

/*! \file edit.php
*/

include_once( 'kernel/common/template.php' );
include_once( 'extension/survey/modules/survey/classes/ezsurvey.php' );

$http =& eZHTTPTool::instance();

$Module =& $Params['Module'];

if ( $http->hasPostVariable( 'SurveyDiscardButton' ) )
{
    $Module->redirectTo( '/survey/list' );
}

$surveyID =& $Params['SurveyID'];
$survey =& eZSurvey::fetch( $surveyID );

if ( !$survey || $survey->published() )
    return $Module->handleError( EZ_ERROR_KERNEL_NOT_AVAILABLE, 'kernel' );

$surveyList =& $survey->fetchQuestionList();
$validation = array();
$survey->processEditActions( $validation );

if ( $http->hasPostVariable( 'SurveyPublishButton' ) && $validation['error'] == false )
{
    $survey->setAttribute( 'published', 1 );
    $survey->store();
    $Module->redirectTo( '/survey/list' );
}

$survey->sync();

$tpl =& templateInit();

$tpl->setVariable( 'survey', $survey );
$tpl->setVariable( 'survey_questions', $surveyList );
$tpl->setVariable( 'survey_validation', $validation );

$Result = array();
$Result['content'] =& $tpl->fetch( 'design:survey/edit.tpl' );

?>
