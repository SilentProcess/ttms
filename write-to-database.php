<?php
//THIS FILE IN NO LONGER USED AT ALL WE USE COWRIES OWN MYSQL FUNCTIONALITY INSTEAD
require_once('PATH_HERE/db-init.php');

function  addDataToMysql($jsonFile) {
        $authdata = "";
        $logindata = "";
        $path = fopen($jsonFile, "r");
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
                fclose($path);
        } else {
                echo "Error, file not found";
        }
        return array($logindata, $authdata);
}

$jsonfile = "cowrie2.json";

list($logindata, $authdata) = addDataToMysql($jsonfile);

$emptyjson = fopen($jsonfile, "w")
        or die("Can't open file");
fwrite($emptyjson, "");
fclose($emptyjson);

$logindata_array = explode("\n", $logindata);
$authdata_array = explode("\n", $authdata);

if (!empty($logindata_array[0])) {
        foreach($logindata_array as $key=>$value) {
                $values = explode(" ", $value);
                $sourceIp = $values[0];
                $timestamp = $values[1];
                if($timestamp !== "" and $sourceIp !== "") {
                        $sql = "INSERT INTO logindata (srcip, timestamp) VALUES ('$sourceIp', '$timestamp')";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                }
        }
}

if(!empty($authdata_array[0])) {
        foreach($authdata_array as $key=>$value) {
                $values = explode(" ", $value);
                $password = $values[0];
                $username = $values[1];
                if($username !== "") {
                        $sql = "INSERT INTO authdata (username, password) VALUES ('$username', '$password')";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                }
        }
}

?>
~
