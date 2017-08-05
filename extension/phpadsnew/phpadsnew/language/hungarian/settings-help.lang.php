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



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        �rja be annak a ".$phpAds_dbmsname." adatb�zis kiszolg�l�nak az �llom�snev�t, melyhez kapcsol�dni k�v�n.
		";
		
$GLOBALS['phpAds_hlp_dbport'] = "
        �rja be a ".$phpAds_dbmsname." adatb�zis kiszolg�l� portj�t, melyhez kapcsol�dni 
		k�v�n. A ".$phpAds_dbmsname." adatb�zis alap�rtelmezett port sz�ma <i>".
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432')."</i>.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        �rja be azt a felhaszn�l�nevet, mellyel a ".$phpAds_productname." hozz� tud f�rni a ".$phpAds_dbmsname." adatb�zis kiszolg�l�hoz.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        �rja be azt a jelsz�t, amivel a ".$phpAds_productname." hozz� tud f�rni a ".$phpAds_dbmsname." adatb�zis kiszolg�l�hoz.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        �rja be az adatb�zis kiszolg�l�n l�v� annak az adatb�isnak a nev�t, ahol a ".$phpAds_productname." t�rolni fogja az adatokat. 
		Fontos, hogy el�tte hozza l�tre az adatb�zist az adatb�zis kiszolg�l�n. A ".$phpAds_productname." <b>nem</b> hozza l�tre
		ezt az adatb�zist, ha m�g nem l�tezik.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        Az �lland� kapcsolat haszn�lata jelent�sen felgyors�thatja a ".$phpAds_productname." 
		fut�s�t, s�t, a kiszolg�l� terhel�s�t is cs�kkentheti. Van azonban egy h�tr�nya, olyan
		helyen, melynek sok a l�togat�ja, a kiszolg�l� terhel�se n�vekedhet, �s nagyobb lesz,
		mint norm�l kapcsolatok haszn�latakor. A hagyom�nyos vagy az �lland� kapcsolat haszn�lata
		f�gg a l�togat�k sz�m�t�l �s a haszn�lt hardvert�l. Ha a ".$phpAds_productname." t�l sok
		er�forr�st k�t le, akkor el�bb vessen egy pillant�st erre a be�ll�t�sra.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        Adatok besz�r�sakor a ".$phpAds_dbmsname." z�rolja a t�bl�t. Ha magas a hely l�togatotts�ga, 
		akkor lehet, hogy �j sor besz�r�sa el�tt a ".$phpAds_productname." v�rni fog, mert az adatb�zis
		m�g le van z�rva. K�sleltetett besz�r�s eset�n nem kell v�rakoznia, �s a sor besz�r�s�ra
		egy k�s�bbi id�pontban ker�l sor, amikor a m�s sz�lak nem veszik ig�nybe a t�bl�t. 
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
				Ha probl�m�k mer�lnek fel a ".$phpAds_productname." egy harmadik f�l �ltal k�sz�tett term�kbe
		integr�l�sakor, akkor seg�thet az adatb�zis kompatibilit�s m�d bekapcsol�sa. Ha helyi m�d� h�v�sokat
		haszn�l, �s az adatb�zis kompatibilit�s m�dot bekapcsolta, akkor a ".$phpAds_productname." az
		adatb�zis kapcsolat �llapot�t pontosan ugyan�gy hagyja, ahogy a ".$phpAds_productname." fut�sa
		el�tt volt. Ez a tulajdons�g egy kicsit lass� (csak n�mileg), �s ez�rt alap�rtelmez�s szerint
		kikapcsolt.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        Ha a ".$phpAds_productname." adatb�zis haszn�lata t�bb szoftverterm�k �ltal megosztott, akkor
		b�lcs d�nt�s a t�bl�k nev�hez el�tagot hozz�f�zni. Ha �n a ".$phpAds_productname." t�bb telep�t�s�t
		haszn�lja ugyanabban az adatb�zisban, akkor gy�z�dj�n meg arr�l, hogy ez az el�tag valamennyi
		telep�t�s sz�m�ra egyedi.
		";
		
