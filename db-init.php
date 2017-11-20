<?php
//db-init.php
try {
        global $db;
        $db = new PDO('mysql:host=localhost;dbname=cowrie;charset=utf8','PASSWORD HERE', 'USERNAME HERE');
} catch (PDOEXCEPTION $e) {
        echo "Connection failed" .$e->getMessage();
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$status = $db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
//echo $status;
?>
