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
require ("lib-statistics.inc.php");
require ("../libraries/lib-reports.inc.php");


// Register input variables
phpAds_registerGlobal ('startday', 'startmonth', 'startyear', 
					   'endday', 'endmonth', 'endyear');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientid) && $clientid != '')
{
	if (isset($startyear) && isset($startmonth) && isset($startday) &&
		$startyear != '' && $startmonth != '' && $startday != '')
		$first_unixtimestamp = mktime(0, 0, 0, $startmonth, $startday, $startyear);
	else
		$first_unixtimestamp = 0;
	
	if (isset($endyear) && isset($endmonth) && isset($endday))
		$last_unixtimestamp = mktime(23, 59, 59, $endmonth, $endday, $endyear);
	else
		$last_unixtimestamp = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
	
	if (phpAds_SendMaintenanceReport ($clientid, $first_unixtimestamp, $last_unixtimestamp, false))
	{
		$message = $strAdReportSent;
	}
	else
	{
		$message = $strErrorOccurred;
	}
}
else
{
	$message = $strErrorOccurred;
}

header("Location: stats-client-history.php?clientid=$clientid&message=".urlencode($message));

?>