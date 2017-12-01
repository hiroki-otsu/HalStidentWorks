<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../booststrap.php';
//インスタンス化
$session = new Session();
$request = new Request();
//エラー文字を格納する配列
$errormsg = array();

if ($request->isPost()) {
  if(empty($_POST["id"])){
    $errormsg['id'] = "ユーザID入力されていません。";
  }
  if(empty($_POST["pass"])){
    $errormsg['pass'] = "パスワードが入力されていません。";
  }
  if (!empty($_POST["id"]) && !empty($_POST["pass"])) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    print_r ('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  }
  echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}//end if(isPost)
?>
