<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/01/30
 * Time: 20:05
 */
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$request = new Request();
$access = new DataAccess();
if ($request->isPost()){
    $class=$request->getPost('no');
    if(empty($class)){
        $error = "格納されていません";
    }
    else{
        $error = "格納されています";
    }
    $classNo = str_replace('#', '', $class);
    $classData=$access->getSchedule($classNo);

    echo json_encode($classData);
}