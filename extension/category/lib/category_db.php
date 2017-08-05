<?php
//
// Definition of Category database object
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
Version:      $Id: category_db.php,v 1.3 2003/12/15 15:17:48 paulf Exp $
*/
include_once( "lib/ezdb/classes/ezdb.php" );
include_once( "kernel/classes/ezpersistentobject.php" );
include_once( "kernel/classes/ezcontentclassattribute.php" );

class PersistentCategory extends eZPersistentObject
{
    /*!
     Constructor
    */
    function PersistentCategory( $row )
    {
        $this->eZPersistentObject( $row );
    }

    function &definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "category" => array( 'name' => "Category",
                                                                        'datatype' => 'string',
                                                                        'default' => '',
                                                                        'required' => true ),
                                         "objectattribute_id" => array( 'name' => "ObjectAttributeID",
                                                                                    'datatype' => 'integer',
                                                                                    'default' => 0,
                                                                                    'required' => true ) ),
                      "keys" => array( "id"),
                      "class_name" => "PersistentCategory",
                      "name" => "category_information" );
    }

    function &remove( $id )
    {
        eZPersistentObject::removeObject(   PersistentCategory::definition(),
                                          							array( "id" => $id) );
    }

    function &fetch( $id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( PersistentCategory::definition(),
                        												null,
                        												array( "id" => $id ),
                        												$asObject 
																		);
    }

    function &fetchByCategory( $category, $asObject = true )
    {
        return eZPersistentObject::fetchObject( PersistentCategory::definition(),
                        												null,
                        												array( "category" => $category ),
                        												$asObject 
																		);
    }

    function &fetchByCategoryAndAttribute( $category, $objectattribute_id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( PersistentCategory::definition(),
                        												null,
                        												array( "category" => $category,
                        												 			"objectattribute_id" => $objectattribute_id),
                        												$asObject 
																		);
    }

    function &fetchByAttribute( $objectattribute_id, $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( PersistentCategory::definition(),
		                       												null,
                        													array( "objectattribute_id" => $objectattribute_id ),
                                                                            null,
                                                                            null,
                        													$asObject 
																			);
    }

    function &fetchAllCategories( $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( PersistentCategory::definition(),
                        													  null,
                        													  null,
                        													  $asObject 
																		     );
    }

	function &create ( $category, $objectAttributeID )
	{
		$row = array (
								"category" => $category,
								"objectattribute_id" => $objectAttributeID );

		return new PersistentCategory( $row );
	}

	//Attributes
    function hasAttribute( $name )
    {
        if ( $name == 'id' or
        	 $name == 'category' or
             $name == 'objectattribute_id')
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
            case 'id' :
            {
                return $this->ID;
				break;
            }

            case 'category' :
            {
                return $this->Category;
				break;
            }

            case 'objectattribute_id' :
            {
                return $this->ObjectAttributeID;
				break;
            }
        }
    }

    var $ID;
    var $Category;
    var $ObjectAttributeID;
}
?>