<?php
/*! \file templatephpAdsNewoperator.php
*/

/*!
  \class TemplatephpAdsNewOperator
  \brief The class TemplatephpAdsNewOperator
  \author Sören Meyer, xrow GbR
*/
include_once('extension/phpadsnew/phpadsnew/phpadsnew.inc.php');
class TemplatephpAdsNewOperator
{
    var $Operators;

    function TemplatephpAdsNewOperator( $name = "phpadsnew" )
    {
	$this->Operators = array( $name );
    }

    /*! Returns the template operators.
    */
    function &operatorList()
    {
	return $this->Operators;
    }


    function namedParameterPerOperator()
    {
        return true;
    } 
    function namedParameterList()
    {
        return array( 'phpadsnew' => array( 'startnode' => array( 'type' => 'string',
                                                                 'required' => false,
                                                                 'default' => '0' ),
								 
					    'type' => array( 'type' => 'string',
                                                                 'required' => false,
                                                                 'default' => 'franchise' ),
								 
					    'url_to' => array( 'type' => 'url_to',
                                                                 'required' => false,
                                                                 'default' => 'franchise' )
								 ) );
    }
    
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
	$url_to = $namedParameters['url_to'];
	$type = $namedParameters['type'];
	$startnode = $namedParameters['startnode'];
	$operatorValue=array();
	if (!isset($phpAds_context)) $phpAds_context = array();
	if($type=='html')
	{
	    $phpAds_raw = view_raw( $startnode, null, '_blank', '', '0', $phpAds_context);
	    $operatorValue['html']=$phpAds_raw['html'];
	    $operatorValue = array_merge($operatorValue,$phpAds_raw);
	    
	}
	
	if($type=='link')
	{
	    $outputbuffer="";
	    $source="";
	    $startnode="node".$startnode;
	    $phpAds_raw = view_raw( $startnode, 0, '_blank', '', '0', $phpAds_context);
	    $return  =  "/extension/phpadsnew/phpadsnew/adclick.php?bannerid=".$phpAds_raw['bannerid']."&zoneid=".$phpAds_raw['zoneid']."&source=_self&dest=".$url_to;
	/* Mozilla    
	    if (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) && preg_match("#Mozilla/(1|2|3|4)#", $HTTP_SERVER_VARS['HTTP_USER_AGENT']) && !preg_match("#compatible#", $HTTP_SERVER_VARS['HTTP_USER_AGENT']))
	    {
		$outputbuffer .= '<layer id="beacon_'.$phpAds_raw['bannerid'].'" width="0" height="0" border="0" visibility="hide">';
		$outputbuffer .= '<img src="/extension/phpadsnew/phpadsnew/adlog.php?bannerid='.$phpAds_raw['bannerid'].'&amp;clientid='.$phpAds_raw['clientid'].'&amp;zoneid='.$phpAds_raw['zoneid'].'&amp;source='.$source.'&amp;block='.$phpAds_raw['block'].'&amp;capping='.$phpAds_raw['capping'].'&amp;cb='.md5(uniqid('', 1)).'" width="0" height="0" alt="" />';
		$outputbuffer .= '</layer>';
	    }
	    else
	    {
	    $outputbuffer .= '<div id="beacon_'.$phpAds_raw['bannerid'].'" style="position: absolute; left: 0px; top: 0px; visibility: hidden;">';
	    $outputbuffer .= '<img src="/extension/phpadsnew/phpadsnew/adlog.php?bannerid='.$phpAds_raw['bannerid'].'&amp;clientid='.$phpAds_raw['clientid'].'&amp;zoneid='.$phpAds_raw['zoneid'].'&amp;source='.$source.'&amp;block='.$phpAds_raw['block'].'&amp;capping='.$phpAds_raw['capping'].'&amp;cb='.md5(uniqid('', 1)).'" width="0" height="0" alt="" style="width: 0px; height: 0px;" />';
	    $outputbuffer .= '</div>';
	*/	
	        
	    $operatorValue['ext_cb'] = md5(uniqid('', 1));
	    $operatorValue['ext_source']=$source;
	    $operatorValue['ext_url']=$return;
	    $operatorValue = array_merge($operatorValue,$phpAds_raw);
	    
	} // if type = link
    }// function modify
    
    function view_raw($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
    {
	view_raw ($what, $clientid, $target, $source, $withtext, $context, $richmedia);
    } // function view_raw
}
?>
