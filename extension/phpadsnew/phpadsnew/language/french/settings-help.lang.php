<?php // $Revision: 2.0.2.3 $

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
$GLOBALS['phpAds_hlp_dbhost'] = '
	Sp�cifiez ici l\'adresse de votre serveur de donn�es '.$phpAds_dbmsname.' auquel '.$phpAds_productname.' doit se connecter (Ex: sql.monsite.fr).
';

$GLOBALS['phpAds_hlp_dbport'] = '
        Sp�cifiez le num�ro du port de la base de donn�es '.$phpAds_dbmsname.' � laquelle '.$phpAds_productname.' doit se connecter. Le port par d�faut
        pour une base de donn�es ".$phpAds_dbmsname." est <i>'.
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432').'</i>.
';

$GLOBALS['phpAds_hlp_dbuser'] = '
	Sp�cifiez le nom d\'utilisateur avec lequel '.$phpAds_productname.' peut se connecter � la base '.$phpAds_dbmsname.'.
';
		
$GLOBALS['phpAds_hlp_dbpassword'] = '
	Sp�cifiez le mot de passe avec lequel '.$phpAds_productname.' peut se connecter � la base '.$phpAds_dbmsname.'.
';

$GLOBALS['phpAds_hlp_dbname'] = '
	Sp�cifiez le nom de la base de donn�es dans laquelle '.$phpAds_productname.' doit stocker ses donn�es.
	Attention: la base doit d�j� exister sur le serveur de donn�es. '.$phpAds_productname.' ne cr�eras <b>pas</b> la base si elle n\'existe pas.
';

$GLOBALS['phpAds_hlp_persistent_connections'] = '
	L\'utilisation de connections persistantes peut acc�l�rer consid�rablement '.$phpAds_productname.', et peut m�me diminuer la charge du serveur.
	N�anmoins, en cas de fortes charges du serveur Web, la charge du serveur SQL sera plus importe avec cette option. Le choix de cette option d�pend du nombre de
	visiteurs, et du mat�riel que vous utilisez. Si '.$phpAds_productname.' utilise trop de ressources, vous devriez regarder d\'abord cette option. Par d�faut
	cette option est d�sactiv�e, car elle peut-�tre incompatible avec certains syst�mes.
';

$GLOBALS['phpAds_hlp_insert_delayed'] = '
	'.$phpAds_dbmsname.' bloque la table lorsque l\'on ins�re des donn�es. Si vous avez beaucoup de visiteurs, il est possible
	que '.$phpAds_productname.' soit oblig� d\'attendre avant d\'ins�rer une nouvelle ligne, la table �tant d�j�
	bloqu�e. Quand vous utilisez les insertions retard�es, vous n\'avez pas � attendre, et la ligne sera ins�r�e
	plus tard, lorsque la table ne sera plus utilis�e.
';

$GLOBALS['phpAds_hlp_compatibility_mode'] = '
	Si vous avez des probl�mes d\'int�gration de '.$phpAds_productname.' avec d\'autres produits, cela peut aider d\'activer
	le mode de compatibilit� de la base de donn�es. Si vous utilisez le mode d\'invocation local, et que cette
	option est activ�e, '.$phpAds_productname.' laisserat la connexion avec la base de donn�es exactement comme
	il l\'avait trouv�. Cette option ralentit un peu '.$phpAds_productname.' (seulement un peu), c\'est pourquoi elle est d�sactiv�e
	par d�faut.
';

$GLOBALS['phpAds_hlp_table_prefix'] = '
	Si la base de donn�es que '.$phpAds_productname.' utilise est partag�e par plusieurs produits, il est int�ressant d\'ajouter
	un pr�fixe aux noms des tables de '.$phpAds_productname.'. Si vous utilisez plusieurs '.$phpAds_productname.' avec la m�me base
	de donn�es, vous devez choisir un pr�fixe diff�rent pour chacune des installation.
';

