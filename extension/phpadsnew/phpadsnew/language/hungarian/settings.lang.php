<?php // $Revision: 1.1.2.2 $

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
$GLOBALS['strInstall']				= "Telep�t�s";
$GLOBALS['strChooseInstallLanguage']		= "V�lassza ki a telep�t�si folyamat nyelv�t";
$GLOBALS['strLanguageSelection']		= "Nyelv �tv�lt�sa";
$GLOBALS['strDatabaseSettings']			= "Adatb�zis be�ll�t�sai";
$GLOBALS['strAdminSettings']			= "Adminisztr�tor be�ll�t�sai";
$GLOBALS['strAdvancedSettings']			= "Speci�lis be�ll�t�sok";
$GLOBALS['strOtherSettings']			= "Egy�b be�ll�t�sok";

$GLOBALS['strWarning']				= "Figyelmeztet�s";
$GLOBALS['strFatalError']			= "V�gzetes hiba t�rt�nt";
$GLOBALS['strUpdateError']			= "Hiba t�rt�nt friss�t�s k�zben";
$GLOBALS['strUpdateDatabaseError']	= "Ismeretlen okb�l kifoly�lag az adatb�zis szerkezet friss�t�se nem siker�lt. V�grehajt�s�nak javasolt m�dja a <b>Friss�t�s �jrapr�b�l�s�ra</b> kattint�s, amivel megpr�b�lhatja kijav�tani e lehets�ges probl�m�kat. Ha �n biztos abban, hogy ezek a hib�k nincsenek kihat�ssal a ".$phpAds_productname." m�k�d�s�re, akkor a <b>Hib�k kihagy�sa</b> v�laszt�s�val folytathatja. Ezeknek a hib�knak a figyelmen k�v�l hagy�sa komoly probl�m�kat okozhat, �s nem aj�nlott!";
$GLOBALS['strAlreadyInstalled']			= "M�r telep�tette a ".$phpAds_productname."-t erre a rendszerre. Ha be szeretn� �ll�tani, akkor v�ltson �t a <a href='settings-index.php'>be�ll�t�sok kezel�fel�letre</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Nem lehet kapcsol�dni az adatb�zishoz, ellen�rizze ism�t az �n �ltal megadott be�ll�t�sokat";
$GLOBALS['strCreateTableTestFailed']		= "Az �n �ltal megadott felhaszn�l�nak nincs joga l�trehozni vagy friss�teni az adatb�zis szerkezetet. Vegye fel a kapcsolatot az adatb�zis adminisztr�tor�val.";
$GLOBALS['strUpdateTableTestFailed']		= "Az �n �ltal megadott felhaszn�l�nak nincs joga friss�teni az adatb�zis szerkezetet. Vegye fel a kapcsolatot az adatb�zis adminisztr�tor�val.";
$GLOBALS['strTablePrefixInvalid']		= "A t�bla el�tag �rv�nytelen karaktert tartalmaz";
$GLOBALS['strTableInUse']			= "Az �n �ltal megadott adatb�zis m�r l�tezik a ".$phpAds_productname." sz�m�ra. Haszn�ljon m�sik t�bla el�tagot, vagy olvassa el a k�zik�nyvben a friss�t�sre vonatkoz� utas�t�sokat.";
$GLOBALS['strTableWrongType']		= "A ".$phpAds_dbmsname." telep�t�s nem t�mogatja az �n �ltal kiv�lasztott t�blat�pust.";
$GLOBALS['strMayNotFunction']			= "Folytat�s el�tt jav�tsa ki ezeket a lehets�ges hib�kat:";
$GLOBALS['strFixProblemsBefore']		= "Jav�tsa ki a k�vetkez� objektumo(ka)t a ".$phpAds_productname." telep�t�se el�tt. Ha k�rd�se van ezzel a hiba�zenettel kapcsolatban, akkor tanulm�nyozza az <i>Administrator guide</i> k�zik�nyvet, mely r�sze az �n �ltal let�lt�tt csomagnak.";
$GLOBALS['strFixProblemsAfter']			= "Ha nem tudja kijav�tani a fenti probl�m�kat, akkor vegye fel a kapcsolatot annak a kiszolg�l�nak az adminisztr�tor�val, melyre a ".$phpAds_productname."-t pr�b�lja telep�teni. A kiszolg�l� adminisztr�tora biztosan tud seg�teni �nnek.";
$GLOBALS['strIgnoreWarnings']			= "Figyelmeztet�sek mell�z�se";
$GLOBALS['strWarningDBavailable']		= "Az �n �ltal haszn�lt PHP-v�ltozat nem t�mogatja a kapcsol�d�st a ".$phpAds_dbmsname." adatb�zis kiszolg�l�hoz. Enged�lyezze a PHP ".$phpAds_dbmsname." b�v�tm�nyt, miel�tt folytatn�.";
$GLOBALS['strWarningPHPversion']		= "A ".$phpAds_productname." megfelel� m�k�d�s�hez PHP 4.0 vagy �jabb sz�ks�ges. �n jelenleg a {php_version}-s verzi�t haszn�lja.";
$GLOBALS['strWarningRegisterGlobals']		= "A register_globals PHP konfigur�ci�s v�ltoz�nak enged�lyezettnek kell lennie.";
$GLOBALS['strWarningMagicQuotesGPC']		= "A magic_quotes_gpc PHP konfigur�ci�s v�ltoz�nak enged�lyezettnek kell lennie.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "A magic_quotes_runtime PHP konfigur�ci�s v�ltoz�nak letiltottnak kell lennie.";
$GLOBALS['strWarningFileUploads']		= "A file_uploads  PHP konfigur�ci�s v�ltoz�nak enged�lyezettnek kell lennie.";
$GLOBALS['strWarningTrackVars']			= "A track_vars PHP konfigur�ci�s v�ltoz�nak enged�lyezettnek kell lennie.";
$GLOBALS['strWarningPREG']				= "Az �n �ltal haszn�lt PHP-verzi� nem rendelkezik PERL kompatibilis regul�ris kifejez�s t�mogat�ssal. Enged�lyezze a PREG kiterjeszt�st, miel�tt folytatn�.";
$GLOBALS['strConfigLockedDetected']		="A ".$phpAds_productname." meg�llap�totta, hogy a kiszolg�l� nem tud �rni a <b>config.inc.php</b> f�jlba. Csak a f�jl enged�lyeinek m�dos�t�sa ut�n folytathatja. Olvassa el a hozz� adott dokument�ci�ban, ha nem tudja, hogyan kell.";
$GLOBALS['strCantUpdateDB']  			= "Az adatb�zis jelenleg nem friss�thet�. Ha a folytat�s mellett d�nt, akkor valamennyi rekl�m, statisztika �s hirdet� t�rl�sre ker�l.";
$GLOBALS['strIgnoreErrors']			= "Hib�k kihagy�sa";
$GLOBALS['strRetryUpdate']			= "Friss�t�s ism�tl�se";
$GLOBALS['strTableNames']			= "T�blanevek";
$GLOBALS['strTablesPrefix']			= "T�blanevek el�tag";
$GLOBALS['strTablesType']			= "T�bla t�pusa";

