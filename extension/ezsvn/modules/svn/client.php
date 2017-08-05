<?php
################### JUST FOR TESTING PURPOSE##############################
// include client classes
include_once( "lib/ezsoap/classes/ezsoapclient.php" );
include_once( "lib/ezsoap/classes/ezsoaprequest.php" );


$login='admin';
$password='publish';
// create a new client
$client = new eZSOAPClient( "freecpd.example.com", "/svn/configserver" );
$client->setLogin( $login );
$client->setPassword( $password ); 

$namespace = "http://soapinterop.org/";

// create the SOAP request object
$request = new eZSOAPRequest( "SVNServerFunctions::svnconfig", "http://freecpd.example.com/svn/configserver" );

// add parameters to the request
$request->addParameter( "remote_id", '3f5bedf1f158f517d2d14c8b475eeae2' );

// send the request to the server and fetch the response
$response =& $client->send( $request );

// check if the server returned a fault, if not print out the result
if ( $response->isFault() )
{
    var_dump( "SOAP fault: " . $response->faultCode(). " - " . $response->faultString() . "" );
}
else
{
    var_dump( "Returned SOAP value was: \"" . $response->value() . "\"" );
	var_dump( $response->value() );
}
?>