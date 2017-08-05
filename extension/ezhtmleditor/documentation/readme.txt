eZ HTML Editor
---------------------

This is an attempt at providing a simple inline server-side html editor for eZ publish. 
It is largely based upon htmlarea (http://dynarch.com/mishoo/htmlarea.epl), using the image manager 
from http://www.zhuo.org/htmlarea/ to extend it.

Please read the forum thread about online editors for further info:

http://ez.no/community/forum/suggestions/online_editors

NOTES:

-THIS ONLY WORKS ON TEXTFIELD ATTRIBUTES. It does *not* work with xmltextfields.

- Currently only simple html works. 

- Instructions are included to show the Image Manager but it is fiddly and doesn't work, though
it does pop up. Fitting the pop up scheme into the eZ module structure will take more time than
i've given it this morning ;)

To install
-------------
1. Add the ezhtmleditor as a normal extension, adding it to your site.ini file.

2. Within the pagelayout for your admin design, usually located at: design/admin/templates/pagelayout.tpl 
from your ez root directory add this code to the file:

Within <head> enter

<script type="text/javascript">
   _editor_url = "/extension/ezhtmleditor/htmlarea/";
   _editor_ezurl = 'http://{ezini("SiteSettings","SiteURL")}/';
   _editor_lang = "en";
</script>

<script type="text/javascript" src="/extension/ezhtmleditor/htmlarea/htmlarea.js"></script>

<script type="text/javascript">
    //load the ImageManage + Editor plug-in
    HTMLArea.loadPlugin("ImageManager");

    var editor = new HTMLArea("editor");

   //the rest of your HTMLArea initialisation.
</script>

And add this onload command to the body tag:

<body onLoad="javascript:HTMLArea.replaceAll();">

3. 

a) To get the basics of the ImageManager working you need to add the correct SiteURL for your admin
interface. Within the siteaccess site.ini for the admin design enter the correct SiteURL for your site, eg:

[SiteSettings]
DefaultPage=/content/view/full/2
LoginPage=custom

SiteName=My Admin
SiteURL=127.0.0.1

Or use a proper host name. For Window pop ups the Image Manager needs an absolute url to use, otherwise 
eZ displays the wrong display. WIth this url the javascript function appends a path to the correct module.

b) For the pop up to work you need to symbolic link the ez module to the module file within the htmlarea image manager 
plugin. For example, on linux:

cd ezhtmleditor/modules
ln -s ../htmlarea/plugins/ImageManager .

For Windows i guess the quickest thing is to copy the whole ImageManager directory to the modules directory.


