{*
Title: Worldpay plain display template
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Tony Wood
Version: $Id: wp_pagelayout.tpl,v 1.6 2003/12/10 15:00:52 tony Exp $
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<link href="/i/9999/favicon.ico" rel="shortcut icon" />
<link rel="stylesheet" type="text/css" href="/i/9999/core.css" />
<link rel="stylesheet" type="text/css" href="/i/9999/troy.css" />

<body class="vbody" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" >


<!-- Main table -->
<table width="750px" align="left" border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td class="vpage-top-gap" colspan="2"></td>
	</tr>
    <tr>
		<td width="1%" height="95px" valign="top"><a href="http://www.visionwt.com/home_page">
    	<img src="/i/9999/pt-logo.gif" hspace="0" vspace="0" border="0" alt="Planet Troy"/></a></td>
    	<td class="vpage-top-bg" height="95px" valign="top">

            <table  style="height: 95px; width: 99%;" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" align="left" class="vuser-text"><img src="/i/9999/im-royaltyfree.gif" height="28px" width="197px" hspace="0" vspace="0" border="0" alt="Royalty Free Images"/>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" align="left"><a href="http://www.visionwt.com/home_page"><img name="Home" src="/i/9999/b-home.gif" height="27" hspace="0" vspace="0"  border="0" alt="Home"/></a><a href="http://www.planet-troy.com/troy/about/about_us" ><img name="About" src="/i/9999/b-about.gif" height="27" hspace="0" vspace="0"  border="0" alt="About Us"/></a><a href="http://www.planet-troy.com/troy/personal/my_account"><img name="MyAccount" src="/i/9999/b-myaccount.gif" height="27" hspace="0" vspace="0"  border="0" alt="My Account"/></a><a href="http://www.planet-troy.com/user/logout"><img name="Logout" src="/i/9999/b-logout.gif" height="27" hspace="0" vspace="0"  border="0" alt="Logout"/></a><a href="http://www.planet-troy.com/troy/contact_us"><img name="Contact" src="/i/9999/b-contact.gif" height="27" hspace="0" vspace="0"  border="0" alt="Contact"/></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
		<td class="vpage-body-gap" colspan="2"></td>
	</tr>
    <tr>
        <td width="185px">
		</td>
		<td class="vcontent-total-content-width" valign="top" align="left">	
        	<table width="100%" height="100%"  border="0" cellspacing="0" cellpadding="0">
			  	<tr>
      				{$module_result.content}
        		</tr>
        		<tr>
	        		{include uri="design:page_footer.tpl"}
    	    	</tr>
        	</table>
		</td>
	</tr>
</table>
</div>

</body>
</html>
