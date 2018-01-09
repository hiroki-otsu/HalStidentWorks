<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/01/10
 * Time: 0:54
 */
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$request = new Request();
$session = new Session();
$access = new DataAccess();
$error = new Errors();

$title = $request->getGet('title');
$content = $request->getGet('content');
$flg=true;
if (empty($title)){
    $error->setErrors('タイトルが入力されていません');
    $flg=false;
}
if (empty($content)){
    $error->setErrors('お問い合わせ内容が入力されていません');
    $flg=false;
}
if($flg){
    $access->setContact($title,$content,$user=$session->get('ohs50054'));
}else{

}

