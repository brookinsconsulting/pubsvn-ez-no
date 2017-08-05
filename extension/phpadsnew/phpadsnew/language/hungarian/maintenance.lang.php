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


// Main strings
$GLOBALS['strChooseSection']			= "Szekci� kiv�laszt�sa";


// Priority
$GLOBALS['strRecalculatePriority']		= "Priorit�s �jrasz�mol�sa";
$GLOBALS['strHighPriorityCampaigns']		= "Magas priorit�s� kamp�ny";
$GLOBALS['strAdViewsAssigned']			= "Beosztott let�lt�s";
$GLOBALS['strLowPriorityCampaigns']		= "Alacsony priorit�s� kamp�ny";
$GLOBALS['strPredictedAdViews']			= "Let�lt�sek el�rejelz�se";
$GLOBALS['strPriorityDaysRunning']		= "Jelenleg {days} napra vonatkoz� statisztika �ll rendelkez�sre, melyb�l a ".$phpAds_productname." meg tudja �llap�tani a napi el�rejelz�st. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Az el�rejelz�s az e heti �s a m�lt heti adatok alapj�n t�rt�nik. ";
$GLOBALS['strPriorityBasedLastDays']		= "Az el�rejelz�s az elm�lt n�h�ny nap alapj�n t�rt�nik. ";
$GLOBALS['strPriorityBasedYesterday']		= "Az el�rejelz�s a tegnapi adatok alapj�n t�rt�nik. ";
$GLOBALS['strPriorityNoData']			= "Megb�zhat� el�rejelz�s k�sz�t�s�hez kev�s adat �ll rendelkez�sre a hirdet�skiszolg�l� �ltal ma l�trehozand� kiad�sok sz�m�val kapcsolatban. Csak val�s idej� statisztika lesz a priorit�s beoszt�sok alapja. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Elegend� kattint�snak kell lennie a megc�lzott magas priorit�s� kamp�nyok teljes kiel�g�t�s�hez. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nem vil�gos, hogy elegend� let�lt�s lesz-e ma szolg�ltatva a megc�lzott magas priorit�s� kamp�nyok kiel�g�t�s�hez ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Rekl�m gyors�t�t�r �jra�p�t�se";
$GLOBALS['strBannerCacheExplaination']		= "
	A rekl�m gyors�t�t�r a rekl�mot megjelen�t� HTML-k�d m�solat�t tartalmazza. A rekl�m gyors�t�t�r haszn�lat�val fel lehet
	gyors�tani a rekl�mok tov�bb�t�s�t, mert a HTML-k�dot nem kell a rekl�m minden tov�bb�t�sakor gener�lni. Mivel a rekl�m
	gyors�t�t�r a ".$phpAds_productname."-ra �s rekl�maira mutat� nehezen m�dos�that� hivatkoz�sokat tartalmaz, a gyors�t�t�rat
	a ".$phpAds_productname." minden �thelyez�sekor a webkiszolg�l� egy m�sik hely�re t�rt�n� �thelyez�sekor friss�teni kell.
";


// Cache
$GLOBALS['strCache']			= "Tov�bb�t�s gyors�t�t�r";
$GLOBALS['strAge']				= "Kor";
$GLOBALS['strRebuildDeliveryCache']			= "Tov�bb�t�s gyors�t�t�r �jra�p�t�se";
$GLOBALS['strDeliveryCacheExplaination']		= "
	A tov�bb�t�s gyors�t�t�rral n�velhet� a rekl�mok tov�bb�t�s�nak sebess�ge. A gyors�t�t�r tartalmazza mindazon
	rekl�mok m�solat�t, melyek kapcsolva vannak ahhoz a z�n�hoz, amelyik menti az adatb�zis lek�rdez�sek sz�m�t,
	mikor �ppen tov�bb�tja �ket a felhaszn�l�nak. A gyors�t�t�r �jra�p�t�se minden olyan alkalommal megt�rt�nik,
	mikor v�ltoztat�s t�rt�nik a z�n�ban vagy annak rekl�maiban, s lehet, hogy a gyors�t�t�r elavultt� v�lik.
	Emiatt a gyors�t�t�r �jra�p�t�se �r�nk�nt automatikusan t�rt�nik, de lehet�s�g van a k�zi �jra�p�t�sre is.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Jelenleg az osztott mem�ri�ban t�rt�nik a tov�bb�t�s gyors�t�t�r t�rol�sa. 
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Jelenleg az adatb�zisban t�rt�nik a tov�bb�t�s gyors�t�t�r t�rol�sa. 
";
$GLOBALS['strDeliveryCacheFiles']		= "
	A tov�bb�t�s gyors�t�t�r t�rol�sa jelenleg t�bb f�jlban t�rt�nik a kiszolg�l�n.
";


// Storage
$GLOBALS['strStorage']				= "T�rol�s";
$GLOBALS['strMoveToDirectory']			= "Az adatb�zisban t�rolt k�pek �thelyez�se egy k�nyvt�rba";
$GLOBALS['strStorageExplaination']		= "
	A helyi rekl�mok �ltal haszn�lt k�pek t�rol�sa az adatb�zisban vagy egy k�nyvt�rban t�rt�nik.
	Ha k�nyvt�rban t�rolja a k�peket, akkor az adatb�zis terhel�se cs�kken, ami a sebess�g megn�veked�s�t
	jelenti.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	�n enged�lyezte a <i>t�m�r statisztik�t</i>, viszont a r�gi statisztika m�g r�szletes form�ban
	l�tezik. �talak�tja az �j t�m�r�tett form�tumba a r�szletes statisztik�t?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Friss�t�s keres�se. Kis t�relmet...";