$GLOBALS['strInstallWelcome']			= "�dv�zli a ".$phpAds_productname."";
$GLOBALS['strInstallMessage']			= "Miel�tt haszn�latba venn�, v�gezze el a ".$phpAds_productname." be�ll�t�s�t, �s <br>hozza l�tre az adatb�zist. A <b>Tov�bb</b> gombbal folytathatja.";
$GLOBALS['strInstallSuccess']			= "<b>A ".$phpAds_productname." telep�t�se ezzel befejez�d�tt.</b><br><br>A ".$phpAds_productname." megfelel� m�k�d�s�hez ellen�rizze
               a karbantart�s f�jl �r�nk�nti futtat�s�nak v�grehajt�s�t. A dokument�ci�ban t�bb inform�ci�t tal�l err�l a t�m�r�l.
						   <br><br>A <b>Tov�bb</b> gomb megnyom�s�val t�ltheti be Be�ll�t�sok lapot, ahol elv�gezheti
							 a testreszab�st. Miut�n elk�sz�lt, ne feledje el lez�rni a config.inc.php f�jlt, mert �gy
							 megel�zheti a biztons�gi s�rt�seket.";
$GLOBALS['strUpdateSuccess']			= "<b>A ".$phpAds_productname." friss�t�se siker�lt.</b><br><br>A ".$phpAds_productname." megfelel� m�k�d�se c�lj�b�l ellen�rizze
               azt is, hogy fut-e �r�nk�nt a karbantart�s f�jl (el�tte ez napont�ra volt �ll�tva). A dokument�ci�ban t�bb inform�ci�t tal�l err�l a t�m�r�l.
						   <br><br>A <b>Tov�bb</b> megnyom�s�val v�lthat �t az adminisztr�tor kezel�fel�letre. Ne feledje el lez�rni a config.inc.php f�jlt, mert �gy
							 megel�zheti a biztons�gi s�rt�seket.";
