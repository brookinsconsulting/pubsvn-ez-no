<?php
include_once( 'kernel/classes/datatypes/ezenum/ezenumtype.php' ); 

define( "EZ_IMPORT_PRESERVED_KEY_NODE_ID", "node_id" );

class eZImportProcess
{
	var $options;
	function eZImportProcess()
	{
		
	}
	function &instance( $processHandler )
	{
		ext_class( "import" ,  "ez" . $processHandler . "process" );
		$processHandlerName = "ez" . $processHandler . "process";
		$processHandlerImp = new $processHandlerName();
		return $processHandlerImp;
	}
	function run( &$data )
	{
	
	}
	function setOptions( $array = array () )
	{
		$this->options = $array;
	}
	function store_attr( $data, &$contentObjectAttribute )
	{
    $contentClassAttribute = $contentObjectAttribute->attribute( 'contentclass_attribute' );
    $dataTypeString = $contentClassAttribute->attribute( 'data_type_string' );
    switch( $dataTypeString ) {
        case 'ezfloat' :
            $contentObjectAttribute->SetAttribute( 'data_float', $data );
            $contentObjectAttribute->store();
            break;
        case 'ezprice' :
            $contentObjectAttribute->SetAttribute( 'data_float', $data );
            $contentObjectAttribute->store();
            break;
        case 'ezboolean' :
            $contentObjectAttribute->SetAttribute( 'data_int', $data );
            $contentObjectAttribute->store();
        case 'ezdate' :
            $contentObjectAttribute->SetAttribute( 'data_int', $data );
            $contentObjectAttribute->store();
        case 'ezdatetime' :
            $contentObjectAttribute->SetAttribute( 'data_int', $data );
            $contentObjectAttribute->store();
        case 'ezinteger' :
            $contentObjectAttribute->SetAttribute( 'data_int', $data );
            $contentObjectAttribute->store();
        case 'ezsubtreesubscription' :
            
        case 'eztime' :
            $contentObjectAttribute->SetAttribute( 'data_int', $data );
            $contentObjectAttribute->store();
            break;
        case 'ezemail' :
        case 'ezisbn' :
        case 'ezstring' :
        case 'eztext' :
            $contentObjectAttribute->SetAttribute( 'data_text', $data );
            $contentObjectAttribute->store();
        case 'ezurl' :
            $contentObjectAttribute->SetAttribute( 'data_text', $data );
            $contentObjectAttribute->store();
            break;
        case 'ezxmltext' :
            $dummy = "";
            $converter = new text2xml( $dummy, 0, $contentObjectAttribute );
            $converter->validateText( $data, $contentObjectAttribute );
            $contentObjectAttribute->SetAttribute( 'data_int', EZ_XMLTEXT_VERSION_TIMESTAMP );
            $contentObjectAttribute->store();
            break;
        case 'ezenum' :
            if( is_array( $data )) {
                store_enum( $data, $contentObjectAttribute );
            } else {
                store_enum( array( $data ), $contentObjectAttribute );
            }
            break;
        default :
            die( 'Can not store this datatype: ' . $dataTypeString );
    }
}

function store_enum( $array_selectedEnumElement, &$contentObjectAttribute )
{
    // Adapted from function fetchObjectAttributeHTTPInput(...) in class eZEnumType;
    $contentObjectAttributeID = $contentObjectAttribute->attribute( 'id' );
    $contentObjectAttributeVersion = $contentObjectAttribute->attribute( 'version' );
    $contentClassAttribute = $contentObjectAttribute->attribute( 'contentclass_attribute' );
    $contentClassAttributeID = $contentClassAttribute->attribute('id' );
    $contentClassAttributeVersion = $contentClassAttribute->attribute('version' );
    $array_enumValue = ezEnumValue::fetchAllElements( $contentClassAttributeID, 
                                                      $contentClassAttributeVersion );
    eZEnum::removeObjectEnumerations( $contentObjectAttributeID, $contentObjectAttributeVersion );
    foreach( $array_enumValue as $enumValue ) 
    {
        foreach( $array_selectedEnumElement as $selectedEnumElement ) 
        {
            if( $enumValue->EnumValue === $selectedEnumElement ) 
            {
                eZEnum::storeObjectEnumeration( $contentObjectAttributeID, 
                        $contentObjectAttributeVersion, $enumValue->ID, 
                        $enumValue->EnumElement, $enumValue->EnumValue );
            	}
        	}
    	}
	}
}

