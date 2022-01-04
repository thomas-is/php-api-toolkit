<?php

namespace NoLibForIt\API;

abstract class Service {

  public const ALLOW        = [ "GET" ];
  public const CONTENT_TYPE = "text/plain";
  public const CHARSET      = "utf-8";

  public function __construct( Request $request ) {

    $this->request = $request;
    $this->answer  = new Answer($this::CHARSET);

    if( $this->request->method == "OPTIONS" ) {
      $this->replyOptions();
    }

    if( ! in_array($this->request->method,$this::ALLOW) ) {
      $this->answer
        ->plain("Method not allowed")
        ->close(405);
    }

  }

  public function handle() {
    $this->answer
      ->plain("Not implemented")
      ->close(501);
  }

  private function replyOptions() {

    if( ! empty($this::ALLOW) ) {
      $this->answer->setHeader("Allow",implode(",",$this::ALLOW));
    };

    if( ! empty($this::CONTENT_TYPE) ) {
      if( ! empty($this::CHARSET) ) {
        $this->answer->setHeader("Content-Type",$this::CONTENT_TYPE . "; charset=" . $this::CHARSET);
      } else {
        $this->answer->setHeader("Content-Type",$this::CONTENT_TYPE);
      }
    }

    $this->answer->ok();

  }

}

?>
