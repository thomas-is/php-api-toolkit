<?php

namespace NoLibForIt\API;

class Engine {

  /**
    * start the API engine
    * @static
    * @uses NoLibForIt\API\Request
    * @uses NoLibForIt\API\Answer
    **/
  public static function start() {

    $request = new Request;
    $answer  = new Answer;

    if( empty(API_SERVICE) ) {
      $answer
        ->plain("Undefined API_SERVICE.")
        ->close(500);
    }

    $serviceClass = @API_SERVICE[@$request->argv[0]];

    /* 404 on undefined service mapping */
    if( empty($serviceClass) ) {
      $answer
        ->plain("Not found")
        ->close(404);
    }

    /* 500 on mapped but undefined class */
    if( ! class_exists($serviceClass) ) {
      $answer
        ->plain("Class $serviceClass does not exist")
        ->close(500);
    }

    /* handle OPTIONS method */
    if( $request->method == "OPTIONS" ) {
      if( ! empty(@$serviceClass::ALLOW) ) {
        $answer->setHeader("Allow",implode(",",$serviceClass::ALLOW));
      }
      if( ! empty(@$serviceClass::CONTENT_TYPE) ) {
        $answer->setHeader("Content-Type",$serviceClass::CONTENT_TYPE);
      }
      $answer->ok();
    }

    $service = new $serviceClass($request);
    $service->handle();

    /* 520 on service no reply */
    $answer
      ->plain("Service ended with no reply")
      ->close(520);

  }

}

?>
