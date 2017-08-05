{*
Title: Treemenu 2 menu_display
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Paul Forsyth, Tony Wood, Helen Wood
Version: $Id: menu_display.tpl,v 1.3 2003/11/04 12:04:08 paulf Exp $
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

{* Explicitly declare used variables *}
{default display_node=$display_node
			selected=$selected
			item_depth=sub($display_node.depth,$menu_node.depth)}

{* Examine the current position and determine which depth decoration should be used. *}
{section show=and(eq($selected,1), eq($#highlight_used_node,'enabled'))}

	{set depth_indicator="/extension/treemenu/design/standard/images/treemenu2/nav-arrow-on.gif"}

{section-else}

	{section show=$item_depth|gt(2)}

		{set depth_indicator="0"}	

	{section-else}

		{section show=and(eq($contains_node, 1), ne($selected,1))}

			{set depth_indicator="/extension/treemenu/design/standard/images/treemenu2/nav-arrow-down.gif"}

		{section-else}

			{set depth_indicator="/extension/treemenu/design/standard/images/treemenu2/nav-arrow.gif"}

		{/section}

	{/section}

{/section}					

{* Include the correct template according to class id *}
{switch match=$display_node.object.contentclass_id}

	{case match=$#folder_class_id}

		{include uri="design:treemenu2/classes/folder.tpl" display_node=$display_node selected=$selected item_depth=$item_depth depth_indicator=$depth_indicator}

	{/case}

	{case match=$#article_class_id}

		{include uri="design:treemenu2/classes/article.tpl" display_node=$display_node selected=$selected item_depth=$item_depth depth_indicator=$depth_indicator}
		
	{/case}

{/switch}

{/default}