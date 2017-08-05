<?php // $Revision: 2.0 $

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



// Installer translation strings
$GLOBALS['strInstall']				= "��ġ";
$GLOBALS['strChooseInstallLanguage']		= "��ġ�� ����� �� �����ϼ���.";
$GLOBALS['strLanguageSelection']		= "��� ����";
$GLOBALS['strDatabaseSettings']			= "�����ͺ��̽� ����";
$GLOBALS['strAdminSettings']			= "������ ����";
$GLOBALS['strAdvancedSettings']			= "��� ����";
$GLOBALS['strOtherSettings']			= "��Ÿ ����";

$GLOBALS['strWarning']				= "���";
$GLOBALS['strFatalError']			= "ġ������ ������ �߻��߽��ϴ�.";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."�� �̹� �ý��ۿ� ��ġ�Ǿ� �ֽ��ϴ�. ������ �Ϸ��� <a href='settings-index.php'>���� �������̽�</a>�� ����Ͻʽÿ�.";
$GLOBALS['strCouldNotConnectToDB']		= "�����ͺ��̽��� ������ �� �����ϴ�. �Է��� ������ �´��� �ٽ� Ȯ���Ͻʽÿ�.";
$GLOBALS['strCreateTableTestFailed']		= "�Էµ� ����ڴ� �����ͺ��̽� ������ �����ϰų� ������Ʈ�� �� �ִ� ������ �����ϴ�. �����ͺ��̽� �����ڿ��� �����Ͻʽÿ�.";
$GLOBALS['strUpdateTableTestFailed']		= "�Էµ� ����ڴ� �����ͺ��̽� ������ ������Ʈ�� �� �ִ� ������ �����ϴ�. �����ͺ��̽� �����ڿ��� �����Ͻʽÿ�..";
$GLOBALS['strTablePrefixInvalid']		= "���̺� ���ξ�� ����� �� ���� ���ڰ� �ֽ��ϴ�.";
$GLOBALS['strTableInUse']			= "������ �����ͺ��̽��� �̹�".$phpAds_productname."���� ����ϰ� �ֽ��ϴ�. �ٸ� ���̺� ���ξ ����ϰų� ���׷��̵� ��ħ���� �����Ͻʽÿ�.";
$GLOBALS['strMayNotFunction']			= "��� �����ϱ� ���� ������ �����Ͻʽÿ�. ������ �������� �ʰ� �����ϸ� ������ �߻��� �� �ֽ��ϴ�:";
$GLOBALS['strIgnoreWarnings']			= "��� ����";
$GLOBALS['strWarningDBavailable']		= "���� ������� PHP�� ".$phpAds_dbmsname." ������ �������� �ʽ��ϴ�. PHP ".$phpAds_dbmsname." Ȯ���� ��ġ�� ������ ��� �����Ͻʽÿ�.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requires PHP 4.0 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP ���� ���� register_globals�� �����ؾ� �մϴ�.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP ���� ���� magic_quotes_gpc�� �����ؾ� �մϴ�.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP ���� ���� magic_quotes_runtime�� �����ؾ��մϴ�.";
$GLOBALS['strWarningFileUploads']		= "PHP ���� ���� file_uploads�� �����ؾ� �մϴ�.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." has detected that your <b>config.inc.php</b> file is not writeable by the server.<br> You can't proceed until you change permissions on the file. <br>Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "���� �����ͺ��̽��� ������ �� �����ϴ�. ��� �����ϸ� ������ ������ ���, ���, �����ְ� ��� �����˴ϴ�.";
$GLOBALS['strTableNames']			= "���̺� �̸�";
$GLOBALS['strTablesPrefix']			= "���̺� ���ξ�";
$GLOBALS['strTablesType']			= "���̺� ����";

$GLOBALS['strInstallWelcome']			= "ȯ���մϴ�. ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesfull.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file 
						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "���� ������ �߻��߽��ϴ�:";
$GLOBALS['strErrorInstallDatabase']		= "�����ͺ��̽� ������ �������� �ʾҽ��ϴ�.";
$GLOBALS['strErrorInstallConfig']		= "���� ���� �Ǵ� �����ͺ��̽��� ������Ʈ�� �� �����ϴ�.";
$GLOBALS['strErrorInstallDbConnect']		= "�����ͺ��̽��� ������ �� �����ϴ�.";

