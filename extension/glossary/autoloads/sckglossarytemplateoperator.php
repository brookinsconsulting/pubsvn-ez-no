<?php

/*
    Glossary extension for eZ publish 3.x
    Copyright (C) 2003-2004  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

/*!
  \class   SckGlossaryTemplateOperator sckglossarytemplateoperator.php
  \ingroup eZTemplateOperators
  \brief   Handles template operator SckGlossaryTemplateOperator
  \version 3.02
  \date    Tuesday 06 January 2004 9:55:49 pm
  \author  Hans Melis <hmelis@sckcen.be>

  By using SckGlossaryTemplateOperator you can ...

  Example:
\code
{$value|glossary('first',$input2)|wash}
\endcode
*/

/*
If you want to have autoloading of this operator you should create
a eztemplateautoload.php file and add the following code to it.
The autoload file must be placed somewhere specified in AutoloadPath
under the group TemplateSettings in settings/site.ini

$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'sckglossarytemplateoperator.php',
                                    'class' => '$full_class_name',
                                    'operator_names' => array( 'sck_glossary_operator' ) );

*/

include_once( 'kernel/classes/ezurlalias.php' );
include_once( 'kernel/classes/ezcontentobjectattribute.php' );
include_once( "lib/ezutils/classes/ezini.php" );

