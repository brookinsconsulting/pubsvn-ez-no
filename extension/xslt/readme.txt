0. Introduction
***************

This template operator creates the possibility to parse xml-data (stored in an object attribute or somewhere else)
with a matching XSLT-file. This is very useful if you want to store xml-data in contentobjects and present it in a nice way.

1. Dependencies
***************

This template operator relies on the sablotron extension of php. Php should be properly compiled with sablotron otherwise this operator won't work. For more information about this PHP-extension check http://www.php.net/manual/en/ref.xslt.php

2. Installation & configuration
*******************************

This template operator should be easy to install if you follow these steps

	1)  extract the contents of the archive into your eZ Publish extension directory

	2)  Create/Modify settings/override/site.ini.append.php and add the following lines
	
		[ExtensionSettings]
		ActiveExtensions[]=xslt
	    
	    If [ExtensionSettings] is already there just add the second line


		[TemplateSettings]
		AutoloadPathList[]=extension/xslt/kernel/common/

	    If [TemplateSettings] is already there just add the second line

	3) adjust the basedir setting in extension/xslt/settings/xslt.ini to the path where you want to store your 		   xsl-templates

3. Using the xslt-operator
**************************

Syntax:
{$xml|xslt( hash(  xslt_file, $filename,
		       xslt_params, hash('parameter1', $paramater1value, ...)))}

$xml is a template variable that contains xml-data (all kinds of template variables are ok, as long as they contain xml-data)

$filename is a string (or template variable containing a string) that specifies which xsl-template to use. Keep in mind that the basedir is given in the xslt.ini file. So if you want to specify a path to a xsl-template start from there.

Optionally you can pass parameters to your xsl-template. This might by usefull if you want to pass php-variables not included in the xmldata. You can pass as many parameters as you want to the xsl-template using the hash construct.

If everything is ok the xslt-operator will return the converted xml-data (probably xhtml), if there where errors during processing it will return these errors.


Real life example (might clear up some things):

{$attribute.data_text|xslt(hash(   xslt_file, 'reference/edit_reference.xsl',
				   xslt_params, hash('param', $attribute.id)
			       )
			  )}


4.  Thanks
**********

to Hans Melis & Paul Borgermans for the support and suggestions
