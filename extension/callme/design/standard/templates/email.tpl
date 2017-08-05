{*
Title: Callme email template
Description:  
Copyright: Copyright (c) Vision with Technology Ltd 1997-2003. All rights reserved
Company: Vision with Technology Ltd
Author: Tony Wood
Version: $Id: email.tpl,v 1.4 2003/11/06 11:07:27 paulf Exp $
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

Feedback for Company site: Call Me

Name: {$name}

email: {$email}

Tel: {$tel}

Company: {$company}

Website: {$website}

Interest: {$interest}

{* Use this line to specify the e-mail in the template, can read this from the object to make it dynamic from form *}
{set-block scope=root variable=email_receiver}nospam@visionwt.com{/set-block}

