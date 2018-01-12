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

if ($request-> isPost()) {
    $title=$request->getPost('title');
    $category=$request->getPost('category');
    $file=$_FILES["image"];
    $comment=$request->getPost('comment');
    $flg=true;
    if(empty($title)){
        $error->setErrors('タイトルが入力されていません');
        $flg=false;
        echo 'タイトル';
    }
    if(empty($category)){
        $error->setErrors('カテゴリーが選択されていません');
        $flg=false;
        echo 'カテゴリー';

    }
    if(empty($file)){
        $error->setErrors('ファイルが選択されていません');
        $flg=false;
        echo 'ファイル';
    }
    if(empty($comment)){
        $error->setErrors('コメントが入力されていません');
        $flg=false;
        echo 'コメント';
    }
    if ($flg){
        $student=$session->get('ohs50054');
        $tmp_name = $file['tmp_name']; // 一時ファイルのパス
        $tmp_size = getimagesize($tmp_name); // 一時ファイルの情報を取得
        $img = $extension = null;
        switch ($tmp_size[2]) { // 画像の種類を判別
            case 1 : // GIF
                $img = imageCreateFromGIF($tmp_name);
                $extension = 'gif';
                break;
            case 2 : // JPEG
                $img = imageCreateFromJPEG($tmp_name);
                $extension = 'jpg';
                break;
            case 3 : // PNG
                $img = imageCreateFromPNG($tmp_name);
                $extension = 'png';
                break;
            default : break;
        }
        $save_filename = date('YmdHis');
        $imageDirectory = 'image/lostArticle/' .$save_filename.'.'.$extension;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $imageDirectory)){
            $msg = $imageDirectory. 'のアップロードに成功しました';
            $access->setLostArticle($no,$title,$category,$comment,$imageDirectory,$student);
            header();
        }else {
            $msg = 'アップロードに失敗しました';
        }
        echo $msg;
    }
}
