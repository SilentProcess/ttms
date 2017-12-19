<?php
// initialize database
require_once('db-init.php');
// read all login attempt timestamps into an array
$order = isset($_GET['a']) ? $_GET['a'] : '';
if($order == "timestamp") {
        $dataorder = "timestamp";
} elseif ($order == "input") {
        $dataorder = "count";
} else {
        $dataorder = "timestamp";
}
function createList($localdb, $dataorder) {
        $data = array();
        $query = "SELECT DISTINCT input.session, count(input.input) AS count, convert_tz(auth.timestamp,'+00:00','+02:00') AS timestamp, sessions.ip FROM input INNER JOIN auth on input.session=auth.session INNER JOIN sessions on auth.session=sessions.id GROUP BY input.session, auth.timestamp HAVING count>3 ORDER BY {$dataorder} DESC;";
        $dataresult = $localdb->prepare($query);
        $dataresult->execute();
        while ($row = $dataresult->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
        }
        return $data;
}
$data = createList($db, $dataorder);
//var_dump($data);
// separate date-month-year and hour-minute-second parts and read the day-month-year parts
// into an array

function printData($datalist, $order) {
        foreach ($datalist as $list) {
                echo "<tr><td><a href='index.php?id={$list['session']}&a={$order}'>{$list['session']}</a></td>"  ."<td>{$list['count']}</td>" ."<td>{$list['timestamp']}</td>" ."<td>{$list['ip']}</td></tr>";
        }
}

$html_start = <<<HTMLEND
        <!DOCTYPE html>
        <html>
        <body>
        <table>
        <tr>
                <th>session</th>
                <th><a href="index.php?a=input">inputs</a></th>
                <th><a href="index.php?a=timestamp">timestamp</a></th>
                <th>ip</th>
        </tr>
HTMLEND;

$html_end = <<<HTMLEND
        </table>
        </body>
        </html>
HTMLEND;

echo $html_start;
printData($data, $order);
echo $html_end;
?>
