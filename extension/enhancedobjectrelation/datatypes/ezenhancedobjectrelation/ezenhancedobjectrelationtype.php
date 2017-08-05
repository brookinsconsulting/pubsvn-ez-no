<?php
//
// Definition of eZEnhancedObjectRelationType class
//
// Created on: <24-Sept-2004 xavier dutoit>
// Modified by Gabriel Ambuehl to allow creation of new objects
// Modified by Gabriel Ambuehl so it's searchable now...
// Modified by Xavier Dutoit : added you can choose the selectable 
// related objects by class (previously only by parent node)
//
// Copyright (C) 2004 Sydesy ltd. All rights reserved.
// author Xavier DUTOIT ezenhancedobjectrelation@sydesy.com
// modified by Gabriel Ambuehl (adding the search function)
// and infrastructure to support creation of objects right on the page
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//

/*!
  \class eZEnhancedObjectRelationType ezenhancedobjectrelationtype.php
  \ingroup eZKernel
  \brief A content datatype which handles object relations

*/

include_once( "kernel/classes/ezdatatype.php" );
include_once( "lib/ezutils/classes/ezintegervalidator.php" );
include_once( "lib/ezi18n/classes/eztranslatormanager.php" );
//include_once( "lib/ezutils/classes/ezoperationhandler.php" );

define( "EZ_DATATYPESTRING_ENHANCED_OBJECT_RELATION", "ezenhancedobjectrelation" );

class eZEnhancedObjectRelationType extends eZDataType
{
    /*!
     Initializes with a string id and a description.
    */
    function eZEnhancedObjectRelationType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_ENHANCED_OBJECT_RELATION, ezi18n( 'kernel/classes/datatypes', "Enhanced Object relation", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
		$classAttribute =& $contentObjectAttribute->contentClassAttribute();

		$postVariableName = $base . "_data_object_relation_id_list_" . $contentObjectAttribute->attribute( "id" );
        if ( $http->hasPostVariable( $postVariableName) )
        {
			$list = & $http->postVariable( $postVariableName );
			if ( $classAttribute->attribute( "is_required" ) and empty($list) )
            {
                $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                     'Missing enhancedobjectrelation input.' ) );
                return EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
        }

