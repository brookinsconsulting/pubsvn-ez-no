README FOR THE GLOSSARY OPERATOR
--------------------------------


>---------------------------------------------------------------
What does the glossary operator do?
>---------------------------------------------------------------
The glossary operator scans a given text for glossary words. If it finds one or more 
matches, it will add a link to the item in the glossary.


>---------------------------------------------------------------
What is "the glossary"?
>---------------------------------------------------------------
The glossary itself is nothing more than a folder (Class Folder) in the EZP content tree. 
The "DefaultGlossaryNodeID" in glossary.ini should point to your default glossary node 
(you can have multiple glossary nodes for the various sections, this variable is just a fallback).


>---------------------------------------------------------------
A glossary contains keywords. How do you create keywords and
have the operator use them?
>---------------------------------------------------------------
The keywords of the glossary are actually objects in the glossary node. You can add objects 
of any class to the glossary node. The actual keyword is the name of the object (the name of 
the object is what you see in the admin interface when navigating through the content tree). 

If you add an article to the glossary, and you set the title to "Thomas", the glossary 
operator will look for "Thomas" in the text it's given. As I said, any class can be used in 
the glossary node. You can also add subfolders to that node, the operator will "walk the tree".

From release 2 and newer, you can also specify which contentobject attribute to use for 
the keyword (see glossary.ini).


>---------------------------------------------------------------
What happens when the operator finds a keyword inside the text
it has to scan?
>---------------------------------------------------------------
The glossary operator links to the corresponding contentobject in the glossary. It
automatically determines whether your site is using nice URLs or not, and adjusts the 
links accordingly.

This is guaranteed to work on any site. Don't worry about the siteaccess or the 
index.php (for non-virtual host setups); the operator deals with them automatically.


>---------------------------------------------------------------
What is the short description?
>---------------------------------------------------------------
The short description is a brief explanation of the glossary keyword. Use glossary.ini
to specify which attribute should be used for the short description (e.g. the Intro of
an Article). This is a per-class setting.

The short description for a glossary word appears in a tooltip-like popup.



>---------------------------------------------------------------
The glossary.ini file contains a setting called 
GlossarySections[]. Are those sections automatically "glossaried"
>---------------------------------------------------------------
Not automatically. The operator is a template operator, so you have to use it 
in a template. This setting in glossary.ini makes it possible to enable/disable 
sections without having to use separate templates per section. This comes in 
handy when several sections use the same layout for a certain Class, but you 
don't want some sections to be affected by the glossary.

The necessary checks have to be in the template too. The code to do this is also in 
glossary.ini.





Version history:
----------------
* Release 1: initial release

* Release 1.1: bugfix release

* Release 2:
	- Hardcoded index.php + demo siteaccess removed.
		The operator now determines whether you need index.php
		in URLs + the current siteaccess.
	- Tags that should never be replaced are now an ini setting.
	- Restructured glossary.ini
	- Added site.ini.append.php
		The AutoLoadPathList is now automatically changed instead
		of a manual change. You only need to activate the extension
		now.
	- Glossary keywords are no longer limited to an Object's name attribute
		You can specify which attribute of a class to use for the glossary
		keyword. See glossary.ini
	- Rewritten code that builds the replacement array
		Both keyword and description field have support for simple
		datatypes. The description also adds support for ezxmltext.
	- Released 20 Oct. 2003

* Release 3:
	- Added support for nice URLs. The operator will adapt to your site's settings
	- Fixed bug that caused nested links when using uppercase words in the glossary
	- Fixed bug that caused skipping of terms that should've been highlighted.
	- Completely new way of replacing words. No more complex regular expressions :)
	- Prepared the data arrays to return more info in the future.
	- Moved preg_replace callback functions inside the operator's class
	- Now uses the "autoloads" directory in the extension. "kernel" is gone
	- Complete rewrite of the internals: optimised code resulting in less memory usage
	  and less SQL queries (+/- 1 per object in the glossary)
	- Added 'fast' execution mode: this mode uses direct database calls. 'normal' mode is default.
	- Committed to trunk: 14 March 2004
	- Revised on 19 march 2004 & 22 march 2004



Disclaimer & Copyright:
-----------------------
/*
    Glossary extension for eZ publish 3.x
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

This operator was developed as part of knowledge management projects inside the
Belgian Nuclear Research Centre (http://www.sckcen.be).

The operator is tailored to fit our needs, and is shared with the community as is.
YMMV!