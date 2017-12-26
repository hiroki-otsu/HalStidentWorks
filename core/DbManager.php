<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
/**
 * データベースに接続するクラス
 */
class DbManager
{
  const DSN ="mysql:host=localhost;dbname=StudentWorks;charset=utf8";//データベース名
  const USER_NAME ="root";//ユーザー名
   const PASSWORD ="root";//パスワード

  public function DbConnection() {
    $db = new PDO(self::DSN,self::USER_NAME,self::PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }
}
?>