$GLOBALS['phpAds_hlp_table_type'] = "
        A ".$phpAds_dbmsname." lehet�v� teszi t�bbf�le t�blat�pus haszn�lat�t. Mindegyik t�blat�pus
		egyedi tulajdons�gokkal rendelkezik, �s n�melyik jelent�sen felgyors�thatja a ".$phpAds_productname."
		fut�s�t. A MyISAM az alap�rtelmezett t�blat�pus, �s a ".$phpAds_productname." valamennyi telep�t�s�ben
		el�rhet�. Lehet, hogy m�s t�blat�pusok nem haszn�lhat�k a kiszolg�l�n.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        A ".$phpAds_productname." megfelel� m�k�d�se szempontj�b�l fontos inform�ci� a sz�m�ra, 
				hogy hol helyezkedik el a webkiszolg�l�n. Meg kell adnia annak a k�nyvt�rnak a hivatkoz�s�t, melybe a ".$phpAds_productname." 
				telep�t�se t�rt�nt. P�ld�ul: <i>http://www.az-on-hivatkozasa.com/".$phpAds_productname."</i>.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Itt adhatja meg a fejl�c f�jlok �tvonal�t (pl.: /home/login/www/header.htm),
				hogy legyen fejl�c �s l�bjegyzet az adminisztr�tori kezel�fel�let mindegyik
				oldal�n. Sz�veget vagy HTML-k�dot egyar�nt �rhat ezekben a f�jlokban (ha az 
				egyik vagy mindk�t f�jlban HTML-k�dot akar haszn�lni, akkor ne haszn�ljon
				olyan elemeket, mint a &lt;body> vagy a &lt;html>).
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		A GZIP tartalomt�n�r�t�s enged�lyez�s�vel az adminisztr�tor kezel�fel�let egy oldal�nak 
		minden alkalommal t�rt�n� megnyit�sakor nagyon cs�kkenhetnek a b�ng�sz�h�z k�ld�tt 
		adatok m�retei. A funkci� enged�lyez�s�hez legal�bb PHP 4.0.5 �s a GZIP b�v�tm�ny
		telep�t�se sz�ks�ges.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Itt v�laszthatja ki a ".$phpAds_productname." �ltal haszn�lt alap�rtelmezett
				nyelvet. Ez a nyelv alap�rtelmezettk�nt ker�l felhaszn�l�sra az adminisztr�tor 
				�s a hirdet� kezel�fel�let sz�m�ra. Ne feledje: az egyes hirdet�knek elt�r� 
				nyelvet �ll�that be az adminisztr�tor kezel�fel�letb�l, �s enged�lyezhetzi a 
				hirdet�knek, hogy saj�t maguk v�lts�k �t a nyelvet..
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        �rja be az ehhez az alkalmaz�shoz haszn�lni k�v�nt nevet. Ez a sz�veg lesz
				l�that� az adminisztr�tor �s a hirdet� kezel�fel�let valamennyi oldal�n.
				Ha �resen (alap�rtelmez�s) hagyja ezt a be�ll�t�st, akkor a	".$phpAds_productname." 
				jelenik meg helyette.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        Ez a n�v ker�l felhaszn�l�sra a ".$phpAds_productname." �ltal k�ld�tt e-mailben.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        A ".$phpAds_productname." �ltal�ban felismeri, hogy a GD k�nyvt�r telep�tve
				van-e, �s a GD telep�tett v�ltozata mely k�pform�tumot t�mogatja. Azonban
				lehet, hogy ez a meg�llap�t�s pontatlan vagy hamis, a PHP n�mely verzi�ja
				nem teszi lehet�v� a t�mogatott k�pform�tumok felismer�s�t. Ha a ".$phpAds_productname."
				nem tudja automatikusan meg�llap�tani a megfelel� k�pform�tumot, akkor �n is
				megadhatja azt. A lehets�ges �rt�kek: nincs, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Ha akarja enged�lyezni a ".$phpAds_productname." P3P Adatv�delmi Nyilatkozat�t,
				akkor jel�lje be ezt a tulajdons�got. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        A cookie-kkal egy�tt k�ld�tt t�m�r nyilatkozat. Az alap�rtelmezett be�ll�t�s:
				'CUR ADM OUR NOR STA NID', ami lehet�v� teszi az Internet Explorer 6 sz�m�ra,
				hogy elfogadja a ".$phpAds_productname." �ltal haszn�lt cookie-kat. V�ltoztathat
				ezeken a be�ll�t�sokon, ha akar, hogy megfeleljenek a saj�t bizalmi 
				nyilatkozat�nak.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Ha teljes adatv�delmi nyilatkozatot akar haszn�lni, akkor megadhatja
				a nyilatkozat hely�t.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		A jelz�k�pek kis m�ret�ek �s l�thatatlanok, azon az oldalon vannak elhelyezve,
		melyen a rekl�m is megjelenik. Ha enged�lyezi ezt a funkci�t, akkor a 
		".$phpAds_productname." ezt a jelz�k�pet fogja felhaszn�lni a let�lt�sek
		sz�mol�s�ra, amit a rekl�m kapott. Ha letiltja ezt a tulajdons�got, akkor a
		let�lt�s tov�bb�t�s k�zben ker�l sz�mol�sra, azonban ez nem teljesen pontos,
		mert a tov�bb�tott rekl�mot nem kell mindig megjelen�tenie a k�perny�n.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        A ".$phpAds_productname." eredetileg el�gg� terjedelmes napl�z�st haszn�lt,
				ami nagyon r�szletes volt, viszont nagyon f�gg�tt az adatb�zis kiszolg�l�t�l
				is. Ez a magas l�togatotts�g� helyeken nagy probl�ma lehetett. Ennek a
		progl�m�nak a lek�zd�s�re a ".$phpAds_productname." �jfajta statisztik�t is
		t�mogat, az adatb�zis kiszolg�l�t�l kev�sb� f�gg�, de kev�sb� r�szletes t�m�r 
		statisztik�t.
		A t�m�r statisztika �r�nk�nt gy�jti a let�lt�seket �s a kattint�sokat, de ha
		sz�ks�ge van a r�szletekre, a t�m�r statisztik�t kikapcsolhatja.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Norm�l esetben minden let�lt�s napl�z�sra ker�l, viszont ha �n nem akar
				statisztik�t gy�jteni a let�lt�sekr�l, kikapcsolhatja ezt.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		Ha egy l�togat� friss�t egy oldalt, a ".$phpAds_productname." minden alkalommal 
		egy let�lt�st fog napl�zni. Ezzel a funkci�val gy�z�dhet�nk meg arr�l, hogy
		csak egyetlen let�lt�s lett napl�zva minden egyes rekl�mhoz az �n �ltal megadott
		m�sodpercek sz�ma eset�n. P�ld�ul: ha 300 m�sodpercre �ll�tja ezt az �rt�ket,
		akkor a ".$phpAds_productname." csak akkor fogja napl�zni a kattint�sokat, ha
		ugyanazt a rekl�mot m�g nem l�tta ugyanaz a felhaszn�l� az ut�bbi 5 percben.
		Ez a funkci� csak akkor m�k�dik, ha a b�ng�sz� fogadja a cookie-kat.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Norm�l esetben minden kattint�s napl�z�sra ker�l, viszont ha �n nem akarja
				gy�jteni a kattint�sok statisztik�j�t, akkor kikapcsolhatja.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Ha egy l�togat� t�bbsz�r kattint egy rekl�mra, a ".$phpAds_productname." minden 
		alkalommal napl�z	egy kattint�st. Ezzel a funkci�val gy�z�dhet�nk meg arr�l,
		hogy csak egy kattint�s lett napl�zva minden egyes rekl�mhoz az �n �ltal megadott
		m�sodpercek sz�ma eset�n. P�ld�ul: ha 300 m�sodpercre �ll�tja ezt az �rt�ket,
		akkor a ".$phpAds_productname." csak akkor fogja napl�zni a kattint�sokat, ha
		ugyanazt a rekl�mot m�g nem l�tta ugyanaz a felhaszn�l� az ut�bbi 5 percben.
		Ez a funkci� csak akkor m�k�dik, ha a b�ng�sz� fogadja a cookie-kat.
		";
		
