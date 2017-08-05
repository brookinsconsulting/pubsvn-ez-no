SOAP Administration Extension for eZ publish
============================================

Installation
------------
Unpack the files and place them under the extension directory in your 
eZ publish root folder.

To enable this SOAP extension you need eZ publish 3.6 or later. In 
soap.ini set the following configuration switches:

[GeneralSettings]
EnableSOAP=true

[ExtensionSettings]
SOAPExtentensions[]=soapadmin

Usage
-----
The folowing SOAP functions can be called via this extension. All functions
should use the namespace: http://ez.no/soap/soapadmin.

clearTemplateCache( templateFile : string )

Clears the template cache for the given template file. 
E.g. design/standard/templates/pagelayout.tpl or 
design/mydesign/override/templates/full/article.tpl can be used
as arguments.


clearAllCache()

Clears all cache files in eZ publish.


enableTemplateDebug( enable : boolean )

Enables or disables template debug output in eZ publish.
