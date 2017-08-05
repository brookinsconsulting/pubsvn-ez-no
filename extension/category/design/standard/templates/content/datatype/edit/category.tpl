{*
Title: Category datatype content edit view
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Paul Forsyth
Version: $Id: category.tpl,v 1.3 2003/12/15 15:17:31 paulf Exp $
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
<input class="box" type="text" size="70" name="ContentObjectAttribute_Category_data_{$attribute.id}" value="{$attribute.content.category_string|wash(xhtml)}" />
