<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/02/01
 * Time: 12:06
 */
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$request = new Request();
$access = new DataAccess();
$session = new Session();
if ($request->isPost()){
    $requestClassNo=$request->getPost('requestClass');
    if(empty(requestClassNo)){
        $error = "格納されていません";
    }
    else{
        $error = "格納されています";
    }
    echo json_encode($requestClassNo);
    $classNo = explode('-',$requestClassNo);
    $requestRoom=$access->setRequestClassRoom($classNo[0],$classNo[1],$user=$session->get('ohs50054'));

    echo json_encode($requestRoom);
}