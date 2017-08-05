<?php // $Revision: 2.0.2.2 $

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
require ("lib-size.inc.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'listorder', 'orderdirection', 'period', 'period_range');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);


// Set default values
$tabindex = 1;



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	$affiliateid = phpAds_getUserID();
}



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-affiliate-zones.php']['listorder']))
		$listorder = $Session['prefs']['stats-affiliate-zones.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-affiliate-zones.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-affiliate-zones.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['stats-affiliate-zones.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['stats-affiliate-zones.php']['nodes']);
else
	$node_array = array();


if (!isset($period))
{
	if (isset($Session['prefs']['stats-affiliate-zones.php']['period']))
		$period = $Session['prefs']['stats-affiliate-zones.php']['period'];
	else
		$period = '';
}


if (!isset($period_range))
{
	if (isset($Session['prefs']['stats-affiliate-zones.php']['period_range']))
		$period_range = $Session['prefs']['stats-affiliate-zones.php']['period_range'];
	else
		$period_range = array (
			'start_day' => 0,
			'start_month' => 0,
			'start_year' => 0,
			'end_day' => 0,
			'end_month' => 0,
			'end_year' => 0
		);
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
			"stats-affiliate-zones.php?affiliateid=".$row['affiliateid'],
			$affiliateid == $row['affiliateid']
		);
	}
	
	phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');
	
	
	phpAds_PageHeader("2.4.2");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.1", "2.4.2"));
}
else
{
	phpAds_PageHeader("1.1");
	
	if ($phpAds_config['client_welcome'])
	{
		echo "<br><br>";
		// Show welcome message
		if (!empty($phpAds_client_welcome_msg))
			echo $phpAds_client_welcome_msg;
		else
			include('templates/welcome-publisher.html');
		echo "<br><br>";
	}
	
	phpAds_ShowSections(array("1.1", "1.2"));
}


/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get the zones for each affiliate
$res_zones = phpAds_dbQuery("
	SELECT 
		zoneid, affiliateid, zonename, what, delivery
	FROM 
		".$phpAds_config['tbl_zones']."
	WHERE
		affiliateid = '".$affiliateid."'
		".phpAds_getZoneListOrder ($listorder, $orderdirection)."
	") or phpAds_sqlDie();

while ($row_zones = phpAds_dbFetchArray($res_zones))
{
	$zones[$row_zones['zoneid']] = $row_zones;
	$zones[$row_zones['zoneid']]['views'] = 0;
	$zones[$row_zones['zoneid']]['clicks'] = 0;
	
	$zoneids[] = $row_zones['zoneid'];
}


// Check period range
if ($period_range['start_month'] == 0 || $period_range['start_day'] == 0 || $period_range['start_year'] == 0)
{
	$period_begin = 0;
	$period_range['start_day'] = $period_range['start_month'] = $period_range['start_year'] = 0;
}
else
	$period_begin = mktime(0, 0, 0, $period_range['start_month'], $period_range['start_day'], $period_range['start_year']);


if ($period_range['end_month'] == 0 || $period_range['end_day'] == 0 || $period_range['end_year'] == 0)
{
	$period_end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'));
	$period_range['end_day'] = $period_range['end_month'] = $period_range['end_year'] = 0;
}
else
	$period_end = mktime(0, 0, 0, $period_range['end_month'], $period_range['end_day'], $period_range['end_year']);



if (!$phpAds_config['compact_stats'])
{
	switch ($period)
	{
		case 'r':	$limit 		    	= " AND t_stamp >= ".date('YmdHis', $period_begin)." AND t_stamp < ".date('YmdHis', $period_end);
					break;
				
		case 'y':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));	
					$timestamp_end		= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 		    	= " AND t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
					break;
				
		case 't':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'w':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'm':	$timestamp_begin	= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		default:	$limit = '';
					$period = '';
					break;
	}
}
else
{
	switch ($period)
	{
		case 'r':	$limit 		    	= " AND day >= ".date('Ymd', $period_begin)." AND day < ".date('Ymd', $period_end);
					break;
				
		case 'y':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;
				
		case 't':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'w':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'm':	$timestamp_begin	= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;
				
		default:	$limit = '';
					$period = '';
					break;
	}
}


