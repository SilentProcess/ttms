<?php

// this file needs to be not accessible by a web browser! if the user navigates to this page it
// creates excess calls to geoplugin API and can result in a ban from the service!

// initialize database
require_once('PATH_HERE/db-init.php');

// this function queries the latest 65 ip addresses that have been logged trying to get into
// the honeypot.
function getIpAddresses($localdb) {
        $ip_addresses = array();
        $query = "SELECT ip FROM sessions GROUP BY ip ORDER BY MAX(starttime) DESC LIMIT 65";
        $get_addresses = $localdb->prepare($query);
        $get_addresses->execute();
        while ($row = $get_addresses->fetch(PDO::FETCH_ASSOC)) {
                $ip_addresses[] = $row;
        }
        return $ip_addresses;
}
$ip_addresses = getIpAddresses($db);
//var_dump($ip_addresses);
$addresses = array();

// read the addresses into an array of strings
foreach ($ip_addresses as $address) {
        //var_dump($address);
        $stringval = $address['ip'];
        $addresses[] = $stringval;
}

//var_dump($addresses);
$addresseslen = count($addresses);

$addresses_array = array();

// for each ip address, query geolocation data from geoplugin API and read the data including the ip
// address and formatting data (for the javascript to use later) into an array and encode it to json.
if (!empty($addresseslen)) {
        for($i = 0; $i < $addresseslen; $i++){
                $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$addresses[$i]) );
                $addresses_array[] = array (
                'scale'=>"0.5",
                'title'=> $addresses[$i] ." ". $geoplugin['geoplugin_countryCode'] . "</br>" . $geoplugin['geoplugin_city'],
                'latitude' => $geoplugin['geoplugin_latitude'],
                'longitude' => $geoplugin['geoplugin_longitude'],
                'type'=>"circle"
        );
        }

        $response = json_encode($addresses_array);
} else {
        echo "<h3>No data available! big error!</h3>";
}

// write the data to a json file. This file will be read by the site. This way we avoid too many calls to
// the geoplugin API. Again, this file (geo.php) must not be accessible by a web browser but the resulting
// json file should be. You must specify the full path to the file (for example /var/www/html/json/geo.json)
// so that this script is able to find it.
$geofile = fopen("geo.json", 'w')
        or die("Unable to open file!");
fwrit-*e($geofile, $response);
fclose($geofile);
?>
