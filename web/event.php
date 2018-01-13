<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/01/12
 * Time: 1:32
 */
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$session = new Session();
$request = new Request();
$access = new DataAccess();
$error = new Errors();

$title=$request->getGet('title');
$category=$request->getGet('category');
$date=$request->getGet('eventDate');
$target=$request->getGet('target');
$content=$request->getGet('content');

$flg=true;

echo 'タイトル'.$title.'<br>';
echo '学科'.$category.'<br>';
echo '開催日'.$date.'<br>';
print_r($target);
echo 'イベント内容'.nl2br($content).'<br>';