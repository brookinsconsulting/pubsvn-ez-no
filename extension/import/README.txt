/*
    eZImport Framework for eZ publish
    Copyright (C) 2004  xrow GbR, Hannover Germany

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

Developed by
Björn Dieding   ( bjoern@xrow.de )

State: Beta

PubSVN:
http://pubsvn.ez.no/viewcvs/community/trunk/extension/import/

Description:
Basic classes for abstracting data imports

=============
Usage
=============
This is just a little sample code to import data from an csv file into contentobjects.

include_once( 'lib/ezutils/classes/ezextension.php' );
ext_class( 'import' ,  'ezimportframework' );

$if =& eZImportFramework::instance( 'cvs' );
$if->getData( "extension/franchise/bin/import.csv" );

$cli->output( "Found " . count( $if->data ) );

$user =& eZUser::fetchByName("admin");
$userID =& $user->attribute( 'contentobject_id' );
$class = eZContentClass::fetchByIdentifier( "franchise" );

$options = array
(
'contentClassID' => $class->attribute( 'id' ),
'userID' => $userID,
'parentNodeID' => 'node_id'
);
$if->processData( 'contentobject', $options );