$GLOBALS['phpAds_hlp_table_type'] = '
	'.$phpAds_dbmsname.' supporte plusieurs types de table. Chacun de ces types a des propri�t�s particuli�res, et certains
	peuvent acc�l�rer '.$phpAds_productname.' consid�rablement. MyISAM est le type par d�faut, et est pr�sent dans
	toutes les installations '.$phpAds_dbmsname.'. Certains autres types de tables peuvent ne pas �tre pr�sents sur votre serveur SQL.
';

$GLOBALS['phpAds_hlp_url_prefix'] = '
	'.$phpAds_productname.' a besoin de connaitre l\'adresse o� il r�side. Vous devez donc pr�ciser l\'url publique � laquelle se trouve '.$phpAds_productname.'.
	Par exemple : <i>http://www.monsite.fr/'.$phpAds_productname.'</i>
';

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = '
	Cette option vous permet de sp�cifier des fichiers d\'ent�te et de pied de page, qui seront affich� en haut et en bas de chaque page.
	Il doit s\'agir d\'une adresse relative (exemple : ../site/header.html), ou absolue (exemple : /home/login/www/header.html). Ces deux fichiers peuvent contenir
	de l\'HTML, mais notez bien qu\'il seront inclus apr�s la balise &lt;body&gt; pour l\'ent�te, et avant la balise &lt;/body&gt; pour le pied de page.
	Ils ne doivent donc en aucun cas contenir des balises telles que &lt;body&gt;, &lt;html&gt; ou &lt;head&gt;.
';

$GLOBALS['phpAds_hlp_content_gzip_compression'] = '
	L\'option GZip permet au serveur Web, et � la machine des clients de compresser les donn�es qu\'ils s\'�changent. Cette option augment� l�gerement le temps
	d\'�x�cution des pages, mais diminue notablement le temps de chargement des pages, ainsi que la quantit� de donn�es envoy�es par le serveur.
	Pour activer cette option, vous devez avoir PHP 4.0.5 (ou plus), avec l\'option GZip install�e.<br>
	Cette option peut vous int�resser si votre h�bergeur vous facture la quantit� dedonn�es envoy�es.
';
		
$GLOBALS['phpAds_hlp_language'] = '
	La langue choisie ici sera celle par d�faut pour l\'interfa�e d\'administration. Notez que vous pouvez sp�cifi� une langue diff�rente pour chaque utilisateur.
';

$GLOBALS['phpAds_hlp_name'] = '
	Le nom de l\'application appara�trat sur toutes les pages de l\'administration,et de la gestion des publicit�.
	Si vous laissez ce champ vide (par d�faut), un logo '.$phpAds_productname.' sera affich� � la place.
';

$GLOBALS['phpAds_hlp_company_name'] = '
	Ce nom est utilis� dans les emails envoy�s par '.$phpAds_productname.'.
';

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = '
	Normalement, '.$phpAds_productname.' d�tecte automatiquement la pr�sence, et les formats support�s par la librairie GD. N�anmoins, il se peut que la d�tection
	soit �rron�e. Si '.$phpAds_productname.' ne parvient pas � trouver les bon param�tres, vous pouvez sp�cifier directement le bon format. Les valeurs autoris�es sont:
	none, png, jpeg, gif.
';

$GLOBALS['phpAds_hlp_p3p_policies'] = '
	Si vous souhaitez activer la politique de respect de la vie priv�e P3P de '.$phpAds_productname.', vous devez utiliser
	cette option. 
';

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = '
	La politique compacte est envoy�e avec les cookies. Ce r�glage par d�faut autorise Internet Explorer 6 �
	accepter les cookies de '.$phpAds_productname.'. Si vous voulez, vous pouvez modifier ce param�tre afin qu\'il corresponde
	� votre propre politique de respect de la vie priv�e.
';

$GLOBALS['phpAds_hlp_p3p_policy_location'] = '
	Si vous utilisez une politique compl�te de respect de la vie priv�e, vous pouvez indiquer l\'emplacement de
	votre chartre.
';

