<?php
//
// Created on: <28-Nov-2003 17:43:11 wy>
//
// Copyright (C) 1999-2003 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE.GPL included in
// the packaging of this file.
//
// Licencees holding valid "eZ publish professional licences" may use this
// file in accordance with the "eZ publish professional licence" Agreement
// provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" is available at
// http://ez.no/products/licences/professional/. For pricing of this licence
// please contact us via e-mail to licence@ez.no. Further contact
// information is available at http://ez.no/home/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

include_once( "lib/ezutils/classes/ezhttpfile.php" );
include_once( 'lib/ezutils/classes/ezhttptool.php' );
include_once( 'lib/ezdb/classes/ezdb.php' );
include_once( "kernel/common/template.php" );
include_once( 'kernel/classes/ezcontentobject.php' );
include_once( 'lib/ezutils/classes/ezexecution.php' );
include_once( 'lib/ezlocale/classes/ezdatetime.php' );
include_once( "kernel/common/image.php" );

set_time_limit( 0 );

$Module =& $Params["Module"];

$tpl =& templateInit();


global $URL;
$domain = getenv( 'HTTP_HOST' );
$protocol = 'http';

global $db;
$db =& eZDB::instance();
$db->setIsSQLOutputEnabled( false );

// Default to https if SSL is enabled

// Check if SSL port is defined in site.ini
$ini =& eZINI::instance();
$sslPort = 443;
if ( $ini->hasVariable( 'SiteSettings', 'SSLPort' ) )
{
    $sslPort = $ini->variable( 'SiteSettings', 'SSLPort' );
}

if ( eZSys::serverPort() == $sslPort )
{
    $protocol = 'https';
}

$URL = $protocol . "://" . $domain;

$URL .= eZSys::wwwDir();

$importIni =& eZINI::instance( "csv.ini" );

global $messages;
$messages = array();
$patternList = array();
$parentNodeName = null;
$parentNodeRemoteID = null;
$importKey = null;
$parseFile = false;
if ( $importIni->hasVariable( 'CSVImportSettings', 'PatternList' ) )
    $patternList =& $importIni->variable( 'CSVImportSettings', 'PatternList' );

$http =& eZHTTPTool::instance();
$importPattern = "";
if ( $http->hasVariable( 'import_pattern' ) )
{
    $importPattern = $http->variable( 'import_pattern' );
}

$maxFileSize = $importIni->variable( 'CSVImportSettings', 'MaxFileSize' );
$maxFileSize = $maxFileSize * 1024;

$fieldCount = 0;