$GLOBALS['phpAds_hlp_log_source'] = "
		Ha a forr�sparam�tert haszn�lja a h�v�sk�dban, akkor ezt az inform�ci�t az adatb�zisban
		is t�rolhatja, �gy mindig l�thatja a statisztik�t arr�l, hogy hogyan teljes�lnek
		a k�l�nf�le forr�sparam�terek. Ha nem haszn�lja a forr�sparam�tert, vagy nem akarja
		ennek a param�ternek ez inform�ci�j�t t�rolni, akkor nyugodtan letilthatja ezt a
		tulajdons�got.
		";
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		If you are using a geotargeting database you can also store the geographical information
		in the database. If you have enabled this option you will be able to see statistics about the
		location of your visitors and how each banner is performing in the different countries.
		This option will only be available to you if you are using verbose statistics.
		";
		
$GLOBALS['phpAds_hlp_log_hostname'] = "
		Ha a statisztik�ban t�rolni k�v�nja a l�togat�k �llom�snev�t vagy IP-c�m�t, akkor
		enged�lyezheti ezt a funkci�t. Ennek az inform�ci�nak a t�rol�s�val tudhatjuk meg,
		hogy mely �llom�sok nyerik vissza a legt�bb rekl�mot. Ez a tulajdons�g csak
		r�szletes statisztika eset�n m�k�dik.
		";
		
