<?php // $Revision: 2.3 $

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
$GLOBALS['strInstall']				= "��װ";
$GLOBALS['strChooseInstallLanguage']		= "ѡ��װ���̵�����";
$GLOBALS['strLanguageSelection']		= "����ѡ��";
$GLOBALS['strDatabaseSettings']			= "���ݿ�����";
$GLOBALS['strAdminSettings']			= "����Ա����";
$GLOBALS['strAdvancedSettings']			= "�߼�����";
$GLOBALS['strOtherSettings']			= "��������";
$GLOBALS['strLicenseInformation']		= "���֤��Ϣ";
$GLOBALS['strAdministratorAccount']		= "����Ա�ʺ�";
$GLOBALS['strDatabasePage']				= $phpAds_dbmsname."���ݿ�";
$GLOBALS['strInstallWarning']			= "�������������Լ��";
$GLOBALS['strCongratulations']			= "ף��!";
$GLOBALS['strInstallFailed']			= "��װʧ��!";
$GLOBALS['strSpecifyAdmin']				= "���ù���Ա�ʺ�";
$GLOBALS['strSpecifyLocaton']			= "��ָ����������".$phpAds_productname."��λ��";

$GLOBALS['strWarning']				= "����";
$GLOBALS['strFatalError']			= "����һ����������";
$GLOBALS['strUpdateError']			= "���������з���һ������";
$GLOBALS['strUpdateDatabaseError']		= "��Ϊδ֪����,���ݿ�ṹ����û�гɹ�.������<b>��������</b>�������޸���ЩǱ�ڵĴ���. �����ȷ����Щ���󲻻�Ӱ��".$phpAds_productname."�Ĺ���,�����Ե��<b>���Դ���</b>����.������Щ���������ɺ����ص�����,���Բ��Ƽ�ʹ��!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."�Ѿ���װ. �����������ϵͳ,�뵽 <a href='settings-index.php'>���ý���</a>";
$GLOBALS['strCouldNotConnectToDB']		= "�����������ݿ�,������������";
$GLOBALS['strCreateTableTestFailed']		= "���ṩ���û�û��Ȩ�޴������ݿ�ṹ,����ϵ���ݿ����Ա.";
$GLOBALS['strUpdateTableTestFailed']		= "���ṩ���û�û��Ȩ�޸������ݿ�ṹ,����ϵ���ݿ����Ա.";
$GLOBALS['strTablePrefixInvalid']		= "���ݱ��ǰ׺�����Ƿ��ַ�";
$GLOBALS['strTableInUse']			= "���ṩ�����ݿ��Ѿ���".$phpAds_productname."ʹ��,��ʹ�ò�ͬ�ı�ǰ׺,���߲ο��û��ֲ���ϵͳ������ָ������.";
$GLOBALS['strTableWrongType']			= "����װ��".$phpAds_dbmsname."��֧������ѡ������ݱ�����"; 
$GLOBALS['strMayNotFunction']			= "������һ��֮ǰ,�������ЩǱ�ڵĴ���:";
$GLOBALS['strFixProblemsBefore']		= "������װ".$phpAds_productname."֮ǰ��������������Ŀ.������Դ�����Ϣ��ʲô����,��鿴<i>����Ա�ֲ�</i>,�ֲ�����������ص����ѹ�������ҵ�."; 
$GLOBALS['strFixProblemsAfter']			= "������޷����������г�������,����ϵ��Ҫ��װ".$phpAds_productname."�ķ������Ĺ���Ա.�˷������Ĺ���Ա�����ܹ������������Щ����"; 
$GLOBALS['strIgnoreWarnings']			= "���Ծ���";
$GLOBALS['strWarningDBavailable']		= "������ʹ�õ�PHP�汾��֧��".$phpAds_dbmsname."���ݿ�.�ڽ�������Ĳ���֮ǰ,����Ҫ����PHP��".$phpAds_dbmsname."��֧��";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname."��ҪPHP 4.0.3���߸��߰汾��������������������ʹ�õİ汾��{php_version}.";
$GLOBALS['strWarningPHP5beta']		= "��������ͼ��һ��װ��PHP 5���ڲ��԰汾�ķ������ϰ�װ".$phpAds_productname.".��Щ�汾��Ϊ����һЩBug����ͨ������Ϊ��Ʒʹ��.���ǲ�����,�����鲻Ҫ��PHP 5�����и".$phpAds_productame;
$GLOBALS['strWarningRegisterGlobals']		= "PHP���ñ���register_globals��Ҫ��.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP���ñ���magic_quotes_gpc��Ҫ��.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP���ñ���magic_quotes_runtime��Ҫ�ر�.";
$GLOBALS['strWarningMagicQuotesSybase']	= "PHP���ñ���magic_quotes_sybase��Ҫ�ر�.";
$GLOBALS['strWarningFileUploads']		= "PHP���ñ���file_uploads��Ҫ��.";
$GLOBALS['strWarningTrackVars']			= "PHP���ñ���track_vars��Ҫ��.";
$GLOBALS['strWarningPREG']			= "������ʹ�õ�PHP�汾��֧��PERL����ģʽ��������ʽ. �ڽ�������Ĳ���֮ǰ,����Ҫ����PREL������ʽ��֧��.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname."��⵽���������ļ�<b>config.inc.php</b>����д<br>������޸�Ȩ��֮����ܽ�����һ��.<br>�������֪����β�����ο��ĵ�.";
$GLOBALS['strCacheLockedDetected']  	= "������ʹ���ļ����ͻ��淽ʽ,".$phpAds_productname."��⵽<b>cache</b>Ŀ¼����д,���޸Ĵ�Ŀ¼Ȩ�޺���ܼ���.�������֪����ν��,���Ķ�����ֲ�.";
$GLOBALS['strCantUpdateDB']  			= "���ڲ��ܸ������ݿ�.�����ȷ�Ͻ���,�������еĹ��,����Ϳͻ����ᱻɾ��.";
$GLOBALS['strIgnoreErrors']			= "���Դ���";
$GLOBALS['strRetryUpdate']			= "��������";
$GLOBALS['strTableNames']			= "���ݱ�����";
$GLOBALS['strTablesPrefix']			= "���ݱ�ǰ׺";
$GLOBALS['strTablesType']			= "���ݱ�����";

