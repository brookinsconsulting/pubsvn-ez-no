<?php
/*!
  \class SckPersonListType sckpersonlisttype.php
  \brief SckPersonListType handles multiple persons
*/

include_once( "kernel/classes/ezdatatype.php" );
include_once( "lib/ezutils/classes/ezmail.php" );
include_once( 'lib/ezutils/classes/ezini.php' );
include_once( "kernel/classes/datatypes/ezuser/ezuser.php" );
include_once( $repositoryDirectory . '/sckpersonlist/sckperson.php' );

define( "EZ_DATATYPESTRING_SCKPERSONLIST", "sckpersonlist" );

// Storage places
define( 'CLASS_STORAGE_CLASSES', 'data_text5' );
define( 'CLASS_STORAGE_ONNEW', 'data_int1' );
define( 'CLASS_STORAGE_ONUPDATE', 'data_int2' );
define( 'CLASS_STORAGE_NODEID', 'data_int3' );
define( 'CLASS_STORAGE_USE_OWNER', 'data_int4' );

class SckPersonListType extends eZDataType
{
    function SckPersonListType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_SCKPERSONLIST, ezi18n( 'extension/datatypes/sckpersonlist', "Person list", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }
	
	/*!
     Validates all variables given on content class level
     \return EZ_INPUT_VALIDATOR_STATE_ACCEPTED or EZ_INPUT_VALIDATOR_STATE_INVALID if
             the values are accepted or not
    */
    function validateClassAttributeHTTPInput( &$http, $base, &$contentClassAttribute )
    {
        if( $http->hasPostVariable( $base . "_data_sckpersonlist_classes_" . $contentClassAttribute->attribute( 'id' ) ) )
		{
			$classes = $http->postVariable( $base . "_data_sckpersonlist_classes_" . $contentClassAttribute->attribute( 'id' ) );
			
			if( (is_array( $classes ) and count( $classes ) > 0) or $classes != '' )
			{
				return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
			}
		}
		return EZ_INPUT_VALIDATOR_STATE_INVALID;
		//return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }
	
	/*!
     Fetches all variables inputed on content class level
     \return true if fetching of class attributes are successfull, false if not
    */
    function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
		$isPostAction = false;
        
        $classesName = $base . "_data_sckpersonlist_classes_" . $classAttribute->attribute( 'id' );
		$onNewName = $base . "_data_sckpersonlist_onnew_" . $classAttribute->attribute( 'id' );
		$onUpdateName = $base . "_data_sckpersonlist_onupdate_" . $classAttribute->attribute( 'id' );
        $useOwnerName = $base . "_data_sckpersonlist_useowner_" . $classAttribute->attribute( 'id' );
		$nodeName = $base . "_data_sckpersonlist_nodeid_" . $classAttribute->attribute( 'id' );
		
        // Store the selected classes
		if( $http->hasPostVariable( $classesName ) )
		{
			$isPostAction = true;
            $classes = $http->postVariable( $classesName );
			$classes = implode( ';', $classes );
			
			$classAttribute->setAttribute( CLASS_STORAGE_CLASSES, $classes );
		}
		
		// Store the 'on new' flag
		if( $http->hasPostVariable( $onNewName ) )
		{
			$classAttribute->setAttribute( CLASS_STORAGE_ONNEW, 1 );
		}
		else if( $isPostAction === true )
		{
			$classAttribute->setAttribute( CLASS_STORAGE_ONNEW, 0 );
		}
		
		// Store the 'on update' flag
		if( $http->hasPostVariable( $onUpdateName ) )
		{
			$classAttribute->setAttribute( CLASS_STORAGE_ONUPDATE, 1 );
		}
		else if( $isPostAction === true )
		{
			$classAttribute->setAttribute( CLASS_STORAGE_ONUPDATE, 0 );
		}
        
        // Store the 'use owner' flag
        if( $http->hasPostVariable( $useOwnerName ) )
        {
            $classAttribute->setAttribute( CLASS_STORAGE_USE_OWNER, 1 );
        }
        else if( $isPostAction === true )
        {
            $classAttribute->setAttribute( CLASS_STORAGE_USE_OWNER, 0 );
        }
		
		// Store the root node of the user subtree
		if( $http->hasPostVariable( $nodeName ) )
		{
			$nodeID = $http->postVariable( $nodeName );
			
			$classAttribute->setAttribute( CLASS_STORAGE_NODEID, $nodeID );
		}
		
		return true;
	}
	
