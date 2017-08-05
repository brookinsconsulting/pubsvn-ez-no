<?php // $Revision: 2.2.2.5 $

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
$GLOBALS['strInstall']				= 'Installer';
$GLOBALS['strChooseInstallLanguage']		= 'Choisissez la langue pour la proc�dure d\'installation';
$GLOBALS['strLanguageSelection']		= 'S�lection de la langue';
$GLOBALS['strDatabaseSettings']			= 'Param�tres de la base de donn�es';
$GLOBALS['strAdminSettings']			= 'Param�tres de l\'administrateur';
$GLOBALS['strAdvancedSettings']			= 'Param�tres avanc�s de la base de donn�es';
$GLOBALS['strOtherSettings']			= 'Autres param�tres';
$GLOBALS['strLicenseInformation']		= 'Informations de licence';
$GLOBALS['strAdministratorAccount']		= 'Compte administrateur';
$GLOBALS['strDatabasePage']			= 'Base de donn�es '.$phpAds_dbmsname;
$GLOBALS['strInstallWarning']			= 'Contr�le du serveur et de l\'int�grit�';
$GLOBALS['strCongratulations']			= 'F�licitations !';
$GLOBALS['strInstallFailed']			= 'L\'installation a �chou� !';
$GLOBALS['strSpecifyAdmin']			= 'Configurer le compte administrateur';
$GLOBALS['strSpecifyLocaton']			= 'Indiquer l\'emplacement de '.$phpAds_productname.' sur le serveur';

