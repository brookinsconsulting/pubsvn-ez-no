/*
    phpadsnew for eZ publish
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
Sören Meyer   ( soeren@xrow.de )

State: Beta

PubSVN:
http://pubsvn.ez.no/viewcvs/community/trunk/extension/phpadsnew/

Description:
This extension delivers an integration of phpadsnew in eZ publish.


Currently it provides following functionality

- phpadsnew
- A template operator to display phpadsnew banner ads

=============
Installation
=============
- Setup eZ publish virtual host
- add special rewrite rule:
    # eZ publish 3.4.x :
    RewriteRule !((^/design|^/var/.*/storage|^/var/storage|^/var/.*/cache|^/var/cache|^/extension/.*/design|^/kernel/setup/packages|^/packages|^/share/icons).*\.(gif|css|jpg|png|jar|js|ico|pdf|swf))|^/extension/phpadsnew/phpadsnew/.*)$ /index.php
- Copy extension into extenstion folder
- Activate extenstion admin->setup->extensions
- Setup phpadsnew
-   Insert database dump of phpadsnew
-   Create config file in folder setttings 
---------settings/phpadsnew.php----------
<?php
// Database hostname
$phpAds_config['dbhost'] = 'example.com';

// Database port
$phpAds_config['dbport'] = 3306;

// Database username
$phpAds_config['dbuser'] = 'root';

// Database password
$phpAds_config['dbpassword'] = 'password';

// Database name
$phpAds_config['dbname'] = 'database';
?>
--------------------------------


=============
Usage
=============
- Place template code in any template
Sample 1:
-----------------------------------
{let data=phpadsnew( 'keyword', 'html')}
                    {$data.html}
{/let}
-----------------------------------
Sample 2:
-----------------------------------
{default    data=phpadsnew($:item.node_id, 'link', $:item.url_alias|ezurl(no))}
    <a href={$data.ext_url|ezroot}>{$:item.name}</a>
    {include uri="design:phpadsnew/viewcount.tpl" data=$data}
{/default}
{* The keyword "node2" in phpadsnew is linked to object with node_id 2*}
-----------------------------------

- Login into phpadsnew admin interface http://www.example.com/extension/phpadsnew/phpadsnew
