<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|教室検索・予約</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/themes/default.css">
<link type="text/css" rel="stylesheet" href="css/themes/default.date.css">
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_classroom.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
  <div id="nav" class="z-depth-3">
    <div id="logo">
      <img src="" width="" height="" alt=""/>
    </div>
    <div id="menu">
      <ul>
        <li class="menubar"><a href="home.php"><img src="image/icon/ic_home_black_24dp_1x.png" width="24" height="24" alt="home"/>Home</a></li>
        <li class="menubar"><a href="enrollment.php"><img src="image/icon/ic_airline_seat_recline_extra_black_24dp_1x.png" width="24" height="24" alt="座席確認"/>在籍確認</a></li>
        <li class="menubar"><a href="events.php"><img src="image/icon/ic_event_note_black_24dp_1x.png" width="24" height="24" alt="イベント掲示板"/>イベント掲示板</a></li>
        <li class="menubar"><a href="lost_article.php"><img src="image/icon/ic_live_help_black_24dp_1x.png" width="24" height="24" alt="忘れ物掲示板"/>忘れ物掲示板</a></li>
        <li class="menubar"><a href="classroom.php"><img src="image/icon/ic_search_black_24dp_1x.png" width="24" height="24" alt="教室予約"/>教室検索・予約</a></li>
      </ul>
    </div>
  </div>
  <div id="contents">
    <div id="header">
      <div id="title">
        <h2>HAL Students System</h2>
      </div>
      <div id="user">
        <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/>ohs50054:大津裕幹</a></p>
      </div>
    </div><!-- end header -->
    <div id="reservation">
      <form action="#" method="get">
      <div id="roomlanport"><!-- Lan_port(LANﾎﾟｰﾄ)-->
        LANポート
        <input class="with-gap" name="lan" type="radio" id="lantrue"  checked/>
        <label for="lantrue">有り</label>
        <input class="with-gap" name="lan" type="radio" id="lanfalse"  />
        <label for="lanfalse">無し</label>
      </div>
      <div id="roompowerport"><!--Power_port(電源ﾎﾟｰﾄ) -->
        電源ポート
        <input class="with-gap" name="power" type="radio" id="powertrue"  checked/>
        <label for="powertrue">有り</label>
        <input class="with-gap" name="power" type="radio" id="powerfalse"  />
        <label for="powerfalse">無し</label>
      </div>
      <div id="roomsize"><!-- size(教室のサイズ)  -->
        教室サイズ
        <input class="with-gap" name="size" type="radio" id="size_s"  checked/>
        <label for="size_s">S</label>
        <input class="with-gap" name="size" type="radio" id="size_m"  />
        <label for="size_m">M</label>
        <input class="with-gap" name="size" type="radio" id="size_l"  />
        <label for="size_l">L</label>
      </div>
      <div id="roomfloor">
        <div class="input-field col s12">
          <select>
            <option value="" disabled selected>floor</option>
            <option value="1">3</option>
            <option value="2">4</option>
            <option value="3">5</option>
          </select>
        </div>
      </div>
      <div id="roomsarch">
        <a  class="waves-effect waves-light btn">検索</a>
      </div>

    </form>
    </div><!-- reservation -->
    <div id="plans">
      <div id="roomlist"><!--list(教室リスト) -->
        <table class="centered highlight">
          <thead>
            <tr>
                <th>教室</th>
                <th>LANポート</th>
                <th>電源ポート</th>
                <th>サイズ</th>
                <th>空き状況確認</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>161</td>
              <td>有</td>
              <td>有</td>
              <td>L</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
            <tr>
              <td>162</td>
              <td>有</td>
              <td>有</td>
              <td>S</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
            <tr>
              <td>163</td>
              <td>有</td>
              <td>有</td>
              <td>S</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
            <tr>
              <td>164</td>
              <td>有</td>
              <td>有</td>
              <td>S</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
            <tr>
              <td>165</td>
              <td>無</td>
              <td>無</td>
              <td>S</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
            <tr>
              <td>171</td>
              <td>有</td>
              <td>有</td>
              <td>S</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
            <tr>
              <td>172</td>
              <td>有</td>
              <td>有</td>
              <td>S</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">確認</a></td>
            </tr>
          </tbody>
        </table>
      </div><!-- list  -->
    </div><!-- plans -->

    <!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4>161教室</h4>
        <table class="centered highlight">

          <tbody>
            <tr>
              <td>1限目</td>
              <td>×</td>
              <td>使用中</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>
            </tr>
            <tr>
              <td>2限目</td>
              <td>〇</td>
              <td>空き</td>
              <td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
      </div>
    </div>

    <div id="footer">
      <footer>2017 HAL Students System</footer>
    </div><!-- footer -->
  </div><!-- end contents -->
</div><!-- end wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/check.js"></script>
<script type="text/javascript" src="js/model.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/legacy.js"></script>
<script type="text/javascript" src="js/lang-ja.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/picker.js"></script>
<script type="text/javascript" src="js/picker.date.js"></script>
</body>
</html>