$GLOBALS['strWarning']				= 'Alerte';
$GLOBALS['strFatalError']			= 'Une erreur fatale est survenue';
$GLOBALS['strUpdateError']			= 'Une erreur est survenue en tentant de mettre � jour '. $phpAds_productname;
$GLOBALS['strUpdateDatabaseError']		= 'Une erreur non identifi�e �tant survenue, la structure de la base de donn�es n\'a pas pu �tre mise � jour. Il est recommand� de cliquer sur <b>Retenter la mise � jour</b>, afin d\'essayer de corriger ces probl�mes potentiels; n�anmoins, si vous �tes sur que ces erreurs ne vont pas affecter la bonne marche de '.$phpAds_productname.', vous pouvez cliquer sur <b>Ignorer les erreurs</b> et continuer. Ignorer ces erreurs peut entrainer de graves probl�mes !';
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname.' est d�j� install� sur ce syst�me. Si vous souhaitez le configurer :<a href=\'settings-index.php\'>Param�tres de '.$phpAds_productname.'</a>.';
$GLOBALS['strCouldNotConnectToDB']		= $phpAds_productname.' ne peut se connecter � la base de donn�e. Veuillez v�rifier les param�tres que vous avez entr�s. Assurez vous aussi que la base existes. '.$phpAds_productname.' ne cr�era pas la base pour vous, et donc vous devez la cr�er avant de commencer l\'installation.';
$GLOBALS['strCreateTableTestFailed']		= 'L\'utilisateur que vous avez sp�cifi� n\'a pas la permission de cr�er ou de mettre � jour la structure de la base de donn�es. Veuillez contacter l\'administrateur de la base.';
$GLOBALS['strUpdateTableTestFailed']		= 'L\'utilisateur que vous avez sp�cifi� n\'a pas la permission de mettre � jour la structure de la base de donn�es. Veuillez contacter l\'administrateur de la base.';
$GLOBALS['strTablePrefixInvalid']		= 'Le pr�fixe des tables contient des caract�res invalides';
$GLOBALS['strTableInUse']			= 'La base de donn�es que vous avez sp�cifi�e est d�j� utilis�e pour '.$phpAds_productname.'. Veuillez utiliser un pr�fixe de table diff�rent, ou lire le manuel pour les instructions de mise � jour.';
$GLOBALS['strTableWrongType']			= 'Le type de table que vous avez s�lectionn� n\'est pas support� par votre installation de '.$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= 'Avant de continuer, vous devriez corriger ce probl�me potentiel :';
$GLOBALS['strFixProblemsBefore']		= 'Le(s) chose(s) suivante(s) doivent �tre corrig�e(s) avant que vous ne puissiez installer '.$phpAds_productname.'. Si vous avez des questions � propos de ce message d\'erreur, lisez le <i>Guide de l\'administrateur</i> (Administrator guide, en anglais), qui est fourni avec l\'archive que vous avez t�l�charg�e.';
$GLOBALS['strFixProblemsAfter']			= 'Si vous ne pouvez pas corriger les probl�mes ci-dessus, veuillez contacter l\'adminitrateur du serveur sur lequel vous tentez d\'installer '.$phpAds_productname.'. Il devrait �tre capable de vous aider.';
$GLOBALS['strIgnoreWarnings']			= 'Ignorer les avertissement';
$GLOBALS['strWarningDBavailable']               = 'La version de PHP que vous utilisez n\'a pas le support n�cessaire pour se connecter � une base de donn�es '.$phpAds_dbmsname.'. Vous devez activer l\'extension '.$phpAds_dbmsname.' de PHP avant de pouvoir continuer.';
$GLOBALS['strWarningPHPversion']		= $phpAds_productname.' requiert PHP 4.0.3 (ou plus) pour fonctionner correctement. Vous utilisez actuellement {php_version}.';
$GLOBALS['strWarningPHP5beta']			= 'Vous tentez d\'installez '.$phpAds_productname.' sur un serveur avec une des premi�re version de test de PHP 5. Ces versions ne sont pas pr�vues pour un environnement de production, et contiennent habituellement des bugs. Il n\'est pas recommand� de faire fonctionner '.$phpAds_productname.' sur PHP5, si ce n\'est � des fins de test.';
$GLOBALS['strWarningRegisterGlobals']		= 'La variable de configuration globale PHP <i>register_globals</i> doit �tre activ�e.';
$GLOBALS['strWarningMagicQuotesGPC']		= 'La variable de configuration globale PHP <i>magic_quotes_gpc</i> doit �tre activ�e.';
$GLOBALS['strWarningMagicQuotesRuntime']  	= 'La variable de configuration globale PHP <i>magic_quotes_runtime</i> doit �tre d�sactiv�e.';
$GLOBALS['strWarningMagicQuotesSybase']		= 'La variable de configuration globale PHP <i>magic_quotes_sybase</i> doit �tre d�sactiv�e.';
$GLOBALS['strWarningFileUploads']		= 'La variable de configuration globale PHP <i>file_uploads</i> doit �tre activ�e.';
$GLOBALS['strWarningTrackVars']			= 'La variable de configuration globale PHP <i>track_vars</i> doit �tre activ�e.';
$GLOBALS['strWarningPREG']			= 'La version de PHP que vous utilisez ne dispose pas des PCRE (Expression rationnelles compatibles Perl). Vous devez activer l\'extension PCRE avant de pouvoir continuer.';
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname.' ne peut pas �crire sur le fichier <b>config.inc.php</b>.<br> Vous devez accorder avoir les privil�ges d\'�criture sur ce fichier. <br>Veuillez lire la documentation fournie pour plus d\'informations.';
$GLOBALS['strCacheLockedDetected']		= 'Vous utilisez le cache de distribution par fichier, et '.$phpAds_productname.' a detect� que le r�pertoire de <b>cache</b> n\'est pas �crivable par le serveur. Vous ne pouvez pas continuer tant que vous n\'aurez pas chang� les permissions du r�pertoire. Lisez la documentation fournie pour plus d\'informations.';
$GLOBALS['strCantUpdateDB']  			= 'Il n\'est pas possible de mettre � jour la base de donn�es. Si vous d�cidez de continuer, toutes les banni�res existantes, les statistiques, et les annonceurs seront perdus.';
$GLOBALS['strIgnoreErrors']			= 'Ignorer les erreurs';
$GLOBALS['strRetryUpdate']			= 'Retenter la mise � jour';
$GLOBALS['strTableNames']			= 'Nom de la base';
$GLOBALS['strTablesPrefix']			= 'Pr�fixe des noms des tables';
$GLOBALS['strTablesType']			= 'Type de table';