$classID = 0;
if ( $importPattern != "" )
{
    $rootNodeID = $importIni->variable( $importPattern, 'RootNode' );
    $creatorID = $importIni->variable( $importPattern, 'CreatorID' );
    $classID = $importIni->variable( $importPattern, 'MatchClassID' );

    if ( $importIni->hasVariable( $importPattern, 'SectionID' ) )
    {
        $objectRelationClassID = $importIni->variable( $importPattern, 'ObjectRelationClassID' );
    }
    else
    {
        $objectRelationClassID = 0;
    }

    if ( $importIni->hasVariable( $importPattern, 'SectionID' ) )
    {
        $sectionID = $importIni->variable( $importPattern, 'SectionID' );
    }
    else
    {
        $sectionID = 1;
    }
    $delimiter = $importIni->variable( $importPattern, 'FileFieldSeparator' );

    if ( $delimiter == "tab" )
        $delimiter = "\t";
    $fieldIdentifierArray = $importIni->variable( $importPattern, 'Field' );

    if ( $importIni->hasVariable( $importPattern, 'KeyField' ) )
    {
        $keyField = $importIni->variable( $importPattern, 'KeyField' );
    }
    else
    {
        $keyField = 0;
    }

    $fieldCount = count( $fieldIdentifierArray );
    if ( $importIni->hasVariable( $importPattern, 'ConvertTag' ) )
    {
        $convertTag = $importIni->variable( $importPattern, 'ConvertTag' );
        $tagList = $importIni->variable( $importPattern, 'ConvertTagList' );
    }
    else
    {
        $convertTag = false;
    }

    if ( $importIni->hasVariable( $importPattern, 'ParentNodeField' ) )
    {
        $parentNodeField = $importIni->variable( $importPattern, 'ParentNodeField' );
    }
    else
    {
        $parentNodeField = 0;
    }
    if ( $importIni->hasVariable( $importPattern, 'ParentNodeFieldID' ) )
    {
        $parentNodeFieldID = $importIni->variable( $importPattern, 'ParentNodeFieldID' );
    }
    else
    {
        $parentNodeFieldID = 0;
    }
    if ( $importIni->hasVariable( $importPattern, 'FolderClassID' ) )
    {
        $folderClassID = $importIni->variable( $importPattern, 'FolderClassID' );
    }
    else
    {
        $folderClassID = 1;
    }
    if ( $importIni->hasVariable( $importPattern, 'StartLine' ) )
    {
        $startLine = $importIni->variable( $importPattern, 'StartLine' );
    }
    else
    {
        $startLine = 1;
    }
    if ( $importIni->hasVariable( $importPattern, 'StopLine' ) )
    {
        $stopLine = $importIni->variable( $importPattern, 'StopLine' );
    }
    else
    {
        $stopLine = -1;
    }
    if ( $importIni->hasVariable( $importPattern, 'PrintLogFields' ) )
    {
        $logFields = $importIni->variable( $importPattern, 'PrintLogFields' );
        $logFieldList =split( ";", $logFields );
    }
    else
    {
        $logFieldList = null;
    }
}

$classAttributes =& eZContentClassAttribute::fetchListByClassID( $classID );

$fieldArray = array();
foreach ( $classAttributes as $classAttribute )
{
    $attributeID = $classAttribute->attribute( 'id' );
    $attributeIdentifier = $classAttribute->attribute( 'identifier' );
    foreach ( array_keys( $fieldIdentifierArray ) as $key )
    {
        $fieldIdentifier = $fieldIdentifierArray[$key];
        if ( $fieldIdentifier == $attributeIdentifier )
            $fieldArray[$key] = $attributeID;
    }
}

$pdate = eZDateTime::currentTimeStamp();

