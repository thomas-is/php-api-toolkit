<?php

namespace NoLibForIt\API;

/**
  * @uses NoLibForIt\API\Request
  * @uses NoLibForIt\API\Answer
  **/
class Engine {

  /**
    * @static
    **/
  public static function start() {

    $request = new Request;
    $answer  = new Answer;

    if( ! class_exists(API_MAP_CLASS) ) {
      $answer
        ->plain("Missing API_MAP_CLASS: '" . API_MAP_CLASS ."'")
        ->close(500);
    }

    $mapClass = API_MAP_CLASS;
    $serviceClass = @$mapClass::SERVICE[@$request->argv[0]];

    if( empty($serviceClass) ) {
      $answer
        ->plain("Not found.")
        ->close(404);
    }

    if( ! class_exists($serviceClass) ) {
      $answer
        ->plain("Class $serviceClass does not exist")
        ->close(500);
    }

    $service = new $serviceClass($request);
    $service->handle();

    $answer
      ->plain("Service ended with no reply")
      ->close(520);

  }

}

?>
