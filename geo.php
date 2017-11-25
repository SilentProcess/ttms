<?php

require_once('PATH_HERE/db-init.php');
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
foreach ($ip_addresses as $address) {
        //var_dump($address);
        $stringval = $address['ip'];
        $addresses[] = $stringval;
}

//var_dump($addresses);
$addresseslen = count($addresses);

$addresses_array = array();

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

$geofile = fopen("geo.json", 'w')
        or die("Unable to open file!");
fwrite($geofile, $response);
fclose($geofile);
?>
