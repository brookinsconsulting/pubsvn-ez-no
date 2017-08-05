<?php
include_once('lib/ezutils/classes/ezsys.php');

if ( !defined( 'CACHE_DIR' ) )
	DEFINE( "CACHE_DIR", realpath(eZSys::cacheDirectory()).eZSys::fileSeparator().'jpgraph'.eZSys::fileSeparator());
if ( !defined( 'APACHE_CACHE_DIR' ) )
	DEFINE( "APACHE_CACHE_DIR", realpath(eZSys::cacheDirectory()).eZSys::fileSeparator().'jpgraph'.eZSys::fileSeparator());
if ( !defined( 'READ_CACHE' ) )
	DEFINE( "READ_CACHE", true );
if ( !defined( 'USE_CACHE' ) )
	DEFINE( "USE_CACHE", true );
$cachedir = eZSys::cacheDirectory().eZSys::fileSeparator().'jpgraph';
if ( !file_exists( $cachedir ))
{
	eZDir::mkdir($cachedir);
}
$ini = eZINI::instance( 'texttoimage.ini' );
$TTF_DIR = $ini->variable( 'PathSettings', 'FontDir' );
if ( $TTF_DIR[0] )
{
	DEFINE( "TTF_DIR", realpath( $TTF_DIR[0] ) . eZSys::fileSeparator() );
}
$imageini = eZINI::instance( 'image.ini' );
if ($imageini->hasVariable( 'GDSettings', 'HasGD2' ) )
{
	if ( $imageini->variable( 'GDSettings', 'HasGD2' ) == 'true' )
	{
		if ( !defined( 'USE_TRUECOLOR' ) )
		{
			DEFINE('USE_TRUECOLOR',  false );
			DEFINE('USE_LIBRARY_GD2', true );
		}
	}
	else
	{
		if ( !defined( 'USE_TRUECOLOR' ) )
		{
			DEFINE( 'USE_TRUECOLOR',  false );
			DEFINE( 'USE_LIBRARY_GD2', false );
		}
	}	
}
?> 