$GLOBALS['strInstallNotSuccessful']		= "<b>A ".$phpAds_productname." telep�t�se nem siker�lt.</b><br><br>A telep�t�si folyamat r�sz�t nem lehetett befejezni.
						   Ezek a probl�m�k val�sz�n�leg csak ideiglenesek, ebben az esetben nyugodtan nyomja meg a <b>Tov�bb</b>t, 
							 �s t�rjen vissza a telep�t�si folyamat els� l�p�s�hez. Ha t�bbet szeretni tudni arr�l, hogy mit jelent az al�bbi
							 hiba�zenet, �s hogyan h�r�thatja el, akkor n�zzen ut�na a dokument�ci�ban.";
$GLOBALS['strErrorOccured']			= "A k�vetkez� hiba t�rt�nt:";
$GLOBALS['strErrorInstallDatabase']		= "Nem lehet l�trehozni az adatb�zis szerkezetet.";
$GLOBALS['strErrorInstallConfig']		= "Nem lehet friss�teni a konfigur�ci�s f�jlt vagy az adatb�zist.";
$GLOBALS['strErrorInstallDbConnect']		= "Nem lehet kapcsolatot l�tes�teni az adatb�zissal.";

$GLOBALS['strUrlPrefix']			= "Hivatkoz�s el�tag";

$GLOBALS['strProceed']				= "Tov�bb &gt;";
$GLOBALS['strInvalidUserPwd']			= "A felhaszn�l�n�v vagy a jelsz� �rv�nytelen";

$GLOBALS['strUpgrade']				= "Friss�t�s";
$GLOBALS['strSystemUpToDate']			= "A rendszer friss�t�se m�r megt�rt�nt, jelenleg nincs sz�ks�g az aktualiz�l�s�ra. <br>A <b>Tov�bb</b> megnyom�s�val ugorjon a kezd�lapra.";
$GLOBALS['strSystemNeedsUpgrade']		= "A megfelel� m�k�d�s c�lj�b�l friss�teni kell az adatb�zis szerkezetet �s a konfigur�ci�s f�jlt. A <b>Tov�bb</b> megnyom�s�val ind�thatja a friss�t�si folyamatot. <br><br>Att�l f�gg�en, hogy melyik verzi�r�l friss�t, �s mennyi statisztik�t t�rol m�r az adatb�zisban, ez a folyamat az adatb�zis kiszolg�l�t nagyon leterhelheti. Legyen t�relemmel, a friss�t�s eltarthat n�h�ny percig.";
$GLOBALS['strSystemUpgradeBusy']		= "A rendszer friss�t�se folyamatban. Kis t�relmet...";
$GLOBALS['strSystemRebuildingCache']		= "A gyors�t�t�r �jra�p�t�se. Kis t�relmet...";
$GLOBALS['strServiceUnavalable']		= "A szolg�ltat�s �tmenetileg nem el�rhet�. A rendszer friss�t�se folyamatban";