$GLOBALS['strRevCorrupt']			= 'Le fichier <b>{filename}</b> est corrompu ou a �t� modifi�. Si vous n\'avez pas modifi� le fichier, merci d\'en uploader une copie neuve. Si vous avez modifi� le fichier, merci d\'ignorer cet avertissement.';
$GLOBALS['strRevTooOld']			= 'Le fichier <b>{filename}</b> est plus vieux que ce qu\'il devrait pour �tre utilis� par cette version de '.$phpAds_productname.'. Veuillez uploader une copie neuve du fichier sur le serveur.';
$GLOBALS['strRevMissing']			= 'Le fichier <b>{filename}</b> n\'a pas pu �tre v�rifi�, car il �tait absent. Veuillez en uploader une copie neuve sur le serveur.';
$GLOBALS['strRevCVS']				= 'Vous essayer d\'installer un ckeckout du CVS de '.$phpAds_productname.'. Ceci n\'est pas une version officielle, et pourrait �tre instable, voir m�me non-fonctionnel. Etes vous sur de vouloir continuer ?';

$GLOBALS['strInstallWelcome']			= 'Bienvenue sur '.$phpAds_productname;
$GLOBALS['strInstallMessage']			= 'Avant de pouvoir utiliser '.$phpAds_productname.', il est n�cessaire de le configurer, et la base de donn�es doit �tre cr�e. Cliquez sur <b>Continuer</b> pour poursuivre.';
$GLOBALS['strInstallMessageCheck']		= $phpAds_productname.' a v�rifi� l\'int�grit� des fichiers que vous avez upload�s sur le serveur, et a v�rifi� que le serveur �tait capable de faire marcher '.$phpAds_productname.'. Les �l�ments suivant doivent �tre pris en compte avant de pouvoir continuer.';
$GLOBALS['strInstallMessageAdmin']		= 'Avant de continuer, vous devez r�gler le compte administrateur. Vous pourrez ensuite utiliser ce compte pour vous connecter � l\'interfa�e d\'administration, configurer la distribution, et voir les statistiques.';
$GLOBALS['strInstallMessageDatabase']		= $phpAds_productname.' utilise une base de donn�es '.$phpAds_dbmsname.' pour stocker vos publicit�s ainsi que les statistiques. Avant de continuer, vous devez indiquer quel serveur vous souhaitez utiliser, ainsi que le nom d\'utilisateur et le mot de passe que ".$phpAds_productname." utilisera pour se connecter � la base de donn�es.  Si vous ne savez pas quoi r�pondre, vous devriez contacter l\'administrateur de votre serveur.';
$GLOBALS['strInstallSuccess']			= '<b>L\'installation de '.$phpAds_productname.' est maintenant termin�e.</b><br><br>Afin que '.$phpAds_productname.' fonctionne '
						 .'correctement, vous devez aussi faire en sorte que le fichier de maintenance soit ex�cut� chaque heure. Vous trouverez plus '
						 .' d\'informations sur ce sujet dans la documentation.<br><br>Cliquez sur <b>Continuer</b> pour acc�der � l\'interfa�e de '
						 .'configuration, d\'o� vous pourrez finir de param�trer '.$phpAds_productname.'. Veuillez � ne pas oublier de prot�ger contre '
						 .'l\'�criture le fichier <i>config.inc.php</i> lorsque vous aurez fini, afin de s�curiser '.$phpAds_productname.'.';

$GLOBALS['strUpdateSuccess']			= '<b>La mise � niveau de '.$phpAds_productname.' a r�ussie.</b><br><br>Afin que '.$phpAds_productname.' fonctionne correctement, '
						 .'vous devez aussi faire en sorte que le fichier de maintenance soit ex�cut� chaque heure (pr�c�demment c\'�tait chaque jour). '
						 .'Vous trouverez plus d\'informations sur ce sujet dans la documentation.<br><br>Cliquez sur <b>Continuer</b> pour acc�der '
						 .'� l\'interfa�e de configuration, d\'o� vous pourrez finir de param�trer '.$phpAds_productname.'. Veuillez � ne pas oublier '
						 .'de prot�ger en �criture le fichier <i>config.inc.php</i> lorsque vous aurez fini, afin de s�curiser '.$phpAds_productname.'.';
$GLOBALS['strInstallNotSuccessful']		= '<b>L\'installation de '.$phpAds_productname.' a �chou�e</b><br><br>Certaines partie du processus d\'installation n\'ont pas pu '
						 .'�tre r�alis�es. Il est possible que ces probl�mes ne soient que temporaires; dans ce cas vous pouvez simplement cliquer '
						 .'sur <b>Continuer</b> et retourner � la premi�re �tape du processus d\'installation. Si vous voulez en savoir plus sur la '
						 .'signification du message d\'erreur ci-dessous, et savoir comment r�soudre le probl�me, veuillez consulter la documentation fournie.';
