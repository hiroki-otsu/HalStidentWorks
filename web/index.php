<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_index.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="title">
            <h2>HAL Students System</h2>
        </div>
    </div><!-- end header -->
    <div id="contents">
        <div id="login-form">

            <ul class="collection with-header">
                <li class="collection-item">ログインフォーム</li>
                <li class="collection-item">
                    <form action="Login.php" method="post">
                        <div id="error-msg">
                            <ul>
                                <?php
                                $error = new Errors();
                                $error->getErrors();
                                ?>
                            </ul>
                        </div>
                        <div class="input-field" id="login-student">
                            <input id="user" type="text" name="student" value="" class="validate">
                            <label for="user">ユーザID</label>
                        </div>
                        <div class="input-field" id="login-pass">
                            <input id="pass" type="password" name="pass" value="" class="validate">
                            <label for="pass">パスワード</label>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action" id="btn-login">ログイン
                            <i class="material-icons right">send</i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div><!-- end contents -->
    <div id="footer">
        <footer>2017 HAL Students System</footer>
    </div><!-- footer -->
</div><!-- end wrapper -->

<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>

