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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$clientid = phpAds_getUserID();
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$bannerids = array();

$idresult = phpAds_dbQuery ("
	SELECT
		b.bannerid
	FROM
		".$phpAds_config['tbl_banners']." AS b,
		".$phpAds_config['tbl_clients']." AS c
	WHERE
		c.parent = $clientid AND
		c.clientid = b.clientid
");

while ($row = phpAds_dbFetchArray($idresult))
{
	$bannerids[] = "bannerid = ".$row['bannerid'];
}


if ($phpAds_config['compact_stats']) 
{
	$res = phpAds_dbQuery("
		SELECT
			DATE_FORMAT(day, '%Y%m%d') as date,
			DATE_FORMAT(day, '$date_format') as date_formatted
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			(".implode(' OR ', $bannerids).")
		GROUP BY
			day
		ORDER BY
			day DESC
		LIMIT 7
	") or phpAds_sqlDie();
}
else
{
	$res = phpAds_dbQuery("
		 SELECT
			DATE_FORMAT(t_stamp, '%Y%m%d') as date,
			DATE_FORMAT(t_stamp, '$date_format') as date_formatted
		 FROM
			".$phpAds_config['tbl_adviews']."
		 WHERE
			(".implode(' OR ', $bannerids).")
		 GROUP BY
			date
		 ORDER BY
			date DESC
		 LIMIT 7
	") or phpAds_sqlDie();
}

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		$row['date_formatted'],
		"stats-client-daily-hosts.php?day=".$row['date']."&clientid=".$clientid,
		$day == $row['date']
	);
}

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
	
	phpAds_PageHeader("2.1.1.2");
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-date.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.1.1", "2.1.1.2"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.1.2");
		echo "<img src='images/icon-date.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br>";
		phpAds_ShowSections(array("1.1.1", "1.1.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$lib_hourly_where = "(".implode(' OR ', $bannerids).")";

include ("lib-hourly-hosts.inc.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>