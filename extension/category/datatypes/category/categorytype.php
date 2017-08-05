<?php
//
// Definition of Category datatype
//
// Copyright (C) 1999-2003 Vision with Technology, All rights reserved.
// http://www.visionwt.com
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation 
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@visionwt.com if any conditions of this licencing isn't clear to
// you.
//
/*
Author:       Paul Forsyth
Version:      $Id: categorytype.php,v 1.2 2003/12/15 15:18:22 paulf Exp $
*/

// Include the super class file
include_once( "kernel/classes/ezdatatype.php" );

// Include the category class
include_once( "extension/category/datatypes/category/category.php" );

// debug
include_once( "lib/ezutils/classes/ezdebug.php" );

// Define the name of datatype string
define( "EZ_DATATYPESTRING_CATEGORY", "category" );

class CategoryType extends eZDataType
{
    /*!
     Construction of the class, note that the second parameter in eZDataType 
     is the actual name showed in the datatype dropdown list.
    */
    function CategoryType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_CATEGORY, "Category" );
    }

    /*!
    */
    function validateObjectAttributeHTTPInput( &$http, 
																		$base, 
																		&$contentObjectAttribute )
    {
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
		$debug=true;
		
		if ($debug) eZDebug::writeDebug( "Fetching information from:".$base."_Category_data_" .$contentObjectAttribute->attribute( "id" ) );

        if ( $http->hasPostVariable( $base . "_Category_data_" .$contentObjectAttribute->attribute( "id" ) ) )
        {
            $data =& $http->postVariable( $base . "_Category_data_" .$contentObjectAttribute->attribute( "id" ) );

			if ($debug) eZDebug::writeDebug( "Fetching information: ".$data." array: ".count($data));

            $category = new Category();

			// parse the input data into the category array
			$categories = explode(",",$data);

			// add categories to the category class for later storage
            $category->initialiseCategory( $categories );
            
            // inform the content object of this content.
            $contentObjectAttribute->setContent( $category );
            return true;
        }

        return false;
    }

    /*!
     Store the content. Since the content has been stored in function 
     fetchObjectAttributeHTTPInput(), this function is with empty code.
    */
    function storeObjectAttribute( &$contentObjectattribute )
    {
		$debug=true;
		
		if ($debug) eZDebug::writeDebug( "Storing information" );

        $category =& $contentObjectattribute->content();

        if ( is_object( $category ) )
        {
        	$category->store( $contentObjectattribute );
        }

		if ($debug) eZDebug::writeDebug( "Finished storing information" );
    }

    /*!
     \reimp
    */
    function fetchClassAttributeHTTPInput( &$http, $base, &$attribute )
    {
        return true;
    }

    /*!
     \reimp
    */
    function validateClassAttributeHTTPInput( &$http, $base, &$attribute )
    {
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
    	$debug=true;
		if ($debug) eZDebug::writeDebug( "Fetching objectAttributeContent information");

        $category = new Category();
        $category->fetch( $contentObjectAttribute );

		if ($debug) eZDebug::writeDebug( "Finished objectAttributeContent information");

        return $category;
    }

    /*!
     Returns the meta data used for storing search indices.
    */
    function metaData( $contentObjectAttribute )
    {
    	$debug=true;
		if ($debug) eZDebug::writeDebug( "Fetching metaData information");

        $category = new Category();
        $category->fetch( $contentObjectAttribute );

        $return =& $category->categoriesString();

		if ($debug) eZDebug::writeDebug( "Finished metaData information");

        return $return;
    }

    /*!
     \reuturn the collect information action if enabled
    */
    function contentActionList( &$classAttribute )
    {
        return array();
    }

    /*!
     Returns the text.
    */
    function title( &$contentObjectAttribute )
    {
    	$debug=true;
		if ($debug) eZDebug::writeDebug( "Fetching title information");

        $category = new Category();
        $category->fetch( $contentObjectAttribute );

        $return =& $category->categoriesString();

		if ($debug) eZDebug::writeDebug( "Finished title information");

        return $return;
    }
    
    function isIndexable()
    {
        return true;
    }

    function isInformationCollector()
    {
        return true;
    }
    
}

eZDataType::register( EZ_DATATYPESTRING_CATEGORY, "categorytype" );

?>