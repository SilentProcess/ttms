<?php

require_once('PATH_HERE/db-init.php');

function getLoginAttempts($localdb) {
        $attempts = array();
        $query = <<<SQL
        SELECT
        `logindata`.`srcip`,
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

$attempt_array = array();

if (!empty($attempts)) {
  foreach ($attempts as $attempt) {
    $srcip = $attempt['srcip'];
    $timestamp = $attempt['timestamp'];
    $attempt_array[] = array (
        'src_ip' => $srcip,
        'timestamp' => $timestamp,
    );
  }
  $response = json_encode($attempt_array);
} else {
  echo '<span style="margin-left: 15px;">ree</span>';
}

header('Content-type: application/json');
echo $response;
?>