$GLOBALS['strConfigNotWritable']		= "A config.inc.php f�jl nem �rhat�";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "V�lasszon szekci�t";
$GLOBALS['strDayFullNames'] 			= array("Vas�rnap","H�tf�","Kedd","Szerda","Cs�t�rt�k","P�ntek","Szombat");
$GLOBALS['strEditConfigNotPossible']   		= "Ezek a be�ll�t�sok nem m�dos�that�k, mert a konfigur�ci�s f�jl biztons�gi okokb�l z�rolva van. ".
										  "Ha szeretn� m�dos�tani, akkor el�bb oldja fel a config.inc.php f�jlt.";
$GLOBALS['strEditConfigPossible']		= "A be�ll�t�sok m�dos�that�k, mert nem z�rta le a konfigur�ci�s f�jlt, ez viszont �gy biztons�gi r�st jelent. ".
										  "Ha szeretn� biztons�goss� tenni a rendszert, akkor z�rja le a config.inc.php f�jlt.";



// Database
$GLOBALS['strDatabaseSettings']			= "Adatb�zis be�ll�t�sai";
$GLOBALS['strDatabaseServer']			= "Adatb�zis kiszolg�l�";
$GLOBALS['strDbLocal']				= "Kapcsol�d�s helyi kiszolg�l�hoz szoftvercsatorn�val"; // Pg only
$GLOBALS['strDbHost']				= "Adatb�zis �llom�sneve";
$GLOBALS['strDbPort']				= "Adatb�zis port sz�ma";
$GLOBALS['strDbUser']				= "Adatb�zis felhaszn�l�neve";
$GLOBALS['strDbPassword']			= "Adatb�zis jelszava";
$GLOBALS['strDbName']				= "Adatb�zis neve";

$GLOBALS['strDatabaseOptimalisations']		= "Adatb�zis optimaliz�l�sa";
$GLOBALS['strPersistentConnections']		= "�lland� kapcsolatok haszn�lata";
$GLOBALS['strInsertDelayed']			= "K�sleltetett besz�r�sok haszn�lata";
$GLOBALS['strCompatibilityMode']		= "Adatb�zis kompatibilit�s m�d haszn�lata";
$GLOBALS['strCantConnectToDb']			= "Nem lehet kapcsol�dni az adatb�zishoz";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "H�v�s �s tov�bb�t�s be�ll�t�sai";

$GLOBALS['strAllowedInvocationTypes']		= "Enged�lyezett h�v�st�pusok";
$GLOBALS['strAllowRemoteInvocation']		= "T�vh�v�s enged�lyez�se";
$GLOBALS['strAllowRemoteJavascript']		= "T�vh�v�s JavaScripthez enged�lyez�se";
$GLOBALS['strAllowRemoteFrames']		= "T�vh�v�s keretekhez enged�lyez�se";
$GLOBALS['strAllowRemoteXMLRPC']		= "T�vh�v�s XML-RPC haszn�lat�val enged�lyez�se";
$GLOBALS['strAllowLocalmode']			= "Helyi m�d enged�lyez�se";
$GLOBALS['strAllowInterstitial']		= "Interst�ci�s ablakok enged�lyez�se";
$GLOBALS['strAllowPopups']			= "Felbukkan� ablakok enged�lyez�se";

$GLOBALS['strUseAcl']				= "A tov�bb�t�si korl�toz�sok ki�rt�kel�se tov�bb�t�s k�zben";