$GLOBALS['strAvailableUpdates']			= "L�tez� friss�t�sek";
$GLOBALS['strDownloadZip']			= "Let�lt�s (.zip)";
$GLOBALS['strDownloadGZip']			= "Let�lt�s (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Megjelent a ".$phpAds_productname." �j verzi�ja.                 \\n\\nSzeretne t�bb inform�ci�t megtudni \\nerr�l a friss�t�sr�l?";
$GLOBALS['strUpdateAlertSecurity']		= "Megjelent a ".$phpAds_productname." �j verzi�ja.                 \\n\\nMiel�bbi friss�t�se er�sen aj�nlott, \\nmert ez a verzi� egy vagy t�bb \\nbiztons�gi jav�t�st tartalmaz.";

$GLOBALS['strUpdateServerDown']			= "
    Ismeretlen okb�l kifoly�lag nem lehet inform�ci�hoz <br>
		jutni a lehets�ges friss�t�sekr�l. Pr�b�lkozzon k�s�bb.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	�n a ".$phpAds_productname." leg�jabb verzi�j�t haszn�lja. Friss�t�s jelenleg nem �ll rendelkez�sre.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Megjelent a ".$phpAds_productname." �j verzi�ja.</b><br> Ezt a friss�t�st �rdemes telep�teni, 
	mert kijav�tottunk benne n�h�ny jelenleg l�tez� probl�m�t, s �j funkci�kkal is b�v�tett�k. A friss�t�sr�l
	az al�bbi f�jlokban k�zreadott dokument�ci�b�l tudhat meg t�bbet.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>A friss�t�s miel�bbi telep�t�se er�sen aj�nlott, mert sz�mos biztons�gi jav�t�st tartalmaz.</b>
	A ".$phpAds_productname." �n �ltal jelenleg haszn�lt verzi�ja bizonyos t�mad�sokkal sebezhet�, �s
	lehet, hogy nem biztons�gos. A friss�t�sr�l	az al�bbi f�jlokban k�zreadott dokument�ci�b�l tudhat 
	meg t�bbet.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Mivel az XML b�v�tm�ny nem el�rhet� a kiszolg�l�n, a ".$phpAds_productname." nem tudja
	ellen�rizni, hogy jelent-e meg �jabb verzi�.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Ha szeretn� megtudni, hogy jelent-e meg �jabb verzi�, k�rj�k, hogy l�togasson el webhely�nkre.
";

$GLOBALS['strClickToVisitWebsite']		= "Kattintson ide a webhely�nk felkeres�s�hez";
$GLOBALS['strCurrentlyUsing'] 			= "Az �n �ltal jelenleg haszn�lt verzi�:";
$GLOBALS['strRunningOn']				= "rendszer:";
$GLOBALS['strAndPlain']					= "�s";


// Stats conversion
$GLOBALS['strConverting']			= "Konvert�l�s";
$GLOBALS['strConvertingStats']			= "A statisztika konvert�l�sa...";
$GLOBALS['strConvertStats']			= "A statisztika konvert�l�sa";
$GLOBALS['strConvertAdViews']			= "Let�lt�sek konvert�lva";
$GLOBALS['strConvertAdClicks']			= "Let�lt�sek konvert�lva...";
$GLOBALS['strConvertNothing']			= "Nincs mit konvert�lni...";
$GLOBALS['strConvertFinished']			= "Befejezve...";

$GLOBALS['strConvertExplaination']		= "
	�n jelenleg a statisztika t�rol�s�nak t�m�r�tett form�tum�t haszn�lja, de m�g van <br>
	n�h�ny r�szletes form�tum� statisztika. Am�g nem alak�tja �t a r�szletes statisztik�t <br>
	t�m�r form�tumba, addig nem haszn�lhatja ezeknek az oldalaknak a megtekint�sekor. <br>
	A statisztika konvert�l�sa el�tt k�sz�tsen biztons�gi m�solatot az adatb�zisr�l! <br>
	K�v�nja a r�szletes statisztik�t az �j, t�m�r form�tumba konvert�lni? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	Minden marad�k r�szletes statisztika most �talak�t�sra ker�l az �j, t�m�r form�tumba. <br>
	Att�l f�gg�en, hogy h�ny lenyomat t�rol�sa t�rt�nik r�szletes form�tumban, ez eltarthat <br>
	p�r percig. M�s oldalak felkeres�se el�tt v�rja meg a konert�l�s befejez�s�t. <br>
	Al�bb megtekintheti az adatb�zisban t�rt�nt m�dos�t�sok napl�j�t. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	A marad�k r�szletes statisztika konvert�l�sa siker�lt, �s az adatok mostm�r <br>
	�jra haszn�lhat�ak. Al�bb megtekintheti az adatb�zisban t�rt�nt m�dos�t�sok <br>
	napl�j�t.<br>
";


?>