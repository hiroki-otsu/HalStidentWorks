<?php
/**
 * イベントに参加・不参加の情報を登録するphpファイル
 * User: hiro
 * Date: 2018/02/15
 * Time: 11:32
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

$no=$request->getPost('eventNo');
$joinStatus=$request->getPost('join');
$student=$session->get('ohs50054');
$result=$access->setEventJoinDecision($no,$student,$joinStatus);
echo json_encode($result);