$GLOBALS['strUrlPrefix']			= "URL ���ξ�";

$GLOBALS['strProceed']				= "��� &gt;";
$GLOBALS['strRepeatPassword']			= "��й�ȣ Ȯ��";
$GLOBALS['strNotSamePasswords']			= "��й�ȣ�� ��ġ���� �ʽ��ϴ�.";
$GLOBALS['strInvalidUserPwd']			= "�߸��� ����� ID �Ǵ� ��й�ȣ�Դϴ�.";

$GLOBALS['strUpgrade']				= "���׷��̵�";
$GLOBALS['strSystemUpToDate']			= "�ý����� ������Ұ� �̹� �ֽ� �����Դϴ�. ���� ���׷��̵��� �� �����ϴ�.<br> Ȩ�������� �̵��Ϸ��� <b>���</b>�� Ŭ���ϼ���.";
$GLOBALS['strSystemNeedsUpgrade']		= "�ý����� �ùٸ��� �����Ϸ��� �����ͺ��̽� ������ ���� ������ ���׷��̵��ؾ� �մϴ�. �ý����� ���׷��̵��ϱ� ���� <b>���</b>�� Ŭ���Ͻʽÿ�.<br>�ý����� ���׷��̵��ϴ� �� �� �� ���� �ɸ� �� �ֽ��ϴ�.";
$GLOBALS['strSystemUpgradeBusy']		= "�ý����� ���׷��̵����Դϴ�. ��� ��ٷ��ֽʽÿ�...";
$GLOBALS['strSystemRebuildingCache']		= "ĳ�ø� �籸�����Դϴ�. ��� ��ٷ��ֽʽÿ�...";
$GLOBALS['strServiceUnavalable']		= "�ý����� ���׷��̵� ���̹Ƿ� ���񽺸� ��õ��� �̿��� �� �����ϴ�.";

$GLOBALS['strConfigNotWritable']		= "config.inc.php ���Ͽ� ���⸦ �� �� �����ϴ�.";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "���� ����";
$GLOBALS['strDayFullNames'] 			= array("�Ͽ���","������","ȭ����","������","�����","�ݿ���","�����");
$GLOBALS['strEditConfigNotPossible']   		= "���Ȼ� ���� ������ ����ֱ� ������ ������ ������ �� �����ϴ�. ".
										  "������ �����Ϸ��� config.inc.php ������ ����� �����Ͻʽÿ�.";
$GLOBALS['strEditConfigPossible']		= "���� ������ ������� �ʱ� ������ ��� ������ �����ϴ� ���� ����������, �̷����� ���� ������ �߻��� �� �ֽ��ϴ�.".
										  "�ý����� �����ϰ� �Ϸ��� config.inc.php ���Ͽ� ����� �����ؾ� �մϴ�.";



// Database
$GLOBALS['strDatabaseSettings']			= "�����ͺ��̽� ����";
$GLOBALS['strDatabaseServer']			= "�����ͺ��̽� ����";
$GLOBALS['strDbHost']				= "�����ͺ��̽� ȣ��Ʈ��";
$GLOBALS['strDbUser']				= "�����ͺ��̽� ������̸�";
$GLOBALS['strDbPassword']			= "�����ͺ��̽� ��й�ȣ";
$GLOBALS['strDbName']				= "�����ͺ��̽� �̸�";

$GLOBALS['strDatabaseOptimalisations']		= "�����ͺ��̽� ����ȭ";
$GLOBALS['strPersistentConnections']		= "���� ����(persistent connection) ���";
$GLOBALS['strInsertDelayed']			= "������ ���� ���";
$GLOBALS['strCompatibilityMode']		= "�����ͺ��̽� ȣȯ ��� ���";
$GLOBALS['strCantConnectToDb']			= "�����ͺ��̽��� ������ �� �����ϴ�.";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "��� ȣ�� �� �������� ����";