$GLOBALS['strErrorOccured']			= 'L\'erreur suivante est survenue :';
$GLOBALS['strErrorInstallDatabase']		= 'La structure de la base de donn�es n\'a pas pu �tre cr�e.';
$GLOBALS['strErrorInstallConfig']		= 'Le fichier de configuration, ou la base de donn�es n\'a pas pu �tre mis � jour.';
$GLOBALS['strErrorInstallDbConnect']		= $phpAds_productname.' n\'a pas r�ussi � se connecter � la base de donn�es '.$phpAds_dbmsname.'.';

$GLOBALS['strUrlPrefix']			= 'Pr�fixe d\'Url';

$GLOBALS['strProceed']				= 'Continuer &gt;';
$GLOBALS['strInvalidUserPwd']			= 'Nom d\'utilisateur, ou mot de passe invalide';

$GLOBALS['strUpgrade']				= 'Mise � niveau';
$GLOBALS['strSystemUpToDate']			= 'Votre syst�me est d�j� � jour, et aucune mise � niveau n\'est n�cessaire pour le moment. <br>Cliquez sur <b>Continuer</b> pour acc�der � la page d\'accueil.';
$GLOBALS['strSystemNeedsUpgrade']               = 'La structure de la base de donn�es et le fichier de configuration doivent �tre mis � jour pour fonctionner correctement. Cliquez sur <b>Continuer</b> pour commencer le processus de mise � jour. <br><br>Suivant la version � laquelle vous �tes, et la quantit� de statistiques pr�sentes dans la base, cette op�ration peut provoquer une grande charge sur le serveur SQL. Merci d\'�tre patient. Cette mise � jour peut prendre jusqu\'� plusieurs minutes.';
$GLOBALS['strSystemUpgradeBusy']		= 'Mise � jour du syst�me en cours, merci de patienter...';
$GLOBALS['strSystemRebuildingCache']		= 'Reconstruction du cache, merci de patienter...';
$GLOBALS['strServiceUnavalable']		= 'Le service est temporairement indisponible. Mise � jour du syst�me en cours.';

$GLOBALS['strConfigNotWritable']		= $phpAds_productname.' ne peut �crire dans le fichier config.inc.php';
$GLOBALS['strPhpBug20144']			= 'Votre version de PHP est affect� par un <a href="http://bugs.php.net/bug.php?id=20114" target="_blank">bogue</a> qui ne permet pas � '.$phpAds_productname.' de fonctionner correctement.
							La mise � jour vers PHP 4.3.0 (ou plus) doit �tre r�alis�e avant de pouvoir installer '.$phpAds_productname.'.';
$GLOBALS['strPhpBug24652']			= 'Vous tentez d\'installez '.$phpAds_productname.' sur un serveur avec une des premi�re version de test de PHP 5.
	Ces versions ne sont pas pr�vues pour un environnement de production, et contiennent habituellement des bugs.
	Un de ces bugs empeche '.$phpAds_productname.' de fonctionner correctement.
	Ce <a href="http://bugs.php.net/bug.php?id=24652" target="_blank">bug</a> est d�j� r�solu
	et la version finale de PHP5 n\'est pas affect�e.';



/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= 'Param�tres ';
$GLOBALS['strDayFullNames'] 			= array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
$GLOBALS['strEditConfigNotPossible']		= 'Il n\'est pas possible d\'�diter ces param�tres, le fichier de configuration �tant en lecture seule pour des raisons de s�curit�. '.
						  'Si vous souhaitez faire des changements, vous devez d\'abord changer les droits du fichier config.inc.php.';
$GLOBALS['strEditConfigPossible']		= 'Il est possible d\'�diter tous les param�tres, car le fichier de configuration n\'est pas prot�g�, mais cela abaisse le niveau de s�curit� de l\'installation. '.
						  'Pour s�curiser le syst�me, vous devez changer les droits du fichier config.inc.php d�s que vous aurez fini les r�glages.';



// Database
//$GLOBALS['strDatabaseSettings']			= 'Base de donn�es '.$phpAds_dbmsname;
$GLOBALS['strDatabaseServer']			= 'Serveur base de donn�es';
$GLOBALS['strDbLocal']				= 'Se connecter au serveur local en utilisant les sockets'; // Pg only
$GLOBALS['strDbHost']				= 'Adresse du serveur SQL';
$GLOBALS['strDbPort']				= 'Port du serveur SQL';
$GLOBALS['strDbUser']				= 'Nom d\'utilisateur';
$GLOBALS['strDbPassword']			= 'Mot de passe';
$GLOBALS['strDbName']				= 'Nom de la base';

