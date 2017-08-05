<?php

/*
    Regular Expression Line extension for eZ publish 3.x
    Copyright (C) 2005 Hans Melis

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/

/*!
  \class   hmregexplinetype hmregexplinetype.php
  \ingroup eZDatatype
  \brief   Handles the datatype regexpline
  \version 1.0
  \date    Thursday 17 March 2005 2:22:55 pm
  \author  Hans Melis

  By using regexpline you can ...

*/

include_once( "kernel/classes/ezdatatype.php" );

define( 'EZ_DATATYPESTRING_REGEXPLINE', "hmregexpline" );

class hmregexplinetype extends eZDataType
{
    /*!
      Constructor
    */
    function hmregexplinetype()
    {
        $this->eZDataType( EZ_DATATYPESTRING_REGEXPLINE, "Regular Expression Text" );
    }

    /*!
    Validates all variables given on content class level
     \return EZ_INPUT_VALIDATOR_STATE_ACCEPTED or EZ_INPUT_VALIDATOR_STATE_INVALID if
             the values are accepted or not
    */
    function validateClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $regexpName = $base . "_hmregexpline_regexp_" . $classAttribute->attribute( 'id' );
        
        if( $http->hasPostVariable( $regexpName ) )
        {
            $regexp = $http->postVariable( $regexpName );
            
            $check = @preg_match( $regexp, 'Dummy string' );
            
            if( $check === false )
            {
                return EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
        }

        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     Fetches all variables inputed on content class level
     \return true if fetching of class attributes are successfull, false if not
    */
    function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $regexpName = $base . "_hmregexpline_regexp_" . $classAttribute->attribute( 'id' );
        $helpName = $base . "_hmregexpline_helptext_" . $classAttribute->attribute( 'id' );
        $patternName = $base . "_hmregexpline_patternselect_" . $classAttribute->attribute( 'id' );

        $content = $classAttribute->content();

        if( $http->hasPostVariable( $regexpName ) )
        {
            $content['regexp'] = $http->postVariable( $regexpName );
        }
        
        if( $http->hasPostVariable( $helpName ) )
        {
            $content['help_text'] = $http->postVariable( $helpName );
        }
        
        if( $http->hasPostVariable( $patternName ) )
        {
            $content['pattern_selection'] = $http->postVariable( $patternName );
        }
        else if( $http->hasPostVariable( 'ContentClassHasInput' ) )
        {
            $content['pattern_selection'] = array();
        }

        $subPatternCount = @preg_match_all( "/\((?!\?\:)/", $content['regexp'], $matches );
        
        $content['subpattern_count'] = $subPatternCount == false ? 0 : $subPatternCount;
        
        $classAttribute->setContent( $content );
        $classAttribute->store();
        
        return true;
    }
    
    function storeClassAttribute( &$classAttribute, $version )
    {
        $content = $classAttribute->content();
        
        $classAttribute->setAttribute( 'data_text5', serialize( $content ) );
    }

    function &classAttributeContent( &$classAttribute )
    {
        $content = unserialize( $classAttribute->attribute( 'data_text5' ) );
        
        if( !is_array( $content ) )
        {
            $content = array( 'regexp' => '',
                              'help_text' => '',
                              'subpattern_count' => 0,
                              'pattern_selection' => array() );
        }
        
        return $content;
    }

    /*!
     Validates input on content object level
     \return EZ_INPUT_VALIDATOR_STATE_ACCEPTED or EZ_INPUT_VALIDATOR_STATE_INVALID if
             the values are accepted or not
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $textName = $base . "_hmregexpline_data_text_" . $contentObjectAttribute->attribute( 'id' );
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        
        if( $http->hasPostVariable( $textName ) )
        {
            $text = $http->postVariable( $textName );
            $classContent = $classAttribute->content();
            
            if( empty( $text ) and $classAttribute->attribute( 'is_required' ) == 1 )
            {
                $contentObjectAttribute->setValidationError( 'This is a required field which means you can\'t leave it empty' );
                return EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
            
            if( @preg_match( $classContent['regexp'], $text ) === 0 )
            {
                // No match
                $contentObjectAttribute->setValidationError( 'Your input did not meet the requirements.' );
                return EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
        }
        else
        {
            if( $classAttribute->attribute( 'is_required' ) == 1 )
            {
                $contentObjectAttribute->setValidationError( 'This is a required field which means you can\'t leave it empty' );
                return EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
        }
        
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     Fetches all variables from the object
     \return true if fetching of class attributes are successfull, false if not
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $textName = $base . "_hmregexpline_data_text_" . $contentObjectAttribute->attribute( 'id' );
        
        if( $http->hasPostVariable( $textName ) )
        {
            $text = $http->postVariable( $textName );
            $contentObjectAttribute->setAttribute( 'data_text', $text );
            return true;
        }
        return false;
    }

    function storeObjectAttribute( &$contentObjectAttribute )
    {
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    /*!
     Returns the value as it will be shown if this attribute is used in the object name pattern.
    */
    function title( &$contentObjectAttribute )
    {
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        $classContent = $classAttribute->content();
        $content = $contentObjectAttribute->content();
        $index = "";

        if( is_array( $classContent['pattern_selection'] ) and count( $classContent['pattern_selection'] ) > 0 )
        {
            $res = @preg_match( $classContent['regexp'], $content, $matches );

            if( $res !== false )
            {
                foreach( $classContent['pattern_selection'] as $patternIndex )
                {
                    if( isset( $matches[$patternIndex] ) )
                    {
                        $index .= $matches[$patternIndex];
                    }
                }
            }
        }
        else
        {
            $index = $content;
        }

        return $index;
    }

    /*!
     \return true if the datatype can be indexed
    */
    function isIndexable()
    {
        return true;
    }

}

eZDataType::register( EZ_DATATYPESTRING_REGEXPLINE, "hmregexplinetype" );

?>
