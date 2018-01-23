<html>
<body>
<head>
<link rel="stylesheet" href="style.css"
type="text/css" media="all" />
</head>
<?php
// initialize database
require_once('PATH_TO_FILE/db-init.php');
?>
<nav>
<?php include('list.php');?>
</nav>
<section>
<?php
function getListData($localdb) {
        $hash = isset($_GET['id']) ? $_GET['id'] : '';
        $data = array();
        $dataresult = $localdb->prepare("SELECT input FROM input where session = :hash");
        $dataresult->bindParam(':hash', $hash);
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
        echo "<p>{$input['input']}</p>";
}
?>
</section>
</body>
</html>