$GLOBALS['phpAds_hlp_log_beacon'] = '
	Les balises sont de petites images invisibles qui sont plac�es sur la page o� la banni�re est affich�e.
	Si vous activez cette fonctionnalit�, '.$phpAds_productname.' utilisera cette image-balise pour compter le nombre
	d\'affichages que la banni�re a fait. Si vous d�sactivez cette fonctionnalit�, les affichages seront compt�s
	� la distribution, mais ce n\'est pas enti�rement fiable, puisque une banni�re distribu�e n\'est pas toujours
	affich�e � l\'�cran du visiteur (manque de temps, page trop longue, ...).
';
		
$GLOBALS['phpAds_hlp_compact_stats'] = '
	Traditionnellement, '.$phpAds_productname.' utilise une journalisation assez intensive, extr�mement d�taill�e, mais tr�s gourmande en espace disque SQL.
	Pour s\'affranchir de ce probl�me, '.$phpAds_productname.' a introiduit un nouveau type de statistiques, les  statistiques r�sum�es, qui consomme �norm�ment
	mois de place, mais qui est moins d�taill�. Les statistiques compactes ne journalisent non pas chaque clients, mais plut�t le nombre de client � chaque heure.
	Si vous avez beaucoup de visiteurs, ou que votre base de donn�es sature, essayer de passer en mode \'R�sum�\'.
';

$GLOBALS['phpAds_hlp_log_adviews'] = '
	Normalement, tous les affichages sont journalis�s. Si vous ne voulez pas de statistiques concernant les affichages, d�sactivez cette option.
';

$GLOBALS['phpAds_hlp_block_adviews'] = '
	Si un visiteur recharge une page, � chaque fois un affichage sera compt�. Cette fonctionnalit� est utilis�e pour s\'assurer que un seul affichage est d�compt� pour
	la m�me banni�re, et pour le temps sp�cifi� (en secondes). Par exemple, si vous mettez cette valeur � 300 secondes, '.$phpAds_productname.' ne comptera l\'affichage
	d\'une banni�re que si elle n\'a pas �t� montr�e � ce visiteur dans les 5 derni�res minutes. Cette fonction n\'est active que si le navigateur du visiteur
	accepte les cookies.
';
		
$GLOBALS['phpAds_hlp_log_adclicks'] = '
	Normalement, tous les clics sont journalis�s. Si vous ne voulez pas de statistiques concernant les clics, d�sactivez cette option.
';

$GLOBALS['phpAds_hlp_block_adclicks'] = '
	Si un visiteur clique plusieurs fois sur une banni�re, un clic sera compt� par '.$phpAds_productname.' chaque fois.
	Cette fonctionnalit� est utilis�e pour s\'assurer que seul un clic est compt� pour une banni�re unique,
	pour un m�me visiteur, pendant le temps sp�cifi� (en secondes). Par exemple, si vous mettez cette valeur �
	300 secondes, '.$phpAds_productname.' ne comptera le clic d\'un visiteur que si celui ci n\'a pas d�j� cliqu� sur cette
	banni�re dans les 5 derni�res minutes. Cette option ne marche que si le navigateur du visiteur accepte les
	cookies.
';

$GLOBALS['phpAds_hlp_log_source'] = '
	Si vous utilisez le param�tre &quot;source&quot; dans votre conde d\'invocation des banni�res, '.$phpAds_productname.' peut le journaliser
	de telle sorte que vous serez capable de voir les statistiques d\'affichages des diff�rentes sources.
	Si vous n\'utilisez pas le param�tre &quot;source&quot;, ou si vous ne souhaitez pas journaliser cette information, vous pouvez
	d�sactiver sans crainte cette option.
';
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = '
	Si vous utilisez une base de g�olocalisation, vous pouvez journaliser les informations d\'emplacement dans la base de donn�es.
	Si vous avez activ� cette option, vous pourrez visualiser les statistiques de positionnement g�ographique de vos visiteurs, et savoir dans quels
	pays chaque banni�re est la plus vue. Cette option n\'est disponible que si vous utilisez les statistiques d�taill�es.
';
		
$GLOBALS['phpAds_hlp_log_hostname'] = '
	Il est possible de journaliser le nom d\'h�te ou l\'adresse IP de chaque visiteur. Activer cette option vous permettra de voir quelle machine
	affiche le plus de banni�res. Cette option n\'est disponible que si vous utilisez les statistiques d�taill�es.
