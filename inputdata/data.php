<?php
// initialize database
require_once('db-init.php');

include('list.php');

function getListData($localdb) {
        $hash = isset($_GET['id']) ? $_GET['id'] : '';
        $data = array();
        $query = "SELECT input FROM input where session = '$hash'";
        $dataresult = $localdb->prepare($query);
        $dataresult->execute();
        while ($row = $dataresult->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
        }
        return $data;
}


$data = getListData($db);

//var_dump($data);

$inputarray = array();
foreach ($data as $input) {
        echo $input['input'] ."<br>";
}
?>
