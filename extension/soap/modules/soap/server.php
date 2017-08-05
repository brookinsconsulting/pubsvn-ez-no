<?php

include_once( "lib/ezsoap/classes/ezsoapserver.php" );
include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );

$Module =& $Params['Module'];
// Get the username and the password.
$loginUsername = $_SERVER['PHP_AUTH_USER'];
$loginPassword = $_SERVER['PHP_AUTH_PW'];

eZUser::loginUser( $loginUsername, $loginPassword );

$server = new eZSOAPServer ( );

$name = strtolower( $Params['Modulename'] );

$soapmodule =& eZModule::findModule( $name );
$soapfile = $soapmodule->Path.'/'.$soapmodule->Name.'/soap.php';

if ( $soapmodule )
{
	$server->registerObject( 'eZSOAP'.$soapmodule->Name, $soapfile );
	$server->processRequest();
}

eZExecution::cleanExit();
?>