$GLOBALS['strRevCorrupt']			= "�ļ�<b>{filename}</b>�Ѿ��𻵻��߱��޸Ĺ�.�������û���޸Ĺ����ļ�,��Ѵ��ļ������ϴ�һ��.������޸Ĺ����ļ�,�����԰�ȫ�ĺ��Դ˾���.";
$GLOBALS['strRevTooOld']			= "�ļ�<b>{filename}</b>�ȴ˰汾��".$phpAds_productname."ʹ�õ��ļ�Ҫ��.��Ѵ��ļ������ϴ�һ��.";
$GLOBALS['strRevMissing']			= "�ļ�<b>{filename}</b>��Ϊ��ʧ���Լ�ⲻ��.��Ѵ��ļ������ϴ�һ��.";
$GLOBALS['strRevCVS']				= "���������ڰ�װCVS�汾��".$phpAds_productname.".�Ⲣ����һ����ʽ���еİ汾,���ܲ��ȶ�����������.��ȷ����Ҫ����?";

$GLOBALS['strInstallWelcome']			= "��ӭʹ��".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "����ʹ��".$phpAds_productname."֮ǰ,��Ҫ����ϵͳ��<br>�������ݿ�.��<b>��һ��</b>����.";
$GLOBALS['strInstallMessageCheck']		= $phpAds_productname."�Ѿ�����������ص��������ϵ��ļ���������,���Ҽ���˷������Ƿ��������".$phpAds_productname.".�ڽ�����һ������֮ǰ����Ҫע��������Ŀ.";
$GLOBALS['strInstallMessageAdmin']		="�ڽ�����һ��֮ǰ,����Ҫ���ù���Ա�ʺ�.�������ô��ʺŵ�¼���������,������Ͳ鿴ͳ����Ϣ."; 
$GLOBALS['strInstallMessageDatabase']	= $phpAds_productname."ʹ��һ��".$phpAds_dbmsname."����Ź��Ŀ¼��ͳ������.�ڽ�����һ������֮ǰ, ����Ҫ������������Ҫʹ�õ����ݿ������,�û���������,".$phpAds_productname."��Ҫ��Щ��Ϣ���������ݿ������.�������֪����Щ��Ϣ,����ϵ���ķ���������Ա.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname."��װ���.</b><br><br>Ϊ��".$phpAds_productname."������ʹ��,������Ҫȷ��ά���ļ�ÿСʱ����һ��,�йص���Ϣ���Բο�����ĵ�.<br><br>��<b>��һ��</b>��������ҳ��,�����Խ��и��������.��������ɺ��벻Ҫ��������config.inc.php�Ա�֤��ȫ.";
$GLOBALS['strUpdateSuccess']			= "<b>".$phpAds_productname."�����ɹ�.</b><br><br>Ϊ��".$phpAds_productname."������ʹ��,������Ҫȷ��ά���ļ�ÿСʱ����һ��,�йص���Ϣ���Բο�����ĵ�.<br><br>��<b>��һ��</b>��������ҳ��,�����Խ��и��������.��������ɺ��벻Ҫ��������config.inc.php�Ա�֤��ȫ.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname."��װ�������</b><br><br>��װ�е�һЩ���ֲ��ܽ���.��Щ�������ֻ����ʱ�Ե�,���������Լ򵥵İ�<b>��һ��</b>���ҷ��ص���װ�ĵ�һ��,�������֪��������ڴ������Ϣ����ν��,��ο�����ĵ�.";
$GLOBALS['strErrorOccured']			= "�����������:";
$GLOBALS['strErrorInstallDatabase']		= "���ܴ������ݿ�.";
$GLOBALS['strErrorInstallConfig']		= "T�����ļ��������ݿⲻ�ܸ���.";
$GLOBALS['strErrorInstallDbConnect']		= "�������ӵ����ݿ�.";

