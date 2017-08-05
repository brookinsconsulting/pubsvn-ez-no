<?php

//include_once( "lib/ezutils/classes/ezsys.php" );
include_once( "kernel/common/template.php" );
include_once( 'extension/xmlarea/ezxmltext/handlers/input/xmlareaxmlinput.php' );
include_once( "lib/ezutils/classes/ezini.php" );





$Module =& $Params["Module"];

$tpl =& templateInit();
$Result = array();
//$Result['pagelayout'] = 'popup_pagelayout.tpl';


if ( isset( $Params['TagName'] ) )
{
    
    $ini =& eZINI::instance( 'content.ini' );
    $availableClasses = array();
    $availableTags =& $ini->variable( 'CustomTagSettings', 'AvailableCustomTags' );
    $isValidTag = true;
    $atts = array();
    $editAtts = array();
    $validAtts = array();
    $isCustomTag = false;
    $xmlData = '';
    $hander = new XMLAreaXMLInput( $xmlData, null, null );
    
    $tagName = $hander->standardizeTag( strtolower( $Params['TagName'] ) );
    
    if ( $tagName == 'paragraph' || ( in_array( $tagName, $hander->SupportedInputTagArray ) && $tagName != 'anchor' ) )
    {
        $availableClasses = $ini->variable( $tagName, 'AvailableClasses' );
        $validAtts = $hander->TagAttributeArray[$tagName];
    }
    else if ( in_array( $tagName, $availableTags ) )
    {
        $isCustomTag = true;
    }
    else
    {
        $isValidTag = false;
    }
    
    
    if ( isset( $Params['Params'] ) )
    {
        $arr = explode( '|', $Params['Params'] );
        for ( $i=0; $i<count( $arr ); $i+=2 )
        {
            if ( isset($arr[$i]) && isset($arr[$i+1]) )
            {
                $name = trim( $arr[$i] );
                $content = trim( $arr[$i+1] );
                if ( $name != '' && $content != '' )
                {
                    if ( $isCustomTag )
                    {
                        $editAtts[] = array( $name, $content );
                    }
                    else
                    {
                        if ( $name != 'class' || count( $availableClasses ) > 0 )
                            $atts[$name] = $content;
                    }
                }
            }
        }
    }
    
    if ( !$isCustomTag )
    {
        foreach ( $validAtts as $name => $tmp )
        {
            $content = ( isset( $atts[$name] ) ) ? $atts[$name] : '';
            switch ( $name )
            {
                case ( 'anchor_name' ) : $fancyName = 'anchor'; break;
                case ( 'level' ): $name = ''; break;
                case ( 'rowspan' ): $name = ''; break;
                case ( 'colspan' ): $name = ''; break;
                default: $fancyName = $name; break;
            }
            if ( $name != '' )
                $editAtts[] = array( $name, $content, $fancyName );
        }
    }
    
    if ( count( $editAtts ) == 0 )
    {
        $editAtts[] = array('', '');
    }
    
    //$isCustomTag = ( $isCustomTag ) ? 1 : 0;
    
    $fancyName = isset( $Params['FancyName'] ) ? $Params['FancyName'] : $tagName;
    $title = $fancyName.' properties';
        
    $tpl->setVariable('isCustomTag', $isCustomTag );
    $tpl->setVariable('availableClasses', $availableClasses );
    $tpl->setVariable('tagName', $tagName );
    $tpl->setVariable('attributes', $editAtts );
    $tpl->setVariable('title', $title );
    
    //$tpl->setVariable('object_ver', $ver );
    //$tpl->setVariable('object_lang', $lang );
        
    //$tpl->setVariable('object_list', $objects );
 
    
    $Result['content'] =& $tpl->fetch( 'design:xmlarea/tag.tpl' );
    
    $Result['pagelayout'] = 'xmlarea_pagelayout.tpl';
    
    $Result['path'] = array( array( 'text' =>  $title,
                                    'url' => false ) );
                                    
    //$Result['reverse_path'] = $Result['path'];
    
}

                 
?>