$GLOBALS['phpAds_hlp_log_iponly'] = "
		A l�togat� �llom�snev�nek t�rol�sa sok helyet foglal el az adatb�zisban. Ha
		enged�lyezi ezt a funkci�t, a ".$phpAds_productname." m�g mindig fogja t�rolni
		az �llom�st inform�ci�j�t, de csak a kevesebb helyet foglal� IP-c�met fogja
		t�rolni. Ez a tulajdons�g nem m�k�dik, ha a kiszolg�l� vagy a ".$phpAds_productname." 
		nem adja meg ezt az inform�ci�t, mert abban az esetben mindig az IP-c�m ker�l
		t�rol�sra. 
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		�ltal�ban a webkiszolg�l� �llap�tja meg az �llom�s nev�t, de lehet, hogy bizonyos
		esetekben ki kell kapcsolni. Ha haszn�lni k�v�nja a felhaszn�l�k �llom�snev�t a tov�bb�t�si 
		korl�toz�sokban, �s/vagy statisztik�t k�v�n err�l vezetni, a kiszolg�l� viszont nem
		szolg�ltat ilyen inform�ci�t, akkor kapcsolja be ezt a tulajdons�got. A l�togat� 
		�llom�snev�nek meg�llap�t�sa n�mi id�t vesz ig�nybe: lass�tja a rekl�mok tov�bb�t�s�t. 
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Vannak olyan l�togat�k, akik proxy kiszolg�l�n kereszt�l kapcsol�dnak az Internethez.
		Ebben az esetben a ".$phpAds_productname." megk�s�rli napl�zni a proxy kiszolg�l� IP-c�m�t 
		vagy �llom�snev�t, a felhaszn�l�� helyett. Ha enged�lyezi ezt a funkci�t, akkor a
		".$phpAds_productname." megpr�b�lja a proxy kiszolg�l� m�g�tt tart�zkod� felhaszn�l�
		sz�m�t�g�p�nek IP-c�m�t vagy �llom�snev�t. Ha nem lehet a l�togat� pontos c�m�t
		megkeresni, akkor a proxy kiszolg�l� c�m�t haszn�lja. Ez a funkci� alap�rtelmez�sk�nt
		nem enged�lyezett, mert jelent�sen lelass�tja a rekl�mok tov�bb�t�s�t.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor az �sszegy�jt�tt statisztika az al�bbi
		jel�l�n�gyzetben megadott id�tartam letelt�vel automatikusan t�rl�sre ker�l. P�ld�ul,
		ha 5 h�tre �ll�tja ezt a jel�l�n�gyzetet, akkor az 5 h�tn�l r�gebbi statisztika
		automatikusan t�rl�sre ker�l.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		Ez a tulajdons�g automatikusan t�rli azokat a bejegyz�seket a felashzn�l�i napl�b�l,
		melyek r�gebbiek az al�bbi jel�l�n�gyzetben megadott hetek sz�m�n�l.
		";
		
