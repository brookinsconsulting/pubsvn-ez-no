readme.txt for shuffle operator.
by Tim Ross 2003

The shuffle operator works on an array and randomises its order. 
For example, use it on a fetch statement to get a randomised result set.

{let randomised_array = fetch(content,list,...)|shuffle}

This extension was designed and tested on eZpublish 3.2-3, so no guarantees that 
it will work on any other versions.

Its a really basic operator extension but it's not built in and lots of people want 
to know how to do it, so I did. Hope it helps.

To use this extension
=====================

1. Unzip the file shuffle.zip to your extension directory in the eZpublish root.
   If the extension directory does not exist, create it. After unzipping there should 
   be a folder in the extension directory called shuffle.
2. Edit your settings/site.ini file.
   In [ExtensionSettings] under the line ActiveExtensions[] add the line ActiveExtensions[]=shuffle. 
   Your site.ini file should now look something like this:
   
   [ExtensionSettings]
   ExtensionDirectory=extension
   # A list of active extensions, add new ones to activate them
   # The extension itself will then have it's settings directory read (if any)
   # and any extra configurability is done automatically.
   ActiveExtensions[]
   ActiveExtensions[]=shuffle

   Now edit [TemplateSettings] under the ExtensionAutoLoadPath[] add the line ExtensionAutoloadPath[]=shuffle
   This should look like this:
   
   [TemplateSettings]
   ...
   # A list of extensions which have template autoloads.
   # Only specify the extension name, not the path.
   # The extension must contain a subdirectory called autoloads.
   ExtensionAutoloadPath[]
   ExtensionAutoloadPath[]=shuffle
   
3. That's it! clear your cache and you are good to go. The extension should show up in the Extention Setup 
   area of the set up section of your admin site. You can use this extension as a base for you own. 

Good luck,
Tim