include_once( 'kernel/classes/datatypes/ezxmltext/handlers/input/ezsimplifiedxmlinput.php' );
class text2xml extends eZSimplifiedXMLInput
{
    function text2xml( &$xmlData, $contentObjectAttribute )
    {
        $this->eZSimplifiedXMLInput( $xmlData, 0, $contentObjectAttribute );
    }
	function &validateText( &$data, &$contentObjectAttribute )
    {
        $contentObjectAttributeID = $contentObjectAttribute->attribute( "id" );
        // Below is same as in the function validateInput(...) in class eZSimplifiedXMLInput
        eZDebug::writeDebug($data, "input data");
        // Set original input to a global variable
        $originalInput = "originalInput_" . $contentObjectAttributeID;
        $GLOBALS[$originalInput] = $data;

        // Set input valid true to a global variable
        $isInputValid = "isInputValid_" . $contentObjectAttributeID;
        $GLOBALS[$isInputValid] = true;

        $inputData = "<section xmlns:image='http://ez.no/namespaces/ezpublish3/image/' 
                                xmlns:xhtml='http://ez.no/namespaces/ezpublish3/xhtml/' >";
        $inputData .= "<paragraph>";
        $inputData .= $data;
        $inputData .= "</paragraph>";
        $inputData .= "</section>";

        $data =& $this->convertInput( $inputData );
        $message = $data[1];
        if ( $this->IsInputValid == false )
        {
            $GLOBALS[$isInputValid] = false;
            $errorMessage = null;
            foreach ( $message as $line )
            {
                $errorMessage .= $line .";";
            }
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                 $errorMessage,
                                                                 'ezXMLTextType' ) );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }
        else
        {
            $dom = $data[0];
            $objects =& $dom->elementsByName( 'object' );
            if ( $objects !== null )
            {
                foreach ( array_keys( $objects ) as $objectKey )
                {
                    $object =& $objects[$objectKey];
                    $objectID = $object->attributeValue( 'id' );
                    $currentObject =& eZContentObject::fetch( $objectID );
                    $editVersion = $contentObjectAttribute->attribute('version');
                    $editObjectID = $contentObjectAttribute->attribute('contentobject_id');
                    $editObject =& eZContentObject::fetch( $editObjectID );
                    if ( $currentObject == null )
                    {
                        $GLOBALS[$isInputValid] = false;
                        $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                'Object '. $objectID .' does not exist.', 'ezXMLTextType' ) );
                        return EZ_INPUT_VALIDATOR_STATE_INVALID;
                    }
                    else
                    {
                        $relatedObjects =& $editObject->relatedContentObjectArray( $editVersion );
                        $relatedObjectIDArray = array();
                        foreach ( $relatedObjects as $relatedObject )
                        {
                            $relatedObjectID = $relatedObject->attribute( 'id' );
                            $relatedObjectIDArray[] = $relatedObjectID;
                        }
                        if ( !in_array( $objectID, $relatedObjectIDArray ) )
                        {
                            $editObject->addContentObjectRelation( $objectID, $editVersion );
                        }
                    }

                    // If there are any image object with links.
                    $href = $object->attributeValueNS( 'ezurl_href',
                                'http://ez.no/namespaces/ezpublish3/image/' );
                    $urlID = $object->attributeValueNS( 'ezurl_id', 
                                'http://ez.no/namespaces/ezpublish3/image/' );

                    if ( $href != null )
                    {
                        $linkID =& eZURL::registerURL( $href );
                        $object->appendAttribute( $dom->createAttributeNodeNS(
                                'http://ez.no/namespaces/ezpublish3/image/', 'image:ezurl_id', $linkID ) );
                        $object->removeNamedAttribute( 'ezurl_href' );
                    }

                    if ( $urlID != null )
                    {
                        $url =& eZURL::url( $urlID );
                        if ( $url == null )
                        {
                            $GLOBALS[$isInputValid] = false;
                            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                    'Link '. $urlID .' does not exist.', 'ezXMLTextType' ) );
                            return EZ_INPUT_VALIDATOR_STATE_INVALID;
                        }
                    }
                }
            }
            $links =& $dom->elementsByName( 'link' );

            if ( $links !== null )
            {
                foreach ( array_keys( $links ) as $linkKey )
                {
                    $link =& $links[$linkKey];
                    if ( $link->attributeValue( 'id' ) != null )
                    {
                        $linkID = $link->attributeValue( 'id' );
                        $url =& eZURL::url( $linkID );
                        if ( $url == null )
                        {
                            $GLOBALS[$isInputValid] = false;
                            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                    'Link '. $linkID .' does not exist.', 'ezXMLTextType' ) );
                            return EZ_INPUT_VALIDATOR_STATE_INVALID;
                        }
                    }
                    if ( $link->attributeValue( 'href' ) != null )
                    {
                        $url = $link->attributeValue( 'href' );
                        $linkID =& eZURL::registerURL( $url );
                        $link->appendAttribute( $dom->createAttributeNode( 'id', $linkID ) );
                        $link->removeNamedAttribute( 'href' );
                    }
                }
            }

            $domString = $dom->toString();

   eZDebug::writeDebug($domString, "unprocessed xml");
   $domString = preg_replace( "#<paragraph> </paragraph>#", "<paragraph> </paragraph>", $domString );
   $domString = str_replace ( "<paragraph />" , "", $domString );
   $domString = str_replace ( "<line />" , "", $domString );
   $domString = str_replace ( "<paragraph></paragraph>" , "", $domString );
   //$domString = preg_replace( "#>[W]+<#", "><", $domString );
   $domString = preg_replace( "#<paragraph> </paragraph>#", "<paragraph />", $domString );
   $domString = preg_replace( "#<paragraph></paragraph>#", "", $domString );

   $domString = preg_replace( "#[\n]+#", "", $domString );
   $domString = preg_replace( "#</LINE>#", "\n", $domString );
   $domString = preg_replace( "#<PARAGRAPH>#", "\n\n", $domString );
   
            $xml = new eZXML();
            $tmpDom =& $xml->domTree( $domString, array( 'CharsetConversion' => false ) );
//                 $domString = $tmpDom->toString();
            $domString = eZXMLTextType::domString( $tmpDom );


            $contentObjectAttribute->setAttribute( "data_text", $domString );
            $contentObjectAttribute->setValidationLog( $message );

            $paragraphs = $tmpDom->elementsByName( 'paragraph' );

            $classAttribute =& $contentObjectAttribute->contentClassAttribute();
            if ( $classAttribute->attribute( "is_required" ) == true )
            {
                if ( count( $paragraphs ) == 0 )
                    return EZ_INPUT_VALIDATOR_STATE_INVALID;
                else
                    return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
            }
            else
                return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
        }
        return EZ_INPUT_VALIDATOR_STATE_INVALID;
    }    
}
?>