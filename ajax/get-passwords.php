<?php

// initialize database
require_once('YOUR_PATH_HERE/db-init.php');

// this function queries the top 10 used passwords and reads them into an array
function getPassWords($localdb) {
        $passwords = array();
        $query = "SELECT password, COUNT(password) FROM auth GROUP BY password ORDER BY COUNT(password) DESC LIMIT 10";
        $queriedusernames = $localdb->prepare($query);
        $queriedusernames->execute();

        while ($row = $queriedusernames->fetch(PDO::FETCH_ASSOC)) {
                $passwords[] = $row;
        }
        return $passwords;
}

$passwords = getPassWords($db);
//var_dump($passwords);

$passwordarray = array();

// read the data from the array into another array and encode it to json
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
