<?php

require_once('PATH_HERE/db-init.php');

function getLoginAttempts($localdb) {
        $attempts = array();
        $query = <<<SQL
        SELECT
        `logindata`.`timestamp`
        FROM `logindata`
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
        $stringArray = explode("T", $attempt['timestamp']);
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

/*$attempt_array = array();

if (!empty($attempts)) {
  foreach ($attempts as $attempt) {
    $srcip = $attempt['srcip'];
    $timestamp = $attempt['timestamp'];
    $attempt_array[] = array (
        'src_ip' => $srcip,
        'date' => $timestamp,
    );
  }
  $response = json_encode($attempt_array);
} else {
  echo '<span style="margin-left: 15px;">ree</span>';
}


// Toimii testattu:
//header('Content-type: application/json');
echo $response;*/

?>

