<?php

// $Id: example.php,v 1.3 2002/12/16 12:18:42 rossigee Exp $

include("main.whois");

$domain = "example.com";
if(isset($_REQUEST['domain'])) {
	$domain = $_REQUEST['domain'];
}
$whois = new Whois($domain);
$result = $whois->Lookup();

echo "<form method=\"post\" action=\"example.php\">";
echo "<input name=\"domain\" value=\"".$domain."\"/>";
echo "<input type=\"submit\"/>";
echo "</form>";

echo "<pre>";
print_r($result);
echo "</pre>";

?>