$GLOBALS['strDeliverySettings']			= "Tov�bb�t�s be�ll�t�sai";
$GLOBALS['strCacheType']				= "Tov�bb�t�s gyors�t�t�r t�pusa";
$GLOBALS['strCacheFiles']				= "F�jlok";
$GLOBALS['strCacheDatabase']			= "Adatb�zis";
$GLOBALS['strCacheShmop']				= "Osztott mem�ria/Shmop";
$GLOBALS['strCacheSysvshm']				= "Osztott mem�ria/Sysvshm";
$GLOBALS['strExperimental']				= "K�s�rleti";
$GLOBALS['strKeywordRetrieval']			= "Kulcssz� visszakeres�s";
$GLOBALS['strBannerRetrieval']			= "Rekl�m visszakeres�si m�d";
$GLOBALS['strRetrieveRandom']			= "V�letlenszer� rekl�m visszakeres�s (alap�rtelmezett)";
$GLOBALS['strRetrieveNormalSeq']		= "Norm�l soros rekl�m viszakeres�s";
$GLOBALS['strWeightSeq']			= "Fontoss�gon alapul� soros rekl�m visszakeres�s";
$GLOBALS['strFullSeq']				= "Teljes soros rekl�m visszakeres�s";
$GLOBALS['strUseConditionalKeys']		= "Logikai m�veleti jelek enged�lyez�se a k�zvetlen kiv�laszt�s haszn�latakor";
$GLOBALS['strUseMultipleKeys']			= "T�bb kulcssz� enged�lyez�se a k�zvetlen kiv�laszt�s haszn�latakor";

$GLOBALS['strZonesSettings']			= "Z�na visszakeres�se";
$GLOBALS['strZoneCache']			= "Z�n�k gyors�t�t�raz�sa, ez felgyors�that dolgokat a z�n�k haszn�latakor";
$GLOBALS['strZoneCacheLimit']			= "A gyors�t�t�r k�t friss�t�se k�zti id� (m�sodpercben)";
$GLOBALS['strZoneCacheLimitErr']		= "A gyors�t�t�r k�t friss�t�se k�zti id� pozit�v eg�sz sz�m legyen";

$GLOBALS['strP3PSettings']			= "P3P Adatv�delmi Nyilatkozatok";
$GLOBALS['strUseP3P']				= "P3P Nyilatkozatok haszn�lata";
$GLOBALS['strP3PCompactPolicy']			= "P3P T�m�r Nyilatkozat";
$GLOBALS['strP3PPolicyLocation']		= "P3P Nyilatkozat helye"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "Rekl�m be�ll�t�sai";

$GLOBALS['strAllowedBannerTypes']		= "Enged�lyezett rekl�mt�pusok";
$GLOBALS['strTypeSqlAllow']			= "Helyi rekl�mok enged�lyez�se (SQL)";
$GLOBALS['strTypeWebAllow']			= "Helyi rekl�mok enged�lyez�se (Webkiszolg�l�)";
$GLOBALS['strTypeUrlAllow']			= "K�ls� rekl�mok enged�lyez�se";
$GLOBALS['strTypeHtmlAllow']			= "HTML-rekl�mok enged�lyez�se";
$GLOBALS['strTypeTxtAllow']			= "Sz�veges hirdet�sek enged�lyez�se";

$GLOBALS['strTypeWebSettings']			= "Helyi rekl�m (Webkiszolg�l�) be�ll�t�sai";
$GLOBALS['strTypeWebMode']			= "T�rol�si m�d";
$GLOBALS['strTypeWebModeLocal']			= "Helyi k�nyvt�r";
$GLOBALS['strTypeWebModeFtp']			= "K�ls� FTP-kiszolg�l�";
$GLOBALS['strTypeWebDir']			= "Helyi mappa";
$GLOBALS['strTypeWebFtp']			= "FTP-m�d� webrekl�mkiszolg�l�";
$GLOBALS['strTypeWebUrl']			= "Nyilv�nos hivatkoz�s";
$GLOBALS['strTypeFTPHost']			= "FTP-�llom�s";
$GLOBALS['strTypeFTPDirectory']			= "�llom�s k�nyvt�ra";
$GLOBALS['strTypeFTPUsername']			= "Felhaszn�l�n�v";
$GLOBALS['strTypeFTPPassword']			= "Jelsz�";
$GLOBALS['strTypeFTPErrorDir']			= "A k�nyvt�r nem l�tezik az �llom�son";
$GLOBALS['strTypeFTPErrorConnect']		= "Nem siker�lt kapcsol�dni az FTP-kiszolg�l�hoz, a felhaszn�l�n�v vagy a jelsz� hib�s";
$GLOBALS['strTypeFTPErrorHost']			= "Az FTP-kiszolg�l� �llom�sneve pontatlan";
$GLOBALS['strTypeDirError']				= "A helyi k�nyvt�r nem l�tezik";



