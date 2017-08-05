{*
Title: Callme main template
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Tony Wood
Version: $Id: callme.tpl,v 1.5 2003/11/06 11:35:23 paulf Exp $
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

<table  width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td>
		<h1>Call Me about: {$callme_about}</h1>
	</td>
</tr>
<tr>
	<td>
		* Required fields are indicated below

		<form method="post" action="/callme/thankyou">
		
		<table bgcolor="#f0f0f0" cellspacing="0" cellpadding="0" border="0">
		<tr>
		    <td>Your name*</td>
			<td><input class="box" type="text" size="70" name="name" value="" /></td>
		</tr>
		<tr>
		    <td>Email address*</td>
			<td><input class="box" type="text" size="70" name="email" value="" /></td>
		</tr>
		<tr>
		    <td>Telephone number*</td>
			<td><input class="box" type="text" size="70" name="tel" value="" /></td>
		</tr>
		<tr>
		    <td>Company</td>
			<td><input class="box" type="text" size="70" name="company" value="" /></td>
		</tr>
		<tr>
		    <td>Company website</td>
			<td><input class="box" type="text" size="70" name="website" value="" /></td>
		</tr>
		<tr>
		    <td colspan="2">
			Interest:
			<input class="box" type="text" size="70" name="interest" value="I am interested in: {$callme_about}" />
			</td>
		</tr>
		<tr>
		<td colspan="2">
		    <div class="block">
				<input type="submit" align="middle" border="0" alt="Submit enquiry" name="submit" value="submit"/>
		    </div>
		</td>
		</tr>
		</table>
			
		</form>
	</td>
	</tr>
</table>
