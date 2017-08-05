<?php

ext_class("ezadmin","ezuseraddition");

$module =& $Params["Module"];
$http =& eZHTTPTool::instance();

$ObjectID = &$Params['ObjectID'];
if ( !$ObjectID )
{
    eZDebug::writeError('Missing parameter Object ID.',"eZAdmin change User");
    return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}
$user = &eZUser::fetch($ObjectID);
if ( !$user )
{
    eZDebug::writeError('No such user or missing right "content read"',"eZAdmin change User");
    return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}
$usercontentobject = $user->attribute( 'contentobject' );
if ( !$usercontentobject->attribute( 'can_edit' ) )
{
    eZDebug::writeError('You need the right "content edit" for this content object',"eZAdmin change User");
    return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}

eZUserAddition::loginDifferentUser($ObjectID);

$userRedirectURI = $Module->actionParameter( 'UserRedirectURI' );
$ini = &eZINI::instance();
if ( trim( $userRedirectURI ) == "" )
{
    // Only use redirection if requireuser login is disabled
    $requireUserLogin = ( $ini->variable( "SiteAccessSettings", "RequireUserLogin" ) == "true" );
    if ( !$requireUserLogin )
    {
	if ( $http->hasSessionVariable( "LastAccessesURI" ) )
	    $userRedirectURI = $http->sessionVariable( "LastAccessesURI" );
    }

    if ( $http->hasSessionVariable( "RedirectAfterLogin" ) )
    {
	$userRedirectURI = $http->sessionVariable( "RedirectAfterLogin" );
    }
}
$redirectionURI = $userRedirectURI;
if ( $redirectionURI == '' )
        $redirectionURI = $ini->variable( 'SiteSettings', 'DefaultPage' );

if ( $http->hasGetVariable( 'RedirectionURI' ) )
{
    $module->redirectTo( $http->getVariable('RedirectionURI') );
}
else if($redirectionURI)
{
    $module->redirectTo( $redirectionURI );
}
else
{
    $module->redirectTo( "/" );
}
?>