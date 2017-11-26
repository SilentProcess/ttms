<?php

// initialize database
require_once('PATH_HERE/db-init.php');

// read all login attempt timestamps into an array
function getLoginAttempts($localdb) {
        $attempts = array();
        $query = <<<SQL
        SELECT
        `sessions`.`starttime`
        FROM `sessions`
SQL;

        $loginattempts = $localdb->prepare($query);
        $loginattempts->execute();

        while ($row = $loginattempts->fetch(PDO::FETCH_ASSOC)) {
                $attempts[] = $row;
        }
        return $attempts;
}

$attempts = getLoginAttempts($db);
//var_dump($attempts);

$timestamparray = array();

// separate date-month-year and hour-minute-second parts and read the day-month-year parts
// into an array
foreach ($attempts as $attempt) {
        $stringArray = explode(" ", $attempt['starttime']);
        $stringval = $stringArray[0];
        $timestamparray[] = $stringval;
}

// this function counts all the similar timestamps and returns an array that has the timestamp
// as the key and the amount of similar timestamps as value.
$vals = array_count_values($timestamparray);
//print_r($vals);

$attempt_array = array();

// read timestamps and amount of timestamps per day into an array and convert it to json.
if (!empty($vals)) {
        foreach($vals as $key => $value) {
                $attempt_array[] = array (
                'date' => $key,
                'value' => $value
        );
        }
        $response = json_encode($attempt_array);
} else {
        echo "<h3>No data available! big error!</h3>";
}

echo $response;

?>