$GLOBALS['strUrlPrefix']			= "URLǰ׺";

$GLOBALS['strProceed']				= "��һ�� &gt;";
$GLOBALS['strInvalidUserPwd']			= "������û���������";

$GLOBALS['strUpgrade']				= "����";
$GLOBALS['strSystemUpToDate']			= "����ϵͳ�Ѿ������°�,���ڲ���Ҫ����<br>��<b>��һ��</b>�ص���ҳ.";
$GLOBALS['strSystemNeedsUpgrade']		= "���ݿ�ṹ�������ļ���Ҫ��������������������<b>��һ��</b>��ʼ������<br>����ʱ�������ݿ�ͳ�����ݵĶ��ٶ���ͬ,������̿�������ϵͳ���ݿ⸺������.�����ĵȴ�,������Ҫ�����ӵ�ʱ��.";
$GLOBALS['strSystemUpgradeBusy']		= "ϵͳ�����У����Ժ�...";
$GLOBALS['strSystemRebuildingCache']		= "�ؽ��������У����Ժ�...";
$GLOBALS['strServiceUnavalable']		= "������ʱ������,ϵͳ������...";

$GLOBALS['strConfigNotWritable']		= "���������ļ�config.inc.php����д";
$GLOBALS['strPhpBug20144']				= "����PHP�汾�ܵ�һ��<a href='http://bugs.php.net/bug.php?id=20114' target='_blank'>bug</a>��Ӱ��,".$phpAds_productname."������������.
						���԰�װ".$phpAds_productname."֮ǰ�����PHP������4.3.0+.";
