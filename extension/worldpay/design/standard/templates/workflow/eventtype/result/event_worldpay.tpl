{*
Title: Workflow bounce template
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Tony Wood
Version: $Id: event_worldpay.tpl,v 1.5 2003/12/10 15:00:52 tony Exp $
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

<literal>
<SCRIPT LANGUAGE="JavaScript"><!--
setTimeout('document.worldpayForm.submit()',0);
//--></SCRIPT>
</literal>

<td class="vcontent-gap-width">
</td>
<td class="vcontent-content-width" valign="top">

<form name="worldpayForm" action="https://select.worldpay.com/wcc/purchase" method=POST>

<p>
This screen should automatically take you to the Worldpay screen, if it does not please click on Pay button.<br>
</p>

<input type=hidden name="instId" value="99999">
<input type=hidden name="cartId" value="{$order_id}">
<input type=hidden name="amount" value="{$price}">
<input type=hidden name="currency" value="GBP">
<input type=hidden name="desc" value="{$desc}">
<input type=hidden name="testMode" value="0">{*change to 100 for testing*}
<input type=hidden name="name" value="{$name}">
<input type=hidden name="address" value="{$address}">
<input type=hidden name="postcode" value="{$postcode}">
<input type=hidden name="country" value="GB">
<input type=hidden name="tel" value="{$tel}">
<input type=hidden name="email" value="{$email}">

<input type="hidden" name="fixContact">
<input type="hidden" name="lang" value="en">

<input type=hidden name="M_email" value="{$email}">
<input type=hidden name="M_PHPSESSID" value="{$sessionid}">
<input type=hidden name="M_USERID" value="{$user_id}">
<input type=hidden name="M_ORDERCREATED" value="{$order_created}">

<div class="buttonblock">
<input type="image" src={"buttons/b-pay.gif"|ezimage}  name="pay" onMouseOut={concat('this.src=','buttons/b-pay.gif'|ezimage)} onMouseOver={concat('this.src=','buttons/b-pay-ro.gif'|ezimage)} align="middle" border="0" alt="Pay" />
</div>

</form> 

</td>