if ( ( isset( $_FILES['csvfile']['name'] ) and isset( $_FILES['csvfile']['tmp_name'] ) ) )
{
    $row = 0;
    $fileName = $_FILES['csvfile']['name'];
    $tempName = $_FILES['csvfile']['tmp_name'];
    $handle = fopen( "$tempName", "r" );
    if ( $handle )
    {
        while ( $data = fgetcsv ( $handle, 35000, $delimiter ) )
        {
            $num = count ( $data );
            $row++;
            if ( $fieldCount != $num and $num !=1 )
            {
                $lineNr = $row;
                $messages[] = message( "Error", "Parse File", "Input data has wrong format, import stopped at line $row ( near '$data[0]' )" . $fieldCount . "-" . $num );
                break;
            }

            if ( $row == $stopLine )
            {
                break;
            }

            if ( $num !=1 and $row > ( $startLine - 1 )  )
            {
                $dataArray = array();
                $logArray = array();
                for ( $column=0; $column < $num; $column++ )
                {
                    $data[$column] = preg_replace( "/\`\`/", "\n", $data[$column] );
                    foreach ( array_keys( $fieldArray ) as $key )
                    {
                        $field = $fieldArray[$key];
                        if ( $key == ( $column + 1 ) )
                        {
                            $dataArray[$field] = $data[$column];
                        }
                        if ( $keyField == ( $column + 1 ) )
                            $importKey = $data[$column];
                    }

                    if ( $logFieldList != null )
                    {
                        foreach (  $logFieldList as $logField )
                        {
                            if ( $logField == ( $column + 1 ) )
                            {
                                $logArray[] = $data[$column];
                            }
                        }
                    }
                    if ( $parentNodeField != 0 )
                    {
                        $parentNodeName = $data[$parentNodeField-1];
                    }
                    if ( $parentNodeFieldID != 0 )
                    {
                        $parentNodeRemoteID = $data[$parentNodeFieldID-1];
                    }

                    if ( $column == 2 and $importPattern == "oldnews" )
                    {
                        $published = $data[$column];
                        if ( $published != "" )
                        {
                            list( $day, $month, $year ) = split( "-", $published );
                            switch( $month )
                            {
                                case 'Jan':
                                    $month = 1;
                                break;
                                case 'Feb':
                                    $month = 2;
                                break;
                                case 'Mar':
                                    $month = 3;
                                break;
                                case 'Apr':
                                    $month = 4;
                                break;
                                case 'May':
                                    $month = 5;
                                break;
                                case 'Jun':
                                    $month = 6;
                                break;
                                case 'Jul':
                                    $month = 7;
                                break;
                                case 'Aug':
                                    $month = 8;
                                break;
                                case 'Sep':
                                    $month = 9;
                                break;
                                case 'Oct':
                                    $month = 10;
                                break;
                                case 'Nov':
                                    $month = 11;
                                break;
                                case 'Dec':
                                    $month = 12;
                                break;
                            }
                            $pdate = mktime( 0, 0, 0, $month, $day, $year );
                        }
                    }
                }
                if ( $importPattern == "oldnews" )
                {
                    // merge show_on_other to keywords
                    $dataArray["371"] =  preg_replace( "/\|/", ",", $dataArray["371"] );
                    if (  $dataArray["384"] == "" )
                    {
                        $dataArray["384"] = $dataArray["371"];
                    }
                    else
                    {
                        $dataArray["384"] = $dataArray["384"] . ", " . $dataArray["371"];
                    }
                }
                if ( $data[0] != null )
                {
                    if ( ( $row % 80 ) == 0 )
                    {
                        $messages[] = message( "Notice", "Reset cache", " ### eZ publish cache reset " );
                        global $eZContentObjectContentObjectCache;
                        unset ( $eZContentObjectContentObjectCache );
                        global $eZContentObjectDataMapCache;
                        unset( $eZContentObjectDataMapCache );
                    }
                    if ( $convertTag )
                        addContentObject( $rootNodeID, $parentNodeName, $parentNodeRemoteID, $creatorID, $classID, $sectionID, $dataArray, $logArray, $importKey, $folderClassID, $convertTag, $tagList, $objectRelationClassID, $pdate );
                    else
                    {
                        addContentObject( $rootNodeID, $parentNodeName, $parentNodeRemoteID, $creatorID, $classID, $sectionID, $dataArray, $logArray, $importKey, $folderClassID, false, null, $objectRelationClassID, $pdate );
                    }
                }
            }
        }
        fclose($handle);
        $parseFile = true;
    }
    else
    {
        $messages[] = message( "Error", "Parse File", "Could not open file $fileName" );
    }
}

function message( $type, $function, $message )
{

    $tempArray = array( 'type' => $type,
                        'function' => $function,
                        'message' => $message );

    return( $tempArray );
}

