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
$session = new Session();
$access = new DataAccess();
$error = new Errors();

if($request->isPost()) {

    $current=$request->getPost('current');
    $newPass= $request->getPost('new');
    $confirmation=$request->getPost('confirmation');
    $flg =true;

    if(empty($current)){//入力された項目が[空白]かチェック
        echo '空白';
        $flg=false;
    }
    if(empty($newPass)){//入力された項目が[空白]かチェック
        echo '空白';
        $flg=false;
    }
    if(empty($confirmation)){//入力された項目が[空白]かチェック
        echo '空白';
        $flg=false;
    }
    if($flg){//もし空白があった場合false/無かった場合でtrue
        if($newPass===$confirmation){//新しいパスワードと確認で入力されたパスワードが同じか確認
            echo '同じ';
            $access->update($newPass,$student=$session->get('ohs50054'));
            header('Location: /php/HalStudentWorks/web/');//変更完了画面へ
        }
        else{
            echo '異なる';
        }
    }
    else {
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}