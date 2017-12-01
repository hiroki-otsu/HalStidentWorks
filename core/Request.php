<?php
/**
 * リクエスト情報を制御するクラス
 */
class Request
{
  /**
   *HTTPメソッドがPOSTか判定するメソッド
   *
   * @return boolean [description]
   */
  public function isPost()
  {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
      return true;
    }
    return false;
  }
  /**
   *$_GET[変数]から取得するメソッド
   *
   * @param  [type] $name    [description]
   * @param  [type] $default [description]
   * @return [type]          [description]
   */
  public function getGet($name, $default = null)
  {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $default;
  }
  /**
   *$_POST[変数]から取得するメソッド
   *
   * @param  [type] $name
   * @param  [type] $default
   * @return [type]          [description]
   */
  public function getPost($name, $default = null)
  {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $default;
  }
  /**
   *サーバのホスト名を取得するメソッド
   *
   * @return [type] [description]
   */
  public function getHost()
  {
    if (empty($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    }
    return $_SERVER['SERVER_NAME'];
  }
  /**
   *HTTPSでアクセスされたか判定するメソッド
   *
   * @return
   */
  public function isSsl()
  {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on') {
      return true;
    }
    return false;
  }
  /**
   *リクエストされたURLの情報を格納するメソッド
   *
   * @return ホスト部分以降の値を返す
   */
  public function getRequestUri()
  {
    return $_SERVER['REQUEST_URI'];
  }
}


 ?>
