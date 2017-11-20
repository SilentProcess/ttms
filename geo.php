<?php
$ip_addr = "89.250.48.10";
$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_addr) );

if ( is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude']) ) {

$lat = $geoplugin['geoplugin_latitude'];
$long = $geoplugin['geoplugin_longitude'];
}
echo $ip_addr.';'.$lat.';'.$long;
?>