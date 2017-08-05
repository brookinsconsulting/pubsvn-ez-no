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

/*! \file ezsurveyquestion.php
*/

include_once( 'kernel/classes/ezpersistentobject.php' );
include_once( 'extension/survey/modules/survey/classes/ezsurveyquestionresult.php' );

// Uses $GLOBALS['eZSurveyQuestionTypes'] as global variable

// Abstract class! Do not create instances of this class!
class eZSurveyQuestion extends eZPersistentObject
{
    function eZSurveyQuestion( $row )
    {
        $this->eZPersistentObject( $row );
    }

    function &definition()
    {
        return array( 'fields' => array ( 'id' => array( 'name' => 'ID',
                                                         'datatype' => 'integer',
                                                         'default' => 0,
                                                         'required' => true ),
                                          'survey_id' => array( 'name' => 'SurveyID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                          'tab_order' => array( 'name' => 'TabOrder',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                          'type' => array( 'name' => 'Type',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => true ),
                                          'text' => array( 'name' => 'Text',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => false ),
                                          'text2' => array( 'name' => 'Text2',
                                                            'datatype' => 'string',
                                                            'default' => '',
                                                            'required' => false ),
                                          'num' => array( 'name' => 'Num',
                                                          'datatype' => 'integer',
                                                          'default' => 0,
                                                          'required' => false ),
                                          'num2' => array( 'name' => 'Num2',
                                                           'datatype' => 'integer',
                                                           'default' => 0,
                                                           'required' => false ) ),
                      'function_attributes' => array( 'template_name' => 'templateName',
                                                      'answer' => 'answer',
                                                      'number' => 'questionNumber',
                                                      'result' => 'result' ),
                      'keys' => array( 'id' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZSurveyQuestion',
                      'sort' => array( 'tab_order', 'asc' ),
                      'name' => 'ezsurveyquestion' );
    }

    function &clone( $surveyID )
    {
        $row = array( 'id' => null,
                      'survey_id' => $surveyID,
                      'tab_order' => $this->TabOrder,
                      'type' => $this->Type,
                      'text' => $this->Text,
                      'text2' => $this->Text2,
                      'num' => $this->Num,
                      'num2' => $this->Num2 );
        $classname = implode( '', array( 'eZSurvey', $this->Type ) );
        $cloned = new $classname( $row );
        $cloned->store();
        return $cloned;
    }

    function &templateName()
    {
        return strtolower($this->Type);
    }

    function &answer()
    {
        $http =& eZHTTPTool::instance();

        if ( $http->hasPostVariable( 'SurveyAnswer_'.$this->ID ) )
            return $http->postVariable( 'SurveyAnswer_'.$this->ID );
        return false;
    }

    function registerQuestionType( $name, $type )
    {
        $GLOBALS['eZSurveyQuestionTypes'][] = array( 'name' => $name,
                                                     'type' => $type );
    }

    function &listQuestionTypes()
    {
        return $GLOBALS['eZSurveyQuestionTypes'];
    }

    function tabOrderCompare( &$question1, &$question2 )
    {
        $http =& eZHTTPTool::instance();

        $oldOrder1 =& $question1->attribute( 'tab_order' );
        $oldOrder2 =& $question2->attribute( 'tab_order' );
        $newOrder1 =& $http->postVariable( 'SurveyQuestionTabOrder_'.$question1->attribute( 'id' ) );
        $newOrder2 =& $http->postVariable( 'SurveyQuestionTabOrder_'.$question2->attribute( 'id' ) );

        if ( $newOrder1 < $newOrder2 )
            return -1;
        else if ( $newOrder1 > $newOrder2 )
            return 1;
        {
            if ( $oldOrder1 > $oldOrder2 )
                return -1;
            else if ( $oldOrder1 < $oldOrder2 )
                return 1;
            else
                return 0;
        }
    }

    function questionNumberIterate( &$iterator )
    {
        $this->QuestionNumber=$iterator++;
    }

    function &questionNumber()
    {
        return $this->QuestionNumber;
    }

    function processViewActions( &$validation )
    {
    }

    function processEditActions( &$validation )
    {
        $http =& eZHTTPTool::instance();

        if ( $http->hasPostVariable( 'SurveyQuestion_'.$this->ID.'_Text' ) &&
             $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Text' ) != $this->Text )
            $this->setAttribute( 'text', $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Text' ) );
        if ( $http->hasPostVariable( 'SurveyQuestion_'.$this->ID.'_Text2' ) &&
             $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Text2' ) != $this->Text2 )
            $this->setAttribute( 'text2', $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Text2' ) );
        if ( $http->hasPostVariable( 'SurveyQuestion_'.$this->ID.'_Num' ) &&
             $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Num' ) != $this->Num )
            $this->setAttribute( 'num', $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Num' ) );
        if ( $http->hasPostVariable( 'SurveyQuestion_'.$this->ID.'_Num2' ) &&
             $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Num2' ) != $this->Num2 )
            $this->setAttribute( 'num2', $http->postVariable( 'SurveyQuestion_'.$this->ID.'_Num2' ) );
    }

    function storeResult( $resultID )
    {
        $http =& eZHTTPTool::instance();

        if ( !$http->hasPostVariable( 'SurveyAnswer_'.$this->ID ) )
        {
            return;
        }
        $httpAnswer = $http->postVariable( 'SurveyAnswer_'.$this->ID );
        if ( !is_array( $httpAnswer ) )
        {
            $httpAnswer = array( $httpAnswer );
        }
        foreach ( $httpAnswer as $answer )
        {
            $questionResult = new eZSurveyQuestionResult( array ( 'result_id' => $resultID,
                                                                  'question_id' => $this->ID,
                                                                  'value' => $answer ) );
            $questionResult->store();
        }
    }

    function &result()
    {
        return false;
    }

    var $ID;
    var $SurveyID;
    var $TabOrder;
    var $Type;
    var $Text;
    var $Text2;
    var $Num;
    var $Num2;
    var $QuestionNumber='';
    var $QuestionTypes;
}

if ( !isset( $GLOBALS['eZSurveyQuestionTypes'] ) )
    $GLOBALS['eZSurveyQuestionTypes'] = array();

?>