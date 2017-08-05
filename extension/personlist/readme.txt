Person List extension for eZ publish 3.x
----------------------------------------

/*
    Person list extension for eZ publish 3.x
    Copyright (C) 2003-2004  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/


1. What is "personlist"?
------------------------
The Personlist datatype can have several functions:
  - an extended author datatype
  - a newsletter datatype
  - ...

It basically allows you to add existing users, or 'external' people (people
that don't have an account in your eZ publish installation) to a list.

Through class level flags, or their overrides on object level, you can activate
email sending each time the object is updated, or only on new objects. With this
functionality you can turn a regular author datatype into e.g. a newsletter
datatype. The email itself is a template that you can customise.



2. How do I install it?
-----------------------
If you install from the zipped archive:

  1) Extract the archive into the 'extension' folder of your eZ publish installation.
     If you don't have an extension folder, please create it.
     After this, you should have a folder called 'personlist' under the 'extension' folder.

  2) Open your site.ini.append(.php) in 'settings/override' and locate the
     '[ExtensionSettings]' block. Add the following line:

     ActiveExtensions[]=personlist

     If you don't have the [ExtensionSettings] block, please add this:
    
     [ExtensionSettings]
     ActiveExtensions[]=personlist

  3) The datatype should now show up during class editing.
  
  4) If you experience template problems (fields not showing up,...), please clear the
     override cache.


If you install from SVN:

  1) Get the latest version from:
     http://pubsvn.ez.no/community/trunk/extension/personlist

  2) Make sure all files go under a folder called 'personlist' in the 'extension' folder.

  3) Follow the "zipped archive" install procedure from step 2 onwards.


Please take a look at 'personlist.ini' in the extension's settings folder for additional options.
Comments are in the file to document the settings.



3. Release history
------------------
v1.0
    - Initial release
    - Release date: Aug 20, 2004

v1.1
    - Added possibility to make the owner of a contentobject the initial value
      of the datatype.
    - Release: Sept 21, 2004



4. Disclaimer & Copyright:
-------------------------
/*
    Person list extension for eZ publish 3.x
    Copyright (C) 2003-2004  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

This datatype was developed as part of knowledge management projects inside the
Belgian Nuclear Research Centre (http://www.sckcen.be).

Developed by: Hans Melis (hmelis [at] sckcen [dot] be)
Tested on: eZ publish 3.4.1

The datatype is tailored to fit our needs, and is shared with the community as is.
YMMV!