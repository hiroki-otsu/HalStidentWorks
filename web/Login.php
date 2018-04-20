<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
require '../bootstrap.php';
$session = new Session();
$request = new Request();
$access = new DataAccess();
$error = new Errors();
if ($request->isPost()) {

    $student=$request->getPost('student');
    $pass = $request->getPost('pass');
    $flg = true;
    if (empty($student)){
        $error->setErrors('ユーザIDが入力されていません');
        $flg = false;
    }
    if(empty($pass)){
        $error->setErrors('パスワードが入力されていません');
        $flg = false;
    }
    if ($flg){
        $user = $access->getLoginUserInformation($student);
        if(password_verify($pass,$user[1])){
            $userName = $student.':'.$user[0];
            $session ->set($student,$userName);
            header('Location: /php/HalStudentWorks/web/home.php');
        }
    }else{
        $error->setErrors('パスワードかユーザIDが間違っています');
    }
}else{
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
