<?php

// initialize database
require_once('YOUR_PATH_HERE/db-init.php');

// this function queries the top 10 attempted usernames and reads them into an array
function getUserNames($localdb) {
        $usernames = array();
        $query = "SELECT username, COUNT(username) FROM auth GROUP BY username ORDER BY COUNT(username) DESC LIMIT 10";
        $queriedusernames = $localdb->prepare($query);
        $queriedusernames->execute();

        while ($row = $queriedusernames->fetch(PDO::FETCH_ASSOC)) {
                $usernames[] = $row;
        }
        return $usernames;
}

$usernames = getUserNames($db);
//var_dump($usernames);

$userarray = array();

// read the data from the array into another array and encode it to json
if(!empty($usernames)) {
        foreach($usernames as $value) {
                $userarray[] = array (
                'username' => $value['username'],
                'attempts' => $value['COUNT(username)']
        );
        }
        $response = json_encode($userarray);
} else {
        echo "<h3>No data available! huge error!</h3>";
}
echo $response;
?>
