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



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        �Ы��w�z�n�s����".$phpAds_dbmsname."��Ʈw���A�����D���W.
		";
		
$GLOBALS['phpAds_hlp_dbport'] = "
        �Ы��w�z�n�s����".$phpAds_dbmsname."��Ʈw���A�����s����. 
		".$phpAds_dbmsname."���A�������w�s����O<i>".
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432')."</i>.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        �Ы��w".$phpAds_productname."�ΨӦs��".$phpAds_dbmsname."��Ʈw���A�����Τ�W.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        �Ы��w".$phpAds_productname."�ΨӦs��".$phpAds_dbmsname."��Ʈw���A�����K�X.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        �Ы��w".$phpAds_productname."�b".$phpAds_dbmsname."��Ʈw���A���W�ΨӦs��ƾڪ���Ʈw�W.
		�ݭn�`�N���O�b��Ʈw���A���W����Ʈw�����w�g�s�b.
		�p�G����Ʈw���s�b����,".$phpAds_productname."�N<b>���|</b>�۰ʳЫئ���Ʈw.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        �ä[�s�����ϥΥi�H�ܤj������".$phpAds_productname."���t�שM��p���A�����t���C 
		���O���@�ӯ��I�A�p�G�O�@�Ӥj�X�ݶq�����I�A������A�����t���|��ϥδ��q�s���n�W�[���֡A�|�ܧֹF��ܭ����t���C
		�ϥδ��q�s���٬O�ä[�s���n�ھڧA�����I���X�ݶq�M�w�����ӨM�w�C
		�p�G".$phpAds_productname."�ϥΤF�Ӧh���귽�A�z���ӥ��d�ݳo�ӳ]�m�C
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." �b���J�ƾڪ��ɭԭn��w��Ʈw�C�p�G���I���ܦh���X�ݪ̡A 
		�ܥi��".$phpAds_productname."�������ݫܪ����ɶ��~�ഡ�J�@��s�ƾڡA�]����Ʈw���M�Q��w�C 
		�p�G�A�ϥΩ��𴡤J�A�A���ݭn���ݡA��@�q�ɶ�����A�p�G�ƾڪ�S����L�u�{�ϥΡA���s��|�Q���J��ƾڪ��C 
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        �p�G�A�b��X".$phpAds_productname."�P��L�ĤT�貣�~���ɭԦ����D�A���ﶵ�i�����U�A���}��Ʈw���ݮe�Ҧ��C
		�p�G�A���b�ϥΥ��a�եμҦ��åB��Ʈw���ݮe�Ҧ��w�g���}�A 
		".$phpAds_productname."���ӫO����Ʈw�s�����A�M".$phpAds_productname."�B��e�@�P�C 
		���ﶵ���@�ǺC�]�ܤp�^�ҥH���w���A�O�������C
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        �p�G".$phpAds_productname."�ϥΪ���Ʈw�O�P��L�h�ӳn��@��,����Ʈw�[�@�ӫe��O�@�Ӥ���n����ܡC
		�p�G�A�b�P�@�Ӹ�Ʈw���ϥ�".$phpAds_productname."���h�Ӧw�˪����A�A�n�O�ҳo�ӫe��b�Ҧ����w�˪����̬O�ߤ@���C
		";
		
$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname."����h�ؼƾڪ������C�C�ظ�Ʈw�����W�����S�x�ӥB��������ܤj����".$phpAds_productname."���B��t�סC
		MyISAM�O���w���ƾڪ������åB�i�H�b".$phpAds_dbmsname."���Ҧ��w�˪����W�ϥΡC��L�������ƾڪ�i�ण��b�A�����A���W�ϥΡC
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname."�ݭn���D���ۤv�b�������A������m�~�ॿ�`�u�@�C�A��������".$phpAds_productname."�w�˥ؿ���URL�a�}�A 
        �Ҧp�G  http://www.your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        ��J�����������M����󪺸��|(e.g.: /home/login/www/header.htm)�i�H�b�޲z���ɭ����C�ӭ����W�K�[���M�����C 
        �A�i�H��奻�Ϊ�html���(�p�G�A�ϥΦb��󤤨ϥ�html�N�X�A�Ф��n�ϥζH &lt;body> or &lt;html>���аO)�C
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		�ҥ�GZIP���e���Y�A�|���j����p�C���޲z���������}�ɵo�e���s�������ƾڡC 
		PHP��������4.0.5�æw�ˤFGZIP���[�Ҷ��~��ҥΦ��\��C
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        ���".$phpAds_productname."�ϥΪ����w�y���C�o�ӻy���N�Q�Χ@�޲z���M�Ȥ�ɭ������w�y���C 
        �Ъ`�N�G�A�i�H���q�޲z���ɭ����C�@�ӫȤ�]�m���P���y���M�O�_���\�Ȥ�ק�L�̦ۤv���y���]�m�C
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        �z���w���{�Ǫ��W�r. ���r�Ŧ�N�b�޲z���M�Ȥ�ɭ����Ҧ������W���. 
		�p�G����(���w),�N��ܤ@��".$phpAds_productname."���ϼ�.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        �o�ӦW�r�O".$phpAds_productname."�o�e�q�l���l�󪺮ɭԨϥΪ��C
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname."�q�`�n�˴�GD�w�O�_�w�˩M������عϤ��榡. ���O�˴����i�ण�ǽT�Ϊ̿��~,
		�@�Ǫ�����PHP�����\�˴�������Ϥ��榡. �p�G".$phpAds_productname."�۰��˴��Ϥ��榡����,
		�A�i�H��w���T���Ϥ��榡. �i�઺��:none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        �p�G�A�Q�ҥ�".$phpAds_productname."'P3P���p����',�A�������}���ﶵ. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        �Y�������O�Mcookie�@�_�o�e��. ���w���]�m�O:'CUR ADM OUR NOR STA NID', 
		���\Internet Explorer 6 ����".$phpAds_productname."�ϥΪ�cookie.
		�z�i�H��惡�]�m�H�ŦX�z�ۤv�����p�n��.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        �p�G�z�Q�ϥΧ������p����,�z�i�H��w��������m.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		�H���O�O�p�����i�����Ϥ�,�i�H��m�b�s�i��ܪ������W.�p�G�z���}�F���ﶵ,
		".$phpAds_productname."�N�ϥΦ��H���O�ӭp��s�i��ܪ�����. 
		�p�G�z�����F���ﶵ,�s�i����ܦ��ƱN�b�o�e���ɭԭp��, ���O�o�ˤ������ǽT, 
		�]���@�Ӥw�g�o�e���s�i���@�w�`�O��ܦb�̹��W. 
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        �ǲΤW,".$phpAds_productname."�ϥΤF�۷�s�x���O��,�D�`�ԲӦ��O���Ʈw���A���n�D�ܰ�.
		���@�ӳX�ݪ̫ܦh�����I,�o�O�@�ӫܤj�����D. ���F�ѨM�o�Ӱ��D,".$phpAds_productname."�]����@�طs���έp�覡:
		²��έp�Ҧ�,���Ʈw���A���n�D�p�@��,���O���O�ܸԲ�.²���έp�Ҧ��έp�C�p�ɪ��X�ݼƩM�I����,
		�p�G�z�ݭn��ԲӪ��H��,�z�ݭn����²��έp�Ҧ�.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        �q�`�Ҧ����X�ݼƳ��Q�O��,�p�G�z���Q�����X�ݼƪ��ƾ�,�i�H�������ﶵ.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		�p�G�@�ӳX�ݪ̨�s����,�C��".$phpAds_productname."���|�O���X�ݼ�. 
		���ﶵ�ΨӫO�Ҧb�z���w���ɶ����j����@�Ӽs�i���h���X�ݶȰO���@���X�ݼ�.
		�p:�p�G�z�]�m���Ȭ�300��,".$phpAds_productname."�ȷ�5���������s�i�惡�X�ݪ̨S����ܹL�~�O���ӳX�ݼ�.
		���ﶵ�ȷ��s��������cookies���ɭԤ~�_�@��.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        �q�`�Ҧ����I���Ƴ��Q�O��,�p�G�z���Q�����I���ƪ��ƾ�,�i�H�������ﶵ.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		�p�G�@�ӳX�ݪ��I���@�Ӽs�i�F�h��,�C��".$phpAds_productname."���|�O���I����.
		���ﶵ�ΨӫO�Ҧb�z���w���ɶ����j����@�Ӽs�i���h���I���ȰO���@���I����. 
		�p:�p�G�z�]�m���Ȭ�300��,".$phpAds_productname."�ȷ�5���������X�ݪ̨S���I���L���s�i�~�O�����I����.
		���ﶵ�ȷ��s��������cookies���ɭԤ~�_�@��.
		";
			
