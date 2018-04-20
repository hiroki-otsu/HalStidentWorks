<?php
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2018/02/06
 * Time: 20:32
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
    $subject=$request->getPost('code');
    if(empty($subject)){
        $error = "格納されていません";
    }
    else{
        $subjectData=explode("#",$subject);
        $achievement = $access->getAchievementDataList($subjectData[1],$subjectData[0],$session->get('ohs50054'));
        echo json_encode($achievement);
    }
}