class SckGlossaryTemplateOperator
{
    /*!
      Constructor, does nothing by default.
    */
    function SckGlossaryTemplateOperator()
    {
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'glossary' );
    }
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        $ini = &eZINI::instance( "glossary.ini" );
        $glossaryRoot = $ini->variable( 'GlossarySettings', 'DefaultGlossaryNodeID' );

        return array( 'glossary' => array( 'mark_once' => array( 'type' => 'boolean',
                    'required' => false,
                    'default' => false ),
                'glossary_root' => array( 'type' => 'numeric',
                    'required' => false,
                    'default' => $glossaryRoot ),
                'return_method' => array( 'type' => 'string',
                    'required' => false,
                    'default' => 'replace' ),
                'exec_mode' => array( 'type' => 'string',
                    'required' => false,
                    'default' => 'normal' ) ) );
    }

    /*!
	  Makes the $search and $replace array ready for usage
	  Takes a tree of arrays as input and outputs 2 arrays
	*/
    function buildArrays( $glossaryTree )
    {
        $search = array();
        $replace = array();
        $plain = array();

        $sys = &eZSys::instance();
        $ini = &eZINI::instance( "glossary.ini" );

        $exempt = $ini->variable( 'GlossarySettings', 'PossibleExceptions' );
        $exempt = preg_quote( implode( '', $exempt ), '/' ); 
        // Loop through each element
        foreach( $glossaryTree as $item )
        {
            $tmp = array(); 
            // All variations of the Name, NAME and name
            $tmp[] = strtoupper( $item["Name"] );
            $tmp[] = strtolower( $item["Name"] );
            $tmp[] = ucfirst( $item["Name"] );

            /*
			* Prevent an upfirst version if it equals the uppercase version
			* This prevents problems when using uppercase glossary words
			* */
            $tmp = array_unique( $tmp ); 
            // Take each variation and make a $replace entry for it
            // the $replace entry contains a link to the full object
            foreach( $tmp as $name )
            {
                $search[] = "/\b" . preg_quote( $name, "/" ) . "(?![$exempt]\w)" . "\b/";
                $replace[] = "<a href=\"" . $sys->indexDir() . "/" . $item["URL"] . "\" title=\"" . strip_tags( $item["Desc"] ) . "\">" . $name . "</a>";
			}
        } 
        // Return both arrays
        $ret[0] = $search;
        $ret[1] = $replace;

        return $ret;
    }

    function flattenGlossaryArray( $glosArray )
    {
        $ret = array();
        $ini = &eZINI::instance( "glossary.ini" );

        foreach( $glosArray as $glosItem )
        {
            if ( preg_match( "/\b" . $glosItem["Name"] . "\b/i", $this->OpValue ) )
            {
                $ret[] = array( "Name" => $glosItem["Name"],
                    "NodeID" => $glosItem["NodeID"],
                    "Desc" => $glosItem["Desc"] );
            }
        }

        return $ret;
    }

    /*!
	* Get info from the objects in the glossary
	* Normal execution mode: use ezp libraries
	* */
    function getNormalInfo( $glossaryRoot )
    {
        $glosIni = &eZINI::instance( 'glossary.ini' );

        $params = array( 'ClassFilterType' => 'exclude',
            'ClassFilterArray' => array( $glosIni->variable( 'GlossarySettings', 'FolderClassID' ) ) );
        $nodes = &eZContentObjectTreeNode::subTree( $params, $glossaryRoot );

        $shortAttribs = $glosIni->variable( 'ShortAttributes', 'ShortAttributes' );
        $nameAttribs = $glosIni->variable( 'NameAttributes', 'NameAttributes' );

        $ret = array();

        foreach( $nodes as $index => $node )
        {
            unset( $obj );
            $obj = &$node->attribute( 'object' );

            $objData = $obj->dataMap();

            $ret[$index]['ClassID'] = $clsID = $obj->attribute( 'contentclass_id' );
            $ret[$index]['ObjectID'] = $obj->attribute( 'id' );
            $ret[$index]['NodeID'] = $node->attribute( 'node_id' );
            $ret[$index]['URL'] = $node->url();

            if ( array_key_exists( $clsID, $shortAttribs ) && array_key_exists( $shortAttribs[$clsID], $objData ) )
            {
                $short = $objData[$shortAttribs[$clsID]]->content();
                $shortClass = get_class( $short );

                if ( $shortClass )
                {
                    switch ( $shortClass )
                    {
                        case "ezxmltext":
                            {
                                $ret[$index]['Desc'] = $short->attribute( 'xml_data' );
                            }
                            break;

                        default:
                            {
                                $ret[$index]['Desc'] = '';
                            }
                    }
                }
                else
                {
                    $ret[$index]['Desc'] = $short;
                }

                $ret[$index]['Desc'] = trim( strip_tags( $ret[$index]['Desc'] ) );
            }
            else
            {
                $ret[$index]['Desc'] = '';
            }

            if ( array_key_exists( $clsID, $nameAttribs ) && array_key_exists( $nameAttribs[$clsID], $objData ) )
            {
                $ret[$index]['Name'] = strip_tags( $objData[$nameAttribs[$clsID]]->content() );
            }
            else
            {
                $ret[$index]['Name'] = $obj->name();
            }
        }

        return $ret;
    }

    /*!
	* Get info from the objects in the glossary
	* Fast execution mode: do lots of DB queries to speed things up
	* */
    function getFastInfo( $glossaryRoot )
    {
        $ret = array();
        $classes = array();

        $glosIni = &eZINI::instance( 'glossary.ini' );
        $ini = &eZINI::instance( 'site.ini' );
        $db = &eZDB::instance();

        $folderClassID = $glosIni->variable( 'GlossarySettings', 'FolderClassID' );
        $glossaryNode = &eZContentObjectTreeNode::fetch( $glossaryRoot );

        $shortAttribs = $glosIni->variable( 'ShortAttributes', 'ShortAttributes' );
        $nameAttribs = $glosIni->variable( 'NameAttributes', 'NameAttributes' );

        $useNiceUrl = $ini->variable( 'URLTranslator', 'Translation' ) == 'enabled' ? true : false; 
        // Get all objects in the glossary
        $objectQuery = "SELECT b.node_id as node_id, a.id as obj_id, a.contentclass_id as class_id, b.path_identification_string as url
		                FROM ezcontentobject as a, ezcontentobject_tree as b
						WHERE b.path_string LIKE '" . $glossaryNode->attribute( 'path_string' ) . "%'
						AND a.id = b.contentobject_id
						AND a.contentclass_id <> $folderClassID";
        $objectRes = $db->arrayQuery( $objectQuery );

        foreach( $objectRes as $key => $object )
        {
            if ( array_key_exists( $object['class_id'], $classes ) === false )
            { 
                // Class hasn't been fetched yet
                if ( array_key_exists( $object['class_id'], $shortAttribs ) )
                {
                    $shortQuery = "SELECT id
					               FROM ezcontentclass_attribute
								   WHERE contentclass_id = " . $object['class_id'] . "
								   AND version = 0
								   AND identifier = '" . $shortAttribs[$object['class_id']] . "'";
                    $shortRes = $db->arrayQuery( $shortQuery );
                    $classes[$object['class_id']]['short'] = $shortRes[0]['id'];
                }
                else
                {
                    $classes[$object['class_id']]['short'] = '';
                }

                if ( array_key_exists( $object['class_id'], $nameAttribs ) )
                {
                    $nameQuery = "SELECT id
					              FROM ezcontentclass_attribute
								  WHERE contentclass_id = " . $object['class_id'] . "
								  AND version = 0
								  AND identifier = '" . $nameAttribs[$object['class_id']] . "'";
                    $nameRes = $db->arrayQuery( $nameQuery );
                    $classes[$object['class_id']]['name'] = $nameRes[0]['id'];
                }
                else
                {
                    $classes[$object['class_id']]['name'] = '';
                }
            } 
            // Everything's ready, retrieve information
            $ret[$key]['NodeID'] = $object['node_id'];
            $ret[$key]['ObjectID'] = $object['obj_id'];
            $ret[$key]['ClassID'] = $object['class_id'];
            $ret[$key]['URL'] = $useNiceUrl ? $object['url'] : 'content/view/full/' . $object['node_id']; 
            // Is there a class attribute for the short info?
            if ( $classes[$object['class_id']]['short'] != '' )
            {
                $classAttrID = $classes[$object['class_id']]['short'];

                $attrQuery = "SELECT id, version
				              FROM ezcontentobject_attribute
							  WHERE contentclassattribute_id = $classAttrID
							  AND contentobject_id = " . $object['obj_id'] . "
							  ORDER BY version DESC
							  LIMIT 0,1";
                $attrRes = $db->arrayQuery( $attrQuery );

                $attrib = &eZContentObjectAttribute::fetch( $attrRes[0]['id'], $attrRes[0]['version'] );

                $short = $attrib->content();
                $shortClass = get_class( $short );

                if ( $shortClass )
                {
                    switch ( $shortClass )
                    {
                        case "ezxmltext":
                            {
                                $ret[$key]['Desc'] = $short->attribute( 'xml_data' );
                            }
                            break;

                        default:
                            {
                                $ret[$key]['Desc'] = '';
                            }
                    }
                }
                else
                {
                    $ret[$key]['Desc'] = $short;
                }

                $ret[$key]['Desc'] = trim( strip_tags( $ret[$key]['Desc'] ) );
            }
            else
            {
                $ret[$key]['Desc'] = '';
            } 
            // Should we use a class attrib for the name?
            if ( $classes[$object['class_id']]['name'] != '' )
            {
                $classAttrID = $classes[$object['class_id']]['name'];

                $attrQuery = "SELECT id, version
				              FROM ezcontentobject_attribute
							  WHERE contentclassattribute_id = $classAttrID
							  AND contentobject_id = " . $object['obj_id'] . "
							  ORDER BY version DESC
							  LIMIT 0,1";
                $attrRes = $db->arrayQuery( $attrQuery );

                $attrib = &eZContentObjectAttribute::fetch( $attrRes[0]['id'], $attrRes[0]['version'] );

                $ret[$key]['Name'] = trim( strip_tags( $attrib->content() ) );
            }
            else
            { 
                // No class attrib, so fetch a name from the DB.
                $obj = eZContentObject::fetch( $object['obj_id'] );

                $nameQuery = "SELECT name
				              FROM ezcontentobject_name
							  WHERE contentobject_id = " . $object['obj_id'] . "
							  AND content_version = " . $obj->attribute( 'current_version' ) . "
							  AND content_translation = '" . $obj->attribute( 'default_language' ) . "'";
                $nameRes = $db->arrayQuery( $nameQuery );

                $ret[$key]['Name'] = $nameRes[0]['name'];
            }
        }

        return $ret;
    }

    /*!
	* Get info from the objects in the glossary
	* */
    function getInfo( $glossaryRoot )
    {
        if ( $this->executionMode == "fast" )
        {
            $ret = $this->getFastInfo( $glossaryRoot );
        }
        else
        {
            $ret = $this->getNormalInfo( $glossaryRoot );
        }

        return $ret;
    }

    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        $markOnce = $namedParameters['mark_once'];
        $glossaryRoot = $namedParameters['glossary_root'];
        $returnMethod = $namedParameters['return_method'];
        $this->executionMode = $namedParameters['exec_mode'];

        switch ( $operatorName )
        {
            case 'glossary':
                { 
                    // Fetch all children of the glossary node, and put their info in an array
                    $resInfo = $this->getInfo( $glossaryRoot ); 
                    // Strip the "dangerous" tags from the $operatorValue.
                    // This is to prevent false matches inside tag attributes
                    $ini = &eZIni::instance( "glossary.ini" );
                    $ignoreTags = $ini->variable( "GlossarySettings", "IgnoreTags" );

                    $res = $this->stripTags( $operatorValue, $ignoreTags );
					
                    $operatorValue = $res[0];
                    $orig_tags = $res[1];
                    $this->OpValue = $operatorValue;

                    switch ( $returnMethod )
                    {
                        case "array":
                            {
                                $this->teller = 0;
                                $res = $this->flattenGlossaryArray( $resInfo );
                                $operatorValue = $res;
                            }
                            break;

                        default:
                            { 
                                // Use the info to build the arrays so we can start replacing
                                $res = $this->buildArrays( $resInfo ); 
                                // $res[0] = what we need to find ; $res[1] = what we need to add
                                $search = $res[0];
                                $replace = $res[1];

                                $keys = array_keys( $replace );
                                for( $i = 0; $i < count( $keys ); $i++ )
                                {
                                    $keys[$i] = "<" . $keys[$i] . ">";
                                } 
                                // Replace every match in $search with the corresponding value from $replace
                                $limit = ( $markOnce === true ? 1 : -1 );

                                $operatorValue = preg_replace( $search, $keys, $operatorValue, $limit );
                                $operatorValue = preg_replace( "/<([0-9]+)>/e", "\$replace[\\1]", $operatorValue );
                            }
                    } 
                    // Now put the stripped tags back into the text
                    $operatorValue = $this->resetTags( $operatorValue, $orig_tags );
                }
                break;
        }
    }

    /*!
	  Strips certain tags from the text
	*/
    function stripTags( $tekst, $tags )
    {
        if ( count( $tags ) > 0 )
        {
            foreach( $tags as $tag )
            { 
                // Regular expressions ;)
                // Use a callback to provide custmomised replacements
                // This searches for <tag.....>.....</tag>
                // If there's a match, it calls the function replaceLink
                $tekst = preg_replace_callback( "/<$tag.*>.*<\/$tag>/i", array( &$this, 'replaceTags' ), $tekst );
            }
        } 
        // global $original_tags;
        // Build an array so we can return multiple vars
        $ret = array(); 
        // The "stripped" text
        $ret[0] = $tekst; 
        // The "stripped" tags
        $ret[1] = $this->original_tags;

        return $ret;
    }

    /*!
	  Callback function for stripTags
	  Replaces a match in stripTags with <skip*> where * is an int >= 0
	*/
    function replaceTags( $match )
    { 
        // Store the tag so it can be re-added later on
        $this->original_tags[$this->teller] = $match[0];
        $this->teller++;
        // Return what we want in place of the tag
        return "<skip" . ( $this->teller - 1 ) . ">";
    }

    /*!
	  Reverse function of stripTags
	  Add the tags in $original_tags back to the text
	*/
    function resetTags( $tekst, $tags )
    {
        $j = 0;
        if ( count( $tags ) > 0 )
        {
            foreach( $tags as $tag )
            { 
                // Replace the generic <skip*> tags with their respective tag in $original_tags
                $tekst = str_replace( "<skip" . $j . ">", $tag, $tekst );
                $j++;
            }
        } 
        // Return the result
        return $tekst;
    }

    var $Operators;
    var $teller = 0;
    var $original_tags;
    var $settings;
    var $OpValue;
    var $executionMode;
}

?>