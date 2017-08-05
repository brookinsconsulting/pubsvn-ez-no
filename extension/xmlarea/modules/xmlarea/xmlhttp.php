<?php 

include_once( 'lib/ezutils/classes/ezhttppersistence.php' );
include_once( 'extension/xmlarea/ezxmltext/handlers/input/xmlareaxmlinput.php' );
include_once( 'extension/xmlarea/ezxmltext/handlers/output/xmlareaxmloutput.php' );
include_once( 'kernel/classes/datatypes/ezxmltext/handlers/input/ezsimplifiedxmlinput.php' );
include_once( 'kernel/classes/ezcontentobjectattribute.php' );
include_once( "kernel/common/template.php" );

include_once( 'lib/ezutils/classes/ezhttptool.php' );

$Module =& $Params["Module"];

function input( $attributeField, $input )
{
    $attID = substr( strrchr( $attributeField, "_" ), 1 );

    $att = eZContentObjectAttribute::fetch( $attID );
    $dummy = '';
    $in = new XMLAreaXMLInput( $dummy, null, $att );
    
    $data = $in->jsrsValidateInput( rawurldecode($input) );
    $data[2] = $attributeField;

    
    return jsrsArrayToString( $data, "{)!(}" );
}

function output( $attributeField, $input )
{
    $attID = substr( strrchr( $attributeField, "_" ), 1 );

    $att = eZContentObjectAttribute::fetch( $attID );
    $dummy = '';
    
    $in = new ezSimplifiedXMLInput( $dummy, null, $att );
    
    $inputData = "<section xmlns:image='http://ez.no/namespaces/ezpublish3/image/' xmlns:xhtml='http://ez.no/namespaces/ezpublish3/xhtml/' xmlns:custom='http://ez.no/namespaces/ezpublish3/custom/' >";
    $inputData .= "<paragraph>";
    $inputData .= rawurldecode($input);
    $inputData .= "</paragraph>";
    $inputData .= "</section>";
    
       
    $data = $in->convertInput( $inputData );
    $tmp = eZXMLTextType::domString( $data[0] );
    //return jsrsArrayToString( array($inputData, 'poo'), "{)!(}" );
    
    $in = new XMLAreaXMLInput( $dummy, null, $att );
    
    $data = $in->postConvertInput( $data );
    
    $out = new XMLAreaXMLOutput( $data[0], false );
    $data[0] = $out->outputText();
    //$data[1] = $data[0];
    $data[2] = $attributeField;
        
    return jsrsArrayToString( $data, "{)!(}" );
}

function obj( $custom )
{
    $arr = array();
    $arr = explode( '|', $custom );
    $attstr = '';
                
    for ( $i=0; $i<count( $arr ); $i+=2 )
    {
        if ( isset($arr[$i]) && isset($arr[$i+1]) )
        {
            $name = strtolower( trim( $arr[$i] ) );
            $content = trim( $arr[$i+1] );
            if ( $name != '' && $content != '' )
            {
                switch ( $name )
                {
                    case 'ezurl_id' :
                        $attstr .= "image:ezurl_id='" . $content . "' "; break;
                    case 'ezurl_href' :
                        $attstr .= "image:ezurl_href='" . $content . "' "; break;
                    case 'target' :
                        $attstr .= "image:ezurl_target='" . $content . "' "; break;
                    default :
                        $attstr .= $name . "='" . $content . "' ";
                }
            }
        }
    }
    
    //return jsrsArrayToString( array( '<pre>'.$attstr.'</pre>', '' ), "{)!(}" );
    
    $dom = eZXML::domTree( '<tag><object ' . $attstr . '/></tag>' );
    
    $node = $dom->elementsByName('object');
                    
    $objtpl =& templateInit();
                    
    include_once( 'kernel/classes/datatypes/ezxmltext/ezxmloutputhandler.php' );
                    
    $isBlockTag = true;
                    
    $data = XMLareaXMLOutput::renderObjectTag($objtpl, $node[0], $isBlockTag, true );
    
    return jsrsArrayToString( $data, "{)!(}" );
}

function jsrsArrayToString( $a, $delim ){
  // user function to flatten 1-dim array to string for return to client
  $d = "~";
  if (isset($delim)) $d = $delim;
  return implode($a,$d); 
}


if ( isset( $Params['Func'] ) )
{
    $http =& eZHTTPTool::instance();
    if ( $http->hasPostVariable('content') )
    {
        switch ( $Params['Func'] )
        {
            case 'input':
                if ( $http->hasPostVariable('att') )
                    $output = input( $http->postVariable('att'), $http->postVariable('content') );
                break;
            case 'output':
                if ( $http->hasPostVariable('att') )
                    $output = output( $http->postVariable('att'), $http->postVariable('content') );
                break;
            case 'object':
                $output = obj( $http->postVariable('content') );
                break;
        }
    
		while ( @ob_end_flush() );
		echo $output;
    }
}

eZExecution::cleanExit();




  //jsrsDispatch( "test" );
  

/*  function test($str1,$str2){
  // 2 vars coming in, return array
  //return jsrsArrayToString(array(strtolower($str2), strtoupper($str1), "php" ),"~");
  return jsrsArrayToString( array( $str1, rawurldecode($str2) ), "~");
}*/



/*function custom( $attributeField, $id, $content )
{
    $dom = eZXML::domTree( '<tag><custom name="' . $id . '"></custom></tag>' );

    $node = $dom->elementsByName('custom');
                    
    $custtpl =& templateInit();
                    
    include_once( 'kernel/classes/datatypes/ezxmltext/ezxmloutputhandler.php' );
    
    $tdlevel = 0;
    $seclevel = 1;
    
    
                    
    $data = XMLareaXMLOutput::renderCustomTag($custtpl, $node[0], $seclevel, $tdlevel, rawurldecode($content), true );
    
    //return jsrsArrayToString( array(data, $attributeField ), "{)!(}" );
    
    return jsrsArrayToString( array($data, $attributeField ), "{)!(}" );
}*/
?>