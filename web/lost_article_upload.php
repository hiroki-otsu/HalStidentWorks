<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../booststrap.php';
//インスタンス化
$session = new Session();//セッションクラス
$request = new Request();//リクエストクラス
//エラー文字を格納する配列
$errormsg = array();
$inputTitle=null;
$inputComment=null;
if ($request-> isPost()){
  $inputTitle=$request-> getPost("title");
  $inputComment=$request-> getPost("comment");

  if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
    if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "img/" . $_FILES["upfile"]["name"])) {
      chmod("img/" . $_FILES["upfile"]["name"], 0644);
      $file = $_FILES["upfile"]["name"];
      echo $_FILES["upfile"]["name"] . "をアップロードしました。";

    } else {
      echo "ファイルをアップロードできません。";
    }
  } else {
    echo "ファイルが選択されていません。";
  }
}
?>
