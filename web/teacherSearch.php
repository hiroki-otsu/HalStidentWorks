<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/01/29
 * Time: 1:01
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

$teacher=$request->getGet('teacher');
$flg=true;

if(empty($teacher)){
    $flg=false;
}
if($flg){
    $total = $access->getCountDate(TEACHER);
    $totalPage = ceil($total / TEACHER_PAGE);
    $access->getTeacher($teacher);
}else{

}