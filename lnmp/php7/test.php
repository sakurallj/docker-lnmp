<?php
//date
echo date("Y-m-d H:i:s")."<br />\n";
error_reporting(E_ALL);
ini_set("display_errors", 1);

//mysql
try {
    $conn = new PDO('mysql:host=mysql;port=3306;dbname=singshine;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//$conn->exec('set names utf8');
$sql = "SELECT * FROM `tiyu_active` WHERE 1";
$result = $conn->query($sql);
while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
    echo $rows['id'] . ' ' . $rows['title']."<br />\n";
}

//phpinfo
phpinfo();
?>