$GLOBALS['strDefaultBanners']			= "Alap�rtelmezett rekl�mok";
$GLOBALS['strDefaultBannerUrl']			= "Alap�rtelmezett k�p hivatkoz�s";
$GLOBALS['strDefaultBannerTarget']		= "Alap�rtelmezett c�l hivatkoz�s";

$GLOBALS['strTypeHtmlSettings']			= "HTML-rekl�m tulajdons�gai";
$GLOBALS['strTypeHtmlAuto']			= "A HTML-rekl�mok automatikus m�dos�t�sa a kattint�s-nyomk�vet�s utas�t�sa c�lj�b�l";
$GLOBALS['strTypeHtmlPhp']			= "A PHP-le�r�sok HTML-rekl�mb�l t�rt�n� v�grehajt�s�nak enged�lyez�se";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "�llom�s inform�ci�ja �s geotargeting";

$GLOBALS['strRemoteHost']				= "T�voli �llom�s";
$GLOBALS['strReverseLookup']			= "A l�togat� �llom�snev�nek meg�llap�t�sa, ha a kiszolg�l� nem tov�bb�tja";
$GLOBALS['strProxyLookup']				= "A l�togat� val�di IP-c�m�nek meg�llap�t�sa, ha proxy kiszolg�l�t haszn�l";

$GLOBALS['strGeotargeting']				= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "A geotargeting adatb�zis t�pusa";
$GLOBALS['strGeotrackingLocation'] 		= "A geotargeting adatb�zis helye";
$GLOBALS['strGeotrackingLocationError'] = "A geotargeting adatb�zis nem l�tezik az �n �ltal megadott helyen";
$GLOBALS['strGeoStoreCookie']			= "Az eredm�ny t�rol�sa cookie-ban a k�s�bbi hivatkoz�s c�lj�ra";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statisztika be�ll�t�sai";

$GLOBALS['strStatisticsFormat']			= "Statisztika form�tuma";
$GLOBALS['strCompactStats']				= "Statisztika form�tuma";
$GLOBALS['strLogAdviews']				= "Let�lt�s napl�z�sa a rekl�m minden tov�bb�t�sakor";
$GLOBALS['strLogAdclicks']				= "Kattint�s napl�z�sa a felhaszn�l� a rekl�mra t�rt�n� minden kattint�sakor";
$GLOBALS['strLogSource']				= "A h�v�s k�zben megadott forr�s param�ter napl�z�sa";
$GLOBALS['strGeoLogStats']				= "A l�togat� orsz�g�nak napl�z�sa a statisztik�ban";
$GLOBALS['strLogHostnameOrIP']			= "A l�togat� �llom�snev�nek vagy IP-c�m�nek napl�z�sa";
$GLOBALS['strLogIPOnly']				= "Csak a l�togat� IP-c�m�nek napl�z�sa, m�g ha az �llom�sn�v ismert is";
$GLOBALS['strLogIP']					= "A l�togat� IP-c�m�nek napl�z�sa";
$GLOBALS['strLogBeacon']				= "Kis jelz�k�p haszn�lata a let�lt�sek napl�z�s�hoz a csak a tov�bb�tott rekl�mok napl�z�s�nak ellen�rz�s�hez";

$GLOBALS['strRemoteHosts']				= "T�voli �llom�sok";
$GLOBALS['strIgnoreHosts']				= "Nincs statisztika k�sz�t�s a k�vetkez� IP-c�mek vagy �llom�snevek valamelyik�t haszn�l� l�togat�kr�l";
$GLOBALS['strBlockAdviews']				= "Nincs let�lt�s napl�z�s, ha a l�togat� m�r l�tta ugyanazt a rekl�mot a megadott m�sodperceken bel�l";
$GLOBALS['strBlockAdclicks']			= "Nincs kattint�s napl�z�s, ha a l�togat� m�r r�kattintott ugyanarra a rekl�mra a megadott m�sodperceken bel�l";