$GLOBALS['strPhpBug24652']		= "��������ͼ��һ��װ��PHP 5���ڲ��԰汾�ķ������ϰ�װ".$phpAds_productname.".��Щ�汾��Ϊ����һЩBug����ͨ������Ϊ��Ʒʹ��.����һ��Bug����".$phpAds_productname."��������ʹ��.���<a href='http://bugs.php.net/bug.php?id=24652' target='_blank'>bug</a>�Ѿ��޸�,����PHP 5�����հ治�ܴ�Ӱ��";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "ѡ�񲿷�";
$GLOBALS['strDayFullNames'] 			= array("������","����һ","���ڶ�","������","������","������","������");
$GLOBALS['strEditConfigNotPossible']   		= "��Ϊ��ȫԭ�������ļ��Ѿ�������,���Բ����޸�����<br>��������޸�,����Ҫʹconfig.inc.php�ļ���д.";
$GLOBALS['strEditConfigPossible']		= "���ڿ����޸���������,��Ϊ�����ļ�û������,�������ܵ��°�ȫ����.<br>������뱣������ϵͳ,����Ҫ����config.inc.php�ļ�.";



// Database
$GLOBALS['strDatabaseSettings']			= "���ݿ�����";
$GLOBALS['strDatabaseServer']			= "���ݿ������";
$GLOBALS['strDbLocal']				= "ʹ���׽������ӱ��ط�����"; //Pgר��
$GLOBALS['strDbHost']				= "���ݿ�����";
$GLOBALS['strDbPort']				= "���ݿ�˿ں�";
$GLOBALS['strDbUser']				= "���ݿ��û���";
$GLOBALS['strDbPassword']			= "���ݿ�����";
$GLOBALS['strDbName']				= "���ݿ�����";
	
$GLOBALS['strDatabaseOptimalisations']		= "���ݿ��Ż�";
$GLOBALS['strPersistentConnections']		= "ʹ����������";
$GLOBALS['strInsertDelayed']			= "ʹ���ӳٲ���";
$GLOBALS['strCompatibilityMode']		= "ʹ�����ݿ����ģʽ";
$GLOBALS['strCantConnectToDb']			= "�������ӵ����ݿ�";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "���úͷ�������";
$GLOBALS['strAllowedInvocationTypes']		= "����ĵ��÷�ʽ";
$GLOBALS['strAllowRemoteInvocation']		= "����Զ�̵���";
$GLOBALS['strAllowRemoteJavascript']		= "����Զ�̵���Javascript";
$GLOBALS['strAllowRemoteFrames']		= "����Զ�̵���Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "����Զ�̵���XML-RPC";
$GLOBALS['strAllowLocalmode']			= "������ģʽ";
$GLOBALS['strAllowInterstitial']		= "�����϶ģʽ";
$GLOBALS['strAllowPopups']			= "������ģʽ";

$GLOBALS['strUseAcl']				= "�ڷ��͹�����Ԥ����������";

$GLOBALS['strDeliverySettings']			= "��������";
$GLOBALS['strCacheType']			= "���ͻ���������";
$GLOBALS['strCacheFiles']			= "�ļ�";
$GLOBALS['strCacheDatabase']			= "���ݿ�";
$GLOBALS['strCacheShmop']			= "�����ڴ�/shmop";
$GLOBALS['strCacheSysvshm']			= "�����ڴ�/Sysvshm";
$GLOBALS['strExperimental']			= "ʵ���Ե�";
$GLOBALS['strKeywordRetrieval']			= "��ȡ�ؼ���";
$GLOBALS['strBannerRetrieval']			= "����ȡģʽ";
$GLOBALS['strRetrieveRandom']			= "�������ȡ(ȱʡ)";
$GLOBALS['strRetrieveNormalSeq']		= "��ȡ��ͨϵ�й��";
$GLOBALS['strWeightSeq']			= "��ȡȨ��ϵ�й��";
$GLOBALS['strFullSeq']				= "��ȡȫ��ϵ�еĹ��";
$GLOBALS['strUseConditionalKeys']		= "ֱ�ӹ��ѡȡ������ʹ���߼�����";
$GLOBALS['strUseMultipleKeys']			= "ֱ�ӹ��ѡȡ������ʹ�ö���ؼ���";