		//return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
		//for editing, taken from ezobjectrelationlist.php
		$status=EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
		$classAttribute=$contentObjectAttribute->attribute('contentclass_attribute');
		$edit_id_list=$http->sessionVariable('enhancedobjectrelation_id_' . $classAttribute->ID . '_edit_id_list');
		if ( is_array($edit_id_list) ) {
			foreach ($edit_id_list as $id) {
                $subObjectID = $id;
                $attributeBase = $base . '_ezorl_edit_object_' . $subObjectID;
                $object =& eZContentObject::fetch( $subObjectID );
                if ( $object )
                {
				    $attributes =& $object->contentObjectAttributes(  );

                    $validationResult = $object->validateInput( $attributes, $attributeBase,
                                                                $inputParameters, $parameters );
                    $inputValidated = $validationResult['input-validated'];
                    $content['temp'][$subObjectID]['require-fixup'] = $validationResult['require-fixup'];
                    $statusMap = $validationResult['status-map'];
                    foreach ( $statusMap as $statusItem )
                    {
                        $statusValue = $statusItem['value'];
                        $statusAttribute =& $statusItem['attribute'];
                        if ( $statusValue == EZ_INPUT_VALIDATOR_STATE_INTERMEDIATE and
                             $status == EZ_INPUT_VALIDATOR_STATE_ACCEPTED )
                            $status = EZ_INPUT_VALIDATOR_STATE_INTERMEDIATE;
                        else if ( $statusValue == EZ_INPUT_VALIDATOR_STATE_INVALID )
                        {
                            $contentObjectAttribute->setHasValidationError( false );
                            $status = EZ_INPUT_VALIDATOR_STATE_INVALID;
                        }
                    }

                    $content['temp'][$subObjectID]['attributes'] =& $attributes;
                    $content['temp'][$subObjectID]['object'] =& $object;
                }
            }

		}
        return $status;
    }

    /*!
     Fetches the http post var string input
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {

		$classAttribute =&$contentObjectAttribute->attribute('contentclass_attribute' );

		$edit_id_list=$http->sessionVariable('enhancedobjectrelation_id_' .$classAttribute->ID . '_edit_id_list');

//		eZDebug::writeError($contentObjectAttribute);

		if (is_array($edit_id_list)) {
		    foreach ($edit_id_list as $subObjectID) {
                $attributeBase = $base . '_ezorl_edit_object_' . $subObjectID;
                $object = eZContentObject::fetch( $subObjectID );
                if ( $object ) {
                    $attributes = $object->contentObjectAttributes();
                    $customActionAttributeArray = array();
 
                   $fetchResult = $object->fetchInput( $attributes, $attributeBase,
                                                        $customActionAttributeArray,
                                                        $contentObjectAttribute->inputParameters() );

						
				      
                    unset( $attributeInputMap );
                    $attributeInputMap =& $fetchResult['attribute-input-map'];
					$object->storeInput($attributes, $attributeInputMap );
 					$object_contentclass=$object->contentClass();
					$object->setAttribute('published', time());
	                $object->setAttribute('modified', time());
					$object->setAttribute('status', EZ_CONTENT_OBJECT_STATUS_PUBLISHED);

					$object_name=$object_contentclass->contentObjectName($object);
				
					eZDebug::writeError("name".$object_name);
					$object->setName(  $object_name);

//					eZDebug::writeError($object);
				    $object->store();
//                    $content['temp'][$subObjectID]['attribute-input-map'] =& $attributeInputMap;
//                    $content['temp'][$subObjectID]['attributes'] =& $attributes;
//                    $content['temp'][$subObjectID]['object'] =& $object;
                }
            }
		}

		//old starts here
		$ContentClassAttributeID =$contentObjectAttribute->ContentClassAttributeID;
		
		$contentObjectID = $contentObjectAttribute->ContentObjectID;
		$contentObjectVersion = $contentObjectAttribute->Version;

//		echo "$contentObjectID : $contentObjectVersion : $ContentClassAttributeID";
		$postVariableName = $base . "_data_object_relation_id_list_" . $contentObjectAttribute->attribute( "id" );
		
	
		if ( !$http->hasPostVariable( $postVariableName ) )
			return false;
			
		$id_list =& $http->postVariable( $postVariableName );
		if (empty ($id_list))
			return false;
		foreach ($id_list as $objectID)
			$contentObjectAttribute->Content ['id_list'][] = $objectID;
        return true;
    }


    /*!
    */
    function storeObjectAttribute( &$contentObjectAttribute )
    {
		$ContentClassAttributeID =$contentObjectAttribute->ContentClassAttributeID;
		$contentObjectID = $contentObjectAttribute->ContentObjectID;
		$contentObjectVersion = $contentObjectAttribute->Version;

		$this->removeAllContentObjectRelation ($contentObjectID ,$contentObjectVersion,$ContentClassAttributeID);

		if (empty ($contentObjectAttribute->Content['id_list']))
			return true;
		foreach ($contentObjectAttribute->Content['id_list'] as $objectID)
			$this->addContentObjectRelation($contentObjectID,$contentObjectVersion,$ContentClassAttributeID,$objectID );
		return true;
    }

    /*!
     \reimp
    */
    function validateClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $selectionTypeName = 'ContentClass_ezobjectrelation_selection_type_' . $classAttribute->attribute( 'id' );
        $state = EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
        if ( $http->hasPostVariable( $selectionTypeName ) )
        {
            $selectionType = $http->postVariable( $selectionTypeName );
            if ( $selectionType < 0 and
                 $selectionType > 4 )
            {
                $state = EZ_INPUT_VALIDATOR_STATE_INVALID;
            }
        }
        return $state;
    }

    /*!
     \reimp
    */
    function fixupClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
    }

    /*!

	Taken from object relation list to support editing.

     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function fixupObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $content =& $contentObjectAttribute->Content;
		$edit_list_id=$content['edit_list_id'];
		if (is_array($edit_list_id)) {
			foreach ($edit_list_id as $subObjectID) {
                $attributeBase = $base . '_ezorl_edit_object_' . $subObjectID;
                $object =& $content['temp'][$subObjectID]['object'];
                $requireFixup = $content['temp'][$subObjectID]['require-fixup'];
                if ( $object and $requireFixup )
                {
                    $attributes =& $content['temp'][$subObjectID]['attributes'];
                    $object->fixupInput( $contentObjectAttributes, $attributeBase );
                }
            }
        }
    }


    /*!
     \reimp
    */
    function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $selectionTypeName = 'ContentClass_ezobjectrelation_selection_type_' . $classAttribute->attribute( 'id' );
        $content = $classAttribute->content();
        $hasData = false;
        if ( $http->hasPostVariable( $selectionTypeName ) )
        {
            $selectionType = $http->postVariable( $selectionTypeName );
            $content['selection_type'] = $selectionType;
            $hasData = true;
        }
        $FilterClassName = 'ContentClass_ezobjectrelation_filter_class_' . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $FilterClassName ) )
        {
            $FilterClass = $http->postVariable( $FilterClassName );
            $content['filter_class'] = $FilterClass;
            $hasData = true;
        }

	$PlacementNodeName = 'ContentClass_ezobjectrelationlist_placement_' . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( PlacementNodeName ) )
        {
            $DefaultPlacementNode = $http->postVariable( $PlacementNodeName );
            $content['default_placement_node'] = $DefaultPlacementNode;
            $hasData = true;
        }
	
        $helperName = 'ContentClass_ezenhancedobjectrelation_selection_fuzzy_match_helper_' . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $helperName ) )
        {
            $fuzzyMatchName = 'ContentClass_ezenhancedobjectrelation_selection_fuzzy_match_' . $classAttribute->attribute( 'id' );
            $content['fuzzy_match'] = false;
            $hasData = true;
            if ( $http->hasPostVariable( $fuzzyMatchName ) )
            {
                $content['fuzzy_match'] = true;
            }
        }
        if ( $hasData )
        {
            $classAttribute->setContent( $content );
            return true;
        }
        return false;
    }

    function preStoreClassAttribute( &$classAttribute, $version )
    {
        $content = $classAttribute->content();
        $classAttribute->setAttribute( 'data_int1', $content['selection_type'] );
        $classAttribute->setAttribute( 'data_int2', $content['default_selection_node'] );
        $classAttribute->setAttribute( 'data_int3', $content['filter_class'] );
	$classAttribute->setAttribute( 'data_int4', $content['default_placement_node'] );
    }

    /*!
    */
    function customObjectAttributeHTTPAction( $http, $action, &$contentObjectAttribute, $parameters )
    {
        switch ( $action )
        {
            case "set_object_relation" :
            {
                if ( $http->hasPostVariable( 'RemoveObjectButton_' . $contentObjectAttribute->attribute( 'id' ) ) )
                {
                    $contentObjectAttribute->setAttribute( 'data_int', 0 );
                    $contentObjectAttribute->store();
                }

                if ( $http->hasPostVariable( 'BrowseObjectButton_' . $contentObjectAttribute->attribute( 'id' ) ) )
                {
                    $module =& $parameters['module'];
                    $redirectionURI = $parameters['current-redirection-uri'];
                    $ini = eZINI::instance( 'content.ini' );
                    $browseType = 'AddRelatedObjectToDataType';
                    $browseTypeINIVariable = $ini->variable( 'EnhancedObjectRelationDataTypeSettings', 'ClassAttributeStartNode' );
                    foreach( $browseTypeINIVariable as $value )
                    {
                        list( $classAttributeID, $type ) = explode( ';',$value );
                        if ( $classAttributeID == $contentObjectAttribute->attribute( 'contentclassattribute_id' ) && strlen( $type ) > 0 )
                        {
                            $browseType = $type;
                            eZDebug::writeDebug( $browseType, "browseType" );
                            break;
                        }
                    }
                    eZContentBrowse::browse( array( 'action_name' => 'AddRelatedObject_' . $contentObjectAttribute->attribute( 'id' ),
                                                    'type' =>  $browseType,
                                                    'browse_custom_action' => array( 'name' => 'CustomActionButton[' . $contentObjectAttribute->attribute( 'id' ) . '_set_object_relation]',
                                                                                     'value' => $contentObjectAttribute->attribute( 'id' ) ),
                                                    'persistent_data' => array( 'HasObjectInput' => 0 ),
                                                    'from_page' => $redirectionURI ),
                                             $module );

                }
                else if ( $http->hasPostVariable( 'BrowseActionName' ) and
                          $http->postVariable( 'BrowseActionName' ) == ( 'AddRelatedObject_' . $contentObjectAttribute->attribute( 'id' ) ) and
                          $http->hasPostVariable( "SelectedObjectIDArray" ) )
                {
                    $selectedObjectArray = $http->hasPostVariable( "SelectedObjectIDArray" );
                    $selectedObjectIDArray = $http->postVariable( "SelectedObjectIDArray" );

                    $objectID = $selectedObjectIDArray[0];
//                     $contentObjectAttribute->setContent( $objectID );
                    $contentObjectAttribute->setAttribute( 'data_int', $objectID );
                    $contentObjectAttribute->store();
                    $http->removeSessionVariable( 'BrowseCustomAction' );
                }
            } break;

			case "new_object" :
			{
			        $classAttribute =& $contentObjectAttribute->attribute('contentclass_attribute' );
        		       	$class_content = $classAttribute->content();
				$object_attribute_content =$contentObjectAttribute->content();
 				$classID=$class_content['filter_class'];
				$class=& eZContentClass::fetch( $classID );
				$currentObject=&$contentObjectAttribute->attribute('object' );			
				$sectionid= $currentObject->attribute('section_id');
				//instantiate object, same section, currentuser as owner (i.e. provide false as param)
				$newObjectInstance=&$class->instantiate(false, $sectionid);
			
				$nodeassignment=$newObjectInstance->createNodeAssignment($class_content['default_placement_node'], true);
				$nodeassignment->store();
				$newObjectInstance->sync();
				include_once( "lib/ezutils/classes/ezoperationhandler.php" );
				$operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $newObjectInstance->attribute( 'id' ), 'version' => 1) );

				$newObjectInstance->store();
				
				//create relation to the new object
				$this->addContentObjectRelation($contentObjectAttribute->ContentObjectID, $contentObjectAttribute->Version, $contentObjectAttribute->ContentClassAttributeID, $newObjectInstance->ID);

				
				
				$editIDList=$http->sessionVariable('enhancedobjectrelation_id_' . $classAttribute->ID . '_edit_id_list');
				
				if (!is_array($editIDList)) {
					$editIDList=array();
				}
				array_push($editIDList, $newObjectInstance->ID);
				$http->setSessionVariable('enhancedobjectrelation_id_' . $classAttribute->ID . '_edit_id_list', $editIDList);
					

			
				$object_attribute_content['edit_id_list']=$editIDList;
				
				
				if ( array_key_exists('id_list', $object_attribute_content)) {
					array_push($object_attribute_content['id_list'], $newObjectInstance->ID );
				}
				else {
					$object_attribute_content['id_list']=array();
					array_push($object_attribute_content['id_list'], $newObjectInstance->ID );
				}

				
                               
				$contentObjectAttribute->setContent($object_attribute_content);
			  
			  	
			} break;

            default :
            {
                eZDebug::writeError( "Unknown custom HTTP action: " . $action, "eZEnhancedObjectRelationType" );
            } break;
        }
    }


	/*!
	 Adds a link to the given content object id.
	it's taken from ezcontentobject and should belong to that class, but I don't want to modify the kernel
	unless mandatory 
	I don't want to make a link to a specific version of an object
	*/
	function addContentObjectRelation( $FromObjectID, $FromObjectVersion, $ContentClassAttributeID, $ToObjectID )
	{
		$db =& eZDB::instance();
		
		//prevent sql injection
                $FromObjectID=(int) $FromObjectID;
                $ContentClassAttributeID=(int) $ContentClassAttributeID;
                $FromObjectVersion=(int) $FromObjectVersion;
		$ToObjectID=(int) $ToObjectID;

		$db->query( "INSERT INTO ezcontentobject_link ( from_contentobject_id, from_contentobject_version,  contentclassattribute_id, to_contentobject_id )		VALUES ( '$FromObjectID', '$FromObjectVersion', '$ContentClassAttributeID', '$ToObjectID' )" );
	}

	function removeAllContentObjectRelation($FromObjectID, $contentObjectVersion,$ContentClassAttributeID )
	{
		$db =& eZDB::instance();
		//to prevent sql injection
		$FromObjectID=(int) $FromObjectID;
		$ContentClassAttributeID=(int) $ContentClassAttributeID;		
		$contentObjectVersion=(int) $contentObjectVersion;
		$db->query( "DELETE FROM ezcontentobject_link WHERE from_contentobject_id='$FromObjectID' AND from_contentobject_version='$contentObjectVersion' AND  contentclassattribute_id='$ContentClassAttributeID'" );
 	}

	
	/*!
	internal
	Create the filter
	*/
	function FilterClassAttribute ($ContentClassAttributeID)
	{
		if ($ContentClassAttributeID)
			return " AND contentclassattribute_id = '$ContentClassAttributeID'";
		return "";
	}
		

	
	/*! 
	Get the related objects' IDs
	*/
	function &relatedContentObjectIDArray( $objectID, $version, $ContentClassAttributeID = null)
	{
		eZDebugSetting::writeDebug( 'extension-enhancedrelatedobject-related-objects', $objectID, "objectID" );
		$db =& eZDB::instance();

		//protect from SQL injection

		$objectID = (int ) $objectID;
		$version=(int)$version;
		if ($ContentClassAttributeID!=null) {
			$ContentClassAttributeID=(int) $ContentClassAttributeID;
		}
		
		$ClassAttributeFilter = $this->FilterClassAttribute ($ContentClassAttributeID);
		$relatedObjects =& $db->arrayQuery( "SELECT to_contentobject_id as id
				 FROM   ezcontentobject_link
				 WHERE ezcontentobject_link.from_contentobject_id='$objectID' AND
				   ezcontentobject_link.from_contentobject_version='$version' $ClassAttributeFilter"
				 );
    if ($relatedObjects === false)
    {
      $empty= array ();
      return $empty;
    }
		return $relatedObjects;
	}

        /*!
     Initializes the object attribute with some data.
    */
    function initializeObjectAttribute( &$objectAttribute, $currentVersion, &$originalContentObjectAttribute )
    {

	//skip if this is a new content object, THREE === IS VITAL DON'T CHANGE!!!

	if (!($originalContentObjectAttribute === null))
	{	
		eZDebug::writeError( $objectAttribute );
		eZDebug::writeError ($currentVersion);
		
		eZDebug::writeError($originalContentObjectAttribute);

		$ContentObjectID=(int) $originalContentObjectAttribute->ContentObjectID;
		$OriginalVersion=(int) $originalContentObjectAttribute->Version;
		$ContentClassAttributeID= (int) $originalContentObjectAttribute->ContentClassAttributeID;

		$NewVersion= (int) $objectAttribute->Version;

		eZDebug::writeDebug( $ContentObjectID );
	        eZDebug::writeDebug( $currentVersion );	
	


		//fetch original relations
        	$db =& eZDB::instance();
		$oldRelations=$db->arrayQuery("SELECT * FROM ezcontentobject_link WHERE from_contentobject_id='$ContentObjectID' AND from_contentobject_version='$OriginalVersion'");

		eZDebug::writeDebug($oldRelations);
		//remove relations
		$db->query("DELETE FROM ezcontentobject_link WHERE from_contentobject_id='$ContentObjectID' AND from_contentobject_version='$NewVersion'");
		//re-add, corrected.

		foreach ($oldRelations as $relation) {
			  $from_contentobject_id=$relation['from_contentobject_id'];
			  $to_contentobject_id=$relation['to_contentobject_id'];
    			$contentclassattribute_id=$relation['contentclassattribute_id'];

  	  		$this->addContentObjectRelation($from_contentobject_id, $NewVersion, $contentclassattribute_id, $to_contentobject_id );
			
		}
	}
    }
	
	
    /*!
     Returns the content.
     For some reasons, its called 2 times when I edit an object
     TODO: find someone able to optimise it.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {

		$relatedObjects = $this->relatedContentObjectIDArray( $contentObjectAttribute->ContentObjectID, $contentObjectAttribute->Version,  $contentObjectAttribute->ContentClassAttributeID );
		$attributes = array();


		foreach ($relatedObjects as $relatedObject)
		{
			$attributes ['id_list'][] = $relatedObject['id'];
		}
		   
        if (empty($attributes))
			return false;
        else
			return $attributes;
	    }

    /*!
     \reimp
    */
    function &sortKey( &$contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_int' );
    }

    /*!
     \reimp
    */
    function &sortKeyType()
    {
        return 'int';
    }

    function &classAttributeContent( &$classObjectAttribute )
    {
        $selectionType = $classObjectAttribute->attribute( "data_int1" );
        $defaultSelectionNode = $classObjectAttribute->attribute( "data_int2" );
        $ClassFilter = $classObjectAttribute->attribute( "data_int3" );
        $defaultPlacementNode = $classObjectAttribute->attribute( "data_int4" );
                
		
        $content = array( 'selection_type' => $selectionType,
                          'default_selection_node' => $defaultSelectionNode,
						  'filter_class' => $ClassFilter,
						  'default_placement_node' => $defaultPlacementNode);
        return $content;
    }

    function customClassAttributeHTTPAction( &$http, $action, &$classAttribute )
    {
        switch ( $action )
        {
            case 'browse_for_selection_node':
            {
                $module =& $classAttribute->currentModule();
                include_once( 'kernel/classes/ezcontentbrowse.php' );
                $customActionName = 'CustomActionButton[' . $classAttribute->attribute( 'id' ) . '_browsed_for_selection_node]';
                eZContentBrowse::browse( array( 'action_name' => 'SelectObjectRelationNode',
                                                'content' => array( 'contentclass_id' => $classAttribute->attribute( 'contentclass_id' ),
                                                                    'contentclass_attribute_id' => $classAttribute->attribute( 'id' ),
                                                                    'contentclass_version' => $classAttribute->attribute( 'version' ),
                                                                    'contentclass_attribute_identifier' => $classAttribute->attribute( 'identifier' ) ),
                                                'persistent_data' => array( $customActionName => '',
                                                                            'ContentClassHasInput' => false ),
                                                'description_template' => 'design:class/datatype/browse_enhancedobjectrelation_placement.tpl',
                                                'from_page' => $module->currentRedirectionURI() ),
                                         $module );
            } break;
            case 'browsed_for_selection_node':
            {
                include_once( 'kernel/classes/ezcontentbrowse.php' );
                $nodeSelection = eZContentBrowse::result( 'SelectObjectRelationNode' );
                if ( count( $nodeSelection ) > 0 )
                {
                    $nodeID = $nodeSelection[0];
                    $content = $classAttribute->content();
                    $content['default_selection_node'] = $nodeID;
                    $classAttribute->setContent( $content );
                }

            } break;
            case 'browse_for_placement_node':
            {

                $module =& $classAttribute->currentModule();
                include_once( 'kernel/classes/ezcontentbrowse.php' );
                $customActionName = 'CustomActionButton[' . $classAttribute->attribute( 'id' ) . '_browsed_for_placement_node]';
		
                eZContentBrowse::browse( array( 'action_name' => 'SelectObjectRelationNode',
                                                'content' => array( 'contentclass_id' => $classAttribute->attribute( 'contentclass_id' ),
                                                                    'contentclass_attribute_id' => $classAttribute->attribute( 'id' ),
                                                                    'contentclass_version' => $classAttribute->attribute( 'version' ),
                                                                    'contentclass_attribute_identifier' => $classAttribute->attribute( 'identifier' ) ),
                                                'persistent_data' => array( $customActionName => '',
                                                                            'ContentClassHasInput' => false ),
                                                'description_template' => 'design:class/datatype/browse_enhancedobjectrelation_placement.tpl',
                                                'from_page' => $module->currentRedirectionURI() ),
                                         $module );
            } break;
            case 'browsed_for_placement_node':
            {
                include_once( 'kernel/classes/ezcontentbrowse.php' );
                $nodeSelection = eZContentBrowse::result( 'SelectObjectRelationNode' );
                if ( count( $nodeSelection ) > 0 )
                {
                    $nodeID = $nodeSelection[0];
                    $content = $classAttribute->content();
                    $content['default_placement_node'] = $nodeID;
                    $classAttribute->setContent( $content );
                }	
            } break;

            case 'disable_selection_node':
            {
                $content =& $classAttribute->content();
                $content['default_selection_node'] = false;
                $classAttribute->setContent( $content );
            } break;
            default:
            {
                eZDebug::writeError( "Unknown enhancedobjectrelationlist action '$action'", 'eZContentEnhancedObjectRelationListType::customClassAttributeHTTPAction' );
            } break;
        }
    }