$GLOBALS['strPreventLogging']			= "Napl�z�s korl�toz�sa";
$GLOBALS['strEmailWarnings']			= "Figyelmeztet�sek e-mailben";
$GLOBALS['strAdminEmailHeaders']		= "A k�vetkez� fejl�cek hozz�ad�sa a ".$phpAds_productname." �ltal k�ld�tt elektronikus �zenethez";
$GLOBALS['strWarnLimit']				= "Figyelmeztet�s k�ld�se, ha a marad�k let�lt�sek sz�ma kevesebb az itt megadottn�l";
$GLOBALS['strWarnLimitErr']				= "A figyelmeztet�si korl�toz�s pozit�v sz�m legyen";
$GLOBALS['strWarnAdmin']				= "Figyelmeztet�s k�ld�se az adminisztr�tornak, ha egy kamp�ny lej�rata k�zeledik";
$GLOBALS['strWarnClient']				= "Figyelmeztet�s k�ld�se a hirdet�nek, ha k�zeledik a kamp�nya lej�rata";
$GLOBALS['strQmailPatch']				= "A qmail folt enged�lyez�se";

$GLOBALS['strAutoCleanTables']			= "Adatb�zis karbantart�sa";
$GLOBALS['strAutoCleanStats']			= "Statisztika ki�r�t�se";
$GLOBALS['strAutoCleanUserlog']			= "Felhaszn�l�i napl� ki�r�t�se";
$GLOBALS['strAutoCleanStatsWeeks']		= "A statisztika maxim�lis kora <br>(minimum 3 h�t)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "A felhaszn�l�i napl� maxim�lis <br>kora (minimum 3 h�t)";
$GLOBALS['strAutoCleanErr']				= "A maxim�lis kor legal�bb 3 h�t legyen";
$GLOBALS['strAutoCleanVacuum']			= "A t�bl�k V�KUMOS ELEMZ�SE minden �jjel"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Adminisztr�tor be�ll�t�sai";

$GLOBALS['strLoginCredentials']			= "Bel�p�si igazolv�ny";
$GLOBALS['strAdminUsername']			= "Adminisztr�tor felhaszn�l�neve";
$GLOBALS['strInvalidUsername']			= "A felhaszn�l�n�v �rv�nytelen";

$GLOBALS['strBasicInformation']			= "Alapinform�ci�";
$GLOBALS['strAdminFullName']			= "Adminisztr�tor teljes neve";
$GLOBALS['strAdminEmail']			= "Adminisztr�tor e-mail c�me";
$GLOBALS['strCompanyName']			= "C�g";

$GLOBALS['strAdminCheckUpdates']		= "Friss�t�s keres�se";
$GLOBALS['strAdminCheckEveryLogin']		= "Minden bel�p�skor";
$GLOBALS['strAdminCheckDaily']			= "Naponta";
$GLOBALS['strAdminCheckWeekly']			= "Hetente";
$GLOBALS['strAdminCheckMonthly']		= "Havonta";
$GLOBALS['strAdminCheckNever']			= "Soha";

$GLOBALS['strAdminNovice']			= "Biztons�gi c�lb�l meger�s�t�s sz�ks�ges az adminisztr�tor t�rl�seihez";
$GLOBALS['strUserlogEmail']			= "Minden kimen� e-mail napl�z�sa";
$GLOBALS['strUserlogPriority']			= "�r�nk�nti priorit�s sz�m�t�sok napl�z�sa";
$GLOBALS['strUserlogAutoClean']			= "Az adatb�zis automatikus karbantart�s�nak napl�z�sa";


// User interface settings
$GLOBALS['strGuiSettings']			= "Felhaszn�l�i kezel�fel�let be�ll�t�sai";

