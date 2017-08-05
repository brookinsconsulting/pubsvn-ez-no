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
require ("lib-storage.inc.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('moveto', 'returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($campaignid) && $campaignid != '')
{
	if (isset($moveto) && $moveto != '')
	{
		// Move the campaign
		$res = phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET parent = '".$moveto."' WHERE clientid = '".$campaignid."'") or phpAds_sqlDie();
		
		// Rebuild cache
		if (!defined('LIBVIEWCACHE_INCLUDED')) 
			include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
		
		phpAds_cacheDelete();
	}
}

Header ("Location: ".$returnurl."?clientid=".$moveto."&campaignid=".$campaignid);

?>