';
		
$GLOBALS['phpAds_hlp_log_iponly'] = '
	La journalisation du nom d\'h�te de vos visiteurs prends �norm�ment de place dans la base de donn�es. Si vous activez cette option,
	'.$phpAds_productname.' continuera de journaliser les informations concernant l\'h�te, mais en utilisant l\'adresse IP, beaucoup plus petite.
	Cette option n\'est pas disponible si le nom d\'h�te n\'est pas fourni par le serveur ou par '.$phpAds_productname.', car dans ce cas ce sera
	toujours l\'adresse IP qui sera journalis�e.
';	


$GLOBALS['phpAds_hlp_reverse_lookup'] = '
	Le nom d\'h�te est habituellement d�termin� par le serveur Web, mais dans certains cas, cela est d�sactiv�.
	Si vous souhaitez utiliser le nom d\'h�te dans les limitations de distributions et/ou en garder des statistiques, et que le
	serveur ne fournit pas le nom d\'h�te, vous devrez activer cette option.
	Attention n�anmoins: la d�termination du nom d\'h�te est une op�ration longue, et cela ralentiras la distribution des banni�res.
';
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = '
	Certains visiteurs utilisent un serveur proxy pour acc�der � Internet. Dans ce cas, c\'est le nom d\'h�te (ou l\'adresse IP) du serveur proxy
	qui sera journalis� � la place de celui du visiteur. Si vous activez cette option, '.$phpAds_productname.' essaiera de d�terminer le nom d\'h�te ou
	l\'adresse IP du visiteur plac� derri�re le serveur proxy. Si il n\'est pas possible de d�terminer ces informations, celles du serveur proxy seront
	utilis�es � la place. Cette option est d�sactiv�e par d�faut, car elle ralentit consid�rablement la distribution des banni�res.
';

$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = '
	Si vous activez cette option, les informations r�cup�r�es seront automatiquement supprim�es apr�s le nombre de semaines
	sp�cifi� juste en dessous dans la case. Par exemple, si vous r�glez la p�riode � 5 semaines, toutes les statistiques plus vieilles que 5 semaines
	seront automatiquement supprim�es.
';
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = '
	Cette fonctionnalit� supprimera automatiquement les entr�es du journal utilisateur plus vieilles que le nombre de semaines sp�cifi�.
';
		
$GLOBALS['phpAds_hlp_geotracking_type'] = '
	La g�olocalisation permet � '.$phpAds_productname.' de transformer l\'adresse IP du visiteur en une information de positionnement g�ographique.
	Gr�ce � cette information, vous pouvez r�gler une limitation de distribution, ou vous pouvez journaliser cette information pour
	voir quel pays g�n�re le plus d\'affichages ou de clics. Si vous voulez activer la g�olocalisation, vous devez indiquer quel type de base vous avez.
	'.$phpAds_productname.' supporte actuellement les bases <a href="http://hop.clickbank.net/?phpadsnew/ip2country" target="_blank">IP2Country</a>
	et <a href="http://www.maxmind.com/?rId=phpadsnew" target="_blank">GeoIP</a>.
';
		
$GLOBALS['phpAds_hlp_geotracking_location'] = '
	A moins que vous n\'utilisiez le module Apache GeoIP, vous devez indiquer � '.$phpAds_productname.' l\'emplacement
	de votre base de g�olocalisation. Il est vivement recommand� de placer la base � l\'ext�rieur de la racine Web, afin d\'�viter
	que n\'importe qui ne puisse la t�l�charger.
';
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = '
	La conversion de l\'adresse IP en informations g�ographiques prends du temps. Afin d\'�viter � '.$phpAds_productname.' d\'avoir � faire cela
	� chaque banni�re, le r�sultat de la conversion peut �tre stock� dans un cookie. Si le cookie est pr�sent, '.$phpAds_productname.' utilisera
	ce cookie plut�t que de retransformer l\'adresse IP.
';