$GLOBALS['phpAds_hlp_geotracking_type'] = "
		A geotargeting lehet�v� teszi, hogy a ".$phpAds_productname." f�ldrajzi inform�ci�v� 
		alak�tsa a l�togat� IP-c�m�t. Ezeknek az inform�ci�knak az alapj�n szab�lyozhatja a
		tov�bb�t�s korl�toz�s�t, vagy elt�rolhatja ezt az inform�ci�t, �gy megtekintheti, hogy
		mely orsz�g gener�lja a legt�bb let�lt�st vagy kattint�st. Ha enged�lyezni akarja a
		geotargetinget, akkor ki kell v�lasztania, hogy mely adatb�zis t�pusokkal rendelkezik.
		A ".$phpAds_productname." jelenleg az <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a>
		�s a <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> adatb�zisokat
		t�mogatja.
		";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
		Amikor nem �n a GeoIP Apache modul, akkor meg kell adnia a ".$phpAds_productname." sz�m�ra
		a geotargeting adatb�zis hely�t. Az adatb�zist �rdemes mindig a webkiszolg�l�k
		dokumentumgy�ker�n k�v�l elhelyezni, mert k�l�nben le lehet t�lteni az adatb�zist.
		";
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		Az IP-c�m f�ldrajzi adatokk� alak�t�sa id�ig�nyes feladat. A ".$phpAds_productname."
		a rekl�m minden alkalommal t�rt�n� tov�bb�t�s�nak megakad�lyoz�s�ra az eredm�nyt egy
		cookie-ban tudja t�rolni. Ha ez a cookie l�tezik, akkor a ".$phpAds_productname."
		ezt az inform�ci�t haszn�lja fel az IP-c�m �talak�t�sa helyett.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        Ha nem akarja sz�molni valamely sz�m�t�g�pr�l �rkez� kattint�sokat �s let�lt�seket,
				akkor ezeket felveheti erre a list�ra. A ford�tott keres�s enged�lyez�se eset�n
				tartom�nyneveket �s IP-c�meket egyar�nt felvehet, egy�b esetben csak az IP-c�meket
				haszn�lhatja. Karakterhelyettes�t�ket is haszn�lhat (pl. '*.altavista.com' vagy 
				'192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        A legt�bb ember sz�m�ra a h�t els� napja a h�tf�, de ha a vas�rnappal akarja
				kezdeni a hetet, megteheti.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        Azt szabja meg, hogy h�ny tizes hely legyen l�that� a statisztikai oldalakon.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        A ".$phpAds_productname." e-mailt tud �nnek k�ldeni, ha egy kamp�nyban m�r csak
				korl�tozott sz�m� kattint�s vagy let�lt�s van h�tra. Alap�rtelmez�sk�nt ez
				enged�lyezett.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        A ".$phpAds_productname." e-mailt tud k�ldeni a hirdet�nek, ha valamelyik kamp�ny�ban
		csak korl�tozott sz�m� kattint�s vagy let�lt�s van h�tra. Alap�rtelmez�sk�nt ez
		enged�lyezett.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		A qmail n�mely verzi�j�ra egy hiba van hat�ssal, ami a ".$phpAds_productname." �ltal
		k�ld�tt e-mailben a fejl�cnek az e-mail t�rzs�ben l�v� megjelen�t�s�t okozza. Ha
		enged�lyezi ezt a be�ll�t�st, akkor a ".$phpAds_productname." qmail kompatibilis
		form�tumban fogja k�ldeni az e-mailt.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        A hat�r, melynek el�r�sekor a ".$phpAds_productname." figyelmeztet� e-maileket
				kezd k�ldeni. Ez az �rt�k 100 alap�rtelmez�sk�nt.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Ezekkel a be�ll�t�sokkal szab�lyozhatja az enged�lyezett h�v�st�pusokat.
		Ha az egyik h�v�st�pus letiltott, akkor a h�v�sk�d / rekl�mk�d gener�tor
		sz�m�ra nem hozz�f�rhet�. Fontos: a h�v�sm�dszerek m�g mindig m�k�dni fognak,
		ha letiltottak, viszont a gener�l�s sz�m�ra nem el�rhet�ek.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        A ".$phpAds_productname." k�zvetlen v�laszt�st haszn�l� hat�kony visszakeres� 
		rendszert tartalmaz. R�szleteket a felhaszn�l�i k�zik�nyvben olvashat err�l. Ezzel
		a tulajdons�ggal aktiv�lhatja a felt�teles kulcsszavakat. Alap�rtelmez�sk�nt
		enged�lyezve.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        Ha a k�zvetlen kiv�laszt�st haszn�lja a rekl�mok megjelen�t�s�re, akkor mindegyikhez
		megadhat kulcsszavakat. Enged�lyeznie kell ezt a tulajdons�got, ha egyn�l t�bb
		kulcssz�t akar megadni. Alap�rtelmez�sk�nt enged�lyezve.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        Ha nem haszn�lja a tov�bb�t�si korl�toz�sokat, akkor ezzel a tulajdons�ggal letilthatja
				ezt a param�tert. Ez egy kicsit felgyors�tja a ".$phpAds_productname." m�k�d�s�t.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        Ha a ".$phpAds_productname." nem tud kapcsol�dni az adatb�zis kiszolg�l�hoz, vagy
				egy�ltal�n nem tal�l egyez� rekl�mokat, p�ld�ul amikor �sszeomlik vagy t�rl�sre
				ker�l az adatb�zis, akkor nem jelen�t meg semmit. Lehet, hogy lesz olyan felhaszn�l�,
				aki ilyen esetben megjelen�t�sre ker�l� alap�rtelmezett rekl�mot akar megadni.
				Az itt megadott alap�rtelmezett rekl�m nem ker�l napl�z�sra, �s nem ker�l felhaszn�l�sra,
				ha maradnak m�g akt�v rekl�mok az adatb�zisban. Alap�rtelmez�sk�nt tiltva.
		";
		
$GLOBALS['phpAds_hlp_delivery_caching'] = "
		A tov�bb�t�s felgyors�t�s�nak el�mozd�t�s�ra a ".$phpAds_productname." gyors�t�t�rat
		haszn�l, ami tartalmazza a webhely l�togat�ja sz�m�ra megjelen� rekl�m tov�bb�t�s�hoz 
		sz�ks�ges inform�ci�kat. A tov�bb�t�s gyors�t�t�r alap�rtelmez�sk�nt az adatb�zisban
		tal�lhat�, de a sebess�g tov�bbi n�vel�s�hez lehet�s�g van a gyors�t�t�r f�jlban
		vagy osztott mem�ri�ban t�rt�n� t�rol�s�ra. Az osztott mem�ria a leggyorsabb, a f�jl
		is gyors. A tov�bb�t�s gyors�t�t�r kikapcsol�sa nem aj�nlott, mert ez komoly hat�st
		gyakorol a rendszerre.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        A ".$phpAds_productname." k�l�nf�le t�pus� rekl�mokat tud felhaszn�lni, ezeket
				k�l�nf�le m�don tudja t�rolni. Az els� k�t tulajdons�g a rekl�mok helyi t�rol�s�ra
				haszn�lhat�. Az adminisztr�tor kezel�fel�leten t�ltheti fel a rekl�mot, amit a
				".$phpAds_productname." az SQL adatb�zisban vagy a webkiszolg�l�n fog t�rolni.
		K�ls� webkiszolg�l�n t�rolt rekl�mot is haszn�lhat, ill. haszn�lhat HTML-t vagy
		egyszer� sz�veget a rekl�m gener�l�s�hoz.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Ha a webkiszolg�l�n t�rolt rekl�mokat akar haszn�lni, akkor konfigur�lnia
				kell ezt a be�ll�t�st. Ha helyi mapp�ban k�v�nja t�rolni a rekl�mokat, akkor
				a <i>Helyi k�nyvt�r</i> elemet jel�lje ki. Ha k�ls� FTP-kiszolg�l�n akarja
		t�rolni a rekl�mokat, akkor a <i>K�ls� FTP-kiszolg�l�</i> elemet jel�lje ki.
		Lehet, hogy n�mely webkiszolg�l�n, s�t, ak�r a helyi webkiszolg�l�n is az 
		FTP-opci�t k�v�nja haszn�lni.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Adja meg a mapp�t, melybe a ".$phpAds_productname." a felt�lt�tt rekl�mokat
				fogja m�solni. A PHP sz�m�ra ennek a mapp�nak �rhat�nak kell lennie, ami
				azt jelenti, hogy �nnek m�dos�tania kell a k�nyvt�r UNIX enged�lyeit (chmod).
				Az �n �ltal itt megadott k�nyvt�rnak a webkiszolg�l� dokumentumgy�ker�ben
				kell lennie, a webkiszolg�l�nak k�zvetlen�l kell tudnia szolg�lnia a f�jlokat.
				Ne �rjon be per jelet (/). Csak akkor kell ezt a be�ll�t�st elv�geznie, ha
				t�rol�si m�dk�nt a <i>Helyi k�nyvt�r</i> elemet jel�lte ki.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Ha a <i>K�ls� FTP-kiszolg�l�</i> t�rol�si m�dot v�lasztotta, akkor meg
		kell adnia annak az FTP-kiszolg�l�nak az IP-c�m�t vagy tartom�nynev�t, melyre a
		".$phpAds_productname." a felt�lt�tt rekl�mokat m�solni fogja.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Ha a <i>K�ls� FTP-kiszolg�l�</i> t�rol�si m�dot v�lasztotta, akkor meg
		kell adnia az FTP-kiszolg�l�n azt a k�nyvt�rat, melybe a ".$phpAds_productname." 
		a felt�lt�tt rekl�mokat m�solni fogja.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Ha a <i>K�ls� FTP-kiszolg�l�</i> t�rol�si m�dot v�lasztotta, akkor meg
		kell adnia azt a felhaszn�l�nevet, melyet a ".$phpAds_productname." haszn�lni
		fog a k�ls� FTP-kiszolg�l�hoz t�rt�n� csatlakoz�skor. 
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Ha a <i>K�ls� FTP-kiszolg�l�</i> t�rol�si m�dot v�lasztotta, akkor meg
		kell adnia azt a jelsz�t, melyet a ".$phpAds_productname." haszn�lni
		fog a k�ls� FTP-kiszolg�l�hoz t�rt�n� csatlakoz�skor. 
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        Ha webkiszolg�l�n t�rol rekl�mokat, akkor a ".$phpAds_productname." sz�m�ra
				meg kell adnia, hogy melyik nyilv�nos hivatkoz�s tartozik az al�bb megadott
				k�nyvt�rhoz. Ne �rjon be per jelet (/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        Ha enged�lyezi ezt a tulajdons�got, akkor a ".$phpAds_productname." automatikusan
				v�ltogatja a HTML rekl�mokat, hogy enged�lyezze a kattint�sok napl�z�s�t. Viszont
				m�g ennek atulajdons�gnak az enged�lyez�se eset�n is lehet�s�g van ennek a tulajdons�gnak
				a rekl�m alap� letilt�s�ra. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        Lehet�s�g van arra, hogy a ".$phpAds_productname." a HTML-rekl�mokba �gyazott
				PHP-k�dot hajtson v�gre. A funkci� alap�rtelmez�sk�nt tiltva.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        �rja be az adminisztr�tor felhaszn�l�nev�t. Ezzel a felhaszn�l�n�vvel
				jelentkezhet be �n az adminisztr�tor kezel�fel�letre.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
        �rja be az adminisztr�tor kezel�fel�letre t�rt�n� bejelentkez�shez sz�ks�ges
				jelsz�t. A g�pel�si hib�k megel�z�se c�lj�b�l k�tszer kell be�rnia.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        Az adminisztr�tor jelszav�nak megv�ltoztat�s�hoz meg kell adnia a
				fentiekben a r�gi jelsz�t. Tov�bb�, a g�pel�si hib�k elker�l�se v�gett 
				k�tszer meg kell adnia az �j jelsz�t.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        Adja meg az adminisztr�tor teljes nev�t. Ez a n�v ker�l felhaszn�l�sra
				a statisztika e-mailben t�rt�n� k�ld�sekor.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        Az adminisztr�tor e-mail c�me. Ez ker�l felhaszn�l�sra a Felad� mez�ben 
				a statisztika	e-mailben t�rt�n� k�ld�sekor.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        M�dos�thatja a ".$phpAds_productname." �ltal k�ld�tt e-mailekben haszn�lt fejl�ceket.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        Ha szeretne figyelmeztet�st kapni a hirdet�k, kamp�nyok, rekl�mok, kiad�k �s z�n�k 
				t�rl�se el�tt, akkor v�lassza az igaz tulajdons�got.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a hirdet� bejelentkez�se ut�ni els�
		oldalon egy �dv�zlet fog megjelenni. Az admin/templates mapp�ban l�v� welcome.html 
		f�jlban a saj�t �dv�zlet�t �rhatja le. N�h�ny dolog, amit �rdemes tartalmaznia:
		az �n c�g�nek a neve, el�rhet�s�ge, a c�g log�ja, a hirdet�si �rak oldal�ra
		mutat� hivatkoz�s, stb.
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		A welcome.html f�jl �tszerkeszt�se helyett itt adhat meg egy r�vid sz�veget. Ha ide
		sz�veget �r be, akkor a welcome.html f�jl kihagy�sra ker�l. Haszn�lhat HTML elemeket is.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		Ha szeretn� ellen�rizni a ".$phpAds_productname." �j verzi�it, akkor �rdemes enged�lyezni
		ezt a tulajdons�got. Meghat�rozhatja azt is, hogy a ".$phpAds_productname." milyen 
		id�k�z�nk�nt kapcsol�djon a term�kfriss�t�si kiszolg�l�hoz. Ha jelent meg �j verzi�,
		akkor megjelenik a friss�t�sr�l tov�bbi inform�ci�t tartalmaz� p�rbesz�dablak.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		Ha szeretn� a ".$phpAds_productname." �ltal k�ld�tt elektronikus �zenetek m�solatait
		megtartani, akkor enged�lyezze ezt a funkci�t. Az elk�ld�tt �zenetek a felhaszn�l�i napl�ban
		ker�lnek t�rol�sra. 
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Ha meg akar gy�z�dni arr�l, hogy a priorit�s kisz�m�t�sa megfelel� volt, akkor
		ment�st k�sz�thet az �r�nk�nti sz�mol�sr�l. Ez a jelent�s tartalmazza a megj�solt
		profilt, �s hogy mekkora priorit�s lett hozz�rendelve az �sszes rekl�mhoz. Ez
		az inform�ci� akkor lehet hasznos, ha �n hibabejelent�st k�v�n k�ldeni a
		priorit�s kisz�m�t�s�r�l. A jelent�sek t�rol�sa a felhaszn�l�i napl�ban t�rt�nik. 
		";
		
$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		Ha meg akar gy�z�dni arr�l, hogy az adatb�zis tiszt�t�sa megfelel� volt, akkor
		mentheti a jelent�st arr�l, hogy val�j�ban mi is t�rt�nt tiszt�t�s k�zben.
		Ennek az inform�ci�nak a t�rol�sa a felhaszn�l�i napl�ban t�rt�nik.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Ha magasabbra k�v�nja �ll�tani az alap�rtelmezett rekl�m fontoss�got, akkor itt
		adhatja meg az �hajtott fontoss�gi �rt�ket. Ez az �rt�k 1 alap�rtelmez�sk�nt.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Ha magasabbra k�v�nja �ll�tani az alap�rtelmezett kamp�ny fontoss�got, akkor itt
		adhatja meg az �hajtott fontoss�gi �rt�ket. Ez az �rt�k 1 alap�rtelmez�sk�nt.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor <i>Kamp�ny �ttekint�se</i> oldalon tov�bbi 
		inform�ci� jelenik meg az egyes kamp�nyokr�l. Ez a tov�bbi inform�ci� tartalmazza
		a h�tral�v� let�lt�sek �s a h�tral�v� kattint�sok sz�m�t, az aktiv�l�s d�tum�t,
		a lej�rat d�tum�t �s a be�ll�tott priorit�st. 
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a <i>Rekl�m �ttekint�se</i> oldalon tov�bbi
		inform�ci� jelenik meg az egyes rekl�mokr�l. A kieg�sz�t� inform�ci� tartalmazza a
		c�l hivatkoz�st, a kulcsszavakat, a m�retet �s a rekl�m fontoss�g�t.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a <i>Rekl�m �ttekint�se</i> oldalon l�that� lesz
		a rekl�mok k�pe. A tulajdons�g letilt�sa eset�n m�g mindig lehet�s�g van a rekl�mok 
		megtekint�s�re, ha a <i>Rekl�m �ttekint�se</i> oldalon a rekl�m melletti h�romsz�gre
		kattint.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a t�nyleges HTML-rekl�m fog megjelenni a HTML-k�d
		helyett. Ez a tulajdons�g alap�rtelmez�sk�nt letiltott, mert lehet, hogy a HTML-rekl�mok
		�tk�znek a felhaszn�l�i kezel�fel�lettel. Ha ez a tulajdons�g letiltott, m�g mindig lehets�ges
		az aktu�lis HTML-rekl�m megtekint�se, a HTML-k�d melletti <i>Rekl�m megjelen�t�se</i> 
		gombra kattint�ssal.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a <i>Rekl�m tulajdons�gai</i>,
		a <i>Tov�bb�t�s tulajdons�gai</i> �s a <i>Z�n�k kapcsol�sa</i> oldalak tetej�n megtekinthet�
		el�n�zetben. A rulajdons�g letilt�sa eset�n m�g mindig lehet�s�g van a rekl�m
		megtekint�s�re az oldalak tetej�n l�v� <i>Rekl�m megjelen�t�se</i> gombra
		kattint�ssal. 
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a <i>Hirdet�k �s kamp�nyok</i>, ill. a 
		<i>Kamp�ny �ttekint�se</i> oldalon elrejti az inakt�v rekl�mokat, kamp�nyokat �s 
		hirdet�ket. A tulajdons�g enged�lyez�se eset�n m�g mindig lehet�s�g van a rejtett
		elemek megjelen�t�s�re, ha a <i>Mind megjelen�t�se</i> gombra kattint az oldal 
		alj�n.
		";
		
$GLOBALS['phpAds_hlp_gui_show_matching'] = "
		Ha enged�lyezi a tulajdons�got, akkor a megfelel� rekl�m fog megjelenni a 
		<i>Kapcsolt rekl�mok</i> oldalon, a <i>Kamp�ny kiv�laszt�sa</i> m�dszer kiv�laszt�sa
		eset�n. Ez teszi lehet�v�, hogy �n megtekinthesse, pontosan mely rekl�mokat is vegye
		figyelembe tov�bb�t�s c�lj�b�l kapcsolt kamp�ny eset�n. Lehet�s�g van az egyez�
		rekl�mok megtekint�s�re is. 
		";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		Ha enged�lyezi ezt a tulajdons�got, akkor a rekl�mok sz�l� kamp�nyai l�that�k lesznek
		a <i>Kapcsolt rekl�mok</i> oldalon a <i>Rekl�m kiv�laszt�sa</i> m�d v�laszt�sa eset�n.
		�gy v�lik lehet�v� az �n sz�m�ra, hogy a rekl�m kapcsol�sa el�tt megtekinthesse, melyik 
		rekl�m melyik kamp�nyhoz is tartozik. Ez azt is jelenti, hogy a rekl�mok csoportos�t�sa
		a sz�l� kamp�nyok alapj�n t�rt�nik, �s tov�bb m�r nem bet�rendbe soroltak.
		";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
		Alap�rtelmez�sk�nt valamennyi l�tez� rekl�m vagy kamp�ny l�that� a <i>Kapcsolt rekl�mok</i>
		oldalon. Emiatt ez az oldal nagyon hossz� lehet, sokf�le rekl�m tal�lhat� a Nyilv�ntart�ban.
		Ez a tulajdons�g teszi lehet�v� oldalon megjelen� objektumok maxim�lis sz�m�t. Ha t�bb
		objektum van, �s a rekl�m kapcsol�sa k�l�nb�z�k�ppen t�rt�nik, akkor az jelenik meg,
		amelyik sokkal kevesebb helyet foglal el.
		";
		
?>