$GLOBALS['phpAds_hlp_log_source'] = "
		�p�G�z���b�s�i�եΥN�X���ϥη��Ѽ�,�z�i�H��o�ӫH���s���Ʈw��,
		�o�˱z�i�H�b�έp�ƾڤ��ݨ�B�椤�����P���ѼƫH��.
		�p�G�z�S���ϥη��ѼƩΪ̱z���Q�ϥΦ��ѼƨӫO�s�H��,
		�z�i�H�w�����������ﶵ.
		";
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		�p�G�z���b�ϥΤ@��geotargeting��Ʈw,�z�i�H��a�z�H���s�J��Ʈw.
		i�p�G�z�ҥΦ��ﶵ,�z�i�H�b�έp�ƾڤ��ݨ�z���X�ݪ̪��a�z��m
		�M�C�Ӽs�i�b���P��a�o�G�����p.
		���ﶵ�ȷ�z�ϥθԲӲέp�覡���ɭԤ~��ϥ�.
		";
		
$GLOBALS['phpAds_hlp_log_hostname'] = "
		�p�G�z�Q�O�s�C�ӳX�ݪ̪��D���W�Ϊ�IP�a�},�z�i�H�ҥΦ��ﶵ.
		�O�s���H���z�i�H�ݨ쨺�ǥD���˯��F�̦h���s�i.
		���ﶵ�ȷ�z�ϥθԲӲέp�覡���ɭԤ~��ϥ�.
		";
		