$GLOBALS['strAllowedInvocationTypes']		= "���� ��� ȣ�� ����";
$GLOBALS['strAllowRemoteInvocation']		= "���� ��� ȣ�� ���";
$GLOBALS['strAllowRemoteJavascript']		= "���� ��� ȣ�� ���(Javascript)";
$GLOBALS['strAllowRemoteFrames']		= "���� ��� ȣ�� ���(������)";
$GLOBALS['strAllowRemoteXMLRPC']		= "��� ȣ�� ���(XML-RPC)";
$GLOBALS['strAllowLocalmode']			= "���� ��� ���";
$GLOBALS['strAllowInterstitial']		= "������(Interstitial) ���";
$GLOBALS['strAllowPopups']			= "�˾� ���";

$GLOBALS['strUseAcl']				= "��� �����߿� ���� ���� ���� ��";

$GLOBALS['strDeliverySettings']			= "���� ���� ����";
$GLOBALS['strCacheType']				= "���� ���� ĳ�� ����";
$GLOBALS['strCacheFiles']				= "����";
$GLOBALS['strCacheDatabase']			= "�����ͺ��̽�";
$GLOBALS['strCacheShmop']				= "���� �޸�(shmop)";
$GLOBALS['strKeywordRetrieval']			= "Ű���� �˻�";
$GLOBALS['strBannerRetrieval']			= "��� �˻� ���";
$GLOBALS['strRetrieveRandom']			= "���� ��� �˻�(�⺻)";
$GLOBALS['strRetrieveNormalSeq']		= "��� �˻�(�Ϲ�)";
$GLOBALS['strWeightSeq']			= "����ġ�� ��� �˻�";
$GLOBALS['strFullSeq']				= "��ü ��� �˻�";
$GLOBALS['strUseConditionalKeys']		= "���� ������ ����� �� �� �����ڸ� ����մϴ�.";
$GLOBALS['strUseMultipleKeys']			= "���� ������ ����� �� �ټ��� Ű���带 ����մϴ�.";

$GLOBALS['strZonesSettings']			= "���� �˻�";
$GLOBALS['strZoneCache']			= "ĳ�� ����, ĳ�� ������ ����ϸ� ������ ����� �� �ӵ��� ������ �մϴ�.";
$GLOBALS['strZoneCacheLimit']			= "ĳ�� ������Ʈ ����(�� ����)";
$GLOBALS['strZoneCacheLimitErr']		= "������Ʈ ���ݿ��� ������ ����� �� �����ϴ�.";

$GLOBALS['strP3PSettings']			= "P3P ���� ��ȣ ��å";
$GLOBALS['strUseP3P']				= "P3P ��å ���";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact ��å";
$GLOBALS['strP3PPolicyLocation']		= "P3P ��å ��ġ"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "��� ����";

$GLOBALS['strAllowedBannerTypes']		= "��� ����";
$GLOBALS['strTypeSqlAllow']			= "���� ���(SQL) - DB ���� ���";
$GLOBALS['strTypeWebAllow']			= "���� ���(������) - �� ���� ���";
$GLOBALS['strTypeUrlAllow']			= "�ܺ� ���";
$GLOBALS['strTypeHtmlAllow']			= "HTML ���";
$GLOBALS['strTypeTxtAllow']			= "�ؽ�Ʈ ����";

$GLOBALS['strTypeWebSettings']			= "���� ���(������) ����";
$GLOBALS['strTypeWebMode']			= "���� ���";
$GLOBALS['strTypeWebModeLocal']			= "���� ���͸�";
$GLOBALS['strTypeWebModeFtp']			= "�ܺ� FTP ����";
$GLOBALS['strTypeWebDir']			= "���� ���͸�";
$GLOBALS['strTypeWebFtp']			= "FTP ��� �� ��� ����";
$GLOBALS['strTypeWebUrl']			= "��� URL";
$GLOBALS['strTypeFTPHost']			= "FTP ȣ��Ʈ";
$GLOBALS['strTypeFTPDirectory']			= "ȣ��Ʈ ���͸�";
$GLOBALS['strTypeFTPUsername']			= "�α���ID";
$GLOBALS['strTypeFTPPassword']			= "��й�ȣ";

