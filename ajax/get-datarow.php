<?php

require_once('YOUR_PATH_HERE/db-init.php');

function getDataRow($localdb) {
        $datatable = array();
        $query = "SELECT sessions.ip, sessions.starttime, auth.username, auth.password FROM sessions INNER JOIN auth ON sessions.id=auth.session GROUP BY sessions.id, auth.id ORDER BY MAX(sessions.starttime) DESC LIMIT 10;";
        $datarow = $localdb->prepare($query);
        $datarow->execute();

        while ($row = $datarow->fetch(PDO::FETCH_ASSOC)) {
                $datatable[] = $row;
        }
        return $datatable;
}

$datatable = getDataRow($db);
//var_dump($datatable);

$data_array = array();

if(!empty($datatable)) {
        foreach($datatable as $value) {
                $data_array[] = array (
                'ip' => $value['ip'],
                'username' => $value['username'],
                'password' => $value['password'],
                'timestamp' => $value['starttime']
        );
        }
        $response = json_encode($data_array);
} else {
        echo "<h3>No data available! huge error!</h3>";
}
echo $response;
?>
