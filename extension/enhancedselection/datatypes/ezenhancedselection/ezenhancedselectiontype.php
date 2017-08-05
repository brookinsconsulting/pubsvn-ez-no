<?php

/*
    Enhanced Selection extension for eZ publish 3.x
    Copyright (C) 2003-2005  SCK•CEN (Belgian Nuclear Research Centre)
    
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
  \class   ezenhancedselectiontype ezenhancedselectiontype.php
  \ingroup eZDatatype
  \brief   Handles the single and multiple selections.
  \author  SCK•CEN KM Team <g_km@sckcen.be>
  \version 1.1a
*/

include_once( "kernel/classes/ezdatatype.php" );
include_once( "lib/ezxml/classes/ezxml.php" );

define( "EZ_DATATYPESTRING_EZ_ENHANCEDSELECTION", "ezenhancedselection" );

class eZEnhancedSelectionType extends eZDataType
{
    /*!
      Constructor
    */
    function eZEnhancedSelectionType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_EZ_ENHANCEDSELECTION, ezi18n( 'extension/datatypes', "Enhanced Selection", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }
    
    /*!
     Validates all variables given on content class level
     \return EZ_INPUT_VALIDATOR_STATE_ACCEPTED or EZ_INPUT_VALIDATOR_STATE_INVALID if
             the values are accepted or not
    */
    function validateClassAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }
    
    /*!
     Fetches all variables inputed on content class level
     \return true if fetching of class attributes are successfull, false if not
    */
    function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $attributeContent =& $this->classAttributeContent( $classAttribute );
        $classAttributeID = $classAttribute->attribute( 'id' );
        $isMultipleSelection = false;
		$delimiter = false;
		
        if ( $http->hasPostVariable( $base . "_ezenhancedselection_ismultiple_value_" . $classAttributeID ) )
        {
            $isMultipleSelection = true;
        }
        
		if ( $http->hasPostVariable( $base . "_ezenhancedselection_delimiter_". $classAttributeID ) )
        {
            $delimiter = $http->postVariable( $base . "_ezenhancedselection_delimiter_". $classAttributeID );
		}
		
        $currentOptions = $attributeContent['options'];
        $hasPostData = false;
        
        if ( $http->hasPostVariable( $base . "_ezenhancedselection_option_name_array_" . $classAttributeID ) )
        {
            $nameArray = $http->postVariable( $base . "_ezenhancedselection_option_name_array_" . $classAttributeID );
			$identifierArray = $http->postVariable( $base . "_ezenhancedselection_option_identifier_array_" . $classAttributeID );
			$priorityArray = $http->postVariable( $base . "_ezenhancedselection_option_priority_array_" . $classAttributeID );

            // Fill in new names for options
            foreach ( array_keys( $currentOptions ) as $key )
            {
                $currentOptions[$key]['name'] = $nameArray[$currentOptions[$key]['id']];

                if( $identifierArray[$currentOptions[$key]['id']] == "" )
				{
					$name = $nameArray[$currentOptions[$key]['id']];
					$name = strtolower( $name );
                    $name = preg_replace( array( '/[^a-z0-9_ ]/' ,
                                       '/ /',
                                       '/__+/' ),
                                array( '',
                                       '_',
                                       '_' ),
                                $name );
					$name = preg_replace( array('/^_+/',
												'/_+$/'),
										  array('',
										  		''),
										  $name );

                    if( $name != "" && in_array( $name, $identifierArray ) )
					{
						$highestNumber = 0;

                        foreach( $identifierArray as $identifier )
						{
							if( preg_match( '/^'.$name.'__(\d+)$/', $identifier, $matchArray ) )
							{
								if( $matchArray[1] > $highestNumber )
								{
									$highestNumber = $matchArray[1];
								}
							}
						}
						
						$name .= "__" . ++$highestNumber;
					}
					
					$identifierArray[$currentOptions[$key]['id']] = $name;
				}
				
				$currentOptions[$key]['identifier'] = $identifierArray[$currentOptions[$key]['id']];
				$currentOptions[$key]['priority'] = $priorityArray[$currentOptions[$key]['id']];
            }
            $hasPostData = true;
        }
        
		//add a new option
        if ( $http->hasPostVariable( $base . "_ezenhancedselection_newoption_button_" . $classAttributeID ) )
        {
            $currentOptions[] = array( 'id' => count( $currentOptions ) + 1,
                                       'name' => '',
									   'identifier' => '' );
            $hasPostData = true;
        }
        
		//remove options
		if( $http->hasPostVariable( $base . "_ezenhancedselection_removeoption_button_" . $classAttributeID ) )
		{
			$toRemoveArray = $http->postVariable( $base."_ezenhancedselection_option_remove_array_".$classAttributeID );
			$optionIndexToRemove = array();
			
			foreach( $toRemoveArray as $key => $toRemove )
            {
				foreach( $currentOptions as $key2 => $option )
                {
					if( $option["id"] == $key )
                    {
						$optionIndexToRemove[] = $key2;
					}
				}
			}
			
			$tmp = array();
			
			foreach( $currentOptions as $key => $option )
            {
				if( !in_array( $key, $optionIndexToRemove ) )
                {
					$tmp[$key] = $option;
				}
			}
			
			$currentOptions = $tmp;
			$hasPostData = true;
		}

        //move an option down the list
		if( $http->hasPostVariable( "Move_option_down_" . $classAttributeID ) )
		{
			$toMove = array();
			$toMove = array_keys( $http->postVariable( "Move_option_down_" . $classAttributeID ) );
			
			$toMoveOption = $toMove[0];
			$this->reorderTable( $currentOptions, $toMoveOption, "down" );

            $hasPostData = true;
		}
		
		if( $http->hasPostVariable( "Move_option_up_" . $classAttributeID ) )
		{
			$toMove = array();
			$toMove = array_keys( $http->postVariable( "Move_option_up_" . $classAttributeID ) );
			
			$toMoveOption = $toMove[0];
			$this->reorderTable( $currentOptions, $toMoveOption, "up" );
			
			$hasPostData = true;
		}
		
		if( $http->hasPostVariable( "Sort_options_" . $classAttributeID ) and
            $http->hasPostVariable( "Sort_options_order_" . $classAttributeID ) )
		{
            $order = $http->postVariable( "Sort_options_order_" . $classAttributeID );
            $sortArray = array();
            $sortOrder = SORT_ASC;
            $sortType = SORT_STRING;
            $numericSorts = array( 'prior' );

            if( strpos( $order, '_' ) !== false )
            {
                list( $type, $ranking ) = explode( '_', $order );
            }
            else
            {
                $type = $order;
                $ranking = 'asc';
            }
            
            switch( $ranking )
            {
                case 'desc':
                    $sortOrder = SORT_DESC;
                    break;
                    
                case 'asc':
                default:
                    $sortOrder = SORT_ASC;
                    break;
            }
            
            if( in_array( $type, $numericSorts ) )
            {
                $sortType = SORT_NUMERIC;
            }

            foreach( $currentOptions as $option )
            {
                switch( $type )
                {
                    case 'prior':
                        $sortArray[] = $option['priority'];
                        break;
                        
                    case 'alpha':
                    default:
                        $sortArray[] = $option['name'];
                        break;
                }
            }
            
            array_multisort( $sortArray, $sortOrder, $sortType, $currentOptions );
        }
		
        if( $hasPostData )
        {
            // Serialize XML
            $doc = new eZDOMDocument( "selection" );
            $root =& $doc->createElementNode( "ezenhancedselection" );
            $doc->setRoot( $root );
            
            $options =& $doc->createElementNode( "options" );
            $root->appendChild( $options );
            
            foreach ( $currentOptions as $optionArray )
            {
                $optionNode =& $doc->createElementNode( "option" );
                $optionNode->appendAttribute( $doc->createAttributeNode( "id", $optionArray['id'] ) );
                $optionNode->appendAttribute( $doc->createAttributeNode( 'name', $optionArray['name'] ) );
				$optionNode->appendAttribute( $doc->createAttributeNode( 'identifier', $optionArray['identifier']));
				$optionNode->appendAttribute( $doc->createAttributeNode( 'priority', $optionArray['priority'] ) );
                $options->appendChild( $optionNode );
            }
            
            $xml =& $doc->toString();
            $classAttribute->setAttribute( "data_text5", $xml );
            
            if ( $isMultipleSelection == true )
            {
                $classAttribute->setAttribute( "data_int1", 1 );
            }
            else
            {
                $classAttribute->setAttribute( "data_int1", 0 );
            }
            
			$classAttribute->setAttribute( "data_text1", $delimiter);
        }
        return true;
    }

    /*!
     Validates input on content object level
     \return EZ_INPUT_VALIDATOR_STATE_ACCEPTED or EZ_INPUT_VALIDATOR_STATE_INVALID if
             the values are accepted or not
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        $classContent = $classAttribute->content();
        
        if( $http->hasPostVariable( $base . '_ezenhancedselect_selected_array_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $selectOptions =& $http->postVariable( $base . '_ezenhancedselect_selected_array_' . $contentObjectAttribute->attribute( 'id' ) );
            $optionCount = count( $selectOptions );
            $isRequired = $classAttribute->attribute( 'is_required' );
            
   			if( ($isRequired == 1 and $optionCount < 1) or
                ($isRequired == 1 and $optionCount == 1 and empty( $selectOptions[0] )) )
			{
				$contentObjectAttribute->setValidationError( 'No value selected. Please select one.' );
				return EZ_INPUT_VALIDATOR_STATE_INVALID;
			}
			else
			{
				return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;	
			}
		}
		else
		{
            if( $classContent['is_multiselect'] == 1 and $classAttribute->attribute( 'is_required' ) == 1 )
            {
                $contentObjectAttribute->setValidationError( 'This is a required field. You need to select at least one option.' );
            }
            else if ( $classAttribute->attribute( 'is_required' ) == 1 )
            {
                $contentObjectAttribute->setValidationError( 'No POST variable. Please check your configuration.' );
            }
            else
            {
                return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
            }
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
		}
    }
    
    /*!
     Fetches all variables from the object
     \return true if fetching of class attributes are successfull, false if not
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        $classContent = $classAttribute->content();
        
        if( $http->hasPostVariable( $base . '_ezenhancedselect_selected_array_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $selectOptions =& $http->postVariable( $base . '_ezenhancedselect_selected_array_' . $contentObjectAttribute->attribute( 'id' ) );
            $idString = implode( '***', $selectOptions );
            $contentObjectAttribute->setAttribute( 'data_text', $idString );
            return true;
        }
        else
        {
            if( $classContent['is_multiselect'] == 1 )
            {
                $contentObjectAttribute->setAttribute( 'data_text', '' );
                return true;
            }
        }
        return false;
    }

    /*!
     Returns the selected options by id.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        $idString = $contentObjectAttribute->attribute( 'data_text' );
        
		return explode( '***', $idString );
    }
    
    /*!
     Returns the content data for the given content class attribute.
    */
    function &classAttributeContent( &$classAttribute )
    {
        $xml = new eZXML();
        $xmlString =& $classAttribute->attribute( 'data_text5' );
        $dom =& $xml->domTree( $xmlString );

        if( $dom )
        {
            $options =& $dom->elementsByName( 'option' );
            $optionArray = array();
            
			if( count( $options ) > 0 )
			{
				foreach( $options as $optionNode )
	            {
	                $optionArray[] = array( 'id' => $optionNode->attributeValue( 'id' ),
	                                        'name' => $optionNode->attributeValue( 'name' ),
											'identifier' => $optionNode->attributeValue( 'identifier' ),
                                            'priority' => $optionNode->attributeValue( 'priority' ) );
	            }
			}
			else
			{
	            $optionArray[] = array( 'id' => 0,
	                                    'name' => '',
										'identifier' => '' );
			}
        }
        else
        {
            $optionArray[] = array( 'id' => 0,
                                    'name' => '',
									'identifier' => '' );
        }
        
        return  array( 'options' => $optionArray,
                       'is_multiselect' => $classAttribute->attribute( 'data_int1' ),
					   'delimiter' => $classAttribute->attribute( 'data_text1' )
                       );
    }
    
    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        $content = $this->objectAttributeContent( $contentObjectAttribute );

        return array( array( 'id' => '',
							 'text' => implode(' ', $content),
							 'literal' => false ) );
    }
    
    /*!
     Returns the value as it will be shown if this attribute is used in the object name pattern.
    */
    function title( &$contentObjectAttribute )
    {
        $selectedItems = $contentObjectAttribute->content();
        $classContent = $this->classAttributeContent( $contentObjectAttribute->attribute( 'contentclass_attribute' ) );
        
        if( count( $selectedItems ) == 0)
        {
            return '';
        }
        
        $resultArray = array();
        
        foreach( $selectedItems as $selectedItem )
        {
            foreach( $classContent['options'] as $option )
            {
                if( $option['identifier'] === $selectedItem )
                {
                    $resultArray[] = $option['name'];
                }
            }
        }
        
        $delimiter = $classContent['delimiter'];
        
        if( empty( $delimiter ) )
        {
            $delimiter = ', ';
        }
        
        return implode( $delimiter , $resultArray );
    }
    
    /*!
     \return true if the datatype can be indexed
    */
    function isIndexable()
    {
        return true;
    }
    
	function &sortKey( &$contentObjectAttribute )
    {
        $content = $this->objectAttributeContent( $contentObjectAttribute );
		$content = implode(' ', $content);

        return strtolower( $content );
    }
    
    function &sortKeyType()
    {
        return 'string';
    }
    
	function isInformationCollector()
    {
        return true;
    }
    
	/*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( &$collection, &$collectionAttribute, &$http, $base, &$contentObjectAttribute )
    {
        $identArray =& $http->postVariable( $base . "_ezenhancedselect_selected_array_" . $contentObjectAttribute->attribute( "id" ) );
		$classContent = $this->classAttributeContent( $contentObjectAttribute->attribute( 'contentclass_attribute' ) );
        $resultArray = array( );
        
		if( count( $identArray ) > 0)
        {
            foreach( $identArray as $ident )
	        {
	            foreach( $classContent['options'] as $option )
	            {
	                if( $option['identifier'] === $ident )
	                {
	                    $resultArray[] = $option['name'];
	                }
	            }
	        }
		}
		
		$delimiter = $classContent['delimiter'];

        if( empty( $delimiter ) )
        {
            $delimiter = ', ';
        }
		
        $dataText = implode( $delimiter, $resultArray );

        $collectionAttribute->setAttribute( 'data_text', $dataText );

        return true;
    }
    
	/*!
     \reimp
    */
    function &serializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
		$multipleChoice = $classAttribute->attribute('data_int1');
        $delimiter = $classAttribute->attribute( 'data_text1' );
		$xmlString = $classAttribute->attribute('data_text5');
		
		$xml = new eZXML();
		$dom =& $xml->domTree( $xmlString );
		$xmltext = $dom->toString();
		
		$attributeParametersNode->appendChild( eZDOMDocument::createElementTextNode( 'multiple-choice', $multipleChoice ) );
        $attributeParametersNode->appendChild( eZDOMDocument::createElementTextNode( 'delimiter', $delimiter ) );
		$attributeParametersNode->appendChild( eZDOMDocument::createElementTextNode( 'options', $xmltext ) );
	}
	
	/*!
     \reimp
    */
    function &unserializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
		$multipleChoice = $attributeParametersNode->elementTextContentByName( 'multiple-choice' );
        $delimiter = $attributeParametersNode->elementTextContentByName( 'delimiter' );
		$options = $attributeParametersNode->elementTextContentByName( 'options' );
		
		$classAttribute->setAttribute( 'data_int1', intval( $multipleChoice ) );
        $classAttribute->setAttribute( 'data_text1', $delimiter );
        
		$chars = get_html_translation_table(HTML_SPECIALCHARS);
		$chars = array_flip($chars);
		$result = strtr( $options, $chars );
		$classAttribute->setAttribute('data_text5', $result);
	}

    /*!
     This function reorders a table and moves the specified entry either down or up
    */
	function reorderTable( &$table, $id, $direction = "down" )
	{
        $tmp = array();
        $toMoveOption = $id;
        $i = 0;
        $found=false;
        
        if($direction == "up")
        {
        	$table = array_reverse( $table );
        }
        
        foreach( $table as $option )
        {
        	if( $option["id"] == $toMoveOption )
            {
        		if( $i+1 < count( $table ) )
                {
        			$i++;
        		}
        		
        		$found = true;
        		$tmp[$i] = $option;
        	}
            else
            {
        		if( $found )
                {
        			$i-=2;
        			$tmp[$i] = $option;
        			$found = false;
        			$i+=1;
        		}
                else
                {
        			$tmp[$i] = $option;
        		}
        	}
        	
        	$i++;
        }
        
        ksort( $tmp );
        
        if( $direction == "up" )
        {
        	$table = array_reverse( $tmp, false );
        }
        else
        {
        	$table = $tmp;
        }
	}
}
eZDataType::register( EZ_DATATYPESTRING_EZ_ENHANCEDSELECTION, "ezenhancedselectiontype" );
?>
