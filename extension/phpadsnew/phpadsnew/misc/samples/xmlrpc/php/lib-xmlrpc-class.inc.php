<?php // $Revision: 2.0.2.2 $

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
require ('lib-xmlrpc.inc.php');


// Create array to pass needed HTTP headers via XML-RPC
$phpAds_remoteInfo = array(
	// Headers used for logging/ACLs
	'remote_addr' =>		'REMOTE_ADDR',
	'remote_host' =>		'REMOTE_HOST',
	
	// Headers used for ACLs
	'accept_language' =>	'HTTP_ACCEPT_LANGUAGE',
	'referer' =>			'HTTP_REFERER',
	'user_agent' =>			'HTTP_USER_AGENT',
	
	// Headers used for proxy lookup
	'forwarded' =>			'HTTP_FORWARDED',
	'forwarded_for' =>		'HTTP_FORWARDED_FOR',
	'x_forwarded' =>		'HTTP_X_FORWARDED',
	'x_forwarded_for' =>	'HTTP_X_FORWARDED_FOR',
	'client_ip' =>			'HTTP_CLIENT_IP'
);



/*********************************************************/
/* Class to display banners via XML-RPC                  */
/*********************************************************/

class phpAds_XmlRpc
{
	var $client;
	var $remote_info;
	var $output;
	
	function phpAds_XmlRpc($host, $path, $port = 80)
	{
		$this->connect($host, $path, $port);
	}

	function connect($host, $path, $port = 80)
	{
		global $phpAds_remoteInfo, $HTTP_SERVER_VARS;
		
		// Correct trailing slashes
		if (strlen($path))
			$path = ereg_replace("^/?(.*)/?$", "/\\1", $path);
		
		// Create client object
		$this->client=new xmlrpc_client($path."/adxmlrpc.php", $host, $port);
	
		// Collect remote host information for the adserver
		$this->remote_info = array();
		while (list($k, $v) = each($phpAds_remoteInfo))
		{
			if (isset($HTTP_SERVER_VARS[$v]))
				$this->remote_info[$k] = $HTTP_SERVER_VARS[$v];
		}	
		
		// Encode remote host information into a XML-RPC struct
		$this->remote_info = phpAds_xmlrpcEncode($this->remote_info);
		
		// Reset $output cache
		$this->output = '';
	}
	
	function view_raw($what, $clientid=0, $target='', $source='', $withtext=0, $context=0, $richmedia = true)
	{
		// Create context XML-RPC array
		if (is_array($context))
		{
			for ($i=0;$i<sizeof($context);$i++)
				$context[$i] = phpAds_xmlrpcEncode($context[$i]);
		}
		else
			$context = array();
			
		$xmlcontext = new xmlrpcval($context, "array");
		
		// Create XML-RPC request message
		$msg = new xmlrpcmsg("phpAds.view", array(
			$this->remote_info,
			new xmlrpcval($what, "string"),
			new xmlrpcval($clientid, "int"),
			new xmlrpcval($target, "string"),
			new xmlrpcval($source, "string"),
			new xmlrpcval($withtext, "boolean"),
			$xmlcontext
		));

		// Send XML-RPC request message
		if($response = $this->client->send($msg))
		{
			// XML-RPC server found, now checking for errors
			if ($response->faultCode() == 0)
			{
				$this->output = phpAds_xmlrpcDecode($response->value());

				return $this->output;
			}
		}
		
		return false;
	}

	function view($what, $clientid=0, $target='', $source='', $withtext=0, $context=0, $richmedia = true)
	{
		$this->view_raw($what, $clientid, $target, $source, $withtext, $context, $richmedia);

		echo $this->output['html'];

		return $this->output['bannerid'];
	}

}

?>