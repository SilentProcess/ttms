<?php

require_once('/home/httpserver/db-init.php');

function getUserNames($localdb) {
        $passwords = array();
        $query = "SELECT password, COUNT(password) FROM auth GROUP BY password ORDER BY COUNT(password) DESC LIMIT 10";
        $queriedusernames = $localdb->prepare($query);
        $queriedusernames->execute();

        while ($row = $queriedusernames->fetch(PDO::FETCH_ASSOC)) {
                $passwords[] = $row;
        }
        return $passwords;
}

$passwords = getUserNames($db);
//var_dump($passwords);

$passwordarray = array();

if(!empty($passwords)) {
        foreach($passwords as $value) {
                $passwordarray[] = array (
                'password' => $value['password'],
                'attempts' => $value['COUNT(password)']
        );
        }
        $response = json_encode($passwordarray);
} else {
        echo "<h3>No data available! huge error!</h3>";
}
echo $response;
?>
