<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/01/09
 * Time: 1:50
 */
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$request = new Request();
$access = new DataAccess();
$error = new Errors();

if($request->isPost()){
    $request->getPost('current');
    $request->getPost('new');
    $request->getPost('confirmation');

}