function addContentObject( $rootNodeID, $parentNodeName, $parentNodeRemoteID, $creatorID, $classID, $sectionID, &$dataArray, &$logArray, $importKey,  $folderClassID, $convertTag = false, $tagList = null , $objectRelationClassID = 0, $pdate )
{
    global $messages;
    global $URL;
    global $db;
    $isImported = false;
    /*$db =& eZDB::instance();
	$db->setIsSQLOutputEnabled( false );*/

    //fetch match class
	$class =& eZContentClass::fetch( $classID );

    unset( $contentObject );

    // set remoteID with both \a $classID and \a $importKey

    if ( $importKey != null )
    {
        $remoteID = $classID . "_" . $importKey;

        // Check if it exist
        $objectArray = $db->arrayQuery( "SELECT id FROM ezcontentobject WHERE remote_id = '$remoteID'" );

        if ( count( $objectArray ) != 0 )
        {
            $isImported = true;
        }
    }
    else
    {
        $remoteID = $classID;
    }

    if ( !$isImported )
    {
        if ( $parentNodeName != null )
        {
            if ( $parentNodeRemoteID != null )
            {
                $folderRemoteID = $classID . "_" . $parentNodeRemoteID;
                $parentNodeIDArray = $db->arrayQuery( "SELECT ezcontentobject_tree.node_id FROM ezcontentobject, ezcontentobject_tree
                                                       WHERE ezcontentobject.remote_id = '$folderRemoteID'
                                                      AND ezcontentobject_tree.parent_node_id = '$rootNodeID'
                                                      AND ezcontentobject.id = ezcontentobject_tree.contentobject_id" );
            }
            else
            {
                $parentNodeIDArray = $db->arrayQuery( "SELECT ezcontentobject_tree.node_id FROM ezcontentobject, ezcontentobject_tree
                                                        WHERE ezcontentobject.name = '$parentNodeName'
                                                          AND ezcontentobject_tree.parent_node_id = '$rootNodeID'
                                                          AND ezcontentobject.id = ezcontentobject_tree.contentobject_id" );
            }
            if ( count( $parentNodeIDArray ) < 1 )
            {
                $parentNodeID = createFolder( $rootNodeID, $parentNodeName, $parentNodeRemoteID, $creatorID, $sectionID, $classID, $folderClassID );
            }
            else
                $parentNodeID = $parentNodeIDArray[0]['node_id'];
        }
        else
        {
            $parentNodeID = $rootNodeID;
        }

        // Create object by \a $creatorID in section \a $sectionID
        $contentObject =& $class->instantiate( $creatorID, $sectionID );
        $contentObject->setAttribute('remote_id', $remoteID );
        $contentObject->store();
        $nodeAssignment =& eZNodeAssignment::create( array(
                                                         'contentobject_id' => $contentObject->attribute( 'id' ),
                                                         'contentobject_version' => $contentObject->attribute( 'current_version' ),
                                                         'parent_node' => $parentNodeID,
                                                         'sort_field' => 2,
                                                         'sort_order' => 0,
                                                         'is_main' => 1
                                                         )
                                                     );
        $nodeAssignment->store();

        $version =& $contentObject->version( 1 );
        $version->setAttribute('created', $pdate );
        $version->setAttribute( 'modified', $pdate );
        $version->setAttribute( 'status', EZ_VERSION_STATUS_DRAFT );

        $version->store();

        $contentObjectID = $contentObject->attribute( 'id' );
        $contentObjectAttributes =& $version->contentObjectAttributes();

        foreach ( array_keys ( $contentObjectAttributes ) as $attributeKey )
        {
            $contentObjectAttribute =& $contentObjectAttributes[$attributeKey];
            $contentClassAttributeID =  $contentObjectAttribute->attribute( 'contentclassattribute_id' );
            foreach ( array_keys ( $dataArray ) as $key )
            {
                if ( $key == $contentClassAttributeID )
                {
                    storeAttributeContent( $contentObjectAttribute, $dataArray[$key], $convertTag, $tagList, $objectRelationClassID );
                }
            }
        }

        include_once( 'lib/ezutils/classes/ezoperationhandler.php' );
        $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObjectID,
                                                                                     'version' => 1 ) );

        $mainNode = $contentObject->attribute( 'main_node' );
        $nodeID = $mainNode->attribute( 'node_id' );
        $objectName = $mainNode->attribute( 'name' );

        $publishedContentObject = eZContentObject::fetch( $contentObjectID );
        $publishedContentObject->setAttribute('modified', $pdate );
        $publishedContentObject->setAttribute('published', $pdate );
        $publishedContentObject->store();
        $logMessage = implode( " | ", $logArray );
        $messages[] = message( "Notice", "Added <a href='$URL/content/view/full/$nodeID'>$objectName</a>", $logMessage );
    }
    else
    {
        if ( $parentNodeName != null )
        {
            if ( $parentNodeRemoteID != null )
            {
                $folderRemoteID = $classID . "_" . $parentNodeRemoteID;
                $parentNodeIDArray = $db->arrayQuery( "SELECT ezcontentobject_tree.node_id FROM ezcontentobject, ezcontentobject_tree
                                                       WHERE ezcontentobject.remote_id = '$folderRemoteID'
                                                         AND ezcontentobject_tree.parent_node_id = '$rootNodeID'
                                                         AND ezcontentobject.id = ezcontentobject_tree.contentobject_id" );
            }
            else
            {
                $parentNodeIDArray = $db->arrayQuery( "SELECT ezcontentobject_tree.node_id FROM ezcontentobject, ezcontentobject_tree
                                                        WHERE ezcontentobject.name = '$parentNodeName'
                                                          AND ezcontentobject_tree.parent_node_id = '$rootNodeID'
                                                          AND ezcontentobject.id = ezcontentobject_tree.contentobject_id" );
            }
            if ( count( $parentNodeIDArray ) < 1 )
            {
                $parentNodeID = createFolder( $rootNodeID, $parentNodeName, $parentNodeRemoteID, $creatorID, $sectionID, $classID, $folderClassID );
            }
            else
                $parentNodeID = $parentNodeIDArray[0]['node_id'];
        }
        else
            $parentNodeID = $rootNodeID;

        // update contents
        $contentObjectID = $objectArray[0]['id'];
        $contentObject =& eZContentObject::fetch( $contentObjectID );

        $version =& $contentObject->createNewVersion();
        $version->setAttribute('created', $pdate );
        $version->setAttribute( 'modified', $pdate );
        $version->setAttribute( 'status', EZ_VERSION_STATUS_DRAFT );
        $version->store();

        $versionNr =  $version->attribute( 'version' );

        $contentObjectID = $contentObject->attribute( 'id' );

        $contentObjectAttributes =& $version->contentObjectAttributes();

        foreach ( array_keys ( $contentObjectAttributes ) as $attributeKey )
        {
            $contentObjectAttribute =& $contentObjectAttributes[$attributeKey];
            $contentClassAttributeID =  $contentObjectAttribute->attribute( 'contentclassattribute_id' );
            foreach ( array_keys ( $dataArray ) as $key )
            {
                if ( $key == $contentClassAttributeID )
                {
                    storeAttributeContent( $contentObjectAttribute, $dataArray[$key], $convertTag, $tagList, $objectRelationClassID );
                }
            }
        }
        include_once( 'lib/ezutils/classes/ezoperationhandler.php' );
        $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObjectID,
                                                                                     'version' => $versionNr ) );
        $mainNode = $contentObject->attribute( 'main_node' );
        $nodeID = $mainNode->attribute( 'node_id' );
        $objectName = $mainNode->attribute( 'name' );

        $publishedContentObject = eZContentObject::fetch( $contentObjectID );
        $publishedContentObject->setAttribute('modified', $pdate );
        $publishedContentObject->setAttribute('published', $pdate );
        $publishedContentObject->store();
        $logMessage = implode( " | ", $logArray );
        $messages[] = message( "Notice", "Updated <a href='$URL/content/view/full/$nodeID'>$objectName</a>", $logMessage );
    }
}