$GLOBALS['strDatabaseOptimalisations']		= 'Options de la base de donn�es';
$GLOBALS['strPersistentConnections']		= 'Utiliser des connexions persistantes';
$GLOBALS['strInsertDelayed']			= 'Utiliser des \'INSERT\' retard�s';
$GLOBALS['strCompatibilityMode']		= 'Utiliser le mode de compatibilit� base de donn�es';
$GLOBALS['strCantConnectToDb']			= 'Impossible de se connecter � la base de donn�es';



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= 'Invocation et de distribution';

$GLOBALS['strAllowedInvocationTypes']		= 'Types d\'invocation autoris�s';
$GLOBALS['strAllowRemoteInvocation']		= 'Autoriser l\'invocation distante';
$GLOBALS['strAllowRemoteJavascript']		= 'Autoriser l\'invocation distante avec Javascript';
$GLOBALS['strAllowRemoteFrames']		= 'Autoriser l\'invocation distante avec Frames';
$GLOBALS['strAllowRemoteXMLRPC']		= 'Autoriser l\'invocation distante avec XML-RPC';
$GLOBALS['strAllowLocalmode']			= 'Autoriser le mode local';
$GLOBALS['strAllowInterstitial']		= 'Autoriser les interstitiels';
$GLOBALS['strAllowPopups']			= 'Autoriser les popups';

$GLOBALS['strUseAcl']				= 'Evaluer les limitations lors de la distribution';

$GLOBALS['strDeliverySettings']                 = 'Param�tres de distribution';
$GLOBALS['strCacheType']			= 'Type de cache de distribution';
$GLOBALS['strCacheFiles']			= 'Fichiers';
$GLOBALS['strCacheDatabase']                    = 'Base de donn�es (SQL)';
$GLOBALS['strCacheShmop']			= 'M�moire partag�e (shmop)';
$GLOBALS['strCacheSysvshm']			= 'M�moire partag�e (sysvshm)';
$GLOBALS['strExperimental']			= 'Experimental';
$GLOBALS['strKeywordRetrieval']			= 'Autoriser la s�lection des banni�res par mots cl�s';
$GLOBALS['strBannerRetrieval']			= 'M�thode de s�lection des banni�res';
$GLOBALS['strRetrieveRandom']			= 'S�lection al�atoire (par d�faut)';
$GLOBALS['strRetrieveNormalSeq']		= 'S�lection s�quentielle';
$GLOBALS['strWeightSeq']			= 'S�lection s�quentielle bas�e sur le poids des banni�res';
$GLOBALS['strFullSeq']				= 'S�lection s�quentielle totale';
$GLOBALS['strUseConditionalKeys']		= 'Autoriser l\'utilisation d\'op�rateurs logiques lors de la s�lection directe';
$GLOBALS['strUseMultipleKeys']			= 'Autoriser les mots cl�s multiples lors de la s�lection directe';

$GLOBALS['strZonesSettings']			= 'R�cup�ration des zones';
$GLOBALS['strZoneCache']			= 'Cacher les zones; cela peut acc�l�rer '.$phpAds_productname.' lorsque l\'on utilise les zones';
$GLOBALS['strZoneCacheLimit']			= 'D�lai entre les mises � jour du cache (en secondes)';
$GLOBALS['strZoneCacheLimitErr']		= 'Erreur: le d�lai entre les mises � jour du cache doit �tre un entier positif.';

$GLOBALS['strP3PSettings']			= 'Politique de respect de la vie priv�e P3P';
$GLOBALS['strUseP3P']				= 'Utiliser la politique P3P';
$GLOBALS['strP3PCompactPolicy']			= 'Politique compacte P3P';
$GLOBALS['strP3PPolicyLocation']		= 'Emplacement de la politique P3P';



// Banner Settings
$GLOBALS['strBannerSettings']			= 'Banni�res';

