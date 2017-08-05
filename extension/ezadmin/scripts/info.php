<?php
/*
Add to your vhost

RewriteCond %{REQUEST_URI} ^/info\.php$
RewriteRule ^/(.*)$ /extension/ezadmin/scripts/$1  [L]

Call URL http//www.example.com/info.php to view script
*/
phpinfo();
gd_info();
?>