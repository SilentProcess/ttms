<?php

require_once('PATH_HERE/db-init.php');

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

foreach ($attempts as $attempt) {
        $stringArray = explode(" ", $attempt['starttime']);
        $stringval = $stringArray[0];
        $timestamparray[] = $stringval;
}

$vals = array_count_values($timestamparray);
//print_r($vals);

$attempt_array = array();

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
