<?php
/**
 * 入力されたイベント情報を登録するphpファイル
 *
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

$title=$request->getPost('title');
$category=$request->getPost('category');
$date=$request->getPost('date');
$target=$request->getPost('target');
$content=$request->getPost('content');

$flg=true;

if($request->isPost()){
    if(empty($title)){
        $flg=false;
        echo 'タイトル';
    }
    if(empty($category)){
        echo 'カテゴリー';
        $flg=false;
    }
    if(empty($date)){
        echo '開催日';
        $flg=false;
    }
    if(empty($target)){
        echo '対象学年';
        $flg=false;
    }
    if(empty($content)){
        echo '内容';
        $flg=false;
    }
    if($flg){
        $schoolYear=null;
        for ($i=0;$i<count($target);$i++){
            $schoolYear.=$target[$i].'年生';
            if(isset($target[$i+1])){
                $schoolYear.=',';
            }
        }
        $search = array('年','月');
        $date=str_replace($search,'/',$date);
        $date=str_replace('日','',$date);
        $result=$access->setEvent($title,$category,$schoolYear,$content,$date,$student=$session->get('ohs50054'));
        echo json_encode($result);
    }else {
        echo 'エラー';
    }
}