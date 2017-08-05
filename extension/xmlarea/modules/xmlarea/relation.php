<?php

include_once( 'kernel/classes/eztrigger.php' );
$Module =& $Params['Module'];
include_once( "lib/ezutils/classes/ezini.php" );
include_once( 'extension/xmlarea/modules/xmlarea/relation_edit.php' );
initializeRelationEdit( $Module );


if ( isset( $Module ) )
    $Module =& $Params['Module'];
$ObjectID =& $Params['ObjectID'];
if ( !isset( $EditVersion ) )
    $EditVersion =& $Params['EditVersion'];
else
    $EditVersion = null;
if ( !isset( $EditLanguage ) )
    $EditLanguage = $Params['EditLanguage'];
if ( !isset( $EditLanguage ) )
    $EditLanguage = false;
if ( !is_string( $EditLanguage ) or
     strlen( $EditLanguage ) == 0 )
    $EditLanguage = false;
if ( isset( $Params['InsertParams'] ) )
    $InsertParams = $Params['InsertParams'];

ezDebug::writeNotice( 'id=' . $Params['ObjectID'].', params=' . $Params['InsertParams'] );

$object =& eZContentObject::fetch( $ObjectID );
if ( $object === null )
    return $Module->handleError( EZ_ERROR_KERNEL_NOT_AVAILABLE, 'kernel' );



if ( $version != null )
    $version =& $object->version( $EditVersion );
else
    $version =& $object->currentVersion();
$classID = $object->attribute( 'contentclass_id' );

$attributeDataBaseName = 'ContentObjectAttribute';


$class =& eZContentClass::fetch( $classID );
$contentObjectAttributes =& $version->contentObjectAttributes( $EditLanguage );
if ( $contentObjectAttributes === null or
     count( $contentObjectAttributes ) == 0 )
    $contentObjectAttributes =& $version->contentObjectAttributes();

/*$fromContentObjectAttributes = false;
$isTranslatingContent = false;
if ( $FromLanguage !== false )
{
    $isTranslatingContent = true;
    $fromContentObjectAttributes =& $version->contentObjectAttributes( $FromLanguage );
    if ( $fromContentObjectAttributes === null or
         count( $fromContentObjectAttributes ) == 0 )
    {
        unset( $fromContentObjectAttributes );
        $fromContentObjectAttributes = false;
        $isTranslatingContent = false;
    }
}*/

$http =& eZHTTPTool::instance();

if ( $Module->runHooks( 'post_fetch', array( &$class, &$object, &$version, &$contentObjectAttributes, $EditVersion, $EditLanguage, $InsertParams ) ) )
    return;
    
if ( $Module->runHooks( 'pre_commit', array( &$class, &$object, &$version, &$contentObjectAttributes, $EditVersion, $EditLanguage, $InsertParams ) ) )
            return;
    
if ( $Module->runHooks( 'action_check', array( &$class, &$object, &$version, &$contentObjectAttributes, $EditVersion, $EditLanguage, $InsertParams ) ) )
            return;


if ( isset( $Params['TemplateObject'] ) )
    $tpl =& $Params['TemplateObject'];

if ( !isset( $tpl ) || get_class( $tpl ) != 'eztemplate' )
    $tpl =& templateInit();

//$Module->setTitle( 'Edit ' . $class->attribute( 'name' ) . ' - ' . $object->attribute( 'name' ) );
$res =& eZTemplateDesignResource::instance();

$res->setKeys( array( array( 'object', $object->attribute( 'id' ) ),
                      array( 'class', $class->attribute( 'id' ) ),
                      array( 'class_identifier', $class->attribute( 'identifier' ) )
                      ) );
                      
if ( $Module->runHooks( 'pre_template', array( &$class, &$object, &$version, &$contentObjectAttributes, $EditVersion, $EditLanguage, &$tpl, false ) ) )
    return;


$Module->redirectToView( 'object', array( $ObjectID, $EditVersion, $EditLanguage, $InsertParams ),
         null, false );
return EZ_MODULE_HOOK_STATUS_CANCEL_RUN;





?>