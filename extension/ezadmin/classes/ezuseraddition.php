<?php
class eZUserAddition
{
	function eZUserAddition()
	{

	}
	function loginDifferentUser($ObjectID)
	{
		$http =& eZHTTPTool::instance();
		$currentuser =& eZUser::currentUser();
		$user =& eZUser::fetch($ObjectID);
		if ($user==null)
			return false;
		
		//bye old user 
		$currentID = $http->sessionVariable( 'eZUserLoggedInID' );
		$http  =& eZHTTPTool::instance();
		$currentuser->logoutCurrent();

		//welcome new user
		$user->loginCurrent();
		$http->setSessionVariable( 'eZUserAdditionOldID', $currentID );
		return true;
	}
	function recallUser()
	{
		$http =& eZHTTPTool::instance();
		if ( $http->hasSessionVariable( 'eZUserAdditionOldID' ) )
		{
			$ObjectID = $http->sessionVariable( 'eZUserAdditionOldID' );
			$http->removeSessionVariable( 'eZUserAdditionOldID' );
			$user = &eZUser::currentUser();
			$user->logoutCurrent();
		
			$user = &eZUser::fetch($ObjectID);
			$user->loginCurrent();
			return true;
		}
		return false;
	}
}
?>