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


// Define usertypes
define ("phpAds_userDeliveryEngine", 1);
define ("phpAds_userMaintenance", 2);
define ("phpAds_userAdministrator", 3);
define ("phpAds_userAdvertiser", 4);
define ("phpAds_userPublisher", 5);

// Define actions
define ("phpAds_actionAdvertiserReportMailed", 0);
define ("phpAds_actionPublisherReportMailed", 1);
define ("phpAds_actionWarningMailed", 2);
define ("phpAds_actionDeactivationMailed", 3);
define ("phpAds_actionPriorityCalculation", 10);
define ("phpAds_actionPriorityAutoTargeting", 11);
define ("phpAds_actionDeactiveCampaign", 20);
define ("phpAds_actionActiveCampaign", 21);
define ("phpAds_actionAutoClean", 30);


$GLOBAL['phpAds_Usertype'] = 0;


/*********************************************************/
/* Add an entry to the userlog                           */
/*********************************************************/

function phpAds_userlogAdd ($action, $object, $details = '')
{
	global $phpAds_config, $phpAds_Usertype;
	
	if ($phpAds_Usertype != 0)
	{
		$usertype = $phpAds_Usertype;
		$userid   = 0;
	}
	else
	{
		$usertype = phpAds_userAdministrator;
		$userid   = 0;
	}
	
	$res = phpAds_dbQuery("
		INSERT INTO
			".$phpAds_config['tbl_userlog']."
		SET
			timestamp = ".time().",
			usertype = '".$usertype."',
			userid = '".$userid."',
			action = '".$action."',
			object = '".$object."',
			details = '".addslashes($details)."'
	");
}

function phpAds_userlogSetUser ($usertype)
{
	global $phpAds_Usertype;
	
	$phpAds_Usertype = $usertype;
}

?>