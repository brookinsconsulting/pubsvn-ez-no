<?php
//
// Definition of Category class
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
Version:      $Id: category.php,v 1.3 2003/12/15 15:18:22 paulf Exp $
*/

// debug
include_once( "lib/ezutils/classes/ezdebug.php" );

// Include the category db class
include_once( "extension/category/lib/category_db.php" );

class Category
{
    /*!
     Construct a new keyword instance
    */
    function Category( )
    {
    }

	//Attributes
    function hasAttribute( $name )
    {
        if ( $name == 'categories' or
             $name == 'category_string' )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function &attribute( $name )
    {
        switch ( $name )
        {
            case 'categories' :
            {
                return $this->categoryArray();
				break;
            }

            case 'category_string' :
            {
                return $this->categoriesString();
				break;
            }
        }
    }

    /*!
     Initialise the category object
    */
    function initialiseCategory( $selectedCategories )
    {
		$debug=true;
		
        foreach ( $selectedCategories as $selectedCategory )
        {
			if ($debug) eZDebug::writeDebug( "Adding category: ".trim($selectedCategory));

            $this->CategoryArray[] = trim($selectedCategory);
        }

		if ($debug) eZDebug::writeDebug( "Category string: ".$this->categoriesString() );
    }

    /*!
     Stores new categories and removes old
    */
    function store( &$attribute )
    {
		$debug=true;
		
		if ($debug) eZDebug::writeDebug( "Storing categories: ".$this->categoriesString() );

		// Assign the attribute id		
        $attributeId = $attribute->attribute( 'id' );

        // Get present categories for the attribute
		$existingCategories =& PersistentCategory::fetchByAttribute($attributeId);

		if ($debug) eZDebug::writeDebug( "Count of existing categories: ".count($existingCategories));

        // Find out which categories to remove, if any
		foreach ( $existingCategories as $existingCategory )
		{
			if ($debug) eZDebug::writeDebug( "Count of existing categories: ".count($existingCategories));


			// Check whether the current category is part of the new list
			if ( !in_array($existingCategory->attribute('category'), $this->CategoryArray) )
			{
				if ($debug) eZDebug::writeDebug( "Removing category id: ".$existingCategory->attribute('id'));

				PersistentCategory::remove($existingCategory->attribute('id'));
			}
		}
		
		// Find which categories to add.
		foreach ($this->CategoryArray as $newCategory)
		{
			$newCategoryObject =& PersistentCategory::fetchByCategoryAndAttribute($newCategory, $attributeId);

			// Test if the present category exists. If not add it as new.
			if (!is_object($newCategoryObject))
			{
				if ($debug) eZDebug::writeDebug( "Adding category: ".$newCategory);

                $createNewCategoryObject =& PersistentCategory::create($newCategory, $attributeId);
                $createNewCategoryObject->store();
			}
		}

		if ($debug) eZDebug::writeDebug( "Finished storing");
    }

    /*!
     Fetches the categories for the given attribute.
    */
    function fetch( &$attribute )
    {
    	$debug = true;
    	
    	$attributeId = $attribute->attribute( 'id' );
    	
		$categories =& PersistentCategory::fetchByAttribute($attributeId);

		$this->ObjectAttributeID = $attributeId; 

		if ($debug) eZDebug::writeDebug( "Attribute ids: ".$attributeId);
		if ($debug) eZDebug::writeDebug( "Number of found categories from attribute id: ".count($categories));
		
		// Create 
        foreach ( $categories as $category )
        {
            // Fetch the category array 
			if ($debug) eZDebug::writeDebug( "Fetched category: ".$category->attribute('category'));

            $this->CategoryArray[] = $category->attribute('category');         
        }
    }

    /*!
     Sets the category array
    */
    function setCategoryArray( $categories )
    {
        $this->CategoryArray =& $categories;
    }

    /*!
     Returns the category array
    */
    function &categoryArray( )
    {
        return $this->CategoryArray;
    }

    /*!
     Returns the categories as a string
    */
    function &categoriesString()
    {
		$debug=true;
		
		if ($debug) eZDebug::writeDebug( "Number of categories: ".count($this->categoryArray()));

        return implode( ', ', $this->CategoryArray() );
    }

    /// Contains the category names
	var $CategoryArray = array();

    /// Contains the ID attribute if fetched
    var $ObjectAttributeID = false;
}

?>
