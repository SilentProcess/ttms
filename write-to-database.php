<?php

// change the path to the actual existing path
require_once('FULL PATH HERE/db-init.php');

function  addDataToMysql($jsonFile) {
        $authdata = "";
        $logindata = "";
        $path = fopen($jsonFile, "wr");
        if ($path) {
                while(($line = fgets($path)) !== false) {
                        $output = json_decode($line);
                        if ($output->eventid == "cowrie.session.connect") {
                                $sourceIp = $output->src_ip;
                                $timestamp = $output->timestamp;
                                $logindata .= $sourceIp ." ". $timestamp ."\n";
                        }
                        if ($output->eventid == "cowrie.login.failed" || $output->eventid == "cowrie.login.success") {
                                $password = $output->password;
                                $username = $output->username;
                                $authdata .= $password ." ". $username ."\n";
                        }
                }
                fwrite($path, "");
                fclose($path);
        } else {
                echo "Error, file not found";
        }
        return array($logindata, $authdata);
}


list($logindata, $authdata) = addDataToMysql("cowrie.json");
$logindata_array = explode("\n", $logindata);
$authdata_array = explode("\n", $authdata);

echo $logindata_array;
echo $authdata_array;

foreach($logindata_array as $key=>$value) {
        $values = explode(" ", $value);
        $sourceIp = $values[0];
        $timestamp = $values[1];
        $sql = "INSERT INTO logindata (srcip, timestamp) VALUES ('$sourceIp', '$timestamp')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
}


foreach($authdata_array as $key=>$value) {
        $values = explode(" ", $value);
        $password = $values[0];
        $username = $values[1];
        $sql = "INSERT INTO authdata (username, password) VALUES ('$username', '$password')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
}

?>
