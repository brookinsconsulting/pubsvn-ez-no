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

/*! \file ezsurveyresult.php
*/

include_once( 'kernel/classes/ezpersistentobject.php' );
include_once( 'extension/survey/modules/survey/classes/ezsurveymetadata.php' );

class eZSurveyResult extends eZPersistentObject
{
    function eZSurveyResult( &$survey, $metaData = false )
    {
        $this->Survey =& $survey;
        $row = array( 'survey_id' => $survey->id() );
        $this->eZPersistentObject( $row );
        if ( $metaData == false )
        {
            $this->MetaData = null;
        }
        else
        {
            $this->MetaData = $metaData;
        }
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
                                          'tstamp' => array( 'name' => 'TStamp',
                                                             'datatype' => 'integer',
                                                           'default' => 0,
                                                           'required' => false ) ),
                      'keys' => array( 'id' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZSurveyResult',
                      'sort' => array( 'id', 'asc' ),
                      'name' => 'ezsurveyresult' );
    }

    function storeResult()
    {
        $this->setAttribute( 'tstamp', time() );
        $this->store();
        $object = new eZSurveyMetaData( array( 'result_id' => $this->ID ) );
        if ( $this->MetaData !== null )
        {
            foreach( array_keys( $this->MetaData ) as $key )
            {
                $object->setAttribute( 'attr_name', $key );
                $object->setAttribute( 'attr_value', $this->MetaData[$key] );
                $object->store();
                $object->setAttribute( 'id', null );
            }
        }
        else
        {
            // to have stored result_id in ezsuveymetadata table too
            $object->setAttribute( 'attr_name', '' );
            $object->setAttribute( 'attr_value', '' );
            $object->store();
        }
        $this->Survey->storeResult( $this->ID );
    }

    // static
    function &fetchResultID( $surveyID, $offset, $metadata = false )
    {
        $db =& eZDB::instance();
        $offset = (int) $offset;
        $offset--; // we are counting from 1, sql counts from 0

        if ( $metadata == false )
        {
            $query = ' FROM ezsurveyresult WHERE survey_id=\'';
            $query .= $surveyID;
            $query .= '\'';
        }
        else
        {
            $query = ' FROM ezsurveyresult, ezsurveymetadata as m1';
            for( $index=2; $index <= count( $metadata ); $index++ )
            {
                $query .= ', ezsurveymetadata as m';
                $query .= $index;
            }
            $query .= ' where survey_id=\'';
            $query .= $surveyID;
            $query .= '\'';
            $index = 0;
            foreach ( array_keys( $metadata ) as $key )
            {
                $index++;
                if ( $index == 1 )
                    $query .= ' and ezsurveyresult.id=m1.result_id';
                else
                {
                    $query .= ' and m';
                    $query .= ( $index - 1 );
                    $query .= '.result_id=m';
                    $query .= $index;
                    $query .= '.result_id';
                }
                $query .= ' and m';
                $query .= $index;
                $query .= '.attr_name=\'';
                $query .= $key;
                $query .= '\' and m';
                $query .= $index;
                $query .= '.attr_value=\'';
                $query .= $metadata[$key];
                $query .= '\'';
            }
        }
        $countRows =& $db->arrayQuery( 'SELECT count(distinct ezsurveyresult.id) as count'.$query );
        $count= $countRows[0]['count'];
        $resultIDRows =& $db->arrayQuery( 'SELECT distinct ezsurveyresult.id as result_id'.$query, array ( 'limit' => 1,
                                                                                      'offset' => $offset ) );
        $resultID = false;
        foreach ( array_keys( $resultIDRows ) as $key )
            $resultID = $resultIDRows[$key]['result_id'];
        return array( 'count' => $count, 'result_id' => $resultID );
    }

    var $ID;
    var $SurveyID;
    var $TStamp;
    var $Survey = false;
    var $MetaData;
}

?>