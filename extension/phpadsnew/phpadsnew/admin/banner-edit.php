<?php // $Revision: 2.0.2.8 $

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
require ("lib-storage.inc.php");
require ("lib-swf.inc.php");
require ("lib-banner.inc.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('storagetype', 'network', 'replaceimage', 'upload', 'checkswf', 'url', 'target', 'alink', 
					   'atar', 'alink_chosen', 'alt', 'status', 'bannertext', 'width', 'height', 'imageurl', 'banner', 
					   'autohtml', 'keyword', 'description', 'weight', 'submit', 'asource');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_isAllowed(phpAds_ModifyBanner))
	{
		$result = phpAds_dbQuery("
			SELECT
				clientid
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '$bannerid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["clientid"] == '' || phpAds_getUserID() != phpAds_getParentID ($row["clientid"]))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $row["clientid"];
		}
	}
	else
	{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}




/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	// Delete uploaded var for security
	if (isset($uploaded)) unset ($uploaded);
	
	
	// Get information about uploaded file
	if (isset($HTTP_POST_FILES['upload']))
	{
		if ($HTTP_POST_FILES['upload']['name'] != '' &&
			$HTTP_POST_FILES['upload']['tmp_name'] != 'none')
			$uploaded = $HTTP_POST_FILES['upload'];
	}
	
	
	// Check if uploaded file is really uploaded
	if (isset($uploaded))
	{
		if (function_exists("is_uploaded_file"))
		{
			$upload_valid = @is_uploaded_file($uploaded['tmp_name']);
		}
		else
		{
			if (!$tmp_file = get_cfg_var('upload_tmp_dir')) 
			{
				$tmp_file = tempnam('',''); 
				@unlink($tmp_file); 
				$tmp_file = dirname($tmp_file);
			}
			
			$tmp_file .= '/' . basename($uploaded['tmp_name']);
			$tmp_file = str_replace('\\', '/', $tmp_file);
			$tmp_file  = ereg_replace('/+', '/', $tmp_file);
			
			$up_file = str_replace('\\', '/', $uploaded['tmp_name']);
			$up_file = ereg_replace('/+', '/', $up_file);
			
			$upload_valid = ($tmp_file == $up_file);
		}
		
		
		if (!$upload_valid)
		{
			// Don't use file in case of exploit
			phpAds_PageHeader("1");
			phpAds_Die ('Error', $strErrorUploadSecurity);
		}
		else
		{
			if (@file_exists ($uploaded['tmp_name']))
			{
				$upload_error = false;
				
				// Read the contents of the file in a buffer
				if ($fp = @fopen($uploaded['tmp_name'], "rb"))
				{
					$uploaded['buffer'] = @fread($fp, @filesize($uploaded['tmp_name']));
					@fclose ($fp);
				}
				else
				{
					// Check if moving the file is possible
					if (function_exists("move_uploaded_file"))
					{
						$tmp_dir = phpAds_path.'/misc/tmp/'.basename($uploaded['tmp_name']);
						
						// Try to move the file
						if (@move_uploaded_file ($uploaded['tmp_name'], $tmp_dir))
						{
							$uploaded['tmp_name'] = $tmp_dir;
							
							// Try again if the file is readable
							if ($fp = @fopen($uploaded['tmp_name'], "rb"))
							{
								$uploaded['buffer'] = @fread($fp, @filesize($uploaded['tmp_name']));
								@fclose($fp);
							}
							else
								$upload_error = true;
						}
						else
							$upload_error = true;
					}
					else
						$upload_error = true;
				}
				
				if ($upload_error)
				{
					phpAds_PageHeader("1");
					phpAds_Die ('Error', $strErrorUploadBasedir);
				}
				
				
				// Determine width and height
				$size = @getimagesize($uploaded['tmp_name']);
				$uploaded['width'] = $size[0];
				$uploaded['height'] = $size[1];
			}
			else
			{
				phpAds_PageHeader("1");
				phpAds_Die ('Error', $strErrorUploadUnknown);
			}
		}
		
		
		// Remove temporary file
		if (@file_exists($uploaded['tmp_name']))
			@unlink ($uploaded['tmp_name']);
	}
	
	
	
	// Clean url variable if it is left empty
	if ($url == 'http://')
		$url = '';
	
	if (!isset($target))
		$target = '';
	
	
	// Get current settings
	if (isset($bannerid) && $bannerid != 0)
	{
		$res = phpAds_dbQuery ("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '".$bannerid."'
		");
		
		$current = phpAds_dbFetchArray($res);
		
		$final['appendtype'] = $current['appendtype'];
		$final['append']	 = $current['append'];
	}
	
	
	// Set default edit_swf to false
	$edit_swf = false;
	
	
	// Prepare for storage
	switch($storagetype) 
	{
		case 'sql':
			if (isset($uploaded) && $replaceimage == 't')
			{
				// Get the filename
				$final['filename'] = basename(stripslashes($uploaded['name']));
				
				// Get the height and width
				$final['width'] = $uploaded['width'];
				$final['height'] = $uploaded['height'];
				
				// Get the contenttype
				$ext = substr($uploaded['name'], strrpos($uploaded['name'], ".") + 1);
				switch (strtolower($ext)) 
				{
					case 'jpeg': $final['contenttype'] = 'jpeg';  break;
					case 'jpg':	 $final['contenttype'] = 'jpeg';  break;
					case 'html': $final['contenttype'] = 'html';  break;
					case 'png':  $final['contenttype'] = 'png';   break;
					case 'gif':  $final['contenttype'] = 'gif';   break;
					case 'swf':  $final['contenttype'] = 'swf';   break;
					case 'dcr':  $final['contenttype'] = 'dcr';   break;
					case 'rpm':  $final['contenttype'] = 'rpm';   break;
					case 'mov':  $final['contenttype'] = 'mov';   break;
				}
				
				if ($final['contenttype'] == 'swf')
				{
					// Get dimensions of Flash file
					list ($final['width'], $final['height']) = phpAds_SWFDimensions($uploaded['buffer']);
					$final['pluginversion'] = phpAds_SWFVersion($uploaded['buffer']);
					
					// Check if the Flash banner includes hard coded urls
					if (isset($checkswf) && $checkswf == 't' &&
						$final['pluginversion'] >= 3 &&
						phpAds_SWFInfo($uploaded['buffer']))
					{
						$edit_swf = true;
					}
				}
				else
					$final['pluginversion'] = 0;
				
				// Store the file
				$final['filename'] = phpAds_ImageStore($storagetype, $final['filename'], $uploaded['buffer']);
				$final['imageurl'] = '{url_prefix}/adimage.php?filename='.$final['filename']."&amp;contenttype=".$final['contenttype'];
				
				// Cleanup existing image, if it exists
				if (isset($current['filename']) && $current['filename'] != '' && $current['filename'] != $final['filename'])
					phpAds_ImageDelete ($current['storagetype'], $current['filename']);
			}
			else
			{
				$final['contenttype'] = $current['contenttype'];
				$final['pluginversion'] = $current['pluginversion'];
				$final['filename'] = $current['filename'];
				$final['imageurl'] = $current['imageurl'];
				$final['width']  = $width;
				$final['height'] = $height;
			}
			
			
			if (!isset($bannerid) || $bannerid == '0' || $bannerid == '')
			{
				// New banner set html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			elseif ($final['contenttype'] != $current['contenttype'])
			{
				// Check if the contenttype has changed, if true change html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			else
			{
				// Use existing html template
				$final['htmltemplate'] = stripslashes($current['htmltemplate']);
			}
			
			// Set remaining properties
			$final['alt'] 		  = phpAds_htmlQuotes($alt);
			$final['status']	  = $status;
			$final['bannertext']  = phpAds_htmlQuotes($bannertext);
			$final['url'] 		  = $url;
			$final['target'] 	  = $target;
			$final['storagetype'] = $storagetype;
			
			
			// Update existing hard-coded links
			if (isset($alink) && is_array($alink) && count($alink))
			{
				while (list ($key, $val) = each ($alink))
				{
					if (substr($val, 0, 7) == 'http://' && strlen($val) > 7)
					{
						if (isset($alink_chosen) && $alink_chosen == $key) $final['url'] = $val;
						
						if (isset($asource[$key]) && $asource[$key] != '')
							$val .= '|source:'.$asource[$key];
						
						$final['htmltemplate'] = eregi_replace ("alink".$key."=\{targeturl:[^\}]+\}", "alink".$key."={targeturl:".$val."}", $final['htmltemplate']);
					}
				}
				
				if (isset($atar) && is_array($atar) && count ($atar))
				{
					while (list ($key, $val) = each ($atar))
					{
						$final['htmltemplate'] = eregi_replace ("atar".$key."=[^'&]*", "atar".$key."=".$val, $final['htmltemplate']);
						if (isset($alink_chosen) && $alink_chosen == $key) $final['target'] = $val;
					}
				}
			}
			
			
			// Update bannercache
			$final['htmlcache']   = addslashes(phpAds_getBannerCache($final));
			$final['htmltemplate']= addslashes($final['htmltemplate']);
			
			break;
		
		case 'web':
			if (isset($uploaded) && $replaceimage == 't')
			{
				// Get the filename
				$final['filename'] = basename(stripslashes($uploaded['name']));
				
				// Get the height and width
				$final['width'] = $uploaded['width'];
				$final['height'] = $uploaded['height'];
				
				// Get the contenttype
				$ext = substr($uploaded['name'], strrpos($uploaded['name'], ".") + 1);
				switch (strtolower($ext)) 
				{
					case 'jpeg': $final['contenttype'] = 'jpeg';  break;
					case 'jpg':	 $final['contenttype'] = 'jpeg';  break;
					case 'html': $final['contenttype'] = 'html';  break;
					case 'png':  $final['contenttype'] = 'png';   break;
					case 'gif':  $final['contenttype'] = 'gif';   break;
					case 'swf':  $final['contenttype'] = 'swf';   break;
					case 'dcr':  $final['contenttype'] = 'dcr';   break;
					case 'rpm':  $final['contenttype'] = 'rpm';   break;
					case 'mov':  $final['contenttype'] = 'mov';   break;
				}
				
				if ($final['contenttype'] == 'swf')
				{
					// Get dimensions of Flash file
					list ($final['width'], $final['height']) = phpAds_SWFDimensions($uploaded['buffer']);
					$final['pluginversion'] = phpAds_SWFVersion($uploaded['buffer']);
					
					// Check if the Flash banner includes hard coded urls
					if ($checkswf == 't' &&
						$final['pluginversion'] >= 3 &&
						phpAds_SWFInfo($uploaded['buffer']))
					{
						$edit_swf = true;
					}
				}
				else
					$final['pluginversion'] = 0;
				
				// Add slashes to the file for storage
				$final['filename'] = phpAds_ImageStore($storagetype, $final['filename'], $uploaded['buffer']);
				$final['imageurl'] = $phpAds_config['type_web_url'].'/'.$final['filename'];
				
				if ($final['filename'] == false)
				{
					phpAds_PageHeader("1");
					
					if ($phpAds_config['type_web_mode'] == 0)
						phpAds_Die ('Error', $strErrorStoreLocal);
					else
						phpAds_Die ('Error', $strErrorStoreFTP);
				}
				
				
				// Cleanup existing image, if it exists
				if (isset($current['filename']) && $current['filename'] != '' && $current['filename'] != $final['filename'])
					phpAds_ImageDelete ($current['storagetype'], $current['filename']);				
			}
			else
			{
				$final['contenttype'] = $current['contenttype'];
				$final['pluginversion'] = $current['pluginversion'];
				$final['filename'] = $current['filename'];
				$final['imageurl'] = $current['imageurl'];
				$final['width']  = $width;
				$final['height'] = $height;
			}
			
			
			if (!isset($bannerid) || $bannerid == '0' || $bannerid == '')
			{
				// New banner set html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			elseif ($final['contenttype'] != $current['contenttype'])
			{
				// Check if the contenttype has changed, if true change html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			else
			{
				// Use existing html template
				$final['htmltemplate'] = stripslashes($current['htmltemplate']);
			}
			
			
			// Set remaining properties
			$final['alt'] 		  = phpAds_htmlQuotes($alt);
			$final['status']	  = $status;
			$final['bannertext']  = phpAds_htmlQuotes($bannertext);
			$final['url'] 		  = $url;
			$final['target'] 	  = $target;
			$final['storagetype'] = $storagetype;
			
			
			// Update existing hard-coded links
			if (isset($alink) && is_array($alink) && count($alink))
			{
				while (list ($key, $val) = each ($alink))
				{
					if (substr($val, 0, 7) == 'http://' && strlen($val) > 7)
					{
						if (isset($alink_chosen) && $alink_chosen == $key) $final['url'] = $val;
						
						if (isset($asource[$key]) && $asource[$key] != '')
							$val .= '|source:'.$asource[$key];
						
						$final['htmltemplate'] = eregi_replace ("alink".$key."=\{targeturl:[^\}]+\}", "alink".$key."={targeturl:".$val."}", $final['htmltemplate']);
					}
				}
				
				if (isset($atar) && is_array($atar) && count ($atar))
				{
					while (list ($key, $val) = each ($atar))
					{
						$final['htmltemplate'] = eregi_replace ("atar".$key."=[^'&]*", "atar".$key."=".$val, $final['htmltemplate']);
						if (isset($alink_chosen) && $alink_chosen == $key) $final['target'] = $val;
					}
				}
			}
			
			
			// Update bannercache
			$final['htmlcache']   = addslashes(phpAds_getBannerCache($final));
			$final['htmltemplate']= addslashes($final['htmltemplate']);
			
			break;
		
		case 'url':
			if ($imageurl == 'http://')
				$final['imageurl'] = '';
			else
				$final['imageurl'] = $imageurl;
			
			$ext = parse_url($final['imageurl']);
			$ext = $ext['path'];
			$ext = substr($ext, strrpos($ext, ".") + 1);
			switch (strtolower($ext)) 
			{
				case 'jpeg': $final['contenttype'] = 'jpeg';  break;
				case 'jpg':	 $final['contenttype'] = 'jpeg';  break;
				case 'html': $final['contenttype'] = 'html';  break;
				case 'png':  $final['contenttype'] = 'png';   break;
				case 'gif':  $final['contenttype'] = 'gif';   break;
				case 'swf':  $final['contenttype'] = 'swf';   break;
				case 'dcr':  $final['contenttype'] = 'dcr';   break;
				case 'rpm':  $final['contenttype'] = 'rpm';   break;
				case 'mov':  $final['contenttype'] = 'mov';   break;
				default:  	 $final['contenttype'] = 'gif';   break;
			}
			
			$final['filename']	  = '';
			
			$final['width'] 	  = $width;
			$final['height'] 	  = $height;
			
			if (!isset($bannerid) || $bannerid == '0' || $bannerid == '')
			{
				// New banner set html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			elseif ($final['contenttype'] != $current['contenttype'])
			{
				// Check if the contenttype has changed, if true change html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			else
			{
				// Use existing html template
				$final['htmltemplate'] = stripslashes($current['htmltemplate']);
			}
			
			
			// Set remaining properties
			$final['alt'] 		  = phpAds_htmlQuotes($alt);
			$final['status'] 	  = $status;
			$final['bannertext']  = phpAds_htmlQuotes($bannertext);
			$final['url'] 		  = $url;
			$final['target'] 	  = $target;
			$final['storagetype'] = $storagetype;
			
			// Update bannercache
			$final['htmlcache']   = addslashes(phpAds_getBannerCache($final));
			$final['htmltemplate']= addslashes($final['htmltemplate']);
			
			break;
		
		case 'html';
			$final['filename']	  = '';
			$final['imageurl'] 	  = '';
			$final['alt'] 		  = '';
			$final['bannertext']  = '';
			
			$final['width'] 	  = $width;
			$final['height'] 	  = $height;
			$final['autohtml'] 	  = isset($autohtml) ? 't' : 'f';
			$final['url'] 		  = $url;
			$final['target'] 	  = $target;
			$final['contenttype'] = 'html';
			$final['storagetype'] = $storagetype;
			
			// Update bannercache
			$final['htmltemplate']= stripslashes ($banner);
			$final['htmlcache']   = addslashes (phpAds_getBannerCache($final));
			$final['htmltemplate']= addslashes ($final['htmltemplate']);
			
			break;
		
		case 'txt';
			$final['filename']	  = '';
			$final['imageurl'] 	  = '';
			$final['alt'] 		  = '';
			$final['width'] 	  = 0;
			$final['height'] 	  = 0;
			
			$final['bannertext']  = phpAds_htmlQuotes($bannertext);
			$final['url'] 		  = $url;
			$final['target'] 	  = $target;
			$final['status']  	  = $status;
			$final['contenttype'] = 'txt';
			$final['storagetype'] = $storagetype;
			
			
			if (!isset($bannerid) || $bannerid == '0' || $bannerid == '')
			{
				// New banner set html template
				$final['htmltemplate'] = phpAds_getBannerTemplate($final['contenttype']);
			}
			else
			{
				// Use existing html template
				$final['htmltemplate'] = stripslashes($current['htmltemplate']);
			}
			
			// Update bannercache
			$final['htmlcache']   = addslashes (phpAds_getBannerCache($final));
			$final['htmltemplate']= addslashes ($final['htmltemplate']);
			
			break;
		
		case 'network';
			$final['filename']	  = '';
			$final['imageurl'] 	  = '';
			$final['alt'] 		  = '';
			$final['bannertext']  = '';
			$final['url'] 		  = '';
			$final['target'] 	  = '';
			
			$final['width'] 	  = $width;
			$final['height'] 	  = $height;
			$final['contenttype'] = 'html';
			$final['storagetype'] = $storagetype;
			
			// Get the network template
			if (!isset($bannerid) || $bannerid == '')
				$final['htmltemplate'] = @fread(@fopen(phpAds_path."/admin/networks/".$network.".html", "rb"), @filesize(phpAds_path."/admin/networks/".$network.".html"));
			else
				$final['htmltemplate'] = $current['htmltemplate'];
			
			// Update bannercache
			$final['htmltemplate'] = phpAds_setNetworkInfo($final['htmltemplate'], $vars);
			$final['htmlcache']    = addslashes (phpAds_getBannerCache($final));
			$final['htmltemplate'] = addslashes ($final['htmltemplate']);
			
			break;
	}
	
	$final['clientid'] = $campaignid;
	$final['bannerid'] = $bannerid;
	
	$final['appendtype'] = isset($final['appendtype']) ? addslashes($final['appendtype']) : '';
	$final['append'] = isset($final['append']) ? addslashes($final['append']) : '';
	
	
	if (phpAds_isUser(phpAds_Admin)) 
	{
		if (isset($keyword) && $keyword != '')
		{
			$keywordArray = split('[ ,]+', trim($keyword));
			$final['keyword'] = implode(' ', $keywordArray);
		}
		else
			$final['keyword'] = '';
		
		$final['active'] = "t";
		$final['description'] = $description;
		$final['weight'] = $weight;
	}
	
	
	// Construct appropiate SQL query
	// If bannerid==null, then this is an INSERT, else it's an UPDATE
	if (isset($bannerid) && trim($bannerid) != '')
	{
		// UPDATE
		$set = "";
		while (list($name, $value) = each($final))
		{
			$set .= "$name = '$value', ";
		}
		
		// Cut trailing commas
		$set = ereg_replace(", $", "", $set);
		
		// Execute query
		$sql_query = "
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				$set
			WHERE
				bannerid = ".$final['bannerid'];
		$res = phpAds_dbQuery($sql_query) or phpAds_sqlDie();
	}
	else
	{
		// INSERT
		$final['compiledlimitation'] = "true";
		
		$values_fields = "";
		$values = "";
		while (list($name, $value) = each($final))
		{
			$values_fields .= "$name, ";
			$values .= "'$value', ";
		}
		
		// Cut trailing commas
		$values_fields = ereg_replace(", $", "", $values_fields);
		$values = ereg_replace(", $", "", $values);
		
		// Execute query
		$sql_query = "
			INSERT INTO
				".$phpAds_config['tbl_banners']."
				($values_fields)
			VALUES
			($values)";
		$res = phpAds_dbQuery($sql_query) or phpAds_sqlDie();
		
		$bannerid = phpAds_dbInsertID();
	}
	
	// Recalculate priorities
	if (!isset($current) || $current['weight'] != $weight)
	{
		require ("../libraries/lib-priority.inc.php");
		phpAds_PriorityCalculate ();
	}
	
	
	// Rebuild cache
	if (!defined('LIBVIEWCACHE_INCLUDED')) 
		include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	phpAds_cacheDelete();
	
	
	if ($edit_swf)
	{
		Header('Location: banner-swf.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
	}
	else
	{
		if (phpAds_isUser(phpAds_Client))
		{
			Header('Location: stats-campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid);
		}
		else
		{
			Header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
		}
	}
	
	exit;
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($bannerid != '')
{
	// Fetch the data from the database
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = '$bannerid'
	") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($res);
	
	
	
	if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['listorder']))
		$navorder = $Session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
	else
		$navorder = '';
	
	if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection']))
		$navdirection = $Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
	else
		$navdirection = '';
	
	
	// Get other banners
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = '$campaignid'
		".phpAds_getBannerListOrder($navorder, $navdirection)."
	");
	
	while ($others = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildBannerName ($others['bannerid'], $others['description'], $others['alt']),
			"banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$others['bannerid'],
			$bannerid == $others['bannerid']
		);
	}
	
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
		phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
		phpAds_PageShortcut($strBannerHistory, 'stats-banner-history.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-statistics.gif');
		
		
		
		$extra  = "<form action='banner-modify.php'>";
		$extra .= "<input type='hidden' name='bannerid' value='$bannerid'>";
		$extra .= "<input type='hidden' name='clientid' value='$clientid'>";
		$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
		$extra .= "<input type='hidden' name='returnurl' value='banner-edit.php'>";
		$extra .= "<br><br>";
		$extra .= "<b>$strModifyBanner</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-duplicate-banner.gif' align='absmiddle'>&nbsp;<a href='banner-modify.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&duplicate=true&returnurl=banner-edit.php'>$strDuplicate</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-move-banner.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
		$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$extra .= "<select name='moveto' style='width: 110;'>";
		
		$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent != 0 AND clientid != '".$campaignid."'") or phpAds_sqlDie();
		while ($others = phpAds_dbFetchArray($res))
			$extra .= "<option value='".$others['clientid']."'>".phpAds_buildClientName($others['clientid'], $others['clientname'])."</option>";
		
		$extra .= "</select>&nbsp;<input type='image' name='moveto' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&returnurl=campaign-banners.php'".phpAds_DelConfirm($strConfirmDeleteBanner).">$strDelete</a><br>";
		$extra .= "</form>";
		
		
		phpAds_PageHeader("4.1.3.4.2", $extra);
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("4.1.3.4.2", "4.1.3.4.3", "4.1.3.4.6", "4.1.3.4.4"));
	}
	else
	{
		phpAds_PageHeader("1.2.2.2");
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("1.2.2.1","1.2.2.2"));
	}
	
	
	
	// Set basic values
	$storagetype 	   = $row['storagetype'];
	$hardcoded_links   = array();
	$hardcoded_targets = array();
	$hardcoded_sources = array();
	
	
	// Check for hard-coded links
	if ($row['contenttype'] == 'swf')
	{
		if (strpos($row['htmltemplate'], 'alink1={targeturl:') != false)
		{
			$buffer = $row['htmltemplate'];
			
			while (eregi("alink([0-9]+)=\{targeturl:([^\}]+)\}", $buffer, $regs))
			{
				if (strpos($regs[2], '|source:') != false)
				{
					list ($hardcoded_links[$regs[1]], $hardcoded_sources[$regs[1]]) = explode ('|source:', $regs[2]);
				}
				else
				{
					$hardcoded_links[$regs[1]] = $regs[2];
					$hardcoded_sources [$regs[1]] = '';
				}
				
				$buffer = str_replace ($regs[0], '', $buffer);
			}
			
			while (eregi("atar([0-9]+)=([^'&]*)", $buffer, $regs))
			{
				$hardcoded_targets[$regs[1]] = $regs[2];
				$buffer = str_replace ($regs[0], '', $buffer);
			}
		}
	}
}
else
{
	phpAds_PageHeader("4.1.3.4.1");
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br><br><br>";
		phpAds_ShowSections(array("4.1.3.4.1"));
	
	// Set default values for new banner
	$row['alt'] 		 = '';
	$row['status'] 		 = '';
	$row['bannertext'] 	 = '';
	$row['url'] 		 = "http://";
	$row['target'] 		 = '';
	$row['imageurl'] 	 = "http://";
	$row['width'] 		 = '';
	$row['height'] 		 = '';
	$row['htmltemplate'] = '';
	$row['keyword'] 	 = '';
	$row['description']  = '';
	$row['autohtml']	 = $phpAds_config['type_html_auto'] ? 't' : 'f';
	
	$hardcoded_links = array();
	$hardcoded_targets = array();
	$hardcoded_sources = array();
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/


// Determine which bannertypes to show
$show_sql  	  = $phpAds_config['type_sql_allow'];
$show_web  	  = $phpAds_config['type_web_allow'];
$show_url  	  = $phpAds_config['type_url_allow'];
$show_html 	  = $phpAds_config['type_html_allow'];
$show_txt 	  = $phpAds_config['type_txt_allow'];
$show_network = false;

if (isset($storagetype) && $storagetype == "sql") 	   $show_sql     = true;
if (isset($storagetype) && $storagetype == "web")      $show_web     = true;
if (isset($storagetype) && $storagetype == "url")      $show_url     = true;
if (isset($storagetype) && $storagetype == "html")     $show_html    = true;
if (isset($storagetype) && $storagetype == "txt")      $show_txt     = true;
if (isset($storagetype) && $storagetype == "network")  $show_network = true;

// If adding a new banner or used storing type is disabled
// determine which bannertype to show as default

if (!isset($storagetype))
{
	if ($show_network) $storagetype = "network"; 
	if ($show_txt)     $storagetype = "txt"; 
	if ($show_html)    $storagetype = "html"; 
	if ($show_url)     $storagetype = "url"; 
	if ($show_web)     $storagetype = "web"; 
	if ($show_sql)     $storagetype = "sql"; 
}

$tabindex = 1;


if (!isset($bannerid) || $bannerid == '')
{
	echo "<form action='banner-edit.php' method='POST' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='clientid' value='".$clientid."'>";
	echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
	echo "<input type='hidden' name='bannerid' value='".$bannerid."'>";
	
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$strChooseBanner."</b></td></tr>";
	echo "<tr><td height='25'>";
	echo "<select name='storagetype' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
	
	if ($show_sql)     echo "<option value='sql'".($storagetype == "sql" ? ' selected' : '').">".$strMySQLBanner."</option>";
	if ($show_web) 	   echo "<option value='web'".($storagetype == "web" ? ' selected' : '').">".$strWebBanner."</option>";
	if ($show_url) 	   echo "<option value='url'".($storagetype == "url" ? ' selected' : '').">".$strURLBanner."</option>";
	if ($show_html)    echo "<option value='html'".($storagetype == "html" ? ' selected' : '').">".$strHTMLBanner."</option>";
	if ($show_txt)     echo "<option value='txt'".($storagetype == "txt" ? ' selected' : '').">".$strTextBanner."</option>";
	if ($show_network) echo "<option value='network'".($storagetype == "network" ? ' selected' : '').">".$strBannerNetwork."</option>";
	
	echo "</select>";
	echo "</td></tr></table>";
	phpAds_ShowBreak();
	echo "</form>";
	
	
	if ($storagetype == "network")
	{
		$networks = phpAds_AvailableNetworks();
		
		if (count($networks))
		{
			if (!isset($network) || $network == '')
			{
				reset ($networks);
				$network = key($networks);
			}
			
			echo "<form action='banner-edit.php' method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' name='clientid' value='".$clientid."'>";
			echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
			echo "<input type='hidden' name='bannerid' value='".$bannerid."'>";
			echo "<input type='hidden' name='storagetype' value='".$storagetype."'>";
			
			echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
			echo "<tr><td height='25' colspan='3'><b>".$strChooseNetwork."</b></td></tr>";
			echo "<tr><td height='25'>";
			echo "<select name='network' onChange='this.form.submit();'>";
			
			for (reset($networks);$key=key($networks);next($networks))
			{
				echo "<option value='".$key."'".($network == $key ? ' selected' : '').">".$networks[$key]."</option>";
			}
			
			echo "</select>";
			echo "</td>";
			
			//echo "<td align='right'><img src='images/icon-edit.gif' align='absmiddle'> Edit Templates</td>";
			
			echo "</tr></table>";
			phpAds_ShowBreak();
			echo "</form>";
		}
		else
		{
			phpAds_PageFooter();
			exit;
		}
	}
}


?>

<script language='JavaScript'>
<!--
	
	function selectFile(o)
	{
		var filename = o.value.toLowerCase();
		var swflayer = findObj ('swflayer');
		var editbanner = findObj ('editbanner');
		
		// Show SWF Layer
		if (swflayer)
		{
			if (filename.indexOf('swf') + 3 == filename.length)
				swflayer.style.display = '';
			else
				swflayer.style.display = 'none';
		}
		
		// Check upload option
		if (editbanner.replaceimage[1])
			editbanner.replaceimage[1].checked = true;
	}
	
//-->
</script>

<?php


echo "<form id='editbanner' action='banner-edit.php' method='POST' enctype='multipart/form-data'>";
echo "<input type='hidden' name='clientid' value='".$clientid."'>";
echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
echo "<input type='hidden' name='bannerid' value='".$bannerid."'>";
echo "<input type='hidden' name='storagetype' value='".$storagetype."'>";


if ($storagetype == 'sql')
{
	echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".$strMySQLBanner."</b></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	if (isset($row['filename']) && $row['filename'] != '')
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200' valign='top'>".$strUploadOrKeep."</td>";
		echo "<td><table cellpadding='0' cellspacing='0' border='0'>";
		echo "<tr valign='top'><td><input type='radio' name='replaceimage' value='f' checked tabindex='".($tabindex++)."'></td><td>&nbsp;";
		
		switch ($row['contenttype'])
		{
			case 'swf':  echo "<img src='images/icon-filetype-swf.gif' align='absmiddle'> ".$row['filename']; break;
			case 'dcr':  echo "<img src='images/icon-filetype-swf.gif' align='absmiddle'> ".$row['filename']; break;
			case 'jpeg': echo "<img src='images/icon-filetype-jpg.gif' align='absmiddle'> ".$row['filename']; break;
			case 'gif':  echo "<img src='images/icon-filetype-gif.gif' align='absmiddle'> ".$row['filename']; break;
			case 'png':  echo "<img src='images/icon-filetype-png.gif' align='absmiddle'> ".$row['filename']; break;
			case 'rpm':  echo "<img src='images/icon-filetype-rpm.gif' align='absmiddle'> ".$row['filename']; break;
			case 'mov':  echo "<img src='images/icon-filetype-mov.gif' align='absmiddle'> ".$row['filename']; break;
			default:	 echo "<img src='images/icon-banner-stored.gif' align='absmiddle'> ".$row['filename']; break;
		}
		
		$size = phpAds_ImageSize($storagetype, $row['filename']);
		if (round($size / 1024) == 0)
			echo " <i dir='".$phpAds_TextDirection."'>(".$size." bytes)</i>";
		else
			echo " <i dir='".$phpAds_TextDirection."'>(".round($size / 1024)." Kb)</i>";
		
		echo "</td></tr>";
		echo "<tr valign='top'><td><input type='radio' name='replaceimage' value='t' tabindex='".($tabindex++)."'></td>";
		echo "<td>&nbsp;<input class='flat' size='26' type='file' name='upload' style='width:250px;' onChange='selectFile(this);' tabindex='".($tabindex++)."'>";
		
		echo "<div id='swflayer' style='display:none;'>";
		echo "<input type='checkbox' name='checkswf' value='t' checked tabindex='".($tabindex++)."'>&nbsp;".$strCheckSWF;
		echo "</div>";
		
		echo "</td></tr></table><br><br></td></tr>";
		echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	}
	else
	{
		echo "<input type='hidden' name='replaceimage' value='t'>";
		
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200' valign='top'>".$strNewBannerFile."</td>";
		echo "<td><input class='flat' size='26' type='file' name='upload' style='width:350px;' onChange='selectFile(this);' tabindex='".($tabindex++)."'>";
		
		echo "<div id='swflayer' style='display:none;'>";
		echo "<input type='checkbox' name='checkswf' value='t' checked tabindex='".($tabindex++)."'>&nbsp;".$strCheckSWF;
		echo "</div>";
		
		echo "<br><br></td></tr>";
		echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	}
	
	if (count($hardcoded_links) == 0)
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strURL."</td>";
		echo "<td><input class='flat' size='35' type='text' name='url' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($row["url"])."' tabindex='".($tabindex++)."'></td></tr>";
		
		echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strTarget."</td>";
		echo "<td><input class='flat' size='16' type='text' name='target' style='width:150px;' dir='ltr' value='".$row["target"]."' tabindex='".($tabindex++)."'></td></tr>";
	}
	else
	{
		$i = 0;
		
		while (list($key, $val) = each($hardcoded_links))
		{
			if ($i > 0)
			{
				echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
				echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
				echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
			}
			
			echo "<tr><td width='30'>&nbsp;</td>";
			echo "<td width='200'>".$strURL."</td>";
			echo "<td><input class='flat' size='35' type='text' name='alink[".$key."]' style='width:330px;' dir='ltr' value='".phpAds_htmlQuotes($val)."' tabindex='".($tabindex++)."'>";
			echo "<input type='radio' name='alink_chosen' value='".$key."'".($val == $row['url'] ? ' checked' : '')." tabindex='".($tabindex++)."'></td></tr>";
			
			if (isset($hardcoded_targets[$key]))
			{
				echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
				echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
				
				echo "<tr><td width='30'>&nbsp;</td>";
				echo "<td width='200'>".$strTarget."</td>";
				echo "<td><input class='flat' size='16' type='text' name='atar[".$key."]' style='width:150px;' dir='ltr' value='".phpAds_htmlQuotes($hardcoded_targets[$key])."' tabindex='".($tabindex++)."'>";
				echo "</td></tr>";
			}
			
			if (count($hardcoded_links) > 1)
			{
				echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
				echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
				
				echo "<tr><td width='30'>&nbsp;</td>";
				echo "<td width='200'>".$strOverwriteSource."</td>";
				echo "<td><input class='flat' size='50' type='text' name='asource[".$key."]' style='width:150px;' dir='ltr' value='".phpAds_htmlQuotes($hardcoded_sources[$key])."' tabindex='".($tabindex++)."'>";
				echo "</td></tr>";
			}
			
			$i++;
		}
		
		echo "<input type='hidden' name='url' value='".$row['url']."'>";
	}
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strAlt."</td>";
	echo "<td><input class='flat' size='35' type='text' name='alt' style='width:350px;' value='".$row["alt"]."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strStatusText."</td>";
	echo "<td><input class='flat' size='35' type='text' name='status' style='width:350px;' value='".phpAds_htmlQuotes($row["status"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTextBelow."</td>";
	echo "<td><input class='flat' size='35' type='text' name='bannertext' style='width:350px;' value='".$row["bannertext"]."' tabindex='".($tabindex++)."'></td></tr>";
	
	if (isset($bannerid) && $bannerid != '')
	{
		echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strSize."</td>";
		echo "<td>".$strWidth.": <input class='flat' size='5' type='text' name='width' value='".$row["width"]."' tabindex='".($tabindex++)."'>&nbsp;&nbsp;&nbsp;";
		echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".$row["height"]."' tabindex='".($tabindex++)."'></td></tr>";
	}
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

if ($storagetype == 'web')
{
	echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".$strWebBanner."</b></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	if (isset($row['filename']) && $row['filename'] != '')
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200' valign='top'>".$strUploadOrKeep."</td>";
		echo "<td><table cellpadding='0' cellspacing='0' border='0'>";
		echo "<tr valign='top'><td><input type='radio' name='replaceimage' value='f' checked tabindex='".($tabindex++)."'></td><td>&nbsp;";
		
		switch ($row['contenttype'])
		{
			case 'swf':  echo "<img src='images/icon-filetype-swf.gif' align='absmiddle'> ".$row['filename']; break;
			case 'dcr':  echo "<img src='images/icon-filetype-swf.gif' align='absmiddle'> ".$row['filename']; break;
			case 'jpeg': echo "<img src='images/icon-filetype-jpg.gif' align='absmiddle'> ".$row['filename']; break;
			case 'gif':  echo "<img src='images/icon-filetype-gif.gif' align='absmiddle'> ".$row['filename']; break;
			case 'png':  echo "<img src='images/icon-filetype-png.gif' align='absmiddle'> ".$row['filename']; break;
			case 'rpm':  echo "<img src='images/icon-filetype-rpm.gif' align='absmiddle'> ".$row['filename']; break;
			case 'mov':  echo "<img src='images/icon-filetype-mov.gif' align='absmiddle'> ".$row['filename']; break;
			default:	 echo "<img src='images/icon-banner-stored.gif' align='absmiddle'> ".$row['filename']; break;
		}
		
		$size = phpAds_ImageSize($storagetype, $row['filename']);
		if (round($size / 1024) == 0)
			echo " <i>(".$size." bytes)</i>";
		else
			echo " <i>(".round($size / 1024)." Kb)</i>";
		
		echo "</td></tr>";
		echo "<tr valign='top'><td><input type='radio' name='replaceimage' value='t' tabindex='".($tabindex++)."'></td>";
		echo "<td>&nbsp;<input class='flat' size='26' type='file' name='upload' style='width:250px;' onChange='selectFile(this);' tabindex='".($tabindex++)."'>";
		
		echo "<div id='swflayer' style='display:none;'>";
		echo "<input type='checkbox' name='checkswf' value='t' checked tabindex='".($tabindex++)."'>&nbsp;".$strCheckSWF;
		echo "</div>";
		
		echo "</td></tr></table><br><br></td></tr>";
		echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	}
	else
	{
		echo "<input type='hidden' name='replaceimage' value='t'>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200' valign='top'>".$strNewBannerFile."</td>";
		echo "<td><input class='flat' size='26' type='file' name='upload' style='width:350px;' onChange='selectFile(this);' tabindex='".($tabindex++)."'>";
		
		echo "<div id='swflayer' style='display:none;'>";
		echo "<input type='checkbox' name='checkswf' value='t' checked tabindex='".($tabindex++)."'>&nbsp;".$strCheckSWF;
		echo "</div>";
		
		echo "<br><br></td></tr>";
		echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	}
	
	if (count($hardcoded_links) == 0)
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strURL."</td>";
		echo "<td><input class='flat' size='35' type='text' name='url' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($row["url"])."' tabindex='".($tabindex++)."'></td></tr>";
		
		echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strTarget."</td>";
		echo "<td><input class='flat' size='16' type='text' name='target' style='width:150px;' dir='ltr' value='".$row["target"]."' tabindex='".($tabindex++)."'></td></tr>";
	}
	else
	{
		$i = 0;
		
		while (list($key, $val) = each($hardcoded_links))
		{
			if ($i > 0)
			{
				echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
				echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
				echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
			}
			
			echo "<tr><td width='30'>&nbsp;</td>";
			echo "<td width='200'>".$strURL."</td>";
			echo "<td><input class='flat' size='35' type='text' name='alink[".$key."]' style='width:330px;' dir='ltr' value='".phpAds_htmlQuotes($val)."' tabindex='".($tabindex++)."'>";
			echo "<input type='radio' name='alink_chosen' value='".$key."'".($val == $row['url'] ? ' checked' : '')." tabindex='".($tabindex++)."'></td></tr>";
			
			if (isset($hardcoded_targets[$key]))
			{
				echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
				echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
				
				echo "<tr><td width='30'>&nbsp;</td>";
				echo "<td width='200'>".$strTarget."</td>";
				echo "<td><input class='flat' size='16' type='text' name='atar[".$key."]' style='width:150px;' dir='ltr' value='".phpAds_htmlQuotes($hardcoded_targets[$key])."' tabindex='".($tabindex++)."'>";
				echo "</td></tr>";
			}
			
			echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
			echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
			
			echo "<tr><td width='30'>&nbsp;</td>";
			echo "<td width='200'>".$strOverwriteSource."</td>";
			echo "<td><input class='flat' size='50' type='text' name='asource[".$key."]' style='width:150px;' dir='ltr' value='".phpAds_htmlQuotes($hardcoded_sources[$key])."' tabindex='".($tabindex++)."'>";
			echo "</td></tr>";
			
			$i++;
		}
		
		echo "<input type='hidden' name='url' value='".$row['url']."'>";
	}
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strAlt."</td>";
	echo "<td><input class='flat' size='35' type='text' name='alt' style='width:350px;' value='".$row["alt"]."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strStatusText."</td>";
	echo "<td><input class='flat' size='35' type='text' name='status' style='width:350px;' value='".phpAds_htmlQuotes($row["status"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTextBelow."</td>";
	echo "<td><input class='flat' size='35' type='text' name='bannertext' style='width:350px;' value='".$row["bannertext"]."' tabindex='".($tabindex++)."'></td></tr>";
	
	if (isset($bannerid) && $bannerid != '')
	{
		echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strSize."</td>";
		echo "<td>".$strWidth.": <input class='flat' size='5' type='text' name='width' value='".$row["width"]."' tabindex='".($tabindex++)."'>&nbsp;&nbsp;&nbsp;";
		echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".$row["height"]."' tabindex='".($tabindex++)."'></td></tr>";
	}
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

if ($storagetype == 'url')
{
	echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;<b>".$strURLBanner."</b></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strNewBannerURL."</td>";
	echo "<td><input class='flat' size='35' type='text' name='imageurl' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($row["imageurl"])."' tabindex='".($tabindex++)."'></td></tr>";
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strURL."</td>";
	echo "<td><input class='flat' size='35' type='text' name='url' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($row["url"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTarget."</td>";
	echo "<td><input class='flat' size='16' type='text' name='target' style='width:150px;' dir='ltr' value='".$row["target"]."' tabindex='".($tabindex++)."'></td></tr>";
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strAlt."</td>";
	echo "<td><input class='flat' size='35' type='text' name='alt' style='width:350px;' value='".$row["alt"]."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strStatusText."</td>";
	echo "<td><input class='flat' size='35' type='text' name='status' style='width:350px;' value='".phpAds_htmlQuotes($row["status"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTextBelow."</td>";
	echo "<td><input class='flat' size='35' type='text' name='bannertext' style='width:350px;' value='".$row["bannertext"]."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strSize."</td>";
	echo "<td>".$strWidth.": <input class='flat' size='5' type='text' name='width' value='".$row["width"]."' tabindex='".($tabindex++)."'>&nbsp;&nbsp;&nbsp;";
	echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".$row["height"]."' tabindex='".($tabindex++)."'></td></tr>";
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

if ($storagetype == 'html')
{
	echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;<b>".$strHTMLBanner."</b></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td colspan='2'><textarea class='code' cols='45' rows='10' name='banner' wrap='off' dir='ltr' style='width:550px;";
	echo "' tabindex='".($tabindex++)."'>".htmlentities($row['htmltemplate'])."</textarea></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td colspan='2'><input type='checkbox' name='autohtml' value='t'".(isset($row["autohtml"]) && $row["autohtml"] == 't' ? ' checked' : '')." tabindex='".($tabindex++)."'> ".$strAutoChangeHTML."</td></tr>";
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strURL."</td>";
	echo "<td><input class='flat' size='35' type='text' name='url' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($row["url"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTarget."</td>";
	echo "<td><input class='flat' size='35' type='text' name='target' style='width:350px;' dir='ltr' value='".$row["target"]."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strSize."</td>";
	echo "<td>".$strWidth.": <input class='flat' size='5' type='text' name='width' value='".$row["width"]."' tabindex='".($tabindex++)."'>&nbsp;&nbsp;&nbsp;";
	echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".$row["height"]."' tabindex='".($tabindex++)."'></td></tr>";
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

if ($storagetype == 'txt')
{
	echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-text.gif' align='absmiddle'>&nbsp;<b>".$strTextBanner."</b></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td colspan='2'><textarea class='code' cols='45' rows='10' name='bannertext' wrap='off' style='width:550px; ";
	echo "' tabindex='".($tabindex++)."'>".$row['bannertext']."</textarea></td></tr>";
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strURL."</td>";
	echo "<td><input class='flat' size='35' type='text' name='url' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($row["url"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTarget."</td>";
	echo "<td><input class='flat' size='16' type='text' name='target' style='width:150px;' dir='ltr' value='".$row["target"]."' tabindex='".($tabindex++)."'></td></tr>";
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strStatusText."</td>";
	echo "<td><input class='flat' size='35' type='text' name='status' style='width:350px;' value='".phpAds_htmlQuotes($row["status"])."' tabindex='".($tabindex++)."'></td></tr>";
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

if ($storagetype == 'network')
{
	// Get the network template
	if (!isset($bannerid) || $bannerid == '')
		$networkinfo = @fread(@fopen(phpAds_path."/admin/networks/".$network.".html", "rb"), @filesize(phpAds_path."/admin/networks/".$network.".html"));
	else
		$networkinfo = $row['htmltemplate'];
	
	if (ereg("\[define-vars\](.*)\[\/define-vars\]", $networkinfo, $matches))
		$vars = $matches[1];
	
	$result = phpAds_getNetworkInfo($networkinfo);
	
	echo "<br><br>";
	echo "<input type='hidden' name='network' value='".$network."'>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;<b>".$strBannerNetwork.": ".$result['title']."</b></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200' valign='top'>";
	echo "<a href='".$result['signup']."' target='_blank'><img src='networks/logos/".$result['logo']."' border='0'></a>";
	echo "&nbsp;</td><td>".$result['comments']."<br><br><br><br></td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	for ($i=0;$i<count($result['vars']);$i++)
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$result['vars'][$i]['title']."</td>";
		echo "<td><input class='flat' size='35' type='text' name='vars[".$result['vars'][$i]['name']."]' style='width:350px;' value='".phpAds_htmlQuotes($result['vars'][$i]['default'])."'></td></tr>";
		echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	}
	
	if (isset($result['width']) && $result['width'] != '' &&
		isset($result['height']) && $result['height'] != '')
	{
		echo "<input type='hidden' name='width' value='".$result['width']."'>";
		echo "<input type='hidden' name='height' value='".$result['height']."'>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strSize."</td>";
		echo "<td>".$strWidth.": ".$result['width']."&nbsp;&nbsp;&nbsp;";
		echo $strHeight.": ".$result['height']."</td></tr>";
	}
	else
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strSize."</td>";
		echo "<td>".$strWidth.": <input class='flat' size='5' type='text' name='width' value='".$row["width"]."'>&nbsp;&nbsp;&nbsp;";
		echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".$row["height"]."'></td></tr>";
	}
	
	echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

if (phpAds_isUser(phpAds_Admin))
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strKeyword."</td>";
    echo "<td><input class='flat' size='35' type='text' name='keyword' style='width:350px;' value='".phpAds_htmlQuotes($row["keyword"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strDescription."</td>";
    echo "<td><input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($row["description"])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strWeight."</td>";
    echo "<td><input class='flat' size='6' type='text' name='weight' value='".(isset($row["weight"]) ? $row["weight"] : $phpAds_config['default_banner_weight'])."' tabindex='".($tabindex++)."'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='35' colspan='3'><input type='submit' name='submit' value='".$strSaveChanges."' tabindex='".($tabindex++)."'></td></tr>";
echo "</table>";
echo "</form>";

echo "<br><br>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>