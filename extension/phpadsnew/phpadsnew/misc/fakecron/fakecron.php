<?php

@include ('fakecron.lastrun.php');

if (isset($lastrun) && $lastrun != date('H'))
{
	if ($fp = @fopen ('fakecron.lastrun.php', 'wb'))
	{
		@fwrite ($fp, "<"."?php $"."lastrun = ".date('H')."; ?".">");
		@fclose ($fp);
		
		// Call maintenance
		if ($fp = @fsockopen ($HTTP_SERVER_VARS['HTTP_HOST'], 80, $errno, $errstr, 3))
		{
			$location = str_replace('/misc/fakecron/fakecron.php', '/maintenance/maintenance.php', $HTTP_SERVER_VARS['REQUEST_URI']);
		    
			@fputs ($fp, "HEAD ".$location." HTTP/1.0\r\nHost: ".$HTTP_SERVER_VARS['HTTP_HOST']."\r\n\r\n");
		    @fclose ($fp);
	    }
	}
}

header ("Content-Type: image/gif");
header ("Content-Length: 43");

// 1 x 1 gif
echo chr(0x47).chr(0x49).chr(0x46).chr(0x38).chr(0x39).chr(0x61).chr(0x01).chr(0x00).
     chr(0x01).chr(0x00).chr(0x80).chr(0x00).chr(0x00).chr(0x04).chr(0x02).chr(0x04).
 	 chr(0x00).chr(0x00).chr(0x00).chr(0x21).chr(0xF9).chr(0x04).chr(0x01).chr(0x00).
     chr(0x00).chr(0x00).chr(0x00).chr(0x2C).chr(0x00).chr(0x00).chr(0x00).chr(0x00).
     chr(0x01).chr(0x00).chr(0x01).chr(0x00).chr(0x00).chr(0x02).chr(0x02).chr(0x44).
     chr(0x01).chr(0x00).chr(0x3B);

?>	