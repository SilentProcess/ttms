<?php
// initialize database
require_once('db-init.php');
// read all login attempt timestamps into an array
function createList($localdb) {
        $data = array();
        $query = "SELECT DISTINCT input.session, count(input.input) AS count, auth.timestamp FROM input INNER JOIN auth ON input.session=auth.session GROUP BY input.session, auth.timestamp HAVING count>3 ORDER BY MAX(auth.timestamp) DESC";
        $dataresult = $localdb->prepare($query);
        $dataresult->execute();
        while ($row = $dataresult->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
        }
        return $data;
}


$data = createList($db);
//var_dump($data);
$inputarray = array();
// separate date-month-year and hour-minute-second parts and read the day-month-year parts
// into an array
foreach ($data as $list) {
        $hash = $list['session'];
        echo "<a href='data.php?id={$hash}'>{$hash}</a>" ."   "  .$list['count'] ."  " .$list['timestamp'] ."<br>";
}
?>