$GLOBALS['strAllowedBannerTypes']		= 'Types de banni�res autoris�s';
$GLOBALS['strTypeSqlAllow']			= 'Autoriser les banni�res Images - serveur SQL';
$GLOBALS['strTypeWebAllow']			= 'Autoriser les banni�res Images - serveur Web';
$GLOBALS['strTypeUrlAllow']			= 'Autoriser les banni�res Images - externe';
$GLOBALS['strTypeHtmlAllow']			= 'Autoriser les banni�res HTML';
$GLOBALS['strTypeTxtAllow']			= 'Autoriser les publicit�s textuelles';

$GLOBALS['strTypeWebSettings']			= 'Configuration des banni�res locales (Serveur Web)';
$GLOBALS['strTypeWebMode']			= 'M�thode de stockage';
$GLOBALS['strTypeWebModeLocal']			= 'R�pertoire local';
$GLOBALS['strTypeWebModeFtp']			= 'Serveur FTP externe';
$GLOBALS['strTypeWebDir']			= 'R�pertoire local';
$GLOBALS['strTypeWebFtp']			= 'Server Web de banni�re en mode FTP';
$GLOBALS['strTypeWebUrl']			= 'Url publique';
$GLOBALS['strTypeFTPHost']			= 'Adresse du serveur FTP';
$GLOBALS['strTypeFTPDirectory']			= 'R�pertoire sur le serveur';
$GLOBALS['strTypeFTPUsername']			= 'Nom d\'utilisateur';
$GLOBALS['strTypeFTPPassword']			= 'Mot de passe';
$GLOBALS['strTypeFTPErrorDir']			= 'Le r�pertoire sur le serveur FTP distant n\'existe pas.';
$GLOBALS['strTypeFTPErrorConnect']		= 'Impossible de se connecter au serveur FTP distant, le nom d\'utilisateur ou le mot de passe sont incorrects.';
$GLOBALS['strTypeFTPErrorHost']			= 'Le nom de machine du serveur FTP distant est erron�.';
$GLOBALS['strTypeDirError']			= 'Le r�pertoire local sp�cifi� n\'existe pas.';

$GLOBALS['strDefaultBanners']			= 'Banni�re par d�faut';
$GLOBALS['strDefaultBannerUrl']			= 'Emlacement de l\'image par d�faut';
$GLOBALS['strDefaultBannerTarget']		= 'Url de destination par d�faut';

$GLOBALS['strTypeHtmlSettings']			= 'Options des banni�res HTML';
$GLOBALS['strTypeHtmlAuto']			= 'Adapter automatiquement les banni�res HTML, afin de pourvoir compter les clics.';
$GLOBALS['strTypeHtmlPhp']			= 'Autoriser l\'ex�cution d\'expressions PHP dans les banni�res HTML.';


// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= 'H�tes, et g�olocalisation';

$GLOBALS['strRemoteHost']			= 'H�te';
$GLOBALS['strReverseLookup']			= 'D�terminer le nom d\'h�te si celui-ci n\'est pas donn� par le serveur';
$GLOBALS['strProxyLookup']			= 'D�terminer l\'adresse IP r�elle du visiteur si il utilise un serveur proxy';

$GLOBALS['strGeotargeting']			= 'G�olocalisation';
$GLOBALS['strGeotrackingType']			= 'Type de base de donn�es de g�olocalisation';
$GLOBALS['strGeotrackingLocation']		= 'Emplacement de la base de donn�es de g�olocalisation';
$GLOBALS['strGeotrackingLocationError']		= 'La base de g�olocalisation n\'a pas �t� trouv�e � l\'emplacement sp�cifi�';
$GLOBALS['strGeotrackingLocationNoHTTP']	= 'L\'emplacement que vous avez fourni n\'est pas un r�pertoire local du disque dur, mais une URL d\'un fichier sur un serveur Web. L\'emplacement devrait ressembler � �a: <i>{example}</i>. L\'emplacement actuel d�pend de l\'endroit o� est copi� la base de donn�es.';
$GLOBALS['strGeoStoreCookie']			= 'Stocker le r�sultat de la localisation g�ographique dans un cookie, et s\'y r�fenrencer pas la suite.';


// Statistics Settings
$GLOBALS['strStatisticsSettings']		= 'Statistiques';

