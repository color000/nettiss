<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Cache-Control:no-cache');
header('Pragma:no-cache');
header('Content-Type: text/html; charset=UTF-8');

$host = 'localhost';
$user = 'lforyou6';
$pw = 'aa0909**';
$dbName = 'lforyou6';

$mysqli = new mysqli($host, $user, $pw, $dbName);
if ($mysqli) {
    //$time           = unix_timestamp();
    $ip = $_SERVER["REMOTE_ADDR"];
    $browserInfo = $_SERVER['HTTP_USER_AGENT'];

    $sql = "insert into contact (contact_chk, name, email, tel, contents) values ('" . $_POST['contact_chk'] . "', '" . $_POST['name'] . "', '" . $_POST['email'] . "', '" . $_POST['tel'] . "', '" . $_POST['contents'] . "')";
    //echo $sql;
    //exit;
    if ($mysqli->query($sql)) {
        echo "<script>history.back();</script>";
        exit;
    } else {
        echo '실패<br>' . mysqli_error($mysqli);
    }
} else {
    echo "MySQL 접속 실패";
}