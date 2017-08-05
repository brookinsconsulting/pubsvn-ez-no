<?php
class eZImportCommon
{
	function eZImportCommon()
	{

	}
	function &copyto ( &$object,$node)
	{
		$nodeAssignment =& eZNodeAssignment::create( array
		(
		'contentobject_id' => $object->attribute( 'id' ),
		'contentobject_version' => $object->attribute( 'current_version' ),
		'parent_node' => $node,
		'is_main' => 0
		)
		);
		$nodeAssignment->store();

		$treenodegewerk =& eZContentObjectTreeNode::addChild($object->attribute( 'id' ),$node,true);
		$operationResult = eZOperationHandler::execute(
		'content', 'publish', array(
		'object_id' => $object->attribute( 'id' ),
		'version' => $object->attribute( 'current_version' ) ) );
		return eZContentObjectTreeNode::findNode($node,$object->attribute('id'),true);
	}
	function findparentnode($parentNodeID)
	{
		$parentContentObjectTreeNode =& eZContentObjectTreeNode::fetch($parentNodeID);
		$parentContentObject = $parentContentObjectTreeNode->attribute("object");
		$sectionID = $parentContentObject->attribute( 'section_id' );
	}
}
?>