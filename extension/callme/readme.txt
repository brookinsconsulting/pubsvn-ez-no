Callme module
-----------------------

This callme module provides a simple mechanism for passing information from 
one template to the module which then displays a form for sending further information
to someone from your site. When submitted a thank you screen is shown. The format of the email
can be controlled.

Example of usage:

http://<your-site>/callme/callme?about=Anything%20and%20everything

This module is similar in function to the information collector functions. It was written
to avoid a caching issue we found when passing information from one template to another. This may or may 
have been fixed by now. Forum threads suggest a cache time-out feature can be used but we have not
tested this.

Most of the design from the original site has been taken out. Please adjust according to your needs.

An example of this in use can be found here:

http://www.pobox.co.uk/services/hosting/linux_servers

The naming of the module and views could be better :)

Installation
-----------------

Follow these steps to add the Callme module to your ezp installation:

  1) Extract the archive into the /extension directory
  
  2) Edit site.ini.append in /settings/override. Add the following to the file:

       [ExtensionSettings]
       ActiveExtensions[]=callme

     If you already have the [ExtensionSettings] block, just add the second line.

  3) Edit the role permissions for the user to give read access to the new
     module. Normally this is for the anonymous user.

Licence
------------

This file may be distributed and/or modified under the terms of the
"GNU General Public License" version 2 as published by the Free
 Software Foundation

This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.

The "GNU General Public License" (GPL) is available at http://www.gnu.org/copyleft/gpl.html.

Contact licence@visionwt.com if any conditions of this licencing isn't clear to you.

