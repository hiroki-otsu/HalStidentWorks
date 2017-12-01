<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
require '../booststrap.php';
$session = new Session();//セッションクラス

$name = $session -> get("loginUser");

$session->remove($name);
header('Location: http://192.168.33.10/php/StudentWorks/web/index.php');
 ?>