	/*!
     Returns the content data for the given content class attribute.
    */
    function &classAttributeContent( &$classAttribute )
    {
		$onNew = $classAttribute->attribute( CLASS_STORAGE_ONNEW );
		$onUpdate = $classAttribute->attribute( CLASS_STORAGE_ONUPDATE );
		$nodeID = $classAttribute->attribute( CLASS_STORAGE_NODEID );
        $useOwner = $classAttribute->attribute( CLASS_STORAGE_USE_OWNER );
		
		if( $classAttribute->attribute( CLASS_STORAGE_CLASSES ) != '' )
		{
			$classes = explode( ';', $classAttribute->attribute( CLASS_STORAGE_CLASSES ) );
		}
		else
		{
			$classes = array();
		}
		
		return array( 'on_new' => $onNew,
					  'on_update' => $onUpdate,
					  'classes' => $classes,
                      'use_owner' => $useOwner,
					  'node_id' => $nodeID );
	}
	
	function customClassAttributeHTTPAction( &$http, $action, &$classAttribute )
    {
        switch ( $action )
        {
            case 'browse_for_placement':
            {
				$module =& $classAttribute->currentModule();
                include_once( 'kernel/classes/ezcontentbrowse.php' );
                $customActionName = 'CustomActionButton[' . $classAttribute->attribute( 'id' ) . '_browsed_for_placement]';
				
				eZContentBrowse::browse( array( 'action_name' => 'SelectUserNode',
                                                'content' => array( 'contentclass_id' => $classAttribute->attribute( 'contentclass_id' ),
                                                                    'contentclass_attribute_id' => $classAttribute->attribute( 'id' ),
                                                                    'contentclass_version' => $classAttribute->attribute( 'version' ),
                                                                    'contentclass_attribute_identifier' => $classAttribute->attribute( 'identifier' ) ),
                                                'persistent_data' => array( $customActionName => '',
                                                                            'ContentClassHasInput' => false ),
                                                'from_page' => $module->currentRedirectionURI() ),
                                         $module );				
			}break;
			
			case 'browsed_for_placement':
            {
                include_once( 'kernel/classes/ezcontentbrowse.php' );
                $nodeSelection = eZContentBrowse::result( 'SelectUserNode' );
                if ( count( $nodeSelection ) > 0 )
                {
                    $nodeID = $nodeSelection[0];
                    $content = $classAttribute->content();
                    $content['node_id'] = $nodeID;
                    $classAttribute->setContent( $content );
                }
            } break;
		}
	}

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
         $ini =& eZINI::instance( 'personlist.ini' );
		 
		 $newNameName = $base . "_data_sckperson_newname_" . $contentObjectAttribute->attribute('id');
		 $newFirstnameName = $base . "_data_sckperson_newfirstname_" . $contentObjectAttribute->attribute('id');
		 $newEmailName = $base . "_data_sckperson_newemail_" . $contentObjectAttribute->attribute('id');
		 
		 $namelistName = $base . "_data_sckperson_name_" . $contentObjectAttribute->attribute('id');
		 $firstnamelistName = $base . "_data_sckperson_firstname_" . $contentObjectAttribute->attribute('id');
		 $authorlistName = $base . "_data_sckperson_userid_" . $contentObjectAttribute->attribute('id');
		 
		 $newUserIDName = $base . "_data_sckperson_newuserid_" . $contentObjectAttribute->attribute( 'id' );
		 
