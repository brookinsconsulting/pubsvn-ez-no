
Object Relation Browse Datatype
-------------------------------

/*
    Object Relation Browse extension for eZ publish 3.4/3.5+
    Developed by Contactivity bv, Leiden the Netherlands
    http://www.contactivity.com, info@contactivity.com
    

    This file may be distributed and/or modified under the terms of the
    GNU General Public License" version 2 as published by the Free
    Software Foundation and appearing in the file LICENSE.GPL included in
    the packaging of this file.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    The "GNU General Public License" (GPL) is available at
    http://www.gnu.org/copyleft/gpl.html.
    
    
*/


1. Context
----------
One of the most powerful features of eZ publish 3 is the option to create relationships between all kinds of objects. However, the standard 'browse' method used to relate items proved to be too cumbersome when working with a large number of objects (>100.000) and many relations (>10) per object.


We needed a datatype that would:
- display all available objects for relation in a single list;
- provide functionality to dynamically filter objects from the list;
- allow the selection of multiple objects from a list in a single "browse & select" action; 
- store the object relation between objects, so that it would become possible to look up reverse relationships.


2. Features
-----------
We have created the objectrelationbrowse datatype to:
- display all available objects in a single, dynamically filterable list that may contain over 20.000 objects (see:dynamic_list.png);
- handle a one to one or one to many relationships; and
- store the object relation between objects so a reverse object relation becomes available.

Moreover,
- instead of the standard browse or the dynamic list, it is also possible to display lists as listboxes, dropdowns or checkboxes (see: class_edit.png).


3. Example of use
-----------------
For an online library project we used the datatype to manage relationships between authors (>35.000 objects) and publications (>20.000 objects), publications and topics (>20.000 terms), users and transactions. 


4. Known bugs, limitations, etc.
-----------------------------
The datatype has the following limitations and bugs:
- The dynamically filterable list of objects in only available in Microsoft Internet Explorer on the Windows platform, with ActiveX enabled. If another browser is used to display the datatype, the standard 'browse' page is shown; 
- Due to eZ publish's  problems with very long lists of objects, the operator that creates the list bypasses the standard eZ publish functionality, and makes a direct query on the database. As a result the script does not take into account user permissions, nor does it exclude the node that will link to the related objects;
- Debug needs to be disabled for the display of the dynamic list;
- The datatype introduces an override for the standard browse template; and
- Information collection functionality is not supported;
 

5. Feedback
--------------------------------
Please send all remarks, comments and suggestions for improvement to info@contactivity.com.


6. Disclaimer
-------------------------
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.


7. Acknowledgements
-------------------------
The development of this datatype was paid for by the IRC International Water and Sanitation Centre (http://www.irc.nl/), for use in their online library.