$GLOBALS['strStatisticsFormat']			= 'Format des statistiques';
$GLOBALS['strCompactStats']			= 'Type de statistiques';
$GLOBALS['strLogAdviews']			= 'Journaliser les affichages ';
$GLOBALS['strLogAdclicks']			= 'Journaliser les clics';
$GLOBALS['strLogSource']			= 'Journaliser le param�tre \'source\' sp�cifi� lors de l\'invocation';
$GLOBALS['strGeoLogStats']			= 'Journaliser le pays d\'origine du visiteur';
$GLOBALS['strLogHostnameOrIP']			= 'Journaliser le nom de machine, ou l\'adresse IP du visiteur';
$GLOBALS['strLogIPOnly']			= 'Journaliser uniquement l\'adresse IP du visteur, m�me si le nom de sa machine est connu';
$GLOBALS['strLogIP']				= 'Journaliser l\'adresse IP du visiteur';
$GLOBALS['strLogBeacon']			= 'Utiliser des balises invisibles pour compter les affichages (plus pr�cis, recommand�)';

$GLOBALS['strRemoteHosts']			= 'H�tes';
$GLOBALS['strIgnoreHosts']			= '<br>Ne pas journaliser les demandes des adresses IP ou des noms d\'h�tes suivants :';
$GLOBALS['strBlockAdviews']			= 'Ne pas compter deux affichages d\'un m�me client en moins de :<br>(secondes)';
$GLOBALS['strBlockAdclicks']			= 'Ne pas compter deux clics d\'un m�me client en moins de :<br>(secondes)';

$GLOBALS['strPreventLogging']                   = 'Emp�cher la journalisation';
$GLOBALS['strEmailWarnings']			= 'Avertissements par Email';
$GLOBALS['strAdminEmailHeaders']		= '<br><br>Ajouter les ent�tes suivante aux mails envoy�s par '.$phpAds_productname . ' :';
$GLOBALS['strWarnLimit']			= 'Envoyer un avertissement lorsque le cr�dit d\'affichages passe sous :';
$GLOBALS['strWarnLimitErr']			= 'La limite d\'avertissement doit �tre un entier positif.';
$GLOBALS['strWarnAdmin']			= 'Envoyer un avertissement � l\'administrateur lorsque qu\'une campagne va expirer';
$GLOBALS['strWarnClient']			= 'Envoyer un avertissement � l\'annonceur lorsque qu\'une campagne va expirer';
$GLOBALS['strQmailPatch']			= 'Utiliser le patch pour qmail';

$GLOBALS['strAutoCleanTables']			= 'Purger automatiquement la base de donn�es';
$GLOBALS['strAutoCleanStats']			= 'Purger automatiquement les donn�es statistiques';
$GLOBALS['strAutoCleanUserlog']			= 'Purger le journal utilisateur';
$GLOBALS['strAutoCleanStatsWeeks']		= 'Age maximal des statistiques <br>(en semaines, au minimum 3)';
$GLOBALS['strAutoCleanUserlogWeeks']		= 'Age maximal des journaux utilisateurs <br>(en semaines, au minimum 3)';
$GLOBALS['strAutoCleanErr']			= 'L\'�ge maximal doit �tre d\'au moins de 3 semaines';
$GLOBALS['strAutoCleanVacuum']			= 'VACUUM ANALYZE (optimisation - nettoyage) des tables chaque nuit'; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= 'Administrateur';

$GLOBALS['strLoginCredentials']			= 'Accr�ditations de connexion';
$GLOBALS['strAdminUsername']			= 'Nom d\'utilisateur de l\'administrateur';
$GLOBALS['strInvalidUsername']			= 'Nom d\'utilisateur invalide';

$GLOBALS['strBasicInformation']			= 'Informations de base';
$GLOBALS['strAdminFullName']			= 'Nom complet';
$GLOBALS['strAdminEmail']			= 'Adresse email';
$GLOBALS['strCompanyName']			= 'Nom de l\'organisation';

$GLOBALS['strAdminCheckUpdates']		= 'Surveiller les mises � jour';
$GLOBALS['strAdminCheckEveryLogin']		= 'A chaque connexion';
$GLOBALS['strAdminCheckDaily']			= 'Chaque jour';
$GLOBALS['strAdminCheckWeekly']			= 'Chaque semaine';
$GLOBALS['strAdminCheckMonthly']		= 'Chaque mois';
$GLOBALS['strAdminCheckNever']			= 'Jamais';

