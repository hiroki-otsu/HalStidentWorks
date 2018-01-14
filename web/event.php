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

if(empty($title)){
    $flg=false;
}
if(empty($category)){
    $flg=false;
}
if(empty($date)){
    $flg=false;
}
if(empty($target)){
    $flg=false;
}
if(empty($content)){
    $flg=false;
}
if($flg){
    for ($i=0;$i<count($target);$i++){
        $schoolYear=$target[$i].'年生';
        if(isset($target[$i+1])){
            $schoolYear.=',';
        }
    }
    $search = array('年','月');
    $date=str_replace($search,'/',$date);
    $date=str_replace('日','',$date);
    $access->setEvent($title,$category,$schoolYear,$content,$date,$student=$session->get('ohs50054'));
}else {

}