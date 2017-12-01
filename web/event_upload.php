<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../booststrap.php';
//インスタンス化
$session = new Session();//セッションクラス
$request = new Request();//リクエストクラス
//エラー文字を格納する配列
$errormsg = array();
if ($request-> isPost()){
  $inputTitle=$request-> getPost("title");
  $inputDate=$request-> getPost("eventdate");
  $inputComment=$request-> getPost("comment");
  echo $inputTitle;
  echo $inputDate;
  echo $inputComment;
  if(empty($inputTitle)){
    $errormsg['title'] = "タイトルが入力されていません。";
  }
  if(empty($inputDate)){
    $errormsg['date'] = "開催日が選ばれていません。";
  }
  if(empty($inputComment)){
    $errormsg['comment'] = "内容が入力されていません。";
  }
  if (count($errormsg)){
     foreach ($errormsg as $msg){
       echo htmlspecialchars($msg,ENT_QUOTES,'UTF-8');
     }
  }
  if(!empty($inputTitle) && !empty($inputDate) && !empty($inputComment)){
    $data = new DataAccess();
    $time = date("Y/m/d H:i:s");
    $name = $session -> get("loginUser");
    $userId = $data->getUserId($name);
    $no=$data ->getMaxEventNo();
    $setEvent =$data -> setEvent($no,$userId,$inputTitle,$inputComment,$inputDate,$time);
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|メニュー画面</title>
<!--Import Google Icon Font-->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/html5reset-1.6.1.css" />
<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
<link type="text/css" rel="stylesheet" href="css/desin_menu.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
<!--Let browser know website is optimized for mobile-->
</head>
<body>
<div id="wrapper">
   <div id="header">
     <div class="page-header">
        <h1>HAL学生管理システム　　        <small>サブ・テキスト</small></h1>
        <div id="userinfo_box">
          <p><?php echo $name = $session -> get("loginUser");?>さんがログイン中</p>
          <a href="logout.php" >ログアウト</a>
        </div><!-- end userinfo_box -->
       </div><!-- end header -->
    </div><!-- end page-header -->
    <div id="nav_box"></div><!-- end nav_box -->
    <div id="content"></div><!-- end content -->
  <div id="footer">
    <div id="footer_box"></div><!-- end footer_box -->
  </div><!-- end footer -->
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>
