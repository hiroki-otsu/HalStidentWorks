<?php
/**
 * クラスを自動的に読み込むクラス
 *
 */
class ClassLoader
{
  protected $dirs;

  function register()
  {
    spl_autoload_register(array($this,'loadClass'));
  }

  public function registerDir($dir)
  {
    $this->dirs[]=$dir;
  }

  public function loadClass($class)
  {
    foreach ($this->dirs as $dir) {
      $file = $dir . '/' . $class . '.php';
      if (is_readable($file)) {

        require $file;
      }
    }
  }
}

 ?>
