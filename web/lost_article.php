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
$inputTitle=null;
$inputComment=null;
if ($request-> isPost()){
  $inputTitle=$request-> getPost("title");
  $inputComment=$request-> getPost("comment");
  if(empty($inputTitle)){
    $errormsg['title'] = "タイトルが入力されていません。";
  }
  if(empty($inputComment)){
    $errormsg['comment'] = "コメントが入力されていません。";
  }
  if (!empty($inputTitle) && !empty($inputComment)) {
    if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
      if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "img/" . $_FILES["upfile"]["name"])) {
        chmod("img/" . $_FILES["upfile"]["name"], 0644);
        $file = $_FILES["upfile"]["name"];

        $time = date("Y/m/d H:i:s");
        $db = new DataAccess();

        $no=$db-> getMaxLostArticleNo();

        $db -> setLostArticle($no,$inputTitle,$inputComment,$file,$time);

        echo $_FILES["upfile"]["name"] . "をアップロードしました。";
      } else {
        $errormsg['file'] = "ファイルをアップロードできません。";
      }
    } else {
      $errormsg['file'] = "ファイルが選択されていません。";
    }
  }
}
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|忘れ物掲示板</title>
<!--Import Google Icon Font-->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin_enrollment.css" />
<!-- <link type="text/css" rel="stylesheet" href="css/desin_index.css" /> -->
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
   <div id="nav_box">
     <ol class="breadcrumb">
    	<li><a href="menu.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>メニュー画面</a></li>
    	<li class="active">忘れ物掲示板</li>
    </ol>
  </div><!--end nav_box -->
  <div id="content">
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h4 class="panel-title">忘れ物投稿フォーム</h4>
    	</div>
      <div class="panel-body">
        <?php if (count($errormsg)): ?>
          <ul>
            <?php foreach ($errormsg as $msg): ?>
              <li>
                <?php echo htmlspecialchars($msg,ENT_QUOTES,'UTF-8');?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
      <form class="form-horizontal" action="lost_article.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="Title">タイトル</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title" placeholder="タイトル">
          </div>
        </div><!-- end form-group -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="Comment">コメント</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="comment" placeholder="コメント">
          </div>
        </div><!-- end form-group -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="upload">ファイル</label>
          <div class="col-sm-10">
            <input type="file" name="upfile" size="30" id="upload">
          </div>
        </div><!-- end form-group -->
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" class="btn btn-default" value="アップロード">
          </div>
        </div><!-- end form-group -->
      </form>
    	</div>
    </div>
    <div class="page-header">
    	<h4>忘れ物一覧</h4>
    </div>
    <div id="imeage_box">
      <div class="col-xs-6 col-md-3">
        <?php
          $dataAccess = new DataAccess();
          $lostArticles = $dataAccess -> getLostArticlesList();
          foreach ($lostArticles as $value) {
            print("<div class='thumbnail'>");
            print("<img src='img/".$value['LostArticle_Image'].PHP_EOL."' width=150px height=150px />");
            print("<div class='caption'>");
            print("<p>[タイトル]".$value['LostArticle_Title'].PHP_EOL."</p>");
            print("<p>[コメント]".$value['LostArticle_comment'].PHP_EOL."</p>");
            print("<p>[投稿日時]".$value['LostArticle_Time'].PHP_EOL."</p>");
            print("</div>");
            print("</div>");
          }
          ?>
      </div>
    </div><!-- end imeage_box -->
  </div><!-- end content -->
  <div id="footer">
    <div id="footer_box"></div><!-- end footer_box -->
  </div><!-- end footer -->
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>