$GLOBALS['phpAds_hlp_ignore_hosts'] = '
	Si vous ne voulez pas compter les clics et les affichages de certaines machines, vous pouvez les entrer
	ci-contre. Si vous avez activ� la requ�te DNS invers�e, vous pouvez entrer des adresses IP et des noms de
	domaines, autrement vous ne pouvez entrer que des adresses IP. Vous pouvez aussi utiliser des jokers
	(Ex: \'*.altavista.fr\' ou \'192.168.*\').
';

$GLOBALS['phpAds_hlp_begin_of_week'] = '
	Pour la plupart des gens, la semaine commence le Lundi, mais si vous souhaitez commencer chaque semaine un
	Dimanche, vous pouvez.
';

$GLOBALS['phpAds_hlp_percentage_decimals'] = '
	Sp�cifiez combien les pages de statistiques devront afficher de d�cimales dans leurs pourcentages.
';

$GLOBALS['phpAds_hlp_warn_admin'] = '
	'.$phpAds_productname.' peut vous envoyer un email si une campagne n\'a plus qu\'un nombre limit� de clics ou d\'affichages
	restants. Cette option est activ�e par d�faut.
';

$GLOBALS['phpAds_hlp_warn_client'] = '
	'.$phpAds_productname.' peut envoyer � l\'annonceur un email si une de ses campagnes n\'a plus qu\'un nombre limit� de clics
	ou d\'affichages restants. Cette option est activ�e par d�faut.
';

$GLOBALS['phpAds_hlp_qmail_patch'] = '
	Certaines versions de qmail sont affect�es par un bogue, qui affiche les ent�tes du mail dans le corps des messages que '.$phpAds_productname.'envoie.
	Activez cette option si votre version de qmail est bogu�.
';
		
$GLOBALS['phpAds_hlp_warn_limit'] = '
	La limite en dessous de laquelle '.$phpAds_productname.' envoyedes messages d\'avertissement (� l\'administrateur et/ou � l\'annonceur). La valeur est de 100 par d�faut.
';

$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = '
	Vous pouvez choisir les codes d\'invocation autoris�s. Ces r�glages n\'influent que sur la page de g�neration du code, c\'est � dire que les autres modes
	d\'invocation continueront de marcher, � condition que leur code d\'invocation ait �t� g�n�r� avant.
';

$GLOBALS['phpAds_hlp_con_key'] = '
	'.$phpAds_productname.' inclut une puissante m�thode de s�lection des banni�res. Pour plus d\'informations, reportez vous
	� la documentation. Avec cette option, vous pouvez activer les mots cl�s conditionnels. Cette option
	est activ�e par d�faut.
';

$GLOBALS['phpAds_hlp_mult_key'] = '
	Pour chaque banni�re, vous pouvez sp�cifier un ou plusieurs mots cl�s. Cette option est n�cessaire si vous
	souhaitez sp�cifier plus d\'un mot cl�. Cette option est activ�e par d�faut.
';

$GLOBALS['phpAds_hlp_acl'] = '
	Si vous n\'utilisez pas les limitations d\'affichages des banni�res, vous pouvez d�sactiver le contr�le de ces limites � chaque affichage, cela acc�l�rera '.$phpAds_productname.'.
';

$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = '
	Si '.$phpAds_productname.' n\'arrive pas � se connecter au serveur SQL, ou bien qu\'il ne trouve aucune banni�re � afficher, il se tournera vers ces r�glages.
	Cette option est d�sactiv�e par d�faut.
';
$GLOBALS['phpAds_hlp_delivery_caching'] = '
	Afin d\'acc�l�rer la distribution, '.$phpAds_productname.' utilise un cache qui contient les informations n�cessit�es pour la distribution
	d\'une banni�re � un visiteur de votre site. Le cache de distribution est stock� par d�faut dans votre base de donn�es, mais pour acc�l�rer encore plus,
	il est possible de stocker le cache dans un fichier, ou en m�moire partag�e. La m�moire partag�e est la plus rapide, mais les fichiers sont rapides aussi.
	Il n\'est pas recommand� de d�sactiver le cache de distribution, car cela affecterait fortement les performances.
';

$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = '
	'.$phpAds_productname.' peut utiliser diff�rents types de banni�res et les stocker de diff�rentes fa�ons.
	Les deux premi�res options sont utilis�es pour le stockage local des banni�res.
	Vous pouvez utilisez l\'interface d\'administration pour envoyer une banni�re, et '.$phpAds_productname.'
	la stockera dans une base SQL (Option 1), ou sur un serveur Web/FTP (Option 2).
	Vous pouvez aussi utiliser des banni�res stock�es sur des serveurs Web externes (Option 3),
	ou utiliser du HTML pour g�n�rer une banni�re (Option 4). Vous pouvez d�sactiver n\'importe laquelle
	de ces m�thodes de stockage, en modifiant ces param�tres. Par d�faut, tous les types de banni�res
	sont autoris�s.
	Si vous d�sactivez un certain type de banni�re alors qu\'il en existe encore de ce type, '.$phpAds_productname.' les
	utilisera toujours, mais ne permettra plus leur cr�ation.
';

$GLOBALS['phpAds_hlp_type_web_mode'] = '
	Si vous souhaitez utiliser des banni�res stock�es sur un serveur Web, vous devez configurer
	ce param�tre. Pour stocker les banni�res sur un r�pertoire local accessible par PHP, choisissez
	\'r�pertoire local\', et pour les stocker plut�t sur un serveur FTP externe, choisissez \'serveur
	FTP externe\'. Sur certains serveurs vous pouvez pr�f�rer l\'utilisation de l\'option FTP, m�me si celui ci
	est situ� sur le serveur local.
';

$GLOBALS['phpAds_hlp_type_web_dir'] = '
	Sp�cifiez le r�pertoire o� '.$phpAds_productname.' a besoin de copier les banni�res upload�es.
	Ce r�pertoire DOIT �tre inscriptible par PHP, cela peut signifier que vous soyez oblig�
	de changer les permissions UNIX de ce r�pertoire (chmod). Le r�pertoire que vous sp�cifiez ici DOIT
	�tre situ� sous la racine du serveur Web, ce qui veut dire qu le serveur Web doit servir les fichiers
	de ce r�pertoire librement. N\'ajoutez pas un slash (/) final au chemin du r�pertoire.
	Vous n\'avez besoin de configurer cette option que si vous avez activ� le stockage en mode local.
';

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = '
	Si vous avez choisi comme m�thode de stockage <i>Serveur FTP externe</i>, vous devez sp�cifier ici
	l\'adresse IP ou le nom d\'h�te du serveur sur lequel '.$phpAds_productname.' copiera les banni�res.
';
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = '
	Si vous avez choisi comme m�thode de stockage <i>Serveur FTP externe</i>, vous devez sp�cifier ici
	le chemin, sur le serveur FTP externe, du r�pertoire dans lequel '.$phpAds_productname.' copiera les banni�res.
';
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = '
	Si vous avez choisi comme m�thode de stockage <i>Serveur FTP externe</i>, vous devez sp�cifier ici
	le nom d\'utilisateur avec lequel '.$phpAds_productname.' se connectera au serveur FTP externe sur lequel '.$phpAds_productname.'
	copiera les banni�res.
';
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = '
	Si vous avez choisi comme m�thode de stockage <i>Serveur FTP externe</i>, vous devez sp�cifier ici
	le mot de passe avec lequel '.$phpAds_productname.' se connectera au serveur FTP externe sur lequel '.$phpAds_productname.'
	copiera les banni�res.
';
      
$GLOBALS['phpAds_hlp_type_web_url'] = '
	Si vous stockez les banni�re sur un serveur Web (local ou FTP), '.$phpAds_productname.' doit connaitre
	l\'Url publique associ�e avec le r�pertoire que vous avez sp�cifi� pr�c�demment.
	N\'ajoutez pas un slash (/) final au chemin du r�pertoire.
';

$GLOBALS['phpAds_hlp_type_html_auto'] = '
	Si cette option est activ�e, '.$phpAds_productname.' modifiera automatiquement les banni�res HTML, afin
	de permettre le comptage des clics. N�anmoins, m�me si cette option est activ�e, il sera possible
	de la d�sactiver pour certaines banni�res.
';

$GLOBALS['phpAds_hlp_type_html_php'] = '
	Il est possible de laisser '.$phpAds_productname.' ex�cuter du code PHP inclus dans des banni�res HTML.
	Cette option est d�sactiv�e par d�faut.
';

$GLOBALS['phpAds_hlp_admin'] = '
	Le nom d\'utilisateur de l\'administrateur: vous pouvez sp�cifier ici le nom d\'utilisateur que
	vous devez utiliser pour entrer dans l\'interface d\'administration.';

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = '
	Veuillez entrer le mot de passe que vous souhaitez utiliser pour vous connecter � l\'interfa�e d\'administration.
	Vous devez le taper deux fois afin d\'�viter les fautes de frappe.
';
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = '
	Pour changer le mot de passe de l\'administrateur, vous devez sp�cifier l\'ancient mot de passe ci-dessus.
	Vous devez aussi taper le nouveau mot de passe deux fois, afin de pr�venir � tout risque d\'erreur.
';

$GLOBALS['phpAds_hlp_admin_fullname'] = '
	Sp�cifiez ici le nom complet de l\'administrateur. Ce param�tre est utilis� pour signer les
	statistiques envoy�es par email.
';

$GLOBALS['phpAds_hlp_admin_email'] = '
	L\'adresse email de l\'administrateur. Ce param�tre est utilis� comme \'from-address\'
	dans les emails de statistiques.
';

$GLOBALS['phpAds_hlp_admin_email_headers'] = '
	Vous pouvez ajouter des en-t�tes email que '.$phpAds_productname.' ajoutera � tout mail sortant.
';

$GLOBALS['phpAds_hlp_admin_novice'] = '
	Si vous souhaitez recevoir un avertissement lors de l\'effacement d\'annonceurs, de campagnes, ou
	de banni�res. Il est tr�s vivement conseill� de laisser cette option activ�e.
';

$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = '
	Si vous activez cette option, un message de bienvenue sera affich� sur la premi�re page qu\'un annonceur
	voit apr�s s\'�tre connect�. Vous pouvez le personnaliser, en �ditant le fichier \'admin/templates/welcome.html\'.
	Choses que vous pourriez vouloir �crire par exemple: le nom de votre entrepris, les informations concernant
	les contacts, le logo de votre entreprise, un lien vers les tarifs des publicit�s, etc...
';

$GLOBALS['phpAds_hlp_updates_frequency'] = '
	Si vous souhaitez que '.$phpAds_productname.' v�rifie si il existe des mises � jour, vous pouvez activer cette fonction.
	Il est possible de sp�cifier l\'intervalle entre chaque v�rification. Cette v�rification s\'effectue par
	une connexion au serveur de mise � jour. Si une nouvelle version est trouv�e, une boite de dialogue
	appara�tra, avec d\'avantages d\'informations concernant la mise � jour.
';
		
$GLOBALS['phpAds_hlp_userlog_email'] = '
	Si vous souhaitez garder une copie de tous les emails sortant envoy�s par '.$phpAds_productname.', vous pouvez activer
	cette fonctionnalit�. Les emails sortants sont stock�s dans le journal utilisateur.
';
		
$GLOBALS['phpAds_hlp_userlog_priority'] = '
	Pour s\'assurer que le calcul des priorit�s a �t� correctement effectu�, vous pouvez activer l\'enregistrement
	des rapports des calculs de priorit�s (chaque heure) dans le journal utilisateur. Ces rapports incluent
	les pr�visions, ainsi que la priorit� assign�e � chaque banni�re. Ces informations peuvent �tre utiles si
	vous souhaitez soumettre un rapport de bug � propos de ces calculs de priorit�.
';

$GLOBALS['phpAds_hlp_userlog_autoclean'] = '
	Afin de pouvoir vous assurer que la base de donn�es a �t� nettoy�e correctement, vous pouvez sauver un rapport qui d�crira
	ce qui s\'est exactement pass� durant le nettoyage. Ce rapport sera stock� dans le journal utilisateur.
';

$GLOBALS['phpAds_hlp_default_banner_weight'] = '
	Si vous souhaitez assigner un poids par d�faut des banni�res sup�rieur � 1 (valeur par d�faut), vous pouvez
	sp�cifier ici le poids d�sir�.
';
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = '
	Si vous souhaitez assigner un poids par d�faut des campagnes sup�rieur � 1 (valeur par d�faut), vous pouvez
	sp�cifier ici le poids d�sir�.
';
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = '
	Si cette option est activ�e, des informations suppl�mentaires � propos de chaque campagne seront
	montr�es sur la page <i>Aper�u de la campagne</i>. Les informations suppl�mentaires incluent le nombre
	d\'affichages restants, de nombre de clics restants, la date d\'activation, la date d\'expiration, et
	les param�tres de priorit�.
';
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = '
	Si cette option est activ�e, des informations suppl�mentaires � propos de chaque banni�re seront
	montr�es sur la page <i>Aper�u de la banni�re</i>.Les informations suppl�mentaires incluent l\'Url
	de destination, les mots cl�s, la taille, et le poids de la banni�re.
';
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = '
	Si cette option est activ�e, un aper�u de toutes les banni�res sera montr� sur la page <i>Aper�u des
	banni�res</i>. Si cette option est d�sactiv�e, il est toujours possible de voir un aper�u de chaque banni�re
	en cliquant sur le triangle proche de chaque banni�re sur la page <i>Aper�u des banni�res</i>.
';
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = '
	Si cette option est activ�e, la banni�re HTML actuelle sera montr�e, � la place du code HTML brut.
	Cette option est d�sactiv�e par d�faut, car les banni�res HTML peuvent rentrer en conflit avec
	l\'interface utilisateur. Si cette option est d�sactiv�e, il est toujours possible de voir la banni�re
	HTML actuelle, en cliquant sur <i>Montrer la banni�re</i>, a cot� du code HTML brut.
';
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = '
	Si cette option est activ�e, un aper�u sera montr� en haut des pages <i>Propri�t�s de la banni�re</i>,
	<i>Options de limitation</i>, et <i>Zones li�es</i>. Si cette option est d�sactiv�e, il sera toujours
	possible de voir la banni�re, en cliquant sur le <i>Montrer la banni�re</i>, en haut de ces pages.
';
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = '
	Si cette option est activ�e, tous les annonceurs, banni�res, et campagnes inactifs seront cach�s des pages
	<i>Annonceurs et Campagnes</i>, et <i>Aper�u de la campagne</i>. Si cette option est activ�e, il est toujours
	possible de voir les �l�ments cach�s, en cliquant sur <i>Montrer tout</i> en bas de ces pages.
';

$GLOBALS['phpAds_hlp_gui_show_matching'] = '
	Si cette option est activ�e, les banni�res correspondantes seront montr�e dans la page <i>Banni�res li�es</i>,
	si la m�thode <i>S�lection par campagnes</i> est choisie. Cela vous permettra de voir exactement quelles banni�res
	serait susceptibles d\'�tre distribu�es si la campagne �tait li�e. Il sera aussi possible de voir un aper�u des
	banni�res correspondantes.
';
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = '
	Si cette option est activ�e, les campagnes parentes des banni�res seront montr�es sur la page <i>Banni�res li�es</i>,
	si la m�thode <i>S�lection par banni�res</i> est choisie. Cela vous permettra de voir exactement � quelles campagnes
	appartiennent les banni�res que vous vous appr�tez � lier. Cela signifie aussi que les banni�res seront group�es par
	campagnes parentes, et non plus tri�es alphab�tiquement.
';
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = '
	Par d�faut toutes les banni�res disponibles sont affich�es sur la page <i>Banni�res li�es</i>.
	Cette page pourrait ainsi devenir tr�s longue si le nombre de banni�res est important.
	En activant cette option, vous pourrez r�gler un nombre maximal d\'�l�ments qui seront affich�es sur la page.
	Si il y a plus d\'�l�ments, ou plusieurs mani�res de lier, les banni�res seront montr�es ce qui prendra moins de place.
';
?>