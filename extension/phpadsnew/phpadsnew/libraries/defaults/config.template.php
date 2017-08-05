<?php

/*********************************************************/
/* Database configuration                                */
/*********************************************************/

// Database hostname
$phpAds_config['dbhost'] = 'localhost';

// Database port
$phpAds_config['dbport'] = '3306';

// Database username
$phpAds_config['dbuser'] = '';

// Database password
$phpAds_config['dbpassword'] = '';

// Database name
$phpAds_config['dbname'] = '';

// Database table names
$phpAds_config['tbl_adclicks'] = 'phpads_adclicks';
$phpAds_config['tbl_adviews'] = 'phpads_adviews';
$phpAds_config['tbl_adstats'] = 'phpads_adstats';
$phpAds_config['tbl_banners'] = 'phpads_banners';
$phpAds_config['tbl_clients'] = 'phpads_clients';
$phpAds_config['tbl_session'] = 'phpads_session';
$phpAds_config['tbl_acls'] = 'phpads_acls';
$phpAds_config['tbl_zones'] = 'phpads_zones';
$phpAds_config['tbl_config'] = 'phpads_config';
$phpAds_config['tbl_affiliates'] = 'phpads_affiliates';
$phpAds_config['tbl_images'] = 'phpads_images';
$phpAds_config['tbl_userlog'] = 'phpads_userlog';
$phpAds_config['tbl_cache'] = 'phpads_cache';
$phpAds_config['tbl_targetstats'] = 'tbl_targetstats';

// Database table name prefix
$phpAds_config['table_prefix'] = 'phpads_';

// Database table type
$phpAds_config['table_type'] = 'MYISAM';

// Use persistent connections to the database
$phpAds_config['persistent_connections'] = false;

// Use INSERT DELAYED in logging functions?
$phpAds_config['insert_delayed'] = false;

// Database compatibility mode to insure phpAdsNew
// won't disturb an available database connection
$phpAds_config['compatibility_mode'] = false;



/*********************************************************/
/* phpAdsNew configuration                               */
/*********************************************************/

// The URL to your phpAds-installation
$phpAds_config['url_prefix'] = 'http://www.your-url.com/phpAdsNew';

// Is the admin interface enabled
$phpAds_config['ui_enabled'] = true;

// Only allow access to the admin interface if SSL is used
$phpAds_config['ui_forcessl'] = false;



/*********************************************************/
/* Remote host and Geotracking configuration             */
/*********************************************************/

// Reverse DNS lookup remotes hosts?
$phpAds_config['reverse_lookup'] = false;

// Find the correct IP for users behind a proxy
$phpAds_config['proxy_lookup'] = false;

// Type of geotracking database
// Possible options: geoip, ip2country, mod_geoip or an empty string
$phpAds_config['geotracking_type'] = '';

// Location of the geotracking database
$phpAds_config['geotracking_location'] = '';

// Store the location of the user in the statistics
$phpAds_config['geotracking_stats'] = false;

// Store the result in a cookie for future reference (only in combination with beacon logging)
$phpAds_config['geotracking_cookie'] = false;



/*********************************************************/
/* Statistics and logging                                */
/*********************************************************/

// Use compact or verbose statistics
$phpAds_config['compact_stats'] = true;

// Enabled logging of adviews?
$phpAds_config['log_adviews'] = true;

// Enabled logging of adclicks?
$phpAds_config['log_adclicks'] = true;

// Log the source parameter
$phpAds_config['log_source'] = true;

// Log the hostname or IP address
$phpAds_config['log_hostname'] = true;

// Log only the IP address even if a hostname is available
$phpAds_config['log_iponly'] = true;

// Use beacons to log adviews
$phpAds_config['log_beacon'] = true;

// Hosts to ignore (don't count adviews coming from them)
$phpAds_config['ignore_hosts'] = array ();   // Example: array('slashdot.org', 'microsoft.com');

// Block logging of views for xx seconds after the last entry
// This is to prevent logging after each page reload
$phpAds_config['block_adviews'] = 0;

// Block logging of clicks for xx seconds after the last entry
// This is to prevent users from boosting the stats by clicking multiple times
$phpAds_config['block_adclicks'] = 0;

// E-mail admin when clicks/views get low?
$phpAds_config['warn_admin'] = true;

// E-mail client when clicks/views get low?
$phpAds_config['warn_client'] = true;

// Minimum clicks/views before warning e-mail is sent
$phpAds_config['warn_limit'] = 100; 



/*********************************************************/
/* P3P Privacy Policies                                  */
/*********************************************************/

// Use P3P Polices
$phpAds_config['p3p_policies'] = true;

// Compact policy
$phpAds_config['p3p_compact_policy'] = 'CUR ADM OUR NOR STA NID';

// Policy file location
// For example:
// $phpAds_config['p3p_policy_location'] = 'http://www.your-url.com/w3c/p3p.xml';
$phpAds_config['p3p_policy_location'] = '';



/*********************************************************/
/* Banner retrieval                                      */
/*********************************************************/

// Delivery caching type?
// Possible options: none, db, file or shm
$phpAds_config['delivery_caching'] = 'db';

// Use conditional keywords?
$phpAds_config['con_key'] = true;

// Use multiple keywords for banners in banner table?
$phpAds_config['mult_key'] = true;

// Use delivery limitations?
$phpAds_config['acl'] = true;

// Default banner, it is show when phpAdsNew can't connect to the database or
// there are absolutely no banner to display. The banner is not logged.
// Enter the complete url (incl. http://) for the image and the target,
// or leave them empty if you don't want to show a banner when this happens.
$phpAds_config['default_banner_url'] = '';
$phpAds_config['default_banner_target'] = '';



/*********************************************************/
/* Banner storage and types                              */
/*********************************************************/

// Automatically change HTML banners in order to force
// click logging.
$phpAds_config['type_html_auto'] = true;

// Allow php expressions to be executed from within a 
// HTML banner
$phpAds_config['type_html_php'] = false;






/*********************************************************/
/* phpAdsNew self configuration code - don't change      */
/*********************************************************/

define('phpAds_installed', true);

// Disable magic_quotes_runtime
set_magic_quotes_runtime(0);

?>