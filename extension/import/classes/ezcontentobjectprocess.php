<?PHP
class eZContentObjectProcess extends eZImportProcess
{
	function eZContentObjectProcess()
	{

	}
	function run( &$data )
	{
		$contentClassID = $this->options['contentClassID'];
		$class =& eZContentClass::fetch( $contentClassID );
		$userID = $this->options['userID'];
		foreach ( $data as $item )
		{
			$parentNodeID=null;
			if ( $this->options['parentfind'] )
			{
				$parentco =& eZContentObjectTreeNode::fetchObjectList( eZContentObject::definition($contentClassID),
				null,
				array ( 'contentclass_id' => $this->options['parentfind']['contentClassID'], 'name' => $item[$this->options['parentfind']['attribute'][1]] ),
				null,
				null,
				true
				);
				$parentNodeID=eZContentObjectTreeNode::findMainNode($parentco[0]->ID);
			}
			if ( !$parentNodeID )
			{
				if ( is_numeric( $this->options['parentNodeID'] ) )
					$parentNodeID = $this->options['parentNodeID'];
				else if ( is_numeric( $item[ $this->options['parentNodeID'] ] ) and $item[ $this->options['parentNodeID'] ] )
					$parentNodeID = $item[ $this->options['parentNodeID'] ];
			}
			if ( !$parentNodeID )
			{
				continue;
			}
			
			/*
				$co =& eZContentObject::fetchObjectList( eZContentObject::definition($contentClassID),
				null,
				array ('contentclass_id' => $contentClassID, 'remote_id' =>  $item[$remote_id]),
				null,
				null,
				true
				);
			*/

			$locale =& eZLocale::instance();
			$datetime =& eZDateTime::create();
			$datetime->setLocale( $locale );

			$parentContentObjectTreeNode = eZContentObjectTreeNode::fetch( $parentNodeID );
			if ( !is_object( $parentContentObjectTreeNode ) )
			{
				eZDebug::writeError("No Node ID '". $parentNodeID ."'");
				continue;
			}
			$parentContentObject = $parentContentObjectTreeNode->attribute("object");
			$sectionID = $parentContentObject->attribute( 'section_id' );


			$contentObject =& $class->instantiate( $userID, $sectionID );

			$nodeAssignment =& eZNodeAssignment::create( array(
			'contentobject_id' => $contentObject->attribute( 'id' ),
			'contentobject_version' => $contentObject->attribute( 'current_version' ),
			'parent_node' => $parentContentObjectTreeNode->attribute( 'node_id' ),
			'is_main' => 1
			)
			);
			
			$nodeAssignment->store();

			$contentObject->setAttribute( 'remote_id', $item[$remote_id] );
			$contentObject->setAttribute( 'name', $item[$object_name] );
			$contentObject->setAttribute( 'modified', $datetime->timeStamp() );
			$contentObject->setAttribute( 'published', $datetime->timeStamp() );
			$contentObject->setAttribute( 'created', $datetime->timeStamp() );

			$contentObject->store();
			$version =& $contentObject->currentVersion();
			$attribs =& $contentObject->contentObjectAttributes();

			for($i=0;$i<count($attribs);$i++){
				$ident = $attribs[$i]->attribute("contentclass_attribute_identifier");
				if ($item[$ident])
				{
					$this->store_attr($item[$ident],$attribs[$i]);
				}
			}


			$contentObject->setAttribute( 'modified', $datetime->timeStamp() );
			$contentObject->setAttribute( 'created', $datetime->timeStamp() );
			$contentObject->setAttribute( 'status', EZ_VERSION_STATUS_DRAFT );

			$contentObject->store();

			$operationResult = eZOperationHandler::execute(
			'content', 'publish', array(
			'object_id' => $contentObject->attribute( 'id' ),
			'version' => $contentObject->attribute( 'current_version' ) ) );
			
			# var_dump($contentObject); break; // for testing just insert the frist of each
		}
	}
}
?>