<?php
//
/*
    Mailinglist workflow event extension for eZ publish 3.3
    Copyright (C) 2004  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
	
	Authors: Tom Couwberghs & Hans Melis
*/

include_once( "kernel/classes/ezworkflowtype.php" );
include_once( 'lib/ezutils/classes/ezini.php' );
include_once( 'lib/ezutils/classes/ezhttptool.php' );
include_once( 'kernel/classes/ezurlalias.php' );
include_once( 'kernel/classes/eznodeassignment.php' );
include_once( 'lib/ezutils/classes/ezoperationhandler.php' );
include_once( 'lib/ezutils/classes/ezmail.php' );
include_once( 'lib/ezutils/classes/ezmailtransport.php' );
include_once( 'kernel/common/template.php' );

define( "EZ_WORKFLOW_TYPE_SCKMAILINGLIST_ID", "ezsckmailinglist" );

class eZSckMailingListType extends eZWorkflowEventType
{
	function eZSckMailingListType()
	{
		$this->eZWorkflowEventType( EZ_WORKFLOW_TYPE_SCKMAILINGLIST_ID, "Mailing List" );
	}
	
	function &attributeDecoder( &$event, $attr )
    {
		switch($attr)
		{
			case "selected_nodetype":
			{
				return $event->attribute('data_text1');
			}
			break;
			
			case "new":
			{
				return $event->attribute('data_int1');
			}
			break;
			
			case "update":
			{
				return $event->attribute('data_int2');
			}
			break;
		}
		return null;
	}
	
	function typeFunctionalAttributes( )
    {
		return array("selected_nodetype", "new", "update");
	}
	
	function &attribute( $attr )
    {
		return eZWorkflowEventType::attribute( $attr );
	}
	
	function hasAttribute( $attr )
    {
		return eZWorkflowEventType::hasAttribute( $attr );
	}
	
	function execute( &$process, &$event )
    {
		$parameters = $process->attribute( 'parameter_list' );
		$versionID =& $parameters['version'];
        $object =& eZContentObject::fetch( $parameters['object_id'] );
		$node = $object->mainNode();
		
		$nodeType = $event->attribute('data_text1');
		$doNew = $event->attribute('data_int1');
		$doUpdates = $event->attribute('data_int2');
		
		if( ($versionID == 1 && $doNew == 1) ||
			($versionID > 1 && $doUpdates == 1) )
		{
			if( $nodeType == "parent" )
			{
				$parentID = $object->mainParentNodeID();
				$node = null;
				$node = eZContentObjectTreeNode::fetch($parentID);
				$object = null;
				$object = $parentNode->attribute('object');
			}
				
			$classID = $object->attribute('contentclass_id');
			$ini =& eZINI::instance('mailinglist.ini');
			$mailSettings = $ini->group('Class_' . $classID );
		
			if( count($mailSettings["Attributes"]) > 0 )
			{
				$dataMap = $object->dataMap();
				
				foreach( $mailSettings["Attributes"] as $attrib )
				{
					$attribContent = $dataMap[$attrib]->attribute('data_text');
					
					preg_match_all("/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{2,6})(\]?)/i", $attribContent, $matches);
					
					if( count($matches[0]) > 0 )
					{
						foreach( $matches[0] as $email )
						{
							if( eZMail::validate($email) )
							{
								
								$info = $ini->group('MailSettings');
								
								$tpl =& templateInit();
						        $tpl->resetVariables();
								
								$parentNode =& eZContentObjectTreeNode::fetch($node->attribute('parent_node_id'));
								$parentObj = $parentNode->attribute('object');
								
								$res =& eZTemplateDesignResource::instance();
								$res->setKeys( array( array( 'object', $object->attribute( 'id' ) ),
						                              array( 'node', $node->attribute( 'node_id' ) ),
						                              array( 'class', $object->attribute( 'contentclass_id' ) ),
						                              array( 'class_identifier', $object->contentClassIdentifier() ),
						                              array( 'parent_node', $node->attribute( 'parent_node_id' ) ),
						                              array( 'parent_class', $parentObj->attribute( 'contentclass_id' ) ),
						                              array( 'parent_class_identifier', $parentObj->contentClassIdentifier() ),
						                              array( 'depth', $node->attribute( 'depth' ) ),
						                              array( 'url_alias', $node->attribute( 'url_alias' ) )
						                              ) );
													  
								$tpl->setVariable( 'object', $object );
								$tpl->setVariable( 'sender', $info["MailSender"] );
								
								$result = $tpl->fetch( 'design:workflow/eventtype/result/event_ezsckmailinglist.tpl' );
						        $subject = $tpl->variable( 'subject' );
								
								$params = array();
								
								if ( $tpl->hasVariable( 'message_id' ) )
						            $params['message_id'] = $tpl->variable( 'message_id' );
						        if ( $tpl->hasVariable( 'references' ) )
						            $params['references'] = $tpl->variable( 'references' );
						        if ( $tpl->hasVariable( 'reply_to' ) )
						            $params['reply_to'] = $tpl->variable( 'reply_to' );
						        if ( $tpl->hasVariable( 'from' ) )
						            $params['from'] = $tpl->variable( 'from' );
									
								$mail = new eZMail();
								$mail->setReceiver($email);
								$mail->setSender($params['from']);
								$mail->setSubject($subject);
								$mail->setBody($result);
								$mailResult = eZMailTransport::send($mail);
							}
						}
					}
				}
			}
		}
		
		return EZ_WORKFLOW_TYPE_STATUS_ACCEPTED;
	}
	
	
	function fetchHTTPInput( &$http, $base, &$event )
    {
		$nodeName = $base . "_event_ezsckmailinglist_nodetype_" . $event->attribute('id');
		
		if( $http->hasPostVariable($nodeName) )
		{
			$nodeValue = $http->postVariable($nodeName);
			$event->setAttribute('data_text1', $nodeValue);
		}
		
		$newName = $base . "_event_ezsckmailinglist_new_" . $event->attribute('id');
		
		if( $http->hasPostVariable($newName) )
		{
			$event->setAttribute('data_int1', 1);
		}
		elseif( $http->hasPostVariable("StoreButton") || $http->hasPostVariable("NewButton") )
		{
			$event->setAttribute('data_int1', 0);
		}
		
		$updateName = $base . "_event_ezsckmailinglist_update_" . $event->attribute('id');
		
		if( $http->hasPostVariable($updateName) )
		{
			$event->setAttribute('data_int2', 1);
		}
		elseif( $http->hasPostVariable("StoreButton") || $http->hasPostVariable("NewButton") )
		{
			$event->setAttribute('data_int2', 0);
		}
	}
}

eZWorkflowEventType::registerType( EZ_WORKFLOW_TYPE_SCKMAILINGLIST_ID, "ezsckmailinglisttype" );

?>