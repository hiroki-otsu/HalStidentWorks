<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
require '../booststrap.php';
$session = new Session();
$dataAccess = new DataAccess();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|在籍確認画面</title>
<!--Import Google Icon Font-->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_enrollment.css" />
<!--Let browser know website is optimized for mobile-->
</head>
<body>
  <div id="wrapper">
    <div id="header">
      <div class="page-header">
        <div id="titile_box">
          <h1>HAL学生管理システム</h1>
        </div>
        <div id="userinfo_box">
          <h4>ログイン<b>:</b><?php echo $name = $session -> get("loginUser");?><a href="logout.php" >ログアウト</a></h4>
        </div><!-- end userinfo_box -->
      </div><!-- end page-header -->
    </div><!-- end header -->
    <div id="upside">
      <div id="breadcrumb_list_box">
        <ol class="breadcrumb">
          <li><a href="menu.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>メニュー画面</a></li>
          <li class="active">在籍確認画面</li>
        </ol>
      </div>
    </div><!-- end upside -->
    <div id="contents">
      <div id="side">
        <div id="link_navbox">
          <div class="panel panel-default">
            <div class="panel-heading"></div><!-- end panel-heading -->
              <div class="list-group">
                <a class="list-group-item size" href="menu.php">メニュー画面</a>
                <a class="list-group-item list-group-item-info"  href="events.php">在籍確認</a>
                <a class="list-group-item size"  href="events.php">イベント掲示板</a>
                <a class="list-group-item size" href="lost_article.php">忘れ物掲示板</a>
                <a class="list-group-item size" href="#!">????????????</a>
              </div>
          </div>
        </div><!-- end link_navbox -->
      </div><!-- end side -->
      <div id="seach_box">
        <div id="seach">
          <form class="input-group" action="" method="post">
            <input type="search" class="form-control" placeholder="テキスト入力欄"/>
            <span class="input-group-btn">
              <button type="button" class="btn btn-default">検索</button>
            </span>
          </form>
        </div>
      </div>
      <div id="teacher_list_box">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>名前</th>
              <th>在籍状況</th>
              <th>在籍ランプ</th>
              <th>更新日時</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $teacher = $dataAccess -> getTeacherList();
            foreach ($teacher as $value) {
              switch ($value['Enrollment_status']) {
                case 1:
                  $TeacherStatus ="在籍中";
                  $lamp="<div id='lamp_color_green'>";
                  break;
                case 2:
                  $TeacherStatus="離席中";
                  $lamp="<div id='lamp_color_orange'>";
                  break;
                default:
                  $TeacherStatus ="不在";
                  $lamp="<div id='lamp_color_gray'>";
                  break;
              }
              print("<tr>");
              print("<td>".$value['Teacher_Name'].PHP_EOL."</td>");
              print("<td>".$TeacherStatus."</td>");
              print("<td>".$lamp.PHP_EOL."</td>");
              print("<td>".$value['Enrollment_Time'].PHP_EOL."</td>");
              print("</tr>");
            }
            ?>
          </tbody>
        </table>
      </div><!-- end teacher -->
    </div><!-- end contents -->
  <div id="footer">
     <p>Footer Area</p>
   </div>
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>
