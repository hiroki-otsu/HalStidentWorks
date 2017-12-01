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
$inputId=null;
if ($request-> isPost()){
  $inputId=$request-> getPost("id");
  $inputPass=$request-> getPost("pass");
  if(empty($inputId)){
    $errormsg['id'] = "ユーザID入力されていません。";
  }
  if(empty($inputPass)){
    $errormsg['pass'] = "パスワードが入力されていません。";
  }
  if (!empty($inputId) && !empty($inputPass)) {
    $db = new DataAccess();
    $login=$db -> getLoginUserInformation($inputId,$inputPass);
    if($login){
      $session -> set("loginUser",$login[0]);
      header('Location: http://192.168.33.10/php/StudentWorks/web/menu.php');
    }else {
      $errormsg['loginMiss'] = "ユーザIDまたはパスワードが間違っています。";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|Top画面</title>
<!--Import Google Icon Font-->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin_enrollment.css" />
<!--Let browser know website is optimized for mobile-->
</head>
<body>
<div id="wrapper">
  <div id="header">
    <div class="page-header">
      <h1>HAL学生管理システム</h1>
   </div><!-- end page-header -->
  </div><!-- end header -->
  <div id="content">
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h2 class="panel-title">ログイン</h2>
    	</div><!-- end panel-heading -->
    	<div class="panel-body">
        <div id="error_box">
          <?php if (count($errormsg)): ?>
            <ul>
              <?php foreach ($errormsg as $msg): ?>
                <li>
                  <?php echo htmlspecialchars($msg,ENT_QUOTES,'UTF-8');?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div><!-- end error_box -->
        <div id="from_box">
          <form action="index.php" method="post">
          <table>
            <tr>
              <td colspan="2">
                <div class="input-group">
                  <span class="input-group-addon">ユーザーID</span>
                  <input type="search" name="id" value="<?=$inputId?>" class="form-control" placeholder="ユーザID" />
                </div><!-- end input-group -->
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="input-group">
                  <span class="input-group-addon">パスワード</span>
                  <input type="password" name="pass" value="" class="form-control" placeholder="パスワード"/>
                </div><!-- end input-group -->
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <input type="submit" name="login" value="ログイン"  class="btn btn-default btn-lg btn-block"/>
              </td>
            </tr>
          </table>
          </form>
        </div><!-- end from_box -->
    	</div><!-- end panel-body -->
    </div><!-- end panel panel-default -->
  </div><!-- end content -->
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>