$GLOBALS['phpAds_hlp_log_iponly'] = "
		�O�s�X�ݪ̪��D���W�|���θ�Ʈw�ܦh���Ŷ�.
		�p�G�z�ҥΦ��ﶵ,".$phpAds_productname."�N�٬O�O�s�D�����H��,
		���O�ȫO�s���ΪŶ��֪�IP�a�}�H��.
		�p�G���A�������ѥD���W�Ϊ�".$phpAds_productname."�]�m���D,���ﶵ���i��.
		�]�������p�U�`�O�O��IP�a�}.
		";
	
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        	�������A���i�H�۰��˴���D���W,���O�@�Ǳ��p�U���ﶵ�O������.
		�p�G�z�Q�b�o�e����ϥγX�ݪ̪��D���W�H���M/�ΫO�s���έp�ƾ�,
		�åB���A���S�����Ѧ��H��,�z�ݭn���}���ﶵ.
		�ϦV��W�d�߻ݭn�@�w���ɶ�,�i���C�s�i�o�e���t��.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		�@�ǥΤ�ϥΥN�z���A���ӳX�ݤ��p��.�b�����p�U,".$phpAds_productname."�N�O���N�z���A����IP�a�}�Ϊ̥D���W,
		�Ӥ��O�Τ᪺. �p�G�z�ҥΦ��ﶵ,".$phpAds_productname."�N�d��q�L�N�z���A���W�����Τ᪺�u��IP�a�}�M�D���W. 
		�p�G������Τ᪺�u��a�},�N�ϥΥN�z���A�����a�}.���ﶵ���w�èS���ҥ�,�]���i��|��C�s�i�o�e���t��.
		";
				
$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		�p�G�z�ҥΦ��ﶵ,�W�L�z�b����ܮؤU�����w�ɶ����έp�ƾڱN�Q�۰ʧR��.
		�Ҧp,�p�G�z�]�m��5�ӬP��,����5�ӬP�����e���έp�ƾڱN�Q�۰ʧR��.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		�p�G�z�ҥΦ��ﶵ,�W�L�z�b����ܮؤU�����w�ɶ����Τ�O���N�Q�۰ʧR��.
		�Ҧp,�p�G�z�]�m��5�ӬP��,����5�ӬP�����e���Τ�O���N�Q�۰ʧR��.
		";
		
$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Geotargeting���\".$phpAds_productname."��X�ݪ̪�IP�a�}�ഫ���a�z�H��.
		�z�i�H�b���H������¦�W�]�m�o�e����,�Ϊ̱z�i�H�O�s���H���Ӭd��
		���Ӱ�a���̦h���s�i�o�e�M�I���v.
		�p�G�z�Q�ҥ�geotargeting,�z�ݭn��ܱz�{������Ʈw����.
		".$phpAds_productname."�{�b���<a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> 
		�M <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> ��Ʈw.
		";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
		���D�z�ϥ�GeoIP��Apache�Ҷ�, �_�h�z���ӧi�D".$phpAds_productname."
		geotargeting��Ʈw����m. �j�P���˧⦹��Ʈw���������A�������ɥؿ��~��,
		�_�h���ܨ�L�H�i�H�����U������Ʈw.
		";
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		��IP�a�}�ഫ���a�z�H���ݭn�@�w���ɶ�.
		���F����".$phpAds_productname."�b�C�Ӽs�i�o�e���ɭԳ��i���ഫ,
		�i�H�⵲�G�O�s�bcookie��. �p�G�o��cookie�w�g�s�b,
		".$phpAds_productname."�N�����ϥΦ��H���Ӥ��ΦA�ഫIP.
		";
		

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        �p�G�z���Q�O���S�w�p������X�ݼƩM�I����,�z�i�H��L�̥[�J���C��. �p�G�z�ҥΤF�ϦV��W�d��,
		�z�i�H�K�[��W�MIP�a�},�_�h�z�u��ϥ�IP�a�}. �z�]�i�H�ϥγq�t��(�]�N�O'*.altavista.com'�Ϊ�'192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        ��ܦh�H�ӻ��P���@�O�@�P���}�l,���O�z�i�H�]�m�P���ѧ@���@�P���}�l.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        ���w��ܲέp�ƾڪ��������ƾں�T��p���I����X��.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        �p�G�@�Ӷ��إu�ѤU�������X�ݼƩM�I���Ʀs�q,".$phpAds_productname." ����o�q�l�l��Ӵ����z.���ﶵ���w�O���}��.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        �p�G�@�ӫȤ᪺�Y�Ӷ��إu�ѤU�������X�ݼƩM�I���Ʀs�q".$phpAds_productname."����o�q�l�l��Ӵ����Ȥ�.���ﶵ���w�O���}��.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		qmail���@�Ǫ����]������@��bug���v�T,�y��".$phpAds_productname."�o�e���q�l�l��b�l�󪺤��e�̭���ܶl���Y.
		�p�G�z�ҥΦ��ﶵ,".$phpAds_productname."�N�ϥ�qmail�ݮe�榡�ӵo�e�q�l�l��.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        ".$phpAds_productname."�}�l�o�eĵ�i�q�l�l�󪺻֭�,���w�O100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		�o�ǳ]�m�B��z����\�ϥΪ��եΤ覡.�p�G�Y�ӽեΤ覡����,�N���A�X�{�b�եΥN�X/�s�i�N�X���ͭ���.
		���n:�եΤ覡�p�G���Ϋ�N�~��u�@,�N�O���즳���N�X�٬O�i�H�~��ϥ�,
		�u�O�b���ͽեΥN�X���ɭԤ���ϥ�.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname."�]�t�@�ӨϥΪ�������覡���j�j���s�i��ܨt��.
		��h�ԲӪ��H���аѦҥΤ��U. �q�L���ﶵ,�z�i�H�ҥα�������r.�o�ӿﶵ���w�O���}��.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        �p�G�z���b�ϥΪ�������覡����ܼs�i,�z�i�H���C�Ӽs�i���w�@�өΦh������r.
		�����z�Q���w�h������r,�����ҥΦ��ﶵ.�o�ӿﶵ���w�O���}��.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        �p�G�z�S���ϥεo�e����ﶵ,�z�i�H�������ﶵ,�o�N��".$phpAds_productname."�t�׵y�L�[��.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        �p�G".$phpAds_productname."����s�����Ʈw���A��,�Ϊ̤�����ŦX���s�i,�p��Ʈw�Y��Ϊ̳Q�R��,
		�N����ܥ���F��.�@�ǥΤ�i��Q�b�o�ر��p�U����ܤ@�ӫ��w�����w�s�i.�����w�����w�s�i�N���Q�O��,
		�p�G��Ʈw�����¦��ҥΪ��s�i,�����w�����w�s�i�]�N���Q�ϥ�.�o�ӿﶵ���w�O������.
		";
			
$GLOBALS['phpAds_hlp_delivery_caching'] = "
		���F���U�����s�i�o�e���t��,".$phpAds_productname."�ϥΤF�w�s,uses a cache which includes all
		�w�s���]�t�F�o�e�@�Ӽs�i���A�������X�ݪ̪��Ҧ��ݭn���H��.he information needed to delivery the banner to the visitor of your website. The delivery
		�o�ӵo�e�w�s�Ϥ��w�O�s��b��Ʈw��,���F�i�@�B�����t��,
		���]�i�H�s��b�@�Ӥ��Ϊ̦@�ɤ��s��.
		�@�ɤ��s�O�̧֪�,���]�O�ܧ֪�. ��ĳ���n�������w�s��, 
		�]���|��ʯ�v�T���j.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname."�i�H�ϥΤ��P�������s�i,�Τ��P���覡�s��s�i.�Y��ӿﶵ�ΨӦb���a�s��s�i.
		�z�i�H�ϥκ޲z���ɭ��ӤW�Ǽs�i,".$phpAds_productname."�N�bSQL��Ʈw�Ϊ̺������A���W�s��s�i.
		�A�]�i�H��s�i�s��b�~���������A��,�Ϊ̨ϥ�HTML��²���r�ӥͦ��s�i.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        �p�G�z�Q�ϥΦs��b�������A���W���s�i,�z�ݭn�t�m���]�m.�p�G�z�Q�b���a�ؿ��s��s�i,�⦹�ﶵ�]�m��<i>���a�ؿ�</i>.
		�p�G�z�Q��s�i�s���~��FTP���A���W,�⦹�ﶵ�]�m��<i>�~��FTP���A��</i>.
		�b�@�ǯS�w���������A���W,�z�i��ƦܷQ�b���a���������A���W�ϥ�FTP�ﶵ.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        ���w�@�ӥؿ�,".$phpAds_productname."�ݭn��W�Ǫ��s�i�ƻs�즹�ؿ�.���ؿ�PHP�������g�v��,
		�N�O���z�i��ݭn�ק惡�ؿ���UNIX�v��(chmod).���w���ؿ������b�������A����'���ɮڥؿ�'�U,
		�������A�������i�H�����o�G�����.���n���w�������׽u(/).�z�Ȧb��s��覡�]�m��<i>���a�ؿ�</i>�ɤ~�ݭn�t�m���ﶵ.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		�p�G�z�]�m�s��覡��<i>�~��FTP���A��</i>,�z�ݭn���wFTP���A����IP�a�}�Ϊ̰�W,�H��".$phpAds_productname."
		�����W�Ǫ��s�i�ƻs�즹���A���W.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		�p�G�z�]�m�s��覡��<i>�~��FTP���A��</i>,�z�ݭn���w�~��FTP���A�����ؿ�,�H��".$phpAds_productname."
		�����W�Ǫ��s�i�ƻs�즹�ؿ�.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		�p�G�z�]�m�s��覡��<i>�~��FTP���A��</i>,�z�ݭn���w�~��FTP���A�����Τ�W,�H��".$phpAds_productname."
		����s����~��FTP���A��.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		�p�G�z�]�m�s��覡��<i>�~��FTP���A��</i>,�z�ݭn���w�~��FTP���A�����K�X,�H��".$phpAds_productname."
		����s����~��FTP���A��.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        �p�G�z�b�������A���W�s��s�i,".$phpAds_productname."�ݭn���D�U���z���w���ؿ������}���X�ݦa�}.
		���n���w�������׽u(/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        �p�G���}���ﶵ,".$phpAds_productname."�N�۰ʭק�HTML�s�i�N�X�H�O���I����.
		���O�Y�Ϧ��ﶵ���},���M�i�H��C�Ӽs�i���Φ��\��. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        �i�H��".$phpAds_productname."�bHTML�s�i�N�X������PHP�N�X,���ﶵ���w�O������.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        �п�J�޲z�����Τ�W. �q�L���Τ�W�z�i�H�n����޲z���ɭ�.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
        �п�J�޲z�����K�X. �q�L���Τ�W�z�i�H�n����޲z���ɭ�.�z�ݭn��J�⦸�H�K��J���~.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        �ק��±K�X,�z�ݭn�b�W����J�±K�X. �A�]�ݭn��J�s�K�X�⦸,�H�קK��J���~.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        ���w�޲z�������W,�Ψӳq�L�q�l�l��o�e�έp����.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        �޲z�����q�l�l��a�},�Ψӧ@���o�H�H�a�}�q�L�q�l�l��o�e�έp����.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        �z�i�H�ק�".$phpAds_productname."�o�e�q�l�l�󪺶l���Y.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        �p�G�z�Q�b�R���Ȥ�,����,�s�i,�o�G�̩M���쪺�ɭԱo��@��ĵ�i�H��,�]�m���ﶵ��true.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		�p�G���}���ﶵ,�C�ӫȤ�n���᪺�����N��ܤ@���w��H��.�z�i�H�q�L�ק�admin/templates�ؿ��U��
		welcome.html���ӭק惡�H��.�z�i��Q�n�]�A���H���p:�z���q���W�r,�pô�H��,�z���q���ϼ�,�@�Ӽs�i���歶���챵��.
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		�N���s��welcome.html���,�z�i�H�b�o�̫��w�@�Ǥ�r.�p�G�z�b�o�̿�J�F��r,welcome.html���N�Q����.
		�o�̤��\��Jhtml�аO.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		�p�G�z�Q�d��".$phpAds_productname."������,�z�i�H�ҥΦ��ﶵ.�i�H���w".$phpAds_productname."�s��ɯŦ��A��
		�i��ɯŪ��ɶ����j.�p�G���s����,�N�u�X�]�t�����ɯūH�����@�ӹ�ܮ� 
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		�p�G�z�Q�O�s".$phpAds_productname."�o�e���Ҧ��q�l�l��H�����@�Ӱƥ�,�z�i�H�ҥΦ��ﶵ.�q�l�l��H���N�O�s�b�Τ�O����.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		���F�O���u���v�p�⪺���T,�z�i�H���C�Ӥp�ɪ��p��O�s�@������. �o�ӳ���]�A�w�������p�M�C�Ӽs�i���t���u���v.
		�o�ӫH���b�z�Q����@��bug���i���ɭԤ������. �o�ӳ���s��b�Τ�O����.
		";
				
$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		���F�O�Ҹ�Ʈw���T�R��,
		�z�i�H�O�s�@������R������Ҧ��o�ͱ��p�����i.
		�o�ӫH���N�O�s�b�Τ�O����.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		�p�G�z�Q�ϥΤ@�Ӥ��w�󰪪��s�i�v��,�z�i�H�b�o�̫��w�z���檺�v��.�o�ӿﶵ���w�]�m��1.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		�p�G�z�Q�ϥΤ@�Ӥ��w�󰪪������v��,�z�i�H�b�o�̫��w�z���檺�v��.�o�ӿﶵ���w�]�m��1.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		�p�G���}���ﶵ,�C�Ӷ��ت��B�~���H���N�b<i>�����`��</i>�����W���. �B�~�H���]�A�X�ݼƪ��s�q,�I���ƪ��s�q,
		�ҥΤ��,���Ĥ���M�v�ȳ]�m.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		�p�G���}���ﶵ,�C�Ӽs�i���B�~���H���N�b<i>�s�i�`��</i>�����W���. �B�~�H���]�A�ؼ�URL,����r,�ؤo�M�v��.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		�p�G���}���ﶵ,<i>�s�i�`��</i>�����N��ܩҦ��s�i���w��.�p�G�������ﶵ,�b<i>�s�i�`��</i>�����I��
		�C�Ӽs�i�᭱���T���ϼ�,�]�i�H��ܨC�Ӽs�i���w��.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		�N��ܹ�ڪ�HTML�s�i,�Ӥ��OHTML�N�X.���ﶵ���w�O������,�]��HTML�s�i�i��P�Τ᪺�ɭ��Ĭ�.
		�p�G�������ﶵ,�I��HTML�N�X�᭱��<i>��ܼs�i</i>���s,�]�i�H��ܹ�ڪ�HTML�s�i.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		�p�G���}���ﶵ,�b<i>�s�i�ݩ�</i>,<i>�o�e�ﶵ</i>�M<i>�s���s�i</i>����,�N��ܼs�i���w��.
		�p�G�������ﶵ,�I������������<i>��ܼs�i</i>���s,�]�i�H�ݨ�s�i���w��.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		�p�G�ҥΦ��ﶵ,�Ҧ����Ϊ��s�i,����,�Ȥ�N�b<i>�Ȥ�&����</i>�M<i>�����`��</i>�����Q����. 
		��ҥΦ��ﶵ,�z���¥i�H�I������������<i>��ܩҦ�</i>���s�Ӭd�����ê�����.
		";
		
