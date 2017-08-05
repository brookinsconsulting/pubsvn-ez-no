{*
Title: Treemenu 2 article view
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Paul Forsyth, Tony Wood, Helen Wood
Version: $Id: article.tpl,v 1.2 2003/11/04 12:04:08 paulf Exp $
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

<tr>
		{section show=$depth_indicator|compare("0")}
			<td class="vsidemenu-arrow" width="7"></td>
		{section-else}
			<td class="vsidemenu-arrow" width="7"><img src={$depth_indicator} border="0" alt="*"/></td>
		{/section}

	<td class="vsidemenu-link"><a href={$display_node.url_alias|ezurl}>{$display_node.name}</a></td>
</tr>
