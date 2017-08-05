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

/*! \file ezsurvey.php
*/

include_once( 'kernel/classes/ezpersistentobject.php' );
include_once( 'extension/survey/modules/survey/classes/ezsurveyquestion.php' );
include_once( 'extension/survey/modules/survey/classes/ezsurveyquestions.php' );

class eZSurvey extends eZPersistentObject
{
    function eZSurvey( $row )
    {
        $this->eZPersistentObject( $row );
        $this->QuestionList = null;
    }

    function &definition()
    {
        return array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'title' => array( 'name' => 'Title',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => true ),
                                         'enabled' => array( 'name' => 'Enabled',
                                                             'datatype' => 'integer',
                                                             'default' => '1',
                                                             'required' => true ),
                                         'published' => array( 'name' => 'Published',
                                                               'datatype' => 'integer',
                                                               'default' => '0',
                                                               'required' => true ) ),
                      'keys' => array( 'id' ),
                      'function_attributes' => array( 'question_types' => 'questionTypes' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZSurvey',
                      'sort' => array( 'id' => 'asc' ),
                      'name' => 'ezsurvey' );
    }

    function &clone()
    {
        $row = array( 'id' => null,
                      'title' => $this->Title.' (Copy)',
                      'enabled' => 1,
                      'published' => 0 );
        $cloned = new eZSurvey( $row );
        $cloned->store();
        if ( $this->QuestionList === null )
        {
            $this->fetchQuestionList();
        }
        foreach( array_keys($this->QuestionList) as $key )
        {
            $question =& $this->QuestionList[$key];
            $question->clone( $cloned->attribute( 'id' ) );
        }
        return $cloned;
    }

    function id()
    {
        return $this->ID;
    }

    function &fetch( $id , $asObject = true )
    {
        //if ( is_numeric( $id ) )
            $key = 'id';
        //else
        //    $key = 'title';
        return eZPersistentObject::fetchObject( eZSurvey::definition(), 
                                                null,
                                                array( $key => $id ),
                                                $asObject );
    }

    function &fetchQuestionList()
    {
        if ( $this->QuestionList === null )
        {
            $rows = ezPersistentObject::fetchObjectList( eZSurveyQuestion::definition(),
                                                         null,
                                                         array( 'survey_id' => $this->ID ),
                                                         array( 'tab_order' => 'asc' ),
                                                         null,
                                                         false );
            $objects = array();
            $this->QuestionList = array();
            $questionIterator = 1;
            foreach ( $rows as $row )
            {
                $classname = implode( '', array( 'eZSurvey', $row['type'] ) );
                $newObject = new $classname( $row );
                $newObject->questionNumberIterate( $questionIterator );
                $this->QuestionList[$newObject->attribute( 'id' )] = $newObject;
            }
        }
        return $this->QuestionList;
    }

    function &fetchSurveyList()
    {
        $rows = ezPersistentObject::fetchObjectList( eZSurvey::definition(),
                                                     null,
                                                     null,
                                                     array( 'id' => 'desc' ),
                                                     null,
                                                     true );
        return $rows;
    }

    function enabled()
    {
        return ( $this->Enabled == '1' )? true: false;
    }

    function published()
    {
        return ( $this->Published == '1' )? true: false;
    }

    function processViewActions( &$validation )
    {
        $validation['error'] = false;
        $validation['warning'] = false;
        $validation['errors'] = array();
        $validation['warnings'] = array();

        if ( $this->QuestionList === null )
        {
            fetchQuestionList();
        }

        $http =& eZHTTPTool::instance();

        if ( !$http->hasPostVariable( 'SurveyID' ) )
            return;

        foreach ( array_keys( $this->QuestionList ) as $key )
        {
            $question =& $this->QuestionList[$key];
            $question->processViewActions( $validation );
        }
    }

    function processEditActions( &$validation )
    {
        $validation['error'] = false;
        $validation['warning'] = false;
        $validation['errors'] = array();
        $validation['warnings'] = array();

        if ( $this->QuestionList === null )
        {
            fetchQuestionList();
        }

        $http =& eZHTTPTool::instance();

        if ( !$http->hasPostVariable( 'SurveyID' ) )
            return;

        if ( $http->postVariable( 'SurveyTitle' ) != $this->Title )
            $this->setAttribute( 'title', $http->postVariable( 'SurveyTitle' ) );

        $enabled = ( $http->hasPostVariable( 'SurveyEnabled' ) )? 1: 0;
        
        if ( $enabled != $this->Enabled )
            $this->setAttribute( 'enabled', $enabled );

        usort( $this->QuestionList, array( 'eZSurveyQuestion', 'tabOrderCompare' ) );

        if ( $http->hasPostVariable( 'SurveyRemoveSelected' ) )
        {
            foreach ( array_keys($this->QuestionList ) as $key )
            {
                $question =& $this->QuestionList[$key];
                if ( $http->hasPostVariable( 'SurveyQuestion_'.$question->attribute( 'id' ).'_Selected' ) )
                {
                    $question->remove();
                    unset( $this->QuestionList[$key] );
                }
            }
        }

        foreach ( array_keys( $this->QuestionList ) as $key )
        {
            $question =& $this->QuestionList[$key];
            $question->processEditActions( $validation );
        }

        if ( $http->hasPostVariable( 'SurveyNewQuestion' ) )
        {
            $classname = implode( '', array( 'eZSurvey', $http->postVariable( 'SurveyNewQuestionType' ) ) );
            $newObject = new $classname( array( 'survey_id' => $this->ID ) );
            $this->QuestionList[$newObject->attribute( 'id' )] =& $newObject;
        }

        $iterator = 1;
        foreach ( array_keys( $this->QuestionList ) as $key )
        {
            $question =& $this->QuestionList[$key];
            if ( $question->attribute( 'tab_order' ) != $iterator )
                $question->setAttribute( 'tab_order', $iterator );
            $iterator++;
        }
    }

    function sync( $fieldFilters = null )
    {
        eZPersistentObject::sync( $fieldFilters );
        foreach ( array_keys( $this->QuestionList ) as $key )
        {
            $question =& $this->QuestionList[$key];
            $question->sync();
        }
    }

    function storeAll()
    {
        $this->store();
        foreach ( array_keys( $this->QuestionList ) as $key )
        {
            $question =& $this->QuestionList[$key];
            $question->store();
        }
    }

    function storeResult( $resultID )
    {
        foreach ( array_keys( $this->QuestionList ) as $key )
        {
            $question =& $this->QuestionList[$key];
            $question->storeResult( $resultID );
        }
    }

    function &questionTypes()
    {
        return eZSurveyQuestion::listQuestionTypes();
    }

    var $ID;
    var $Title;
    var $Enabled;
    var $Published;
    var $QuestionList;
}

?>
