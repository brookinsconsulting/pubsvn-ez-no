/*
    Gerneric Soap Server for eZ publish
    Copyright (C) 2004  xrow GbR, Hannover Germany

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

Developed by
Björn Dieding   ( bjoern@xrow.de )

State: stable
Dependencies: eZ publish 3.5 and higher

PubSVN:
http://pubsvn.ez.no/viewcvs/community/trunk/extension/soap/

Description:
A gerneric soap server.

It comes with following modules/views

soap/server

=============
Installation
=============
- Copy extension into extenstion folder
- Activate extenstion admin->setup->extensions

=============
Usage
=============
- Place file named "soap.php" with a class named like "eZSOAPmymodule" in your module directory (extension/myextension/modules/mymodule/soap.php) 
- Access your Modules SOAP fucntions like this
    $request = new eZSOAPRequest( 'eZSOAPmymodule::somefunctionname' , 'http:://www.example.com/soap/server/mymodule' );