function makeImage( $objectID, $version, &$attribute, $blob )
{
    $img =& imageInit();
    $contentObjectAttributeID = $attribute->attribute( "id" );
    $sys =& eZSys::instance();
    $storage_dir = $sys->storageDirectory();
    $tmpname = tempnam( "/tmp/" , "eZ" );
    $httpFileName = $blob;
    $content =& $attribute->attribute( 'content' );
    if ( trim( $httpFileName ) != "" and ( preg_match( "/http/i", $httpFileName ) ) )
    {
        $fhandler = fopen( $httpFileName, "r");
        if ( $fhandler  )
        {
            if ( $hasImageAltText )
                $content->setAttribute( 'alternative_text', $imageAltText );
            $result = true;

            $sys =& eZSys::instance();
            $storage_dir = $sys->storageDirectory();

            $urlArray = split('/', $httpFileName );
            $arrayCount = count( $urlArray );
            $tempFile = $urlArray[$arrayCount-1];

            $fwriter = fopen( $storage_dir. "/" . $tempFile, "w");
            $contentValue = "";
            do
            {
                $data = fread( $fhandler, 4096 );
                if ( strlen( $data ) == 0)
                {
                    break;
                }
                $contentValue .= $data;
            } while (true);

            fwrite( $fwriter, $contentValue);
            fclose( $fwriter );

            fclose( $fhandler );

            if ( is_object( $content ) )
            {
                $sys =& eZSys::instance();
                $storage_dir = $sys->storageDirectory();
                $imageFile= $storage_dir . "/" . $tempFile;
                $GLOBALS['eZURLImageIsStored'] = 1;
                if ( $hasImageAltText )
                {
                    $content->initializeFromFile( $imageFile, $imageAltText );
                }
                else
                {
                    $content->initializeFromFile( $imageFile );
                }
                if ( $content->isStorageRequired() )
                {
                    $content->store();
                }
                unlink( $imageFile );
            }
        }
    }
}

