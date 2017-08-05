<?php
//
// templatedatalistoperator.php, creates a datalist used for displaying a dynamic list.
//
// Created on: <27-Feb-2005 11:00:00 oh>
// Version: 0.9 beta
// Created by: Sebastiaan van der Vliet, sebastiaan@contactivity.com
// Contactivity bv, Leiden the Netherlands
// info@contactivity.com, http://www.contactivity.com
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE.GPL included in
// the packaging of this file.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//


include_once( 'kernel/classes/ezcontentobjecttreenode.php' );
include_once( 'kernel/classes/ezcontentobject.php' );
include_once( 'kernel/common/eztemplatedesignresource.php' );
include_once( 'lib/ezfile/classes/ezdir.php' );

class TemplateDatalistOperator
{

    function TemplateDatalistOperator()
    {
    }

    function operatorList()
    {
        return array( 'datalist' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'datalist' => array( 'first_param' => array( 'type' => 'integer',
                                                                    'required' => true,
                                                                    'default' => 2 ) ) );
    }

    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'datalist':
            {

            		//set the node from which the objects are selected

					$NodeID=$namedParameters['first_param'];
					$node = eZContentObjectTreeNode::fetch( $NodeID );
					$nodePath =  $node->attribute( 'path_string' );
					$nodeDepth = $node->attribute( 'depth' );
					$childrensPath = $nodePath ;
					$pathString = " path_string like '$childrensPath%' ";

					//display of 1000's of items requires bypassing standard ezp functionality.
					//the ezp way would be: eZContentObjectTreeNode::subTree( array( 'Depth' => $depth, 'Limit' => $limit ),$NodeID);
					//with depth and limit set to match your own requirements.
					//PLEASE NOTE: read permission check is not yet implemented!

					$query = "SELECT ezcontentobject.id, ezcontentobject_name.name AS name, ezcontentobject_tree.node_id AS node_id
					FROM ezcontentobject_tree, ezcontentobject, ezcontentclass, ezcontentobject_name
					WHERE $pathString
					AND ezcontentclass.version = 0
					AND ezcontentobject_tree.contentobject_id = ezcontentobject.id
					AND ezcontentclass.id = ezcontentobject.contentclass_id
					AND ezcontentobject_tree.contentobject_is_published =1
					AND ezcontentobject_tree.contentobject_id = ezcontentobject_name.contentobject_id
					AND ezcontentobject_tree.contentobject_version = ezcontentobject_name.content_version
					AND ezcontentobject_name.content_translation =  'eng-GB'
					ORDER  BY ezcontentobject_name.name ASC";
					$db =& eZDB::instance();
					$objectlist=$db->arrayQuery($query);

					$Buffer = array();
					$Buffer[]="ID|NAME|NODE|CHECKED";

					foreach ($objectlist as $objectitem)
					{
						$Buffer[]="~".$objectitem['id']."|".str_replace("\"", "'",$objectitem['name'])."|".$objectitem['node_id'];
					}

					$operatorValue=implode("", $Buffer);

            } break;
        }
    }
}

?>
