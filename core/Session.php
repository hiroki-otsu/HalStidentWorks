<?php
/**
 * セッション情報を管理するクラス
 */
class Session
{
  protected static $sessionStarted = false;
  protected static $sessionIdRegenerated = false;
/**
 *セッション自動開始メソッド
 *
 * @param [type] argument [description]
 */
  public function __construct()
  {
    if (!self::$sessionStarted) {
      session_start();
      self::$sessionStarted = true;
    }
  }

  public function set($name,$value)
  {
    $_SESSION[$name] = $value;
  }

  public function get($name,$default = null)
  {
    if (isset($_SESSION[$name])) {
      return $_SESSION[$name];
    }
    return $default;
  }

  public function remove($name)
  {
    unset($_SESSION[$name]);
  }
  public function clear()
  {
    $_SESSION = array();
  }
  /**
   *セッションIDを新しく発行するメソッド
   *
   * @param  boolean $destroy [description]
   * @return [type]           [description]
   */
  public function regenerate($destroy = true)
  {
    if (!self::$sessionIdRegenerated) {
      session_regenerate_id($destroy);

      self::$sessionIdRegenerated = true;
    }
  }
  /**
   * ログイン状態を制御するメソッド
   *
   * @param [type] $bool [description]
   */
  public function setAuthenticated($bool)
  {
    $this->set('_authenticated',(bool)$bool);

    $this->regenerate();
  }
  /**
   * ログイン状態を制御するメソッド
   *
   * @param string $value [description]
   */
  public function isAuthenticated()
  {
    return $this->get('_authenticated',false);
  }
}
 ?>
