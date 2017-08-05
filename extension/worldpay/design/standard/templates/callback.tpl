{*
Title: Callback information display template
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Tony Wood
Version: $Id: callback.tpl,v 1.6 2003/12/10 15:00:52 tony Exp $
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


<table width="550" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="17px" ></td>
	<td>
    
    <h1>Payment screen</h1>
    
    {section show=eq($status,0)}
        <p>
        There has been a problem with your order please contact me@myaddress.<br>
       
        <a href="http://www.visionwt.com">Return</a>
    	</p>   
 	{/section}
    
    
    {section show=eq($status,1)}
        <p>
        Thank you {$name} for your payment of {$amount}.
        </p>
        <a href="http://www.visionwt.com/{$order_id}">View your order</a>
        
    {/section}
    
    {section show=eq($status,2)}
        <p>
        There has been a problem with your order please contact sales@myaddress.com 
        </p>
        <a href="http://www.visionwt.com">Order has not been accepted</a>
    {/section}
    
	<p>
    <WPDISPLAY ITEM=banner>
	</p>

	</td>
</tr>
</table>
