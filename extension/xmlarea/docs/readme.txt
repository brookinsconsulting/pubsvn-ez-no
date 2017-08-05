XMLArea 0.2
-----------

A GPL version of the Online Editor

Should be compatable with:

eZPublish 3.5
Mozilla 1.3+
Firefox 0.8+
IE 5.5+


Changes
-------

0.2:

added nested list support
added editing properties for all tags
added insert special character plugin
added perl spellcheck plugin
added toggle custom context menu button
removed server side browser check
replaced javascript remote scripting with xmlhttprequest

fixed loads of javascript bugs ('specially in ie)
much improved custom tags system
generally tidied things up

0.11b:

sorted links to javascripts for ezpub installations not in root.


Demo
----

You can see a demo by heading to:

http://www.stevoland.org/work/projects/xmlarea

+ leaving a comment.


XMLArea stands on the shoulders of:
-----------------------------------

HTMLArea 3.0 rc1 (Mihai Bazon - http://www.htmlarea.com)


Installation
------------

Copy xmlarea to 'extensions'.

Ensure your .htaccess allows requests for .html through (for the popups).

Deactivate the Online Editor. I haven't got a copy but I presume they'll conflict.

Activate xmlarea extension + clear your caches.

Give the anonymous role rights to the xmlarea module.

Edit something with an ezxmltext attribute (+ cross your fingers)


Configuration
-------------

xmlarea/settings/xmlarea.ini contains options for custom tags, buttons etc.

Follow the notes there for adding a custom tag then add an appropriate template in
xmlarea/design/standard/templates/xmlarea/ezxmltags
the tags in the template have to match the tags specified in the ini.

the following custom tags are set up in the default xmlarea.ini (if they're defined in content.ini aswell):
strike, underline, sub, sup, quote, factbox, hr (horizontal rule)

You can change the appearance of attached objects in the editor by overriding
xmlarea/ezxmltags/object.tpl
the 'file' + 'image' classes are overridden by default

xmlarea/design/standard/javascript/pagestyle.js dictates the appearance of the editor content + object preview.



Notes
-----

XMLArea automatically overrides the following templates:

admin/templates/content/edit - only to remove with window.onload call at the bottom

admin/templates/content/edit_attribute.tpl
standard/templates/content/edit_attribute.tpl - only to pass on the 'edit_version' variable (there must be a better way to get this from content/datatypes/edit/ezxmltext.tpl ?)

standard/templates/content/datatypes/edit/ezxmltext.tpl - of course