function storeAttributeContent( &$contentObjectAttribute, &$attributeContent, $convertTag, $tagList, $objectRelationClassID )
{
    global $messages;
    global $db;
    $contentClassAttribute = $contentObjectAttribute->attribute( 'contentclass_attribute' );
    $dataType = $contentClassAttribute->attribute( 'data_type_string' );
    $attributeName = $contentClassAttribute->attribute( 'name' );
    switch ( $dataType )
    {
        case 'ezboolean':
        {
            $contentObjectAttribute->setAttribute( 'data_int', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezdate':
        {
            $contentObjectAttribute->setAttribute( 'data_int', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezemail':
        {
            $contentObjectAttribute->setAttribute( 'data_text', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezfloat':
        {
            $contentObjectAttribute->setAttribute( 'data_float', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezinteger':
        {
            $contentObjectAttribute->setAttribute( 'data_int', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezstring':
        {
            $contentObjectAttribute->setAttribute( 'data_text', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'eztext':
        {
            $contentObjectAttribute->setAttribute( 'data_text', $attributeContent );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezobjectrelation':
        {
            $relatedObjectName = $attributeContent;
            if ( $relatedObjectName != "" )
            {
                $relatedObject = $db->arrayQuery( "SELECT id FROM ezcontentobject WHERE name='$relatedObjectName' AND contentclass_id='$objectRelationClassID'" );
                if ( count( $relatedObject ) > 0 )
                {
                    $contentObjectAttribute->setAttribute( 'data_int',  $relatedObject[0]['id'] );
                    $contentObjectAttribute->store();
                }
            }
            break;
        }

        case 'ezimage':
        {
            $contentObjectID = $contentObjectAttribute->attribute( 'contentobject_id' );
            $contentObjectVersion = $contentObjectAttribute->attribute( 'version' );
            makeImage( $contentObjectID, $contentObjectVersion, $contentObjectAttribute, $attributeContent );
            break;
        }

        case 'ezxmltext':
        {
            $inputData = "<section xmlns:image='http://ez.no/namespaces/ezpublish3/image/' xmlns:xhtml='http://ez.no/namespaces/ezpublish3/xhtml/' xmlns:custom='http://ez.no/namespaces/ezpublish3/custom/' >";
            $inputData .= "<paragraph>";
            if ( $convertTag == true )
                $inputData .= convert( $attributeContent, $tagList );
            else
                $inputData .= $attributeContent;
            $inputData .= "</paragraph>";
            $inputData .= "</section>";

            include_once( "kernel/classes/datatypes/ezxmltext/handlers/input/ezsimplifiedxmlinput.php" );
            $dumpdata = "";
            $simplifiedXMLInput = new eZSimplifiedXMLInput( $dumpdata, null, null );
            $inputData = $simplifiedXMLInput->convertInput( $inputData );
            $input = $inputData[0]->toString();

            $contentObjectAttribute->setAttribute( 'data_text', $input );
            $contentObjectAttribute->store();
            break;
        }

        case 'ezkeyword':
        {
            include_once( 'kernel/classes/datatypes/ezkeyword/ezkeyword.php' );
            $keyword = new eZKeyword();
            $keyword->initializeKeyword( $attributeContent );
            $keyword->store( $contentObjectAttribute );
            break;
        }

        default:
        {
            $messages[] = message( "Error", "Adding Object attribute $attributeName", "Unsupported data type: $dataType" );
        }
    }
}

function &convert(  &$attributeContent, $tagList )
{
    foreach ( array_keys( $tagList ) as $key )
    {
        $targetTag = $tagList[$key];
        switch ( $targetTag )
        {
            case 'custom':
            {
                $attributeContent = str_replace( "<" . $key . ">", "<custom name='" . $key . "'>", $attributeContent );
                $attributeContent = str_replace( "</" . $key . ">", "</custom>", $attributeContent );
                break;
            }
            case 'literal':
            {
                $attributeContent = str_replace( "<" . $key . ">", "<literal class='" . $key . "'>", $attributeContent );
                $attributeContent = str_replace( "</" . $key . ">", "</literal>", $attributeContent );
                break;
            }
            default:
            {
                $attributeContent = str_replace( "<" . $key . ">", "<" . $targetTag . ">", $attributeContent );
                $attributeContent = str_replace( "</" . $key . ">", "</" . $targetTag . ">", $attributeContent );
            }
        }


    }
    return $attributeContent;
}

function createFolder( $parentNodeID, $name, $parentNodeRemoteID, $creatorID, $sectionID, $classID, $folderClassID )
{
    $folderNodeID = 2;
    $db =& eZDB::instance();
	$db->setIsSQLOutputEnabled( false );

    //fetch folder class
	$class =& eZContentClass::fetch( $folderClassID );

    unset( $contentObject );
    $userID = $creatorID;

    if (  $parentNodeRemoteID != null )
    {
        $remoteID = $classID . "_" . $parentNodeRemoteID;
    }
    else
    {
        $remoteID = $classID . "_folder";
    }

    // Create object by user id in section \a  $sectionID
    $contentObject =& $class->instantiate( $userID, $sectionID );
    $contentObject->setAttribute( 'remote_id', $remoteID );
    $contentObject->setAttribute( 'name', $name );
    $nodeAssignment =& eZNodeAssignment::create( array(
                                                     'contentobject_id' => $contentObject->attribute( 'id' ),
                                                     'contentobject_version' => $contentObject->attribute( 'current_version' ),
                                                     'parent_node' => $parentNodeID,
                                                     'sort_field' => 7,
                                                     'sort_order' => 1,
                                                     'is_main' => 1
                                                     )
                                                 );
    $nodeAssignment->store();

    $version =& $contentObject->version( 1 );
    $version->setAttribute( 'status', EZ_VERSION_STATUS_DRAFT );
    $version->store();

    $contentObjectID = $contentObject->attribute( 'id' );
    $contentObjectAttributes =& $version->contentObjectAttributes();

    $contentObjectAttributes[0]->setAttribute( 'data_text', $name );
    $contentObjectAttributes[0]->store();

    include_once( 'lib/ezutils/classes/ezoperationhandler.php' );
    $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObjectID,
                                                                                 'version' => 1 ) );
    $contentObject->setAttribute('section_id', $sectionID );
    $contentObject->store();

    // Get node id for this folder
    $nodeIDArray = $db->arrayQuery( "SELECT node_id FROM ezcontentobject_tree
                                     WHERE contentobject_id = '$contentObjectID' AND contentobject_version = 1" );
    $folderNodeID = $nodeIDArray[0]['node_id'];

    return $folderNodeID;
}

$tpl->setVariable( "max_file_size", $maxFileSize );
$tpl->setVariable( "pattern_list", $patternList );
$tpl->setVariable( "import_pattern", $importPattern );
$tpl->setVariable( "messages", $messages );

$tpl->setVariable( "parse_file", $parseFile );

$Result = array();
$Result['content'] =& $tpl->fetch( 'design:csvimport.tpl' );

?>
