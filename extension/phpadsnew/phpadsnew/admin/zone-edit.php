<?php // $Revision: 2.0.2.5 $

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
require ("lib-zones.inc.php");
require ("lib-size.inc.php");


// Register input variables
phpAds_registerGlobal ('zonename', 'description', 'delivery', 'sizetype', 'size', 'zwidth', 'zheight', 'submit');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	if (isset($zoneid) && $zoneid > 0)
	{
		$result = phpAds_dbQuery("
			SELECT
				affiliateid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"] || !phpAds_isAllowed(phpAds_EditZone))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$affiliateid = phpAds_getUserID();
		}
	}
	else
	{
		if (phpAds_isAllowed(phpAds_AddZone))
		{
			$affiliateid = phpAds_getUserID();
		}
		else
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
	}
}



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	if (isset($description)) $description = addslashes ($description);
	
	if ($delivery == phpAds_ZoneText)
	{
		$zwidth = 0;
		$zheight = 0;
	}
	else
	{
		if ($sizetype == 'custom')
		{
			if (isset($zwidth) && $zwidth == '*') $zwidth = -1;
			if (isset($zheight) && $zheight == '*') $zheight = -1;
		}
		else
		{
			list ($zwidth, $zheight) = explode ('x', $size);
		}
	}
	
	
	// Edit
	if (isset($zoneid) && $zoneid != '')
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_zones']."
			SET
				zonename='".$zonename."',
				description='".$description."',
				width='".$zwidth."',
				height='".$zheight."',
				delivery='".$delivery."'
				".($delivery != phpAds_ZoneText && $delivery != phpAds_ZoneBanner ? ", append = ''" : "")."
				".($delivery != phpAds_ZoneText ? ", prepend = ''" : "")."
			WHERE
				zoneid='".$zoneid."'
			") or phpAds_sqlDie();
		
		
		// Reset append codes which called this zone
		$res = phpAds_dbQuery("
				SELECT
					zoneid,
					append
				FROM
					".$phpAds_config['tbl_zones']."
				WHERE
					appendtype = ".phpAds_ZoneAppendZone."
			");
		
		while ($row = phpAds_dbFetchArray($res))
		{
			$append = phpAds_ZoneParseAppendCode($row['append']);

			if ($append[0]['zoneid'] == $zoneid)
			{
				phpAds_dbQuery("
						UPDATE
							".$phpAds_config['tbl_zones']."
						SET
							appendtype = ".phpAds_ZoneAppendRaw.",
							append = ''
						WHERE
							zoneid = '".$row['zoneid']."'
					");
			}
		}
		
		header ("Location: zone-advanced.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
		exit;
	}
	
	
	// Add
	else
	{
		$res = phpAds_dbQuery("
			INSERT INTO
				".$phpAds_config['tbl_zones']."
				(
				affiliateid,
				zonename,
				zonetype,
				description,
				width,
				height,
				delivery
				)
			 VALUES (
			 	'".$affiliateid."',
				'".$zonename."',
				'".phpAds_ZoneCampaign."',
				'".$description."',
				'".$zwidth."',
				'".$zheight."',
				'".$delivery."'
				)
			") or phpAds_sqlDie();
		
		$zoneid = phpAds_dbInsertID();
		
		header ("Location: zone-advanced.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
		exit;
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($zoneid != "")
{
	if (isset($Session['prefs']['affiliate-zones.php']['listorder']))
		$navorder = $Session['prefs']['affiliate-zones.php']['listorder'];
	else
		$navorder = '';
	
	if (isset($Session['prefs']['affiliate-zones.php']['orderdirection']))
		$navdirection = $Session['prefs']['affiliate-zones.php']['orderdirection'];
	else
		$navdirection = '';
	
	
	// Get other zones
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = '".$affiliateid."'
			".phpAds_getZoneListOrder ($navorder, $navdirection)."
	");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildZoneName ($row['zoneid'], $row['zonename']),
			"zone-edit.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid'],
			$zoneid == $row['zoneid']
		);
	}
	
	
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');
		phpAds_PageShortcut($strZoneHistory, 'stats-zone-history.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-statistics.gif');
		
		
		$extra  = "<form action='zone-modify.php'>";
		$extra .= "<input type='hidden' name='zoneid' value='$zoneid'>";
		$extra .= "<input type='hidden' name='affiliateid' value='$affiliateid'>";
		$extra .= "<input type='hidden' name='returnurl' value='zone-edit.php'>";
		$extra .= "<br><br>";
		$extra .= "<b>$strModifyZone</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-duplicate-zone.gif' align='absmiddle'>&nbsp;<a href='zone-modify.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&duplicate=true&returnurl=zone-edit.php'>$strDuplicate</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-move-zone.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
		$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$extra .= "<select name='moveto' style='width: 110;'>";
		
		$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE affiliateid <> '".$affiliateid."'") or phpAds_sqlDie();
		while ($row = phpAds_dbFetchArray($res))
			$extra .= "<option value='".$row['affiliateid']."'>".phpAds_buildAffiliateName($row['affiliateid'], $row['name'])."</option>";
		
		$extra .= "</select>&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='zone-delete.php?affiliateid=$affiliateid&zoneid=$zoneid&returnurl=affiliate-zones.php'".phpAds_DelConfirm($strConfirmDeleteZone).">$strDelete</a><br>";
		$extra .= "</form>";
		
		
		phpAds_PageHeader("4.2.3.2", $extra);
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.2.3.2", "4.2.3.6", "4.2.3.3", "4.2.3.4", "4.2.3.5"));
	}
	else
	{
		$sections[] = "2.1.2";
		$sections[] = "2.1.6";
		if (phpAds_isAllowed(phpAds_LinkBanners)) $sections[] = "2.1.3";
		$sections[] = "2.1.4";
		$sections[] = "2.1.5";
		
		phpAds_PageHeader("2.1.2");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections($sections);
	}
}
else
{
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageHeader("4.2.3.1");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.2.3.1"));
	}
	else
	{
		phpAds_PageHeader("2.1.1");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections(array("2.1.1"));
	}
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($zoneid) && $zoneid != '')
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			zoneid = '".$zoneid."'
		") or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res))
	{
		$zone = phpAds_dbFetchArray($res);
	}
	
	if ($zone['width'] == -1) $zone['width'] = '*';
	if ($zone['height'] == -1) $zone['height'] = '*';
}
else
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
		WHERE
			affiliateid = '".$affiliateid."'
	");
	
	if ($affiliate = phpAds_dbFetchArray($res))
		$zone["zonename"] = $affiliate['name'].' - ';
	else
		$zone["zonename"] = '';
	
	$zone['zonename'] 	   .= $strDefault;
	$zone['description'] 	= '';
	$zone['width'] 			= '468';
	$zone['height'] 		= '60';
	$zone['delivery']		= phpAds_ZoneBanner;
}