// Get the adviews/clicks for each banner
if (count($zoneids))
{
	if ($phpAds_config['compact_stats'])
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				sum(views) as views,
				sum(clicks) as clicks
			FROM 
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid IN (".join(', ', $zoneids).")".$limit."
			GROUP BY
				zoneid, bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['views'] = $row_stats['views'];
		}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				count(*) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid IN (".join(', ', $zoneids).")".$limit."
			GROUP BY
				zoneid, bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
				$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
				$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['views'] = $row_stats['views'];
				$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['clicks'] = 0;
		}
		
		
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				count(*) as clicks
			FROM 
				".$phpAds_config['tbl_adclicks']."
			WHERE
				zoneid IN (".join(', ', $zoneids).")".$limit."
			GROUP BY
				zoneid, bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
		}
	}
}



// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
	$node_array[] = $expand;

$node_array_size = sizeof($node_array);
for ($i=0; $i < $node_array_size;$i++)
{
	if (isset($collapse) && $collapse == $node_array[$i])
		unset ($node_array[$i]);
	else
	{
		if (isset($zones[$node_array[$i]]))
			$zones[$node_array[$i]]['expand'] = 1;
	}
}



if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	$totalviews = 0;
	$totalclicks = 0;
	
	// Calculate statistics for affiliates
	for (reset($zones);$key=key($zones);next($zones))
	{
		$zoneviews = 0;
		$zoneclicks = 0;
		
		if (isset($zones[$key]['banners']) && sizeof ($zones[$key]['banners']) > 0)
		{
			$banners = $zones[$key]['banners'];
			
			// Calculate statistics for zones
			while (list ($bkey,) = each ($banners))
			{
				$zoneviews += $banners[$bkey]['views'];
				$zoneclicks += $banners[$bkey]['clicks'];
			}
		}
		
		$totalviews += $zoneviews;
		$totalclicks += $zoneclicks;
		
		$zones[$key]['clicks'] = $zoneclicks;
		$zones[$key]['views'] = $zoneviews;
	}
	
	unset ($banners);
}


echo "<form action='".$HTTP_SERVER_VARS['PHP_SELF']."'>";
echo "<input type='hidden' name='affiliateid' value='".$affiliateid."'>";

echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
	echo "<option value=''".($period == '' ? ' selected' : '').">".$strCollectedAll."</option>";
	echo "<option value='' disabled>-----------------------------------------</option>";
	echo "<option value='t'".($period == 't' ? ' selected' : '').">".$strCollectedToday."</option>";
	echo "<option value='y'".($period == 'y' ? ' selected' : '').">".$strCollectedYesterday."</option>";
	echo "<option value='w'".($period == 'w' ? ' selected' : '').">".$strCollected7Days."</option>";
	echo "<option value='m'".($period == 'm' ? ' selected' : '').">".$strCollectedMonth."</option>";
	echo "<option value='' disabled>-----------------------------------------</option>";
	echo "<option value='r'".($period == 'r' ? ' selected' : '').">".$strCollectedRange."</option>";
echo "</select>";