$GLOBALS['phpAds_hlp_gui_show_matching'] = "
		�p�G�ҥΦ��ﶵ,�M���w<i>���ؿ��</i>�Ҧ�,
		����ŦX���󪺼s�i�N�b<i>�s���s�i</i>�������.
		�o���\�z�ǽT���D�p�G�챵�즹����,���Ǽs�i�i�H�o�e.
		�z�]�i�H�w���@�U�ŦX���󪺼s�i.
		";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		�p�G�ҥΦ��ﶵ,�M���w<i>�s�i���</i>�Ҧ�,
		�s�i�������رN��ܦb<i>�s���s�i</i>����.
		�o���\�z���D�b���s�i�e���Ӷ��ت����Ӽs�i�w�g�s���F.
		�o�N���ۼs�i�ھڤ����بӤ���,�Ӥ��O���H�e�ھڦr�����ǱƧ�.
		";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
		���w�Ҧ��i�Ϊ��s�i�M���س��b<i>�s���s�i</i>�������.
		�ҥH�p�G�ؿ������ܦh���P���i�μs�i����,�o�ӭ����|�ܪ��D�`��.
		�o�ӿﶵ���\�z�]�m�������̦h��ܪ�����.
		�p�G����h���ةM���P�s���覡,�N��ܦ��ΪŶ��̤֪��s�i.
		";
		
?>