$GLOBALS['strZonesSettings']			= "��ȡ��λ";
$GLOBALS['strZoneCache']			= "�����λ����ʹ�ð�λʱ��ѡ���ܹ���������ٶ�";
$GLOBALS['strZoneCacheLimit']			= "���������µ�ʱ����(��)";
$GLOBALS['strZoneCacheLimitErr']		= "���������µ�ʱ����Ӧ����һ������";

$GLOBALS['strP3PSettings']			= "P3P��˽����";
$GLOBALS['strUseP3P']				= "ʹ��P3P����";
$GLOBALS['strP3PCompactPolicy']			= "P3P���Բ���";
$GLOBALS['strP3PPolicyLocation']		= "P3P����λ��"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "�������";

$GLOBALS['strAllowedBannerTypes']		= "����Ĺ������";
$GLOBALS['strTypeSqlAllow']			= "�����ع�棨�������ݿ⣩";
$GLOBALS['strTypeWebAllow']			= "�����ع�棨������ҳ��������";
$GLOBALS['strTypeUrlAllow']			= "�����ⲿ���";
$GLOBALS['strTypeHtmlAllow']			= "����HTML���";
$GLOBALS['strTypeTxtAllow']			= "�������ֹ��";

$GLOBALS['strTypeWebSettings']			= "���ع�棨������ҳ������������";
$GLOBALS['strTypeWebMode']			= "�洢��ʽ";
$GLOBALS['strTypeWebModeLocal']			= "����Ŀ¼";
$GLOBALS['strTypeWebModeFtp']			= "�ⲿFtp������";
$GLOBALS['strTypeWebDir']			= "����Ŀ¼";
$GLOBALS['strTypeWebFtp']			= "Ftpģʽ��������";
$GLOBALS['strTypeWebUrl']			= "������URL";
$GLOBALS['strTypeFTPHost']			= "FTP����";
$GLOBALS['strTypeFTPDirectory']			= "����Ŀ¼";
$GLOBALS['strTypeFTPUsername']			= "��¼";
$GLOBALS['strTypeFTPPassword']			= "����";
$GLOBALS['strTypeFTPErrorDir']			= "����Ŀ¼������";
$GLOBALS['strTypeFTPErrorConnect']		= "�������ӵ�FTP������,�û�������������";
$GLOBALS['strTypeFTPErrorHost']			= "FTP��������������������";
$GLOBALS['strTypeDirError']			= "����Ŀ¼������";

$GLOBALS['strDefaultBanners']			= "ȱʡ���";
$GLOBALS['strDefaultBannerUrl']			= "ȱʡ��ͼƬURL";
$GLOBALS['strDefaultBannerTarget']		= "ȱʡ��Ŀ��URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML���ѡ��";
$GLOBALS['strTypeHtmlAuto']			= "�Զ��޸�HTML����Լ�¼�����";
$GLOBALS['strTypeHtmlPhp']			= "������HTML�����ִ��php����";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "������Ϣ�͵���";

$GLOBALS['strRemoteHost']			= "Զ������";
$GLOBALS['strReverseLookup']			= "���������û���ṩ�����ߵ�������,�����ѯ����";
$GLOBALS['strProxyLookup']			= "���������ʹ���˴���,��ѯ��ʵIP��ַ";

$GLOBALS['strGeotargeting']			= "����";
$GLOBALS['strGeotrackingType']			= "�������ݿ�����";
$GLOBALS['strGeotrackingLocation'] 		= "�������ݿ�λ��";
$GLOBALS['strGeotrackingLocationError'] 	= "����ָ����λ��û���ҵ��������ݿ�λ��";
$GLOBALS['strGeotrackingLocationNoHTTP'] 	= "��ָ����λ�ò����Ǵ˷�����Ӳ���ϵı���Ŀ¼,����һ��ָ����ҳ�������ϵ�ĳ���ļ���URL.���λ��Ӧ��������: <i>{example}</i>.ʵ�ʵ�λ��Ҫ����Ŵ����ݿ��λ��.";
$GLOBALS['strGeoStoreCookie']			= "��������cookie�й��Ժ�ο�";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "��������";

