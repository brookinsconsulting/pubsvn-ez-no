{*
Title: Treemenu 2 build_menu
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Paul Forsyth, Tony Wood, Helen Wood
Version: $Id: build_menu.tpl,v 1.3 2003/11/04 12:04:08 paulf Exp $
Licence:

	This file may be distributed and/or modified under the terms of the
	"GNU General Public License" version 2 as published by the Free
	 Software Foundation
	
	This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
	THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
	PURPOSE.
	
	The "GNU General Public License" (GPL) is available at http://www.gnu.org/copyleft/gpl.html.
	
	Contact licence@visionwt.com if any conditions of this licencing isn't clear to you.

*}

{* Loop through all menu items *}
{section loop=$menu_items}

	{* Find if this node has children *}
	{set new_menu_items=fetch(content, list, hash(parent_node_id,$:item.node_id,
																				sort_by,array(array(priority)), 
																				class_filter_type, "include", 
																				class_filter_array, $#included_classes))}

	{* Test whether the current node is within the current tree. If so set 'contains_node' to 1. *}
	{section show=and($path_array_count|gt($:item.depth), eq($:item.path_array[$:item.depth], $path_array[$:item.depth]))}

		{* Examine whether the current node is same as the current position. If so set 'selected' to 1 otherwise keep it as '0' *}
		{section show=eq($:item.node_id, $current_node.node_id)}

			{include uri="design:treemenu2/menu_display.tpl" display_node=$:item selected=1 contains_node=1 found_node=$found_node}

		{section-else}

			{include uri="design:treemenu2/menu_display.tpl" display_node=$:item selected=0 contains_node=1 found_node=$found_node}

		{/section}

		{* If there are children recurse *}
		{section show=count($new_menu_items)|gt(0)}

			{include uri="design:treemenu2/build_menu.tpl" selected=0 menu_items=$new_menu_items contains_node=1 found_node=1}

		{section-else}

			{* Otherwise record that the node has been found *}
			{set found_node=1}

		{/section}

	{section-else}
	
		{* If there are children recurse *}
		{section show=and(count($new_menu_items)|gt(0), eq($#display_other_children,'enabled')) }
			
			{* Display the current item, then recurse *}
			{include uri="design:treemenu2/menu_display.tpl" display_node=$:item selected=0 contains_node=0 found_node=$found_node}

			{include uri="design:treemenu2/build_menu.tpl" selected=0 menu_items=$new_menu_items contains_node=0 found_node=$found_node}

		{section-else}

			{* Display the current item. *}
			{include uri="design:treemenu2/menu_display.tpl" display_node=$:item selected=0 contains_node=0 found_node=$found_node}

		{/section}

	{/section}

{/section}
