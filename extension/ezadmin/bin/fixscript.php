<?php
if ( !is_object( $cli ) ){
	include_once( 'lib/ezutils/classes/ezcli.php' );
	include_once( 'kernel/classes/ezscript.php' );
	$cli =& eZCLI::instance();
	$script =& eZScript::instance( array( 'description' => ( "Fix script\n" .
                                                         "Fixes common errors\n" .
                                                         "\n" .
                                                         "./extension/freecpd/bin/fixscript.php --user=admin --password=publish" ),
                                      'use-session' => true,
                                      'use-modules' => true,
                                      'use-extensions' => true ) );

	$script->startup();

	$options = $script->getOptions( "[user:][password:][force]",
                                "",
                                array( 'user' => 'Username on remote server',
                                       'password' => 'Password on remote server',
									   'force' => 'Force on all fixes' ) );

	$script->initialize();
	$isCRON=false;
}
else
{
	$isCRON=true;
}

$sys =& eZSys::instance();

// login as admin
include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
$contentini = eZINI::instance( 'content.ini' );
if ( !$options['user'] )
	$username = 'admin';
else
	$username = $options['user'];
	
$user =& eZUser::fetchByName( $username );

if ( is_object( $user ) )
{
	$user->loginCurrent();
	$cli->output( "Logged in as '".$username."'" );
}
else
{
	$cli->output( "Not logged in as '".$username."'" );
	if ( !$isCRON )
	{
		$script->showHelp();
		return $script->shutdown();
	}
	else
		return;
}
$cli->output( 'Using Siteaccess '.$GLOBALS['eZCurrentAccess']['name'] );

fixWorkflowProcesses();
fixCollaboration();

if ( !$isCRON )
{
	$script->showHelp();
	return $script->shutdown();
}
function fixWorkflowProcesses()
{
	$cli =& eZCLI::instance();
	include_once( "kernel/classes/ezworkflowprocess.php" );
	$cli->output( "Cleaning up bogus Workflow processes." );
	$list = eZWorkflowProcess::fetchList();
	foreach( $list as $workflowprocess )
	{
		$parameters = $workflowprocess->attribute( 'parameter_list' );
		$object =& eZContentObject::fetch( $parameters['object_id'] );
		if ( !is_object( $object ) )
		{	
			$cli->output( "Removing ID " . $parameters['object_id'] );
			$workflowprocess->remove();
		}
	}
}
function fixCollaboration()
{
	$cli =& eZCLI::instance();
	$cli->output( "Cleaning bogus Collaboration Items." );
	include_once( 'kernel/classes/ezcollaborationitem.php' );
	include_once( 'kernel/classes/ezcollaborationitemhandler.php' );
	
	$list = eZCollaborationItem::fetchList( array( 'as_object' => true,
											  'offset' => false,
											  'parent_group_id' => false,
											  'limit' => false,
											  'is_active' => true,
											  'is_read' => null,
											  'status' => false,
											  'sort_by' => false ) );
											  
	foreach ( $list as $collaborationItem )
	{
		$typeIdentifier = $collaborationItem->attribute( 'type_identifier' );
		$handler =& $collaborationItem->attribute( 'handler' );
		$content = $collaborationItem->content();
	
		$co = eZContentObject::fetch( $content['content_object_id'] );
		if ( !is_object( $co ) and array_key_exists( 'content_object_id', $content ) )
		{
			eZCollaborationItem_remove( $collaborationItem->attribute( 'id' ) );
			$cli->output( "Removing bogus Collaboration item with ID ". $collaborationItem->attribute( 'id' ) );
		}
	}
}
function eZCollaborationItem_remove( $id = false )
{
	if ( is_object( $this ) )
		$id  = $this->attribute( 'id' );
	
	if ( !is_numeric( $id) )
		return false;
		
	$db =& eZDB::instance();
	$db->begin();
	$db->query( "DELETE FROM ezcollab_item WHERE id = " . $id );
	$db->query( "DELETE FROM ezcollab_item_group_link WHERE collaboration_id = " . $id );
	$db->query( "DELETE FROM ezcollab_item_message_link WHERE collaboration_id = " . $id );
	$db->query( "DELETE FROM ezcollab_item_participant_link WHERE collaboration_id = " . $id );
    $db->query( "DELETE FROM ezcollab_item_status WHERE collaboration_id = " . $id );
    #$db->query( "DELETE FROM ezcollab_notification_rule " . $id );
    #$db->query( "DELETE FROM ezcollab_profile" . $id );
    #$db->query( "DELETE FROM ezcollab_simple_message" . $id );
    $db->commit();
}
?>