$GLOBALS['strStatisticsFormat']			= "�����ʽ";
$GLOBALS['strCompactStats']			= "ʹ�ü��ģʽ";
$GLOBALS['strLogAdviews']			= "��¼��������";
$GLOBALS['strLogAdclicks']			= "��¼�������";
$GLOBALS['strLogSource']			= "��¼���ù����е���Դ����";
$GLOBALS['strGeoLogStats']			= "��¼�����ߵĹ���";
$GLOBALS['strLogHostnameOrIP']			= "��¼�����ߵ���������IP��ַ";
$GLOBALS['strLogIPOnly']			= "���������δ֪,����¼�����ߵ�IP��ַ";
$GLOBALS['strLogIP']				= "��¼�����ߵ�IP��ַ";
$GLOBALS['strLogBeacon']			= "ʹ���źŵ�����¼��������,���Ա�ֻ֤��¼���ͳɹ��Ĺ��";

$GLOBALS['strRemoteHosts']			= "Զ������";
$GLOBALS['strIgnoreHosts']			= "����¼����IP��ַ�����������ķ����ߵ�����";
$GLOBALS['strBlockAdviews']			= "����������Ѿ������˹��,����¼ͬһ����������ʱ����";
$GLOBALS['strBlockAdclicks']			= "����������Ѿ�����˹��,����¼ͬһ���������ʱ����";


$GLOBALS['strPreventLogging']			= "��ֹ��¼��־";
$GLOBALS['strEmailWarnings']			= "�����ʼ�����";
$GLOBALS['strAdminEmailHeaders']		= $phpAds_productname."���͵�ÿһ������ʼ������ϴ��ʼ�ͷ";
$GLOBALS['strWarnLimit']			= "������������С�ڴ�ָ����ʱ����һ��������Ϣ";
$GLOBALS['strWarnLimitErr']			= "�������Ʊ�����һ��������";
$GLOBALS['strWarnAdmin']			= "ÿ�ε�һ����Ŀ����ڵ�ʱ�������Ա����һ��������Ϣ";
$GLOBALS['strWarnClient']			= "ÿ�ε�һ����Ŀ����ڵ�ʱ����ͻ�����һ��������Ϣ";
$GLOBALS['strQmailPatch']			= "����qmail����";

$GLOBALS['strAutoCleanTables']			= "�Զ��������ݿ�";
$GLOBALS['strAutoCleanStats']			= "���ͳ������";
$GLOBALS['strAutoCleanUserlog']			= "����û���¼";
$GLOBALS['strAutoCleanStatsWeeks']		= "ͳ�����ݵ��������<br>(��С3��)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "�û���¼���������<br>(��С3��)";
$GLOBALS['strAutoCleanErr']			= "��������������3��";
$GLOBALS['strAutoCleanVacuum']			= "ÿ����շ������ݱ�"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "����Ա����";

$GLOBALS['strLoginCredentials']			= "��¼��Ϣ";
$GLOBALS['strAdminUsername']			= "����Ա����";
$GLOBALS['strInvalidUsername']			= "�����û���";

$GLOBALS['strBasicInformation']			= "������Ϣ";
$GLOBALS['strAdminFullName']			= "ȫ��";
$GLOBALS['strAdminEmail']			= "�����ʼ���ַ";
$GLOBALS['strCompanyName']			= "��˾����";

$GLOBALS['strAdminCheckUpdates']		= "������";
$GLOBALS['strAdminCheckEveryLogin']		= "ÿ�ε�¼";
$GLOBALS['strAdminCheckDaily']			= "ÿ��";
$GLOBALS['strAdminCheckWeekly']			= "ÿ��";
$GLOBALS['strAdminCheckMonthly']		= "ÿ��";
$GLOBALS['strAdminCheckNever']			= "�Ӳ�";

