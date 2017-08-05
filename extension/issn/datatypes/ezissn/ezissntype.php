<?php
//
/*
    ISSN Datatype extension for eZ publish 3.x
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
  \class eZISSNType ezissntype.php
  \brief The class eZISSNType. Based on eZISBNType and modified by Hans Melis (hmelis@sckcen.be)
  and Tom Couwberghs (tcouwber@sckcen.be).
*/

include_once( "kernel/classes/ezdatatype.php" );

define( "EZ_DATATYPESTRING_ISSN", "ezissn" );


class eZISSNType extends eZDataType
{
    function eZISSNType( )
    {
        $this->eZDataType( EZ_DATATYPESTRING_ISSN, ezi18n( 'extension/issn/datatypes', "ISSN", 'Datatype name' ), array( 'serialize_supported' => true ) );
    }
    
    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $field1 = $http->postVariable( $base . "_issn_field1_" . $contentObjectAttribute->attribute( "id" ) );
        $field2 = $http->postVariable( $base . "_issn_field2_" . $contentObjectAttribute->attribute( "id" ) );

        $issn = $field1.'-'.$field2;
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        if( ( $classAttribute->attribute( "is_required" ) == false ) &&  ( $issn == "-" ) )
        {
            return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
        }
        if ( preg_match( "#^[0-9]{4}\-[0-9]{3}[0-9X]{1}$#", $issn ) )
        {
            $digits = str_replace("-", "", $issn );
            $valid = $this->validateISSNChecksum ( $digits );
            if ( $valid )
            {
                return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
            }else
            {
                $contentObjectAttribute->setValidationError( ezi18n( 'extension/issn/datatypes','The ISSN number is not correct. Please recheck the input' ) );
                return EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
        }else
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'extension/issn/datatypes','The ISSN format is not valid.' ) );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }
        return EZ_INPUT_VALIDATOR_STATE_INVALID;
    }
    
    function validateISSNChecksum ( $issnNr )
    {
        $result=0;
        for ( $i=8;$i>0;$i-- )
        {
            if ( ( $i == 1 ) and ( $issnNr{7} == 'X' ) )
                $result += 10 * $i;
            else
                $result += $issnNr{8-$i} * $i;
        }
        if (  $result%11 == 0 )
            return true;
        else
            return false;
    }
    
    
    /*!
     Fetches the http post var string input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $field1 = $http->postVariable( $base . "_issn_field1_" . $contentObjectAttribute->attribute( "id" ) );
        $field2 = $http->postVariable( $base . "_issn_field2_" . $contentObjectAttribute->attribute( "id" ) );

        $issn = $field1.'-'.$field2;
        $contentObjectAttribute->setAttribute( "data_text", $issn );
        return true;
    }

    /*!
     Store the content.
    */
    function storeObjectAttribute( &$attribute )
    {
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        $data = $contentObjectAttribute->attribute( "data_text" );
        list ( $field1, $field2 ) = split ('[-]', $data );
        $issn = array( "field1" => $field1, "field2" => $field2 );
        return $issn;
    }

    function isIndexable()
    {
        return true;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_text" );
    }

    /*!
     Returns the text.
    */
    function title( &$data_instance )
    {
        return $data_instance->attribute( "data_text" );
    }
}

eZDataType::register( EZ_DATATYPESTRING_ISSN, "ezissntype" );

?>