		 if( $http->hasPostVariable( $newNameName ) and
		     $http->hasPostVariable( $newFirstnameName ) and
			 $http->hasPostVariable( $newEmailName ) )
	     {
		 	$newname = $http->postVariable( $newNameName );
			$newfirstname = $http->postVariable( $newFirstnameName );
			$newemail = $http->postVariable( $newEmailName );
			
			if( $newname != "" or $newfirstname != "" or $newemail != "" )
			{
				if( $newname == "" or $newfirstname == "" )
				{
					$contentObjectAttribute->setValidationError("If you are trying to add an external author, 
						please fill in at least his lastname and firstname.");
					return EZ_INPUT_VALIDATOR_STATE_INVALID;
				}
				else
				{
					if( $http->hasPostVariable( $namelistName ) )
					{
						$namelist = $http->postVariable( $namelistName );
						$firstnamelist = $http->postVariable( $firstnamelistName );
						$authorlist = $http->postVariable( $authorlistName );
						
						foreach( $authorlist as $key => $sckid )
						{
							if( $namelist[$key] == $newname and $firstnamelist[$key] == $newfirstname )
							{
								$contentObjectAttribute->setValidationError("This author already exists in the list.");
								return EZ_INPUT_VALIDATOR_STATE_INVALID;
							}
						}
					}
				}
			}
			else
			{
				if($http->hasPostVariable( $newUserIDName ) and 
        		   $http->hasPostVariable( $authorlistName ))
        		{
                  $author =& $contentObjectAttribute->content();
        
                  $newUserIDs = $http->postVariable( $newUserIDName );
                  $authorlist =& $http->postVariable( $authorlistName );
        
                  /*
                  new user id is the object id of the sck user, we're going to fetch his sckid
                  */
                  if( is_array( $newUserIDs ) and count( $newUserIDs ) > 0 )
        		  {
                     include_once("kernel/classes/ezcontentobject.php");
					 
					 foreach( $newUserIDs as $newUserID )
                     {
                         $obj = eZContentObject::fetch($newUserID);
                         $data = $obj->dataMap();
            
                         $objClassIdentifier = $obj->attribute( 'class_identifier' );
    					 $UserIDSettings = $ini->variable( 'UserInfoSettings', 'UserID' );
    					 
    					 if( array_key_exists( $objClassIdentifier, $UserIDSettings ) and
    					 	 $UserIDSettings[$objClassIdentifier] != 'object_id' )
    					 {
    					 	// The class is configured
    						$newUserSCKID = $data[$UserIDSettings[$objClassIdentifier]]->content();
    					 }
    					 else
    					 {
    					 	$newUserSCKID = $obj->attribute( 'id' );
    					 }
					 
    					 if(in_array($newUserSCKID, $authorlist))
    					 {
                            $contentObjectAttribute->setValidationError("This person is already in the list. (" . $obj->name() . ")");
                            return EZ_INPUT_VALIDATOR_STATE_INVALID;
                         }
                      } /* end foreach */
                   }
        		 }
			}
		 }

		 
		 if( !isset($authorlist) )
		 {
		 	$authorlist = array();
		 }
		 
       
         $numberofitems = count($authorlist);
		 $action = "";

         if($http->hasPostVariable("CustomActionButton"))
		 {
           $keys = array_keys($http->postVariable("CustomActionButton"));
           foreach($keys as $key)
	 	   {
                switch($key)
				{
                    case $contentObjectAttribute->attribute('id')."_new_author":
                         $numberofitems++;
						 $action="add";
                         break;
						 
                    case $contentObjectAttribute->attribute('id')."_remove_selected":
                         if($http->hasPostVariable("ContentObjectAttribute_data_sckperson_remove_".$contentObjectAttribute->attribute('id')))
						 {
						   $removecount= count($http->postVariable("ContentObjectAttribute_data_sckperson_remove_".$contentObjectAttribute->attribute('id')));
						 }
						 else
						 {
						 	$removecount = 0;
						 }
                         $numberofitems -= $removecount;
						 $action = "remove";
                         break;
                }
           }
         }

		 $classAttribute = $contentObjectAttribute->contentClassAttribute();
		   
         if($numberofitems < 1 && $classAttribute->attribute('is_required') == 1)
		 {
              $contentObjectAttribute->setValidationError("At least one author is required");
              return EZ_INPUT_VALIDATOR_STATE_INVALID;
         }
		 
		 $specials = $ini->variable( 'GeneralSettings', 'HasPrimaryPerson' );
		 $object = $contentObjectAttribute->attribute( 'object' );
		 
		 if( !$http->hasPostVariable($base . "_data_sckperson_firstauthor_" . $contentObjectAttribute->attribute('id')) and 
		 	 ($numberofitems >= 1 && $action != "add") and
			 in_array($object->attribute('class_identifier'), $specials) )
		 {
		 	$contentObjectAttribute->setValidationError("Please select the primary person.");
			return EZ_INPUT_VALIDATOR_STATE_INVALID;
		 }
         
		 return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     Store content
    */
    function storeObjectAttribute( &$contentObjectAttribute )
    {
        $author =& $contentObjectAttribute->content();
		$contentObjectAttribute->setAttribute( "data_text", $author->xmlString() );
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        $author = new SckPerson();

        if ( trim( $contentObjectAttribute->attribute( "data_text" ) ) != "" )
        {
            $author->decodeXML( $contentObjectAttribute->attribute( "data_text" ) );
        }

        //$author->fetchUsers();
    
        return $author;
    }


    function initializeObjectAttribute( &$contentObjectAttribute, $currentVersion, &$originalContentObjectAttribute )
    {
		if( $currentVersion == false )
		{
			$classAttribute =& $contentObjectAttribute->contentClassAttribute();
			$person = new SckPerson();
			
			$doNew = $classAttribute->attribute( CLASS_STORAGE_ONNEW );
			$doUpdates = $classAttribute->attribute( CLASS_STORAGE_ONUPDATE );
			$classes = explode( ';', $classAttribute->attribute( CLASS_STORAGE_CLASSES ) );
			$userNode = $classAttribute->attribute( CLASS_STORAGE_NODEID );
            $useOwner = $classAttribute->attribute( CLASS_STORAGE_USE_OWNER );
			
			$person->setNewObjects( $doNew == 1 ? true : false );
			$person->setUpdatedObjects( $doUpdates == 1 ? true : false );
			$person->setUserClasses( $classes );
			$person->setUserNode( $userNode );
            
            if( $useOwner == 1 )
            {
                $object =& $contentObjectAttribute->attribute( 'object' );
                $ownerObject =& eZContentObject::fetch( $object->attribute( 'owner_id' ) );
                $ownerData = $ownerObject->dataMap();
                
                $ini =& eZINI::instance( 'personlist.ini' );
						
        		$UserID = $ini->variable( 'UserInfoSettings', 'UserID' );
        		$UserName = $ini->variable( 'UserInfoSettings', 'UserName' );
        		$UserFirstName = $ini->variable( 'UserInfoSettings', 'UserFirstName' );
        		$objClassIdentifier = $ownerObject->attribute( 'class_identifier' );
            
                // Set the ID
        		if( array_key_exists( $objClassIdentifier, $UserID ) and
        			$UserID[$objClassIdentifier] != 'object_id' )
        		{
        			$newUserSckID = $ownerData[$UserID[$objClassIdentifier]]->content();
        		}
        		else
        		{
        			$newUserSckID = $ownerObject->attribute( 'id' );
        		}
        		
            	if( array_key_exists( $objClassIdentifier, $UserName ) and
        			array_key_exists( $objClassIdentifier, $UserFirstName ) )
        		{
        			$newUserName = $ownerData[$UserName[$objClassIdentifier]]->content();
        			$newUserFirstname = $ownerData[$UserFirstName[$objClassIdentifier]]->content();
        		}
        		else
        		{
        			$newUserName = $ownerObject->attribute( 'name' );
        			$newUserFirstName = '';
        		}
            				
        		// Find the email address
        		$user =& eZUser::fetch( $object->attribute( 'owner_id' ) );
        		if( is_object( $user ) and get_class( $user ) == 'ezuser' )
        		{
            		$newUserEmail = $user->attribute('email');
        		}
        		else
        		{
        			$newUserEmail = '';
        		}
                
                if($newUserSckID != "")
		        {
                    $specials = $ini->variable( 'GeneralSettings', 'HasPrimaryPerson');
        			
                    if( in_array( $objClassIdentifier, $specials ) )
        			{
        				$person->addPerson( $newUserSckID, $newUserName, $newUserFirstname, $newUserEmail, true, true );
        			}
        			else
        			{
                       	$person->addPerson( $newUserSckID, $newUserName, $newUserFirstname, $newUserEmail, true, false );
        			}
        				
            		$contentObjectAttribute->setContent( $person );
                }
            }
			
			$contentObjectAttribute->setAttribute( 'data_text', $person->xmlString() );
		}
		else
		{
			// We are editing an object with version > 2
			$text = $originalContentObjectAttribute->attribute( 'data_text' );
			$contentObjectAttribute->setAttribute( 'data_text', $text );
		}
	}
	
	/*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $firstAuthorName = $base . "_data_sckperson_firstauthor_" . $contentObjectAttribute->attribute('id');
		
		if( $http->hasPostVariable( $firstAuthorName ) )
		{
			$firstauthor = $http->postVariable( $firstAuthorName );
		}
		else
		{
			$firstauthor = -1;
		}
		
		$onNewName = $base . "_data_sckperson_onnew_" . $contentObjectAttribute->attribute('id');
		$onUpdateName = $base . "_data_sckperson_onupdate_" . $contentObjectAttribute->attribute('id');
		$userNodeName = $base . "_data_sckperson_usernode_" . $contentObjectAttribute->attribute( 'id' );
		$userClassesName = $base . "_data_sckperson_userclasses_" . $contentObjectAttribute->attribute( 'id' );
		
		$author = new SckPerson();
		
		if( $http->hasPostVariable( $onNewName ) )
		{
			$author->setNewObjects( true );
		}
		else
		{
			$author->setNewObjects( false );
		}
		
		if( $http->hasPostVariable( $onUpdateName ) )
		{
			$author->setUpdatedObjects( true );
		}
		else
		{
			$author->setUpdatedObjects( false );
		}
		
		if( $http->hasPostVariable( $userNodeName ) )
		{
			$author->setUserNode( $http->postVariable( $userNodeName ) );
		}
		
		if( $http->hasPostVariable( $userClassesName ) )
		{
			$classes = explode( ';', $http->postVariable( $userClassesName ) );
			$author->setUserClasses( $classes );
		}
		
		$idName = $base . "_data_sckperson_userid_" . $contentObjectAttribute->attribute('id');
		$nameName = $base . "_data_sckperson_name_" . $contentObjectAttribute->attribute('id');
		$firstnameName = $base . "_data_sckperson_firstname_" . $contentObjectAttribute->attribute('id');
		$emailName = $base . "_data_sckperson_email_" . $contentObjectAttribute->attribute('id');
		$doEmailName = $base ."_data_sckperson_domail_" . $contentObjectAttribute->attribute('id');
		$doEmailAllName = $base ."_data_sckperson_domailall_" . $contentObjectAttribute->attribute('id');
		
		
		//fetch data from form
        if( $http->hasPostVariable( $idName ) )
		{
			$authorSckIDArray = $http->postVariable( $idName );
			$authorNameArray = $http->postVariable( $nameName );
			$authorFirstnameArray = $http->postVariable( $firstnameName );
			$authorEmailArray = $http->postVariable( $emailName );
			$authorDoEmailArray = $http->postVariable( $doEmailName );
			

        	$i = 0;
			foreach ( $authorSckIDArray as $key => $id )
        	{
            	$doEmail = false;
				if( in_array( $i, $authorDoEmailArray ) )
				{
					$doEmail = true;
				}
				
				if( $key == $firstauthor )
				{
				  $author->addPerson( $id, $authorNameArray[$i], $authorFirstnameArray[$i], $authorEmailArray[$i], $doEmail, true );
				}
				else
				{
				  $author->addPerson( $id, $authorNameArray[$i], $authorFirstnameArray[$i], $authorEmailArray[$i], $doEmail, false );
				}
				$i++;
        	}
			$contentObjectAttribute->setContent( $author );
			
			return true;
		}
		
		$contentObjectAttribute->setContent( $author );
		return false;
    }

    /*!
    */
    function customObjectAttributeHTTPAction( $http, $action, &$contentObjectAttribute )
    {
        switch ( $action )
        {
            case "new_author" :
            {
                $author = $contentObjectAttribute->content();
																
				if( $http->hasPostVariable("ContentObjectAttribute_data_sckperson_newname_" . $contentObjectAttribute->attribute('id')) and
					$http->postVariable("ContentObjectAttribute_data_sckperson_newname_" . $contentObjectAttribute->attribute('id')) != '' and
				    $http->hasPostVariable("ContentObjectAttribute_data_sckperson_newfirstname_" . $contentObjectAttribute->attribute('id')) and
					$http->postVariable("ContentObjectAttribute_data_sckperson_newfirstname_" . $contentObjectAttribute->attribute('id')) != '' )
				{
					$newname = $http->postVariable("ContentObjectAttribute_data_sckperson_newname_" . $contentObjectAttribute->attribute('id'));
					$newfirstname = $http->postVariable("ContentObjectAttribute_data_sckperson_newfirstname_" . $contentObjectAttribute->attribute('id'));
					$newemail = $http->postVariable("ContentObjectAttribute_data_sckperson_newemail_" . $contentObjectAttribute->attribute('id'));
					
					$proceed = true;
					
					if( count($author->attribute('person_list')) > 0 )
					{
						foreach( $author->attribute('person_list') as $auteur )
						{
							if($newname == $auteur["name"] && $newfirstname == $auteur["firstname"])
							{
								$proceed = false;
							}
						}
					}
					
					if($proceed === true)
					{
						$author->addPerson("", $newname, $newfirstname, $newemail, true, false);
						$contentObjectAttribute->setContent($author);
					}
				}
				else
				{
					if( $http->hasPostVariable( "ContentObjectAttribute_data_sckperson_newuserid_" . $contentObjectAttribute->attribute( 'id' ) ) )
					{
						$newUserIDs = $http->postVariable( "ContentObjectAttribute_data_sckperson_newuserid_" . $contentObjectAttribute->attribute( 'id' ) );
					}
					else
					{
						$newUserIDs = array();
                    }                    

					if( is_array( $newUserIDs ) and count( $newUserIDs ) > 0 )
					{
    					$ini =& eZINI::instance( 'personlist.ini' );
						
						include_once("kernel/classes/ezcontentobject.php");
                        foreach( $newUserIDs as $newUserID )
                        {
                            $obj = eZContentObject::fetch($newUserID);
                            $data = $obj->dataMap();
    						
    						$UserID = $ini->variable( 'UserInfoSettings', 'UserID' );
    						$UserName = $ini->variable( 'UserInfoSettings', 'UserName' );
    						$UserFirstName = $ini->variable( 'UserInfoSettings', 'UserFirstName' );
    						$objClassIdentifier = $obj->attribute( 'class_identifier' );
            
                            // Set the ID
    						if( array_key_exists( $objClassIdentifier, $UserID ) and
    							$UserID[$objClassIdentifier] != 'object_id' )
    						{
    							$newUserSckID = $data[$UserID[$objClassIdentifier]]->content();
    						}
    						else
    						{
    							$newUserSckID = $obj->attribute( 'id' );
    						}
    						
            				if( array_key_exists( $objClassIdentifier, $UserName ) and
    							array_key_exists( $objClassIdentifier, $UserFirstName ) )
    						{
    							$newUserName = $data[$UserName[$objClassIdentifier]]->content();
    							$newUserFirstname = $data[$UserFirstName[$objClassIdentifier]]->content();
    						}
    						else
    						{
    							$newUserName = $obj->attribute( 'name' );
    							$newUserFirstName = '';
    						}
            				
    						// Find the email address
    						$user =& eZUser::fetch($newUserID);
    						if( is_object( $user ) and get_class( $user ) == 'ezuser' )
    						{
            					$newUserEmail = $user->attribute('email');
    						}
    						else
    						{
    							$newUserEmail = '';
    						}
            
                            if($newUserSckID != "")
    						{
                                $proceed = true;
                                foreach($author->attribute('person_list') as $auth)
    							{
                                    if($newUserSckID == $auth["id"])
    								{
    								   $proceed = false;
    								   break;
                                    }
                                }
    							
    							$specials = $ini->variable( 'GeneralSettings', 'HasPrimaryPerson');
    							
                                if($proceed === true)
    							{
    							    if( count($author->attribute('person_list')) == 0 and
    								 in_array( $objClassIdentifier, $specials ) )
    								{
    									$author->addPerson( $newUserSckID, $newUserName, $newUserFirstname, $newUserEmail, true, true );
    								}
    								else
    								{
                                    	$author->addPerson( $newUserSckID, $newUserName, $newUserFirstname, $newUserEmail, true, false );
    								}           						
                                }
                            }
                        } /* end foreach */
                        
                        $contentObjectAttribute->setContent( $author );
					}
				}
            }break;
            case "remove_selected" :
            {
                $author =& $contentObjectAttribute->content( );
								
				$postvarname = "ContentObjectAttribute" . "_data_sckperson_remove_" . $contentObjectAttribute->attribute( "id" );
				if($http->hasPostVariable($postvarname))
				{                
                  $array_remove = $http->postVariable( $postvarname );
                  $author->removePersons( $array_remove );
				  $contentObjectAttribute->setContent( $author );
				}
            }break;
            default :
            {
                eZDebug::writeError( "Unknown custom HTTP action: " . $action, "SckPersonType" );
            }break;
        }
    }
	
		
	function onPublish( &$contentObjectAttribute, &$contentObject, &$publishedNodes )
    {
		$ini =& eZINI::instance( 'personlist.ini' );
		$siteIni =& eZINI::instance();
		
		$personObj = $contentObjectAttribute->content();
		$version = $contentObject->attribute( 'current_version' );
		$classAttribute =& $contentObjectAttribute->contentClassAttribute();
		$enabledList = $ini->variable( 'EnableEmailDistribution', 'EnabledList' );
		$isUpdate = false;
		$sendEmail = false;
		
		if( in_array( $contentObject->attribute( 'class_identifier' ), $enabledList ) )
		{
			if( $version > 1 )
			{
				$isUpdate = true;
				if( $personObj->attribute( 'updated_objects' ) === true )
				{
					$sendEmail = true;
				}
			}
			else
			{
				if( $personObj->attribute( 'new_objects' ) === true )
				{
					$sendEmail = true;
				}
			}
		}
		
		if( $sendEmail === true )
		{
			// We need to send an email
			include_once( 'kernel/common/template.php' );
			include_once( 'lib/ezutils/classes/ezmail.php' );
			include_once( 'lib/ezutils/classes/ezmailtransport.php' );
			
			$tpl =& templateInit();
			$tpl->resetVariables();

			$res =& eZTemplateDesignResource::instance();
			$res->setKeys( array( array( 'object', $contentObject ) ) );

			$tpl->setVariable( 'object', $contentObject );
			
			$result = $tpl->fetch( 'design:content/datatype/result/sckpersonlist.tpl' );
			$subject = $tpl->variable( 'subject' );
			
			$mail = new eZMail();
			
			if( $siteIni->variable( 'MailSettings', 'EmailSender' ) != '' )
			{
				$email = $siteIni->variable( 'MailSettings', 'EmailSender' );			
			}
			else
			{
				$email = $siteIni->variable( 'MailSettings', 'AdminEmail' );
			}
			
			$mail->setReceiver( $email );
			$mail->setSender( $email );
			
			$mail->setBccElements( array() );
			if( count( $personObj->attribute( 'person_list' ) ) > 0 )
			{
				foreach( $personObj->attribute( 'person_list' ) as $person )
				{
					if( $person['do_mail'] != false and $person['do_mail'] != '' )
					{
						$mail->addBcc( $person['email'], $person['firstname'] . ' ' . $person['name'] );
					}
				}
			}
			
			$mail->setSubject( $subject );
			$mail->setBody( $result );
			$mailResult = eZMailTransport::send( $mail );
		}
	}

    /*!
     Returns the integer value.
    */
    function title( &$contentObjectAttribute )
    {
        $author =& $contentObjectAttribute->content( );

        if( count($author->attribute('person_list')) > 0 )
		{
			foreach( $author->attribute('person_list') as $auteur )
			{
				$ret[] = $auteur['name']." ".$auteur['firstname'];
			}
		}

		$ret = implode( ', ', $ret );

        return $ret;
    }
	
	function metaData( $contentObjectAttribute )
    {
        $content = $this->objectAttributeContent( $contentObjectAttribute );
		$list = $content->attribute('person_list');
		$ret = array();
		
		if( count($list) > 0 )
		{
			foreach( $list as $auteur )
			{
				$ret[] = array( 'id' => '',
								'text' => $auteur['name']." ".$auteur['firstname']." ".$auteur['email'],
								'literal' => false );
			}
		}
		
		return $ret;
    }
	function hasObjectAttributeContent( &$contentObjectAttribute )
    {
        //return trim( $contentObjectAttribute->attribute( 'data_text' ) ) != '';
        $author =& $contentObjectAttribute->content( );
        return (count($author->attribute('person_list')) != 0);
    }
	function isIndexable()
    {
        return true;
    }
    function &sortKey( &$contentObjectAttribute )
    {
        return strtolower( $contentObjectAttribute->attribute( 'data_text' ) );
    }

    /*!
     \reimp
    */
    function &sortKeyType()
    {
        return 'string';
    }
    
    function &serializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $onNew = $classAttribute->attribute( CLASS_STORAGE_ONNEW );
        $onUpdate = $classAttribute->attribute( CLASS_STORAGE_ONUPDATE );
        $startNode = $classAttribute->attribute( CLASS_STORAGE_NODEID );
        $useOwner = $classAttribute->attribute( CLASS_STORAGE_USE_OWNER );
        $classes = $classAttribute->attribute( CLASS_STORAGE_CLASSES );
        
        $attributeParamatersNode->appendChild( eZDOMDocument::createElementTextNode( 'on-new', $onNew ) );
        $attributeParamatersNode->appendChild( eZDOMDocument::createElementTextNode( 'on-update', $onUpdate ) );
        $attributeParamatersNode->appendChild( eZDOMDocument::createElementTextNode( 'start-node', $startNode ) );
        $attributeParamatersNode->appendChild( eZDOMDocument::createElementTextNode( 'use-owner', $useOwner ) );
        $attributeParamatersNode->appendChild( eZDOMDocument::createElementTextNode( 'classes', $classes ) );
    }
    
    function &unserializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $onNew = $attributeParametersNode->elementTextContentByName( 'on-new' );
        $onUpdate = $attributeParametersNode->elementTextContentByName( 'on-update' );
        $startNode = $attributeParametersNode->elementTextContentByName( 'start-node' );
        $useOwner = $attributeParametersNode->elementTextContentByName( 'use-owner' );
        $classes = $attributeParametersNode->elementTextContentByName( 'classes' );
        
        $classAttribute->setAttribute( CLASS_STORAGE_ONNEW, intval( $onNew ) );
        $classAttribute->setAttribute( CLASS_STORAGE_ONUPDATE, intval( $onUpdate ) );
        $classAttribute->setAttribute( CLASS_STORAGE_NODEID, intval( $startNode ) );
        $classAttribute->setAttribute( CLASS_STORAGE_USE_OWNER, intval( $useOwner ) );
        $classAttribute->setAttribute( CLASS_STORAGE_CLASSES, $classes );
    }
}

eZDataType::register( EZ_DATATYPESTRING_SCKPERSONLIST, "sckpersonlisttype" );

?>
