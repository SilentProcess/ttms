<?php

require_once('YOUR_PATH_HERE/db-init.php');

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
