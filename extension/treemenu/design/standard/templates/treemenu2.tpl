{*
Title: Treemenu 2
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Paul Forsyth, Tony Wood, Helen Wood
Version: $Id: treemenu2.tpl,v 1.4 2003/11/04 12:04:08 paulf Exp $
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

{cache-block keys=array('treemenu2', $DesignKeys:used.node)}

{let start_node_id=ezini('Settings','Home','treemenu.ini')
     highlight_used_node=ezini('Settings','HighlightUsedNode','treemenu.ini')
     display_other_children=ezini('Settings','WithChildren','treemenu.ini')

     is_dynamic=ezini('Settings','Dynamic','treemenu.ini')
     hide_if_home_not_in_path=ezini('Settings','HideIfHomeNotInPath','treemenu.ini')
     fallback_if_used_node_without_children=ezini('Settings','FallbackIfUsedNodeWithoutChildren','treemenu.ini')

	folder_class_id=1
	article_class_id=2
	home_node_id=47

	current_node=fetch('content','node',hash(node_id, $DesignKeys:used.node))
	menu_node=fetch('content','node',hash(node_id,$start_node_id))

	path_array=$current_node.path_array
	path_array_count=count($path_array)

	included_classes=array($folder_class_id, 
											$article_class_id)

	new_menu_items=0
	depth_indicator=0
	menu_items=fetch(content, list, hash(parent_node_id,$start_node_id,
																sort_by,array(array(priority)),
																class_filter_type, "include",
																class_filter_array, $#included_classes))
}

{* Link the stylesheet to control the menu presentation *}
<link rel="stylesheet" type="text/css" href="/extension/treemenu/design/standard/stylesheets/treemenu2.css" /> 

<table width="100%"  border="0" cellspacing="0" cellpadding="0">

<tr>
	<td class="vsidemenu-line" colspan="2"><img src="/extension/treemenu/design/standard/images/treemenu2/nav-dotsline.gif" height="2" width ="164" hspace="0" vspace="0"  border="0" alt="*"/></td>
</tr>
<tr>
	{* Perform a special check for a top level link to the home page *}
	{section show=and(eq($home_node_id, $current_node.node_id), eq($#highlight_used_node,'enabled'))}

		<td class="vsidemenu-arrow" width="7"><img src="/extension/treemenu/design/standard/images/treemenu2/nav-arrow-on.gif" border="0" alt="*"/></td>

	{section-else}

		<td class="vsidemenu-arrow" width="7"><img src="/extension/treemenu/design/standard/images/treemenu2/nav-arrow.gif" border="0" alt="*"/></td>

	{/section}

		<td class="vsidemenu-top"><a href={''|ezurl}>Home</a></td>
</tr>

{* Start the menu by including the recursive menu *}
{include uri="design:treemenu2/build_menu.tpl" menu_items=$menu_items contains_node=0 found_node=0}

{* Finish the menu off by display the line *}
<tr>
	<td class="vsidemenu-line" colspan="2"><img src="/extension/treemenu/design/standard/images/treemenu2/nav-dotsline.gif" height="2" width ="164" hspace="0" vspace="0"  border="0" alt="*"/></td>
</tr>

</table>

{/let}

{/cache-block}																			
