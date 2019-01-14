<?php 

  ob_start();
  session_start();

  error_reporting(E_ALL);

  /**
   * Initialisations
   */

  // Register autoload function
  spl_autoload_register('myAutoloader');

  /**
   * Autoloader
   *
   * @param string $className  The name of the class
   * @return void
   */
  function myAutoloader($className)
  {
    require dirname(dirname(__FILE__)) . '/classes/' . $className . '.class.php';
  }

?>