$tabindex = 1;


echo "<form name='zoneform' method='post' action='zone-edit.php' onSubmit='return phpAds_formCheck(this);'>";
echo "<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";

echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='zonename' size='35' style='width:350px;' value='".phpAds_htmlQuotes($zone['zonename'])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strDescription."</td><td>";
echo "<input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($zone["description"])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'><br>".$strZoneType."</td><td><table>";
echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZoneBanner."'".($zone['delivery'] == phpAds_ZoneBanner ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;".$strBannerButtonRectangle."</td></tr>";

if ($phpAds_config['allow_invocation_interstitial'] || $zone['delivery'] == phpAds_ZoneInterstitial) 
{
	echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZoneInterstitial."'".($zone['delivery'] == phpAds_ZoneInterstitial ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
	echo "&nbsp;<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;".$strInterstitial."</td></tr>";
}

if ($phpAds_config['allow_invocation_popup'] || $zone['delivery'] == phpAds_ZonePopup) 
{
	echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZonePopup."'".($zone['delivery'] == phpAds_ZonePopup ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
	echo "&nbsp;<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;".$strPopup."</td></tr>";
}

echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZoneText."'".($zone['delivery'] == phpAds_ZoneText ? ' CHECKED' : '')." onClick='phpAds_formDisableSize();' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;".$strTextAdZone."</td></tr>";


echo "</table></td></tr>";


if ($zone['delivery'] == phpAds_ZoneText)
{
	$sizedisabled = ' disabled';
	$zone['width'] = '*';
	$zone['height'] = '*';
}
else
	$sizedisabled = '';

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'><br>".$strSize."</td><td>";

$exists = phpAds_sizeExists ($zone['width'], $zone['height']);

echo "<table><tr><td>";
echo "<input type='radio' name='sizetype' value='default'".($exists ? ' CHECKED' : '').$sizedisabled." tabindex='".($tabindex++)."'>&nbsp;";
echo "<select name='size' onchange='phpAds_formSelectSize(this)'".$sizedisabled." tabindex='".($tabindex++)."'>"; 

for (reset($phpAds_IAB);$key=key($phpAds_IAB);next($phpAds_IAB))
{
	if ($phpAds_IAB[$key]['width'] == $zone['width'] &&
		$phpAds_IAB[$key]['height'] == $zone['height'])
		echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."' selected>".$key."</option>";
	else
		echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."'>".$key."</option>";
}

echo "<option value='-'".(!$exists ? ' SELECTED' : '').">".$strCustom."</option>";
echo "</select>";

echo "</td></tr><tr><td>";

echo "<input type='radio' name='sizetype' value='custom'".(!$exists ? ' CHECKED' : '').$sizedisabled." onclick='phpAds_formEditSize()' tabindex='".($tabindex++)."'>&nbsp;";
echo $strWidth.": <input class='flat' size='5' type='text' name='zwidth' value='".(isset($zone["width"]) ? $zone["width"] : '')."'".$sizedisabled." onkeydown='phpAds_formEditSize()' onBlur='phpAds_formUpdate(this);' tabindex='".($tabindex++)."'>";
echo "&nbsp;&nbsp;&nbsp;";
echo $strHeight.": <input class='flat' size='5' type='text' name='zheight' value='".(isset($zone["height"]) ? $zone["height"] : '')."'".$sizedisabled." onkeydown='phpAds_formEditSize()' onBlur='phpAds_formUpdate(this);' tabindex='".($tabindex++)."'>";
echo "</td></tr></table>";
echo "</td></tr>";


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br><br>";
echo "<input type='submit' name='submit' value='".(isset($zoneid) && $zoneid != '' ? $strSaveChanges : $strNext.' >')."' tabindex='".($tabindex++)."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

// Get unique affiliate
$unique_names = array();

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE affiliateid = '".$affiliateid."' AND zoneid != '".$zoneid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_names[] = $row['zonename'];

?>

<script language='JavaScript'>
<!--
	phpAds_formSetRequirements('zonename', '<?php echo addslashes($strName); ?>', true, 'unique');
	phpAds_formSetRequirements('zwidth', '<?php echo addslashes($strWidth); ?>', true, 'number*');
	phpAds_formSetRequirements('zheight', '<?php echo addslashes($strHeight); ?>', true, 'number*');
	
	phpAds_formSetUnique('zonename', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');


	function phpAds_formSelectSize(o)
	{
		// Get size from select
		size   = o.options[o.selectedIndex].value;

		if (size != '-')
		{
			// Get width and height
			sarray = size.split('x');
			height = sarray.pop();
			width  = sarray.pop();
		
			// Set width and height
			document.zoneform.zwidth.value = width;
			document.zoneform.zheight.value = height;
		
			// Set radio
			document.zoneform.sizetype[0].checked = true;
			document.zoneform.sizetype[1].checked = false;
		}
		else
		{
			document.zoneform.sizetype[0].checked = false;
			document.zoneform.sizetype[1].checked = true;
		}
	}
	
	function phpAds_formEditSize()
	{
		document.zoneform.sizetype[0].checked = false;
		document.zoneform.sizetype[1].checked = true;
		document.zoneform.size.selectedIndex = document.zoneform.size.options.length - 1;
	}
	
	function phpAds_formDisableSize()
	{
		document.zoneform.sizetype[0].disabled = true;
		document.zoneform.sizetype[1].disabled = true;
		document.zoneform.zwidth.disabled = true;
		document.zoneform.zheight.disabled = true;
		document.zoneform.size.disabled = true;
	}

	function phpAds_formEnableSize()
	{
		document.zoneform.sizetype[0].disabled = false;
		document.zoneform.sizetype[1].disabled = false;
		document.zoneform.zwidth.disabled = false;
		document.zoneform.zheight.disabled = false;
		document.zoneform.size.disabled = false;
	}
//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>