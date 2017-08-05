{*
Title: Treemenu 2 folder view
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Paul Forsyth, Tony Wood, Helen Wood
Version: $Id: folder.tpl,v 1.2 2003/11/04 12:04:08 paulf Exp $
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

{section show=eq($item_depth,1)}
	<tr>
		<td class="vsidemenu-line" colspan="2"><img src="/extension/treemenu/design/standard/images/treemenu2/nav-dotsline.gif" height="2" width ="164" hspace="0" vspace="0"  border="0" alt="*"/></td>
	</tr>
{/section}

<tr>
	<td class="vsidemenu-arrow" width="7"><img src={$depth_indicator} border="0" alt="*"/></td>

	{section show=$item_depth|gt(1)}
		<td class="vsidemenu-sub"><a href={$display_node.url_alias|ezurl}>{attribute_view_gui attribute=$display_node.data_map.name}</a></td>
	{section-else}
		<td class="vsidemenu-top"><a href={$display_node.url_alias|ezurl}>{attribute_view_gui attribute=$display_node.data_map.name}</a></td>
	{/section}
</tr>