/*!
    Returns the meta data used for storing search indices.
       Gabriel Ambuehl: implemented it for ezenhancedobjectrelation,

       Limitations:
       no matter what language the user has set, it searches for all of them. this is an ezpublish wide problem, though
   */
   function metaData( $contentObjectAttribute )
   {
       $metaDataArray=array();
       $relatedObjects=$this->fetchRelatedContentObjects( $contentObjectAttribute );

       foreach ($relatedObjects as $relatedObject)
       {

           //multilingual indexing
           $translationList=$relatedObject->translationStringList();
           foreach ($translationList as $translation) {
               $relatedObject->setCurrentLanguage($translation);
               $attributes=$relatedObject->contentObjectAttributes();
               $metaData=eZContentObjectAttribute::metaDataArray($attributes);
               $metaDataArray=array_merge($metaDataArray, $metaData);
           }
       }
       return $metaDataArray;
   }

       /*!.
       Gabriel Ambuehl: active, see metaData for more.
       */
   function isIndexable()
   {
               return true;
   }

   /*
    Custom function, fetch related content objects
   */
   function fetchRelatedContentObjects( &$contentObjectAttribute )
   {
       $object = $this->objectAttributeContent( $contentObjectAttribute );
       /*object now contains a hash with an array inside id_list*/
       if ( $object )
       {
           $contentobjects=array();
           foreach($object['id_list'] as $id)
           {
               $contentobject=eZContentObject::fetch($id);
               array_push($contentobjects, $contentobject);
           }
            return $contentobjects;
       }
       return false;

   }

    /*!
     Returns the content of the string for use as a title
    */
    function title( &$contentObjectAttribute )
    {
        $object = $this->objectAttributeContent( $contentObjectAttribute );
        if ( is_object ($object) )
        {
            return $object->attribute( 'name' );
        }
        return false;
    }

    function hasObjectAttributeContent( &$contentObjectAttribute )
    {
        $object = $this->objectAttributeContent( $contentObjectAttribute );
        if ( $object )
            return true;
        return false;
    }

    function &serializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $content =& $classAttribute->content();
        $attributeParametersNode->appendChild( eZDOMDocument::createElementNode( 'selection-type',
                                                                                 array( 'id' => $content['selection_type'] ) ) );
        if ( $content['default_selection_node'] )
            $attributeParametersNode->appendChild( eZDOMDocument::createElementNode( 'default-selection',
                                                                                     array( 'node-id' => $content['default_selection_node'] ) ) );
    
        if ( $content['filter_class'] )
            $attributeParametersNode->appendChild( eZDOMDocument::createElementNode( 'filter_class',
                                                                                     array( 'class-id' => $content['filter_class'] ) ) );
    }

    /*!
     \reimp
    */
    function &unserializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $content =& $classAttribute->content();
        $selectionTypeNode = $attributeParametersNode->elementByName( 'selection-type' );
        $content['selection_type'] = 0;
        if ( $selectionTypeNode )
            $content['selection_type'] = $selectionTypeNode->attributeValue( 'id' );
        $FilterClass = $attributeParametersNode->elementByName( 'filter_class' );
        if ( $FilterClass )
            $content['filter_class'] = $FilterClass->attributeValue( 'id' );

        $defaultSelectionNode = $attributeParametersNode->elementByName( 'default-selection' );
        $content['default_selection_node'] = false;
        if ( $defaultSelectionNode )
            $content['default_selection_node'] = $defaultSelectionNode->attributeValue( 'node-id' );

        $classAttribute->setContent( $content );
        $classAttribute->store();
    }

    /// \privatesection
}

eZDataType::register( EZ_DATATYPESTRING_ENHANCED_OBJECT_RELATION, "ezenhancedobjectrelationtype" );

?>