$GLOBALS['strDefaultBanners']			= "�⺻ ���";
$GLOBALS['strDefaultBannerUrl']			= "�⺻ �̹��� URL";
$GLOBALS['strDefaultBannerTarget']		= "�⺻ ��� URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML ��� �ɼ�";
$GLOBALS['strTypeHtmlAuto']			= "Ŭ�� Ʈ��ŷ�� ���� �����ϱ� ���� HTML ��ʸ� �ڵ����� �����մϴ�.";
$GLOBALS['strTypeHtmlPhp']			= "HTML ��ʾȿ��� PHP �ڵ带 �����մϴ�.";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "��� ����";

$GLOBALS['strStatisticsFormat']			= "��� ����";
$GLOBALS['strLogBeacon']			= "AdViews�� ����ϱ� ���� ���� �̹����� ����մϴ�.";
$GLOBALS['strCompactStats']			= "������ ��踦 ����մϴ�.";
$GLOBALS['strLogAdviews']			= "AdViews �α�";
$GLOBALS['strBlockAdviews']			= "���� �α� ����(��)";
$GLOBALS['strLogAdclicks']			= "AdClicks �α�";
$GLOBALS['strBlockAdclicks']			= "���� �α� ����(��)";

$GLOBALS['strGeotargeting']			= "���� ���� �߽�(Geotargeting)";
$GLOBALS['strGeotrackingType']			= "���� ���� �����ͺ��̽� ����";
$GLOBALS['strGeotrackingLocation'] 		= "���� ���� �����ͺ��̽� ��ġ";
$GLOBALS['strGeoLogStats']			= "�湮�� ������ ��迡 ����մϴ�.";
$GLOBALS['strGeoStoreCookie']		= "���߿� �����ϱ� ���� ��Ű�� ����� �����մϴ�.";

$GLOBALS['strEmailWarnings']			= "�̸��� ���";
$GLOBALS['strAdminEmailHeaders']		= "���� ���� ������ �߼��ڿ� ���� ������ ���� ����� �����մϴ�.";
$GLOBALS['strWarnLimit']			= "���Ƚ�� ����(Warn Limit)";
$GLOBALS['strWarnLimitErr']			= "���Ƚ�� ����(Warn Limit)�� ������ ����� �� �����ϴ�.";
$GLOBALS['strWarnAdmin']			= "�����ڿ��� ��� �˸��ϴ�.";
$GLOBALS['strWarnClient']			= "�����ֿ��� ��� �˸��ϴ�.";
$GLOBALS['strQmailPatch']			= "qmail ��ġ�� ����մϴ�.(qmail�� ����ϴ� ���)";

$GLOBALS['strRemoteHosts']			= "���� ȣ��Ʈ";
$GLOBALS['strIgnoreHosts']			= "������ ȣ��Ʈ";
$GLOBALS['strReverseLookup']			= "DNS ������";
$GLOBALS['strProxyLookup']			= "���Ͻ� ����";

$GLOBALS['strAutoCleanTables']			= "�����ͺ��̽� ����";
$GLOBALS['strAutoCleanStats']			= "��� ����";
$GLOBALS['strAutoCleanUserlog']			= "����� �α� ����";
$GLOBALS['strAutoCleanStatsWeeks']		= "�������� ������ ��� �����<br>(�ּ� 3��)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "�������� ������ ����� �α� �����<br>(�ּ� 3��)";
$GLOBALS['strAutoCleanErr']			= "�ִ� ���� �Ⱓ�� 3�� �̻��̾���մϴ�.";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "������ ����";

$GLOBALS['strLoginCredentials']			= "�α��� ����";
$GLOBALS['strAdminUsername']			= "������ ID"; 
$GLOBALS['strOldPassword']			= "���� ��й�ȣ";
$GLOBALS['strNewPassword']			= "�� ��й�ȣ";
$GLOBALS['strInvalidUsername']			= "�߸��� ID"; 
$GLOBALS['strInvalidPassword']			= "�߸��� ��й�ȣ";

$GLOBALS['strBasicInformation']			= "�⺻ ����";
$GLOBALS['strAdminFullName']			= "������ ��ü �̸�";
$GLOBALS['strAdminEmail']			= "������ �̸���";
$GLOBALS['strCompanyName']			= "ȸ�� �̸�";

