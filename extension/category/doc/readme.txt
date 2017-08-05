//
// Category datatype
//
// Copyright (C) 1999-2003 Vision with Technology, All rights reserved.
// http://www.visionwt.com
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation 
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@visionwt.com if any conditions of this licencing isn't clear to
// you.
//
//Author:       Paul Forsyth
//Version:      $Id: readme.txt,v 1.2 2003/12/15 15:31:27 paulf Exp $
//

Category Datatype readme

This datatype provides a simple mechanism to allow objects to control which categories they
belong to. This differs from the ezenum and ezselection datatypes, where control remains with
the class. For sites using categories to control product inventories it is a problem if categories are
managed by the class - any changes needs to force each product to be republished.

Installing
-------------
Add the category as a normal extension within your site.ini

File: site.ini.append.php
[ExtensionSettings]
ExtensionDirectory=extension
ActiveExtensions[]=category

Create the sql table provided in 'update/mysql/category.sql'. This should just be a straight forward addition.
I don't use PostSQL but hopefully the table should work with this too.

Make sure your file permissions are correct. 

If all is well you should be able to add a category datatype to your classes.

Usage
----------
In the object view a text line is provided for text input. Multiple categories are entered by means of seperating
each with a comma, e.g.

"There, are, five, categories, here"

To remove a category when editing simply remove it from the string and save the object.

Future work
------------------
For this to be more useful a management tool must show which products are using which categories and
provide editing functions.


