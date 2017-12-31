<?php
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
if ($request->isPost()) {

    if ($request->getPost('student')){
         $studentNo=$request->getPost('student');
    }
    else{
        $error->setErrors('ユーザIDが入力されていません');
    }
    if($request->getPost('pass')){
        $passWord=$request->getPost('pass');
    }else {
        $error->setErrors('パスワードが入力されていません');
    }

    if(isset($studentNo) && isset($passWord)){

        if( $user = $access->getLoginUserInformation($studentNo,$passWord)){
            $userName = $studentNo.':'.$user[0];
            $session ->set($studentNo,$userName);
            header('Location: /php/HalStudentWorks/web/home.php');
        }else{
            $error->setErrors('パスワードかユーザIDが間違っています');
        }
    }
    else{
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}
