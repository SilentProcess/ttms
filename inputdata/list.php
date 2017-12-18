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
// separate date-month-year and hour-minute-second parts and read the day-month-year parts
// into an array

function printData($datalist) {
        foreach ($datalist as $list) {
                echo "<tr><td><a href='index.php?id={$list['session']}'>{$list['session']}</a></td>"  ."<td>{$list['count']}</td>" ."<td>{$list['timestamp']}</td></tr>";
        }
}

$html_start = <<<HTMLEND
        <!DOCTYPE html>
        <html>
        <body>
        <table>
        <tr>
                <th>session</th>
                <th>inputs</th>
                <th>timestamp</th>
        </tr>
HTMLEND;

$html_end = <<<HTMLEND
        </table>
        </body>
        </html>
HTMLEND;

echo $html_start;
printData($data);
echo $html_end;
?>
