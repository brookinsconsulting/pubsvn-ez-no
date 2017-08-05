<?php
/*
    Person list extension for eZ publish 3.x
    Copyright (C) 2003-2004  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

include_once( "lib/ezxml/classes/ezxml.php" );

class SckPerson
{
    /*!
    */
    function SckPerson()
    {
        $this->Persons = array();
        $this->PersonCount = 0;
    }
    /*!
     Adds an author
    */
    function addPerson( $sckID, $name, $firstname, $email, $doMail, $isFirstAuthor )
    {
        $this->Persons[] = array(   "id" => $sckID,
									"name" => $name,
									"firstname" => $firstname,
									"email" => $email,
									"do_mail" => $doMail,
									"firstauthor" => $isFirstAuthor );
		$this->PersonCount++;
    }

    function removePersons( $array_remove )
    {
        $tmp =& $this->Persons;
        $remaining = array();

        foreach($tmp as $key => $tmpItem)
		{
            if(!in_array($key, $array_remove))
			{
                $remaining[] = $tmpItem;
            }
			else
			{
				$this->PersonCount--;
			}
        }
		
		$this->Persons = $remaining;
    }
	
	function setNewObjects( $flag )
	{
		$this->DoNewObjects = $flag;
	}
	
	function setUpdatedObjects( $flag )
	{
		$this->DoUpdatedObjects = $flag;
	}
	
	function setUserClasses( $classes )
	{
		$this->UserClasses = $classes;
	}
	
	function setUserNode( $nodeid )
	{
		$this->UserNode = $nodeid;
	}

    function hasAttribute( $name )
    {
        if ( ( $name == "person_list" ) or 
			 ( $name == "users" ) or 
			 ( $name == "new_objects" ) or 
			 ( $name == "updated_objects" ) or
			 ( $name == "user_classes" ) or
			 ( $name == "user_node" ) )
            return true;
        else
            return false;
    }

   function &attribute( $name )
    {
        switch ( $name )
        {
            case "new_objects":
			{
				return $this->DoNewObjects;
			}break;
			
			case "updated_objects":
			{
				return $this->DoUpdatedObjects;
			}break;
			
			case "person_list" :
            {
                return $this->Persons;
            }break;
			
			case "user_classes":
			{
				return $this->UserClasses;
			}break;
			
			case "user_node":
			{
				return $this->UserNode;
			}break;
			
		    case "users" :
		    {
		        if( is_array($this->Users) && count($this->Users) > 0 )
		        {
		          return $this->Users;
		        }
		        else
		        {
		          $this->fetchUsers();
		          return $this->Users;
		        }
		    }break;
        }
    }

    /*!
     Will decode an xml string and initialize the eZ author object
    */
    function decodeXML( $xmlString )
    {
        $xml = new eZXML();
        $dom =& $xml->domTree( $xmlString );
		
		eZDebug::writeError( 'Decoding...' );

        if ( $dom )
        {
            // New objects
			$doNew =& $dom->elementsByName( 'donew' );
						
			if( is_array( $doNew ) and count( $doNew ) == 1 )
			{
				if( $doNew[0]->textContent() != '' and $doNew[0]->textContent() != 0 )
				{
					$this->setNewObjects( true );
				}
				else
				{
					$this->setNewObjects( false );
				}
			}
			
			// Old objects
			$doUpdates =& $dom->elementsByName( 'doupdates' );
						
			if( is_array( $doUpdates ) and count( $doUpdates ) == 1 )
			{
				if( $doUpdates[0]->textContent() != '' and $doUpdates[0]->textContent() != 0 )
				{
					$this->setUpdatedObjects( true );
				}
				else
				{
					$this->setUpdatedObjects( false );
				}
			}
			
			$userClasses =& $dom->elementsByName( 'userclasses' );
			
			if( is_array( $userClasses ) and count( $userClasses ) == 1 )
			{
				$classes = explode( ';', $userClasses[0]->textContent() );
				
				if( !is_array( $classes ) )
				{
					$classes = array( $classes );
				}
				
				$this->setUserClasses( $classes );
			}
			
			$userNode =& $dom->elementsByName( 'usernode' );
			
			if( is_array( $userNode ) and count( $userNode ) == 1 )
			{
				$this->setUserNode( $userNode[0]->textContent() );
			}
			
			$authorArray =& $dom->elementsByName( "person" );
			if( is_array( $authorArray ) and count( $authorArray ) > 0 )
			{
	            foreach( $authorArray as $author )
	            {
	                $this->addPerson( $author->attributeValue( "id" ),
									  $author->attributeValue( "name" ),
									  $author->attributeValue( "firstname" ),
									  $author->attributeValue( "email" ),
									  $author->attributeValue( "do_mail" ),
									  $author->attributeValue( "firstauthor" ) );
	            }
			}
        }
        else
        {
        }
    }

    /*!
     Will return the XML string for this author set.
    */
    function &xmlString( )
    {
        $doc = new eZDOMDocument( "Persons" );
		
        $root =& $doc->createElementNode( "sckperson" );
        $doc->setRoot( $root );

		$doNew =& $doc->createElementTextNode( "donew", $this->DoNewObjects );
		$root->appendChild( $doNew );
		
		$doUpdates =& $doc->createElementTextNode( "doupdates", $this->DoUpdatedObjects );
		$root->appendChild( $doUpdates );
		
		$userClasses =& $doc->createElementTextNode( "userclasses", implode( ';', $this->UserClasses ) );
		$root->appendChild( $userClasses );
		
		$userNode =& $doc->createElementTextNode( "usernode", $this->UserNode );
		$root->appendChild( $userNode );

		$authors =& $doc->createElementNode( "persons" );
		
        $id=0;
        foreach ( $this->Persons as $author )
        {
            $authorNode =& $doc->createElementNode( "person" );
			$authorNode->appendAttribute( $doc->createAttributeNode( "id", $author["id"] ) );
			$authorNode->appendAttribute( $doc->createAttributeNode( "name", $author["name"] ) );
			$authorNode->appendAttribute( $doc->createAttributeNode( "firstname", $author["firstname"] ) );
			$authorNode->appendAttribute( $doc->createAttributeNode( "email", $author["email"] ) );
			$authorNode->appendAttribute( $doc->createAttributeNode( "do_mail", $author['do_mail'] ) );
			$authorNode->appendAttribute( $doc->createAttributeNode( "firstauthor", $author["firstauthor"] ) );
            $authors->appendChild( $authorNode );
        }
		$root->appendChild( $authors );

        $xml =& $doc->toString();

		return $xml;
    }
	
	  
  /*!
  * Fetch all SCK Users
  * */
  function fetchUsers()
  {
    include_once( 'kernel/classes/ezcontentobject.php' );
	include_once( 'kernel/classes/ezcontentobjecttreenode.php' );
	include_once( 'kernel/classes/ezcontentobjectattribute.php' );
    include_once( 'lib/ezutils/classes/ezini.php' );
	    
    $contentIni =& eZINI::instance( 'content.ini' );
	$db =& eZDB::instance();
	
	$classes = implode( "', '", $this->UserClasses );
	
	$res = $db->arrayQuery( "SELECT ezcontentobject.id AS id
							 FROM ezcontentobject, ezcontentobject_tree, ezcontentclass
							 WHERE ezcontentobject_tree.contentobject_id = ezcontentobject.id
							 AND ezcontentobject_tree.path_string LIKE '%/" . $this->UserNode . "/%'
							 AND ezcontentclass.identifier IN ('$classes')
							 AND ezcontentobject.contentclass_id = ezcontentclass.id
							 AND ezcontentobject_tree.node_id = ezcontentobject_tree.main_node_id
                             ORDER BY ezcontentobject.name ASC");
    /*ORDER BY ezcontentobject_tree.path_identification_string ASC" ); */ 
	
	$attribs = "";
	
	if( is_array( $res ) and count( $res ) > 0 )
	{
		foreach( $res as $row )
		{
			$obj =& eZContentObject::fetch( $row['id'] );
			$node = $obj->attribute( 'main_node' );
    
          	$attribs .= "<option value=\"" . $obj->attribute( 'id' ) . "\">";
      		$attribs .= $node->attribute( 'name' ) . "</option>\n";
		}
    }	
    
    $this->Users = $attribs;
  }

    /// Contains the Authors
    var $Persons;

    /// Contains the author counter value
    var $PersonCount;
  
    /// Contains the SCK Users
    var $Users;
	
	var $DoNewObjects;
	
	var $DoUpdatedObjects;
	var $UserClasses;
	var $UserNode;
}

?>