$GLOBALS['strAdminNovice']			= 'L\'administrateur doit quand m�me confirmer les actions de suppression (s�curit�)';
$GLOBALS['strUserlogEmail']			= 'Journaliser tous les messages mail sortants';
$GLOBALS['strUserlogPriority']			= 'Journaliser chaque heure les calculs de priorit�';
$GLOBALS['strUserlogAutoClean']			= 'Journaliser les nettoyages automatiques de la base de donn�es';


// User interface settings
$GLOBALS['strGuiSettings']			= 'Interface utilisateur';

$GLOBALS['strGeneralSettings']			= 'Param�tres g�n�raux';
$GLOBALS['strAppName']				= 'Nom de l\'application';
$GLOBALS['strMyHeader']				= 'Emplacement de l\'ent�te';
$GLOBALS['strMyHeaderError']			= 'Le fichier d\'ent�te n\'a pas �t� trouv� � l\'emplacement que vous avez sp�cifi�';
$GLOBALS['strMyFooter']				= 'Emplacement du pied de page';
$GLOBALS['strMyFooterError']			= 'Le fichier de pied de page n\'a pas �t� trouv� � l\'emplacement que vous avez sp�cifi�';
$GLOBALS['strGzipContentCompression']		= 'Transmettre les pages en GZIP';

$GLOBALS['strClientInterface']			= 'Interface de l\'annonceur';
$GLOBALS['strClientWelcomeEnabled']		= 'Afficher un message d\'accueil';
$GLOBALS['strClientWelcomeText']		= '<br>Message de bienvenue<br>(HTML autoris�)';



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= 'Valeurs par d�faut de l\'interface';

$GLOBALS['strInventory']			= 'Administration';
$GLOBALS['strShowCampaignInfo']			= 'Sur la page <i>Aper�u de la campagne</i>, afficher les informations suppl�mentaires concernant la campagne.';
$GLOBALS['strShowBannerInfo']			= 'Sur la page <i>Aper�u de la banni�re</i>, afficher les informations suppl�mentaires concernant la banni�re.';
$GLOBALS['strShowCampaignPreview']		= 'Montrer un aper�u de toutes les banni�res sur la page <i>Aper�u des banni�res</i>.';
$GLOBALS['strShowBannerHTML']			= 'Pour l\'aper�u des banni�res HTML, pr�f�rer l\'affichage de la banni�re � celui du code HTML brut.';
$GLOBALS['strShowBannerPreview']		= 'Afficher un aper�u de la banni�re au sommet des pages qui la concernent.';
$GLOBALS['strHideInactive']			= 'Cacher les �l�ments inactifs dans toutes les pages d\'aper�us.';
$GLOBALS['strGUIShowMatchingBanners']		= 'Sur les pages <i>Banni�res li�es</i>, afficher les banni�res correspondantes.';
$GLOBALS['strGUIShowParentCampaigns']		= 'Sur les pages <i>Banni�res li�es</i>, afficher les campagnes parentes.';
$GLOBALS['strGUILinkCompactLimit']		= 'Ne pas afficher les banni�res et campagnes non li�es quand il y en a plus de';

$GLOBALS['strStatisticsDefaults'] 		= 'Statistiques';
$GLOBALS['strBeginOfWeek']			= 'Premier jour de la semaine';
$GLOBALS['strPercentageDecimals']		= 'Nombre de d�cimales des pourcentages';

$GLOBALS['strWeightDefaults']			= 'Poids par d�faut';
$GLOBALS['strDefaultBannerWeight']		= 'Poids par d�faut des banni�res';
$GLOBALS['strDefaultCampaignWeight']		= 'Poids par d�faut des campagnes';
$GLOBALS['strDefaultBannerWErr']		= 'Le poids par d�faut des banni�res DOIT �tre un entier positif';
$GLOBALS['strDefaultCampaignWErr']		= 'Le poids par d�faut des campagnes DOIT �tre un entier positif';



// Not used at the moment
$GLOBALS['strTableBorderColor']			= 'Couleur de la bordure de la table';
$GLOBALS['strTableBackColor']			= 'Couleur d\'arri�re-plan de la table';
$GLOBALS['strTableBackColorAlt']		= 'Couleur d\'arri�re-plan de la table (Alternatif)';
$GLOBALS['strMainBackColor']			= 'Couleur principale d\'arri�re-plan';
$GLOBALS['strOverrideGD']			= 'Outrepasser le format d\'Image GD';
$GLOBALS['strTimeZone']				= 'Fuseau horaire';

?>