$GLOBALS['strAdminNovice']			= "����Ա��ɾ��������Ҫȷ���Ա�֤��ȫ";
$GLOBALS['strUserlogEmail']			= "��¼���������е����ʼ���Ϣ";
$GLOBALS['strUserlogPriority']			= "��¼ÿСʱ�����ȼ�����";
$GLOBALS['strUserlogAutoClean']			= "��¼���ݿ���Զ�����";


// User interface settings
$GLOBALS['strGuiSettings']			= "�û���������";

$GLOBALS['strGeneralSettings']			= "һ������";
$GLOBALS['strAppName']				= "��������";
$GLOBALS['strMyHeader']				= "ҳ�涥���ļ�����λ��";
$GLOBALS['strMyHeaderError']			= "����ָ����λ��û���ҵ�ҳ�涥���ļ�����λ��";
$GLOBALS['strMyFooter']				= "ҳ��ײ��ļ�����λ��";
$GLOBALS['strMyFooterError']			= "����ָ����λ��û���ҵ�ҳ��ײ��ļ�����λ��";
$GLOBALS['strGzipContentCompression']		= "ʹ��GZIP����ѹ��";

$GLOBALS['strClientInterface']			= "�ͻ�����";
$GLOBALS['strClientWelcomeEnabled']		= "���ÿͻ���ӭ��Ϣ";
$GLOBALS['strClientWelcomeText']		= "��ӭ����<br>(����HTML���)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "ȱʡ����";

$GLOBALS['strInventory']			= "��ϸĿ¼";
$GLOBALS['strShowCampaignInfo']			= "��<i>��Ŀ����</i>ҳ����ʾ������Ŀ��Ϣ";
$GLOBALS['strShowBannerInfo']			= "��<i>�������</i>ҳ����ʾ��������Ϣ";
$GLOBALS['strShowCampaignPreview']		= "��<i>�������</i>ҳ����ʾ���й���Ԥ��";
$GLOBALS['strShowBannerHTML']			= "HTML����Ԥ����ʾʵ�ʵĹ���������ͨHTML����";
$GLOBALS['strShowBannerPreview']		= "�ڴ������ҳ�涥����ʾ���Ԥ��";
$GLOBALS['strHideInactive']			= "���е�����ҳ�������Ѿ�ͣ�õ���Ŀ";
$GLOBALS['strGUIShowMatchingBanners']		= "��<i>���ӹ��</i>ҳ����ʾ���ϵĹ��";
$GLOBALS['strGUIShowParentCampaigns']		= "��<i>���ӹ��</i>ҳ����ʾ�ϲ���Ŀ";
$GLOBALS['strGUILinkCompactLimit']		= "��<i>���ӹ��</i>ҳ������û�����ӵ���Ŀ���棬����Ŀ����";

$GLOBALS['strStatisticsDefaults'] 		= "ͳ������";
$GLOBALS['strBeginOfWeek']			= "һ�ܵĿ�ʼ";
$GLOBALS['strPercentageDecimals']		= "�ٷֱȾ�ȷ��";

$GLOBALS['strWeightDefaults']			= "ȱʡȨ��ֵ";
$GLOBALS['strDefaultBannerWeight']		= "ȱʡ���Ȩ��ֵ";
$GLOBALS['strDefaultCampaignWeight']		= "ȱʡ��ĿȨ��ֵ";
$GLOBALS['strDefaultBannerWErr']		= "ȱʡ���Ȩ��ֵӦ����һ��������";
$GLOBALS['strDefaultCampaignWErr']		= "ȱʡ��ĿȨ��ֵӦ����һ��������";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "���ߵ���ɫ";
$GLOBALS['strTableBackColor']			= "���ı���ɫ";
$GLOBALS['strTableBackColorAlt']		= "���ı���ɫ(��ѡ)";
$GLOBALS['strMainBackColor']			= "��Ҫ����ɫ";
$GLOBALS['strOverrideGD']			= "����GDͼ�ο��ʽ";
$GLOBALS['strTimeZone']				= "ʱ��";

?>