if ($period == 'r')
{
	phpAds_ShowBreak();
	echo $strFrom."&nbsp;&nbsp;";
	
	// Starting date
	echo "<select name='period_range[start_day]'>\n";
	echo "<option value='0'".($period_range['start_day'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=31;$i++)
		echo "<option value='$i'".($i == $period_range['start_day'] ? ' selected' : '').">$i</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[start_month]'>\n";
	echo "<option value='0'".($period_range['start_month'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=12;$i++)
		echo "<option value='$i'".($i == $period_range['start_month'] ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[start_year]'>\n";
	echo "<option value='0'".($period_range['start_year'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=date('Y')-4;$i<=date('Y');$i++)
		echo "<option value='$i'".($i == $period_range['start_year'] ? ' selected' : '').">$i</option>\n";
	echo "</select>\n";	
	
	// To
	echo "&nbsp;$strTo&nbsp;&nbsp;";
	
	// End date
	echo "<select name='period_range[end_day]'>\n";
	echo "<option value='0'".($period_range['end_day'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=31;$i++)
		echo "<option value='$i'".($i == $period_range['end_day'] ? ' selected' : '').">$i</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[end_month]'>\n";
	echo "<option value='0'".($period_range['end_month'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=12;$i++)
		echo "<option value='$i'".($i == $period_range['end_month'] ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[end_year]'>\n";
	echo "<option value='0'".($period_range['end_year'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=date('Y')-4;$i<=date('Y');$i++)
		echo "<option value='$i'".($i == $period_range['end_year'] ? ' selected' : '').">$i</option>\n";
	echo "</select>\n";	
	
	echo "&nbsp;";
	echo "<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'>";
}

phpAds_ShowBreak();
echo "</form>";




echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strViews']."</b></td>";
echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strClicks']."</b></td>";
echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


if (!isset($zones) || !is_array($zones) || count($zones) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	echo "&nbsp;&nbsp;".$strNoZones;
	echo "</td></tr>";
	
	echo "<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}
else
{
	$i=0;
	for (reset($zones);$key=key($zones);next($zones))
	{
		$zone = $zones[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		if (isset($zone['banners']))
		{
			if (isset($zone['expand']) && $zone['expand'] == '1')
				echo "&nbsp;<a href='stats-affiliate-zones.php?affiliateid=".$affiliateid."&collapse=".$zone['zoneid']."'><img src='images/triangle-d.gif' align='absmiddle' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='stats-affiliate-zones.php?affiliateid=".$affiliateid."&expand=".$zone['zoneid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
		
		if ($zone['delivery'] == phpAds_ZoneBanner)
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
		elseif ($zone['delivery'] == phpAds_ZoneInterstitial)
			echo "<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
		elseif ($zone['delivery'] == phpAds_ZonePopup)
			echo "<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;";
		elseif ($zone['delivery'] == phpAds_ZoneText)
			echo "<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;";
		
		echo "<a href='stats-zone-history.php?affiliateid=".$zone['affiliateid']."&zoneid=".$zone['zoneid']."'>".$zone['zonename']."</a>";
		echo "</td>";
		
		echo "<td height='25'>".$zone['zoneid']."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($zone['views'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($zone['clicks'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($zone['views'], $zone['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		
		
		if (isset($zone['banners']) && sizeof ($zone['banners']) > 0 && isset($zone['expand']) && $zone['expand'] == '1')
		{
			$banners = $zone['banners'];
			
			while (list($bkey,) = each($banners))
			{
				// Divider
				echo "<tr height='1'>";
				echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
				echo "<td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
				echo "</tr>";
				
				// Icon & name
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
				
				if (ereg ('bannerid:'.$banners[$bkey]['bannerid'], $zone['what']))
					echo "<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;";
				else
					echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
				
				
				echo "<a href='stats-linkedbanner-history.php?affiliateid=".$zone['affiliateid']."&zoneid=".$zone['zoneid']."&bannerid=".$banners[$bkey]['bannerid']."'>".phpAds_getBannerName($banners[$bkey]['bannerid'], 30, false)."</td>";
				echo "</td>";
				
				echo "<td height='25'>".$banners[$bkey]['bannerid']."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($banners[$bkey]['views'])."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($banners[$bkey]['clicks'])."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($banners[$bkey]['views'], $banners[$bkey]['clicks'])."&nbsp;&nbsp;</td>";
				echo "</tr>";
			}
		}
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
	
	// Total
	echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalviews)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	//echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['stats-affiliate-zones.php']['listorder'] = $listorder;
$Session['prefs']['stats-affiliate-zones.php']['orderdirection'] = $orderdirection;
$Session['prefs']['stats-affiliate-zones.php']['nodes'] = implode (",", $node_array);

$Session['prefs']['stats-affiliate-zones.php']['period'] = $period;
$Session['prefs']['stats-affiliate-zones.php']['period_range'] = $period_range;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>