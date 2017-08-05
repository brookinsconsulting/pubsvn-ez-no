<?php

include_once( "lib/ezutils/classes/ezsys.php" );
include_once( "kernel/common/template.php" );
include_once( 'kernel/classes/ezcontentobject.php' );
include_once( 'extension/xmlarea/ezxmltext/handlers/output/xmlareaxmloutput.php' );



$Module =& $Params["Module"];

$tpl =& templateInit();
$Result = array();
$Result['pagelayout'] = 'popup_pagelayout.tpl';


if ( isset( $Params['ObjectID'] ) )
{
    $obj = eZContentObject::fetch( $Params['ObjectID'] );
    
    if ( $obj != null)
    {
        $ver = ( isset( $Params['ObjectVer'] ) ) ? $Params['ObjectVer'] : $obj->attribute( "current_version" );
        $lang = ( isset( $Params['ObjectLang'] ) ) ? $Params['ObjectLang'] : '';
        
        ezDebug::writeNotice( 'id=' . $Params['ObjectID']. ', ver=' . $ver. ', lang=' . $Params['ObjectLang']. ', params=' . $Params['InsertID'] );
    
        $objects = $obj->relatedContentObjectArray( $ver );
        
        //$tpl->setVariable('theobject', $obj );
        
        $tpl->setVariable('object_id', $Params['ObjectID'] );
        $tpl->setVariable('object_ver', $ver );
        $tpl->setVariable('object_lang', $lang );
        
        $tpl->setVariable('object_list', $objects );
        
        
        //---
        if ( $ver == '' )
            $ver = false;
        $relatedObjects =& $obj->relatedContentObjectArray( $ver );
        $tpl->setVariable( 'related_contentobjects', $relatedObjects );
    
        $ini =& eZINI::instance( 'content.ini' );
    
        $groups = $ini->variable( 'RelationGroupSettings', 'Groups' );
        $defaultGroup = $ini->variable( 'RelationGroupSettings', 'DefaultGroup' );
    
        $groupedRelatedObjects = array();
        $groupClassLists = array();
        $classGroupMap = array();
        foreach ( $groups as $groupName )
        {
            $groupedRelatedObjects[$groupName] = array();
            $setting = strtoupper( $groupName[0] ) . substr( $groupName, 1 ) . 'ClassList';
            $groupClassLists[$groupName] = $ini->variable( 'RelationGroupSettings', $setting );
            foreach ( $groupClassLists[$groupName] as $classIdentifier )
            {
                $classGroupMap[$classIdentifier] = $groupName;
            }
        }
        $groupedRelatedObjects[$defaultGroup] = array();
    
        foreach ( $relatedObjects as $relatedObjectKey => $relatedObject )
        {
            $classIdentifier = $relatedObject->attribute( 'class_identifier' );
            if ( isset( $classGroupMap[$classIdentifier] ) )
            {
                $groupName = $classGroupMap[$classIdentifier];
                $groupedRelatedObjects[$groupName][] =& $relatedObjects[$relatedObjectKey];
            }
            else
            {
                $groupedRelatedObjects[$defaultGroup][] =& $relatedObjects[$relatedObjectKey];
            }
        }
        $tpl->setVariable( 'related_contentobjects', $relatedObjects );
        $tpl->setVariable( 'grouped_related_contentobjects', $groupedRelatedObjects );
        
        
        //--------
                
        $title = 'Insert Object';
        $preview = '';
        $insert_id = '';
        $insertParams = '';
        $params = '';
        $paramArr = array( 'size' => '', 'align' => '', 'view' => '', 'class' => '', 'ezurl_id' => '', 'ezurl_href' => '', 'ezurl_target' => '', 'custom' => array() );
        
        if ( isset( $Params['InsertParams'] ) )
        {
            $title = 'Modify Object';
            
            $insertParams = rawurlencode( rawurldecode( $Params['InsertParams'] ) );
            $params = str_replace( '{)!(}', '/', rawurldecode( $Params['InsertParams'] ) );
            
            $arr = array();
            $arr = explode( '|', $params );
            
            $params = '';
            
            for ( $i=0; $i<count( $arr ); $i+=2 )
            {
                if ( isset($arr[$i]) && isset($arr[$i+1]) )
                {
                    $name = trim( $arr[$i] );
                    $content = trim( $arr[$i+1] );
                    if ( $name != '' && $content != '' )
                    {
                        $n = $name;
                        $params .= $n . "='" . $content . "' ";
                        if ( $n != 'id' && $n != 'class' && $n != 'view' && $n != 'align' && $n != 'size' && $n != 'ezurl_href' && $n != 'ezurl_target' )
                        {
                            $paramArr['custom'][] = array( $name, $content );
                        }
                        else
                        {
                            $paramArr[$name] = $content;
                        }
                    }
                }
            }
            eZDebug::writeNotice( $params );
            $test = "<tag><object $params /></tag>";
            $dom = eZXML::domTree( $test );
            
            eZDebug::writeNotice( $dom->toString() );
            
            $node = $dom->elementsByName('object');
            
            $object = $node[0];
            
            $insert_id = $object->attributeValue('id');
            
            $objtpl =& templateInit();
            
            include_once( 'kernel/classes/datatypes/ezxmltext/ezxmloutputhandler.php' );
            
            $isBlockTag = true;
            
            $data = XMLareaXMLOutput::renderObjectTag($objtpl, $object, $isBlockTag, true );
            $preview = $data[0];

            
        }
        
        $tpl->setVariable('preview', $preview );
        $tpl->setVariable('insert_id', $insert_id );                
        $tpl->setVariable('object_params', $paramArr );                
        $tpl->setVariable('title', $title );                
        $tpl->setVariable('params', $insertParams);
           
            
    }
    
    $Result['content'] =& $tpl->fetch( 'design:xmlarea/object.tpl' );
    
    $Result['pagelayout'] = 'xmlarea_pagelayout.tpl';
    
    $Result['path'] = array( array( 'text' =>  $title,
                                    'url' => false ) );
    
}

                 
?>