$GLOBALS['strAdminCheckUpdates']		= "������Ʈ �˻�";
$GLOBALS['strAdminCheckEveryLogin']		= "�α丶��";
$GLOBALS['strAdminCheckDaily']			= "����";
$GLOBALS['strAdminCheckWeekly']			= "�ְ�";
$GLOBALS['strAdminCheckMonthly']		= "����";
$GLOBALS['strAdminCheckNever']			= "����";

$GLOBALS['strAdminNovice']			= "������ ���� �����ڰ� �����ϱ� ���� Ȯ���մϴ�.";
$GLOBALS['strUserlogEmail']			= "��� �ܺ� �߼� �̸��� �޽����� ����մϴ�.";
$GLOBALS['strUserlogPriority']			= "�Žð����� �켱���� ����� ����մϴ�.";
$GLOBALS['strUserlogAutoClean']			= "�����ͺ��̽� �ڵ� ������ ����մϴ�.";


// User interface settings
$GLOBALS['strGuiSettings']			= "����� �������̽� ����";

$GLOBALS['strGeneralSettings']			= "�Ϲ� ����";
$GLOBALS['strAppName']				= "���� ���α׷� �̸�";
$GLOBALS['strMyHeader']				= "�� �Ӹ���";
$GLOBALS['strMyFooter']				= "�� �ٴڱ�";
$GLOBALS['strGzipContentCompression']		= "����Ʈ GZIP ���� ���";

$GLOBALS['strClientInterface']			= "������ �������̽�";
$GLOBALS['strClientWelcomeEnabled']		= "������ ȯ�� �޽����� ����մϴ�.";
$GLOBALS['strClientWelcomeText']		= "ȯ�� �޽���<br>(HTML �±� ����)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "�⺻ �������̽� ����";

$GLOBALS['strInventory']			= "���";
$GLOBALS['strShowCampaignInfo']			= "<i>ķ���� ���</i> �������� ķ���� ������ �ڼ��� �����ݴϴ�.";
$GLOBALS['strShowBannerInfo']			= "<i>��� ���</i> �������� ��� ������ �ڼ��� �����ݴϴ�.";
$GLOBALS['strShowCampaignPreview']		= "<i>��� ���</i> �������� ����� �̸����⸦ ��� ǥ���մϴ�.";
$GLOBALS['strShowBannerHTML']			= "HTML �ڵ� ��ſ� ���� ��ʸ� ǥ���մϴ�.";
$GLOBALS['strShowBannerPreview']		= "��� ó�� ȭ�鿡�� ������ ��ܿ� ��� �̸����⸦ ǥ���մϴ�.";
$GLOBALS['strHideInactive']			= "������� �ʴ� �׸��� ��� ��� ���������� ����ϴ�.";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>����� ���</i> �������� �ش� ��ʸ� ǥ���մϴ�.";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>����� ���</i> �������� �ش��ϴ� ���� �������� ǥ���մϴ�.";
$GLOBALS['strGUILinkCompactLimit']		= "<i>�׸��� ���� ��쿡�� <i>����� ���</i> �������� ����� ķ������ ���� ��ʴ� ����ϴ�.";

$GLOBALS['strStatisticsDefaults'] 		= "���";
$GLOBALS['strBeginOfWeek']			= "�� ���� ������";
$GLOBALS['strPercentageDecimals']		= "����� �Ҽ���";

$GLOBALS['strWeightDefaults']			= "����ġ �⺻����";
$GLOBALS['strDefaultBannerWeight']		= "��� ����ġ �⺻��";
$GLOBALS['strDefaultCampaignWeight']		= "ķ���� ����ġ �⺻��";
$GLOBALS['strDefaultBannerWErr']		= "��� ����ġ�� �⺻���� ������ �Է��ؾ��մϴ�.";
$GLOBALS['strDefaultCampaignWErr']		= "ķ���� ����ġ�� �⺻���� ������ �Է��ؾ��մϴ�.";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "���̺� �׵θ� ����";
$GLOBALS['strTableBackColor']			= "���̺� ��� ����";
$GLOBALS['strTableBackColorAlt']		= "���̺� ��� ����(Alternative)";
$GLOBALS['strMainBackColor']			= "�� ��� ����";
$GLOBALS['strOverrideGD']			= "GD �̹��� ������ �����մϴ�.";
$GLOBALS['strTimeZone']				= "�ð� ����";

?>