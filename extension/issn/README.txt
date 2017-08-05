ISSN Datatype
-------------


0. Intro
--------
The ISSN (International Standard Serial Number) is an eight-digit number which
identifies periodical publications as such, including electronic serials.
See http://www.issn.org for more information

The structure of an ISSN is similar to an ISBN, but the ISBN datatype can't be used
for an ISSN. That's why we developed the ISSN datatype.

The ISSN datatype is based on the standard ezp 3.x ISBN datatype, and is made as an
extension so it shouldn't cause any problems for future upgrades.



1. Installation
---------------
Follow these steps to add the ISSN datatype to your ezp installation:

  1) Extract the archive into the /extension directory
  
  2) Edit site.ini.append in /settings/override. Add the following to the file:

       [ExtensionSettings]
       ActiveExtensions[]=issn

     If you already have the [ExtensionSettings] block, just add the second line.

That's it! :)

NOTE: If you renamed the "issn" folder after extracting the archive, don't forget to
      check the "settings" folder of the extension or it won't work.



2. Features
-----------
- Adds ISSN datatype when creating/editing a class
- Checks the entered ISSN: (1) valid format or not, (2) valid number or not
- Translation of text strings is possible



3. Info
-------
/*
    ISSN Datatype extension for eZ publish 3.x
    Copyright (C) 2003  SCK•CEN (Belgian Nuclear Research Centre)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

This datatype is developed in the framework of knowledge management portals of the 
SCK-CEN (Belgian Nuclear Research Centre).

Developed by Hans Melis (hmelis@sckcen.be).