$GLOBALS['strGeneralSettings']			= "�ltal�nos be�ll�t�sok";
$GLOBALS['strAppName']				= "Alkalmaz�s neve";
$GLOBALS['strMyHeader']				= "Fejl�cf�jl helye";
$GLOBALS['strMyHeaderError']		= "Nem tal�lhat� a fejl�cf�jl az �n �ltal megadott helyen";
$GLOBALS['strMyFooter']				= "L�bjegyzetf�jl helye";
$GLOBALS['strMyFooterError']		= "Nem tal�lhat� a l�bjegyzetf�jl az �n �ltal megadott helyen";
$GLOBALS['strGzipContentCompression']		= "GZIP tartalomt�m�r�t�s haszn�lata";

$GLOBALS['strClientInterface']			= "Hirdet�i kezel�fel�let";
$GLOBALS['strClientWelcomeEnabled']		= "A hirdet� �dv�zl�s�nek enged�lyez�se";
$GLOBALS['strClientWelcomeText']		= "�dv�zl�sz�veg<br>(a HTML-elemek enged�lyezettek)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Kezel�fel�let alapbe�ll�t�sai";

$GLOBALS['strInventory']			= "Nyilv�ntart�";
$GLOBALS['strShowCampaignInfo']			= "Kieg�sz�t� kamp�ny-inform�ci� megjelen�t�se a <i>Kamp�ny �ttekint�se</i> oldalon";
$GLOBALS['strShowBannerInfo']			= "Kieg�sz�t� rekl�m-inform�ci� megjelen�t�se a <i>Rekl�m �ttekint�se</i> oldalon";
$GLOBALS['strShowCampaignPreview']		= "A rekl�mok megtekint�se el�n�zetben a <i>Rekl�m �ttekint�se</i> oldalon";
$GLOBALS['strShowBannerHTML']			= "HTML-rekl�m el�n�zet eset�n az aktu�lis rekl�m megjelen�t�se a HTML-k�d helyett";
$GLOBALS['strShowBannerPreview']		= "A rekl�m el�n�zet�nek megjelen�t�se a rekl�mokkal foglalkoz� oldalak tetej�n";
$GLOBALS['strHideInactive']			= "Az inakt�v objektumok elrejt�se az �ttekint�ses oldalakr�l";
$GLOBALS['strGUIShowMatchingBanners']		= "Az egyez� rekl�mok megjelen�t�se a <i>Kapcsolt rekl�m</i> oldalakon";
$GLOBALS['strGUIShowParentCampaigns']		= "A sz�l� kamp�nyok megjelen�t�se a <i>Kapcsolt rekl�m</i> oldalakon";
$GLOBALS['strGUILinkCompactLimit']		= "A nem kapcsolt kamp�nyok vagy rekl�mok elrejt�se a <i>Kapcsolt rekl�m</i> oldalakon, ha nincs t�bb, mint";

$GLOBALS['strStatisticsDefaults'] 		= "Statisztika";
$GLOBALS['strBeginOfWeek']			= "A h�t kezdete";
$GLOBALS['strPercentageDecimals']		= "Sz�zal�kos ar�ny tizedesjegyei";

$GLOBALS['strWeightDefaults']			= "Alap�rtelmezett fontoss�g";
$GLOBALS['strDefaultBannerWeight']		= "Alap�rtelmezett rekl�m fontoss�g";
$GLOBALS['strDefaultCampaignWeight']		= "Alap�rtelmezett kamp�ny fontoss�g";
$GLOBALS['strDefaultBannerWErr']		= "Az alap�rtelmezett rekl�m fontoss�g pozit�v eg�sz sz�m legyen";
$GLOBALS['strDefaultCampaignWErr']		= "Az alap�rtelmezett kamp�ny fontoss�g pozit�v eg�sz sz�m legyen";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "T�bl�zatszeg�ly sz�ne";
$GLOBALS['strTableBackColor']			= "T�bl�zath�tt�r sz�ner";
$GLOBALS['strTableBackColorAlt']		= "T�bl�zath�tt�r sz�ne (v�laszthat�)";
$GLOBALS['strMainBackColor']			= "F� h�tt�rsz�n";
$GLOBALS['strOverrideGD']			= "A GD k�pform�tum hat�lytalan�t�sa";
$GLOBALS['strTimeZone']				= "Id�z�na";

?>