<?php // $Revision: 2.0.2.1 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");

$update_check = false;


/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Check for product updates when the admin logs in
if (phpAds_isUser(phpAds_Admin))
{
	// Check accordingly to user preferences
	switch ($phpAds_config['updates_frequency'])
	{
		case -1:	$update_check = false; break;
		case 0: 	$update_check = true; break;
		default: 	$update_check = ($phpAds_config['updates_timestamp'] +
						$phpAds_config['updates_frequency']*60*60*24) <= time();
					break;
	}
	
	if ($update_check)
	{
		include('lib-updates.inc.php');
		$update_check = phpAds_checkForUpdates($phpAds_config['updates_last_seen']);
		
		if ($update_check[0])
			$update_check = false;
	}
	
	phpAds_SessionDataRegister('update_check', $update_check);
	phpAds_SessionDataStore();
	
	
	// Add Product Update redirector
	if ($update_check)
	{
		Header("Content-Type: application/x-javascript");
		
		if ($Session['update_check'][1]['security_fix'])
			echo "\t\t\talert('".$strUpdateAlertSecurity."');\n";
		else
			echo "\t\t\tif (confirm('".$strUpdateAlert."'))\n\t";
		
		echo "\t\tdocument.location.replace('maintenance-updates.php');\n";
	}
}

?>