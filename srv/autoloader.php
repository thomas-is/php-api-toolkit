<?php
require_once('config.php');
/**
 *   @autoloader
 **/
spl_autoload_register(
  function ($class) {
    $location = [ DIR_PHP_CORE, DIR_PHP ];
    foreach( $location as $dir ) {
      $file = $dir.DIRECTORY_SEPARATOR.str_replace('\\',DIRECTORY_SEPARATOR,$class).'.php';
      if( file_exists($file) ) {
        require_once($file);
        return;
      }
    }
    error_log("[".__FILE__."] file not found: ".$file);
  }
);
?>
