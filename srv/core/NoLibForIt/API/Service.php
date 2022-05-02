<?php

namespace NoLibForIt\API;

abstract class Service {

  public const ALLOW        = [ ];
  public const CONTENT_TYPE = "text/plain";
  public const CHARSET      = "utf-8";

  public function __construct(Request $request) {
    $this->request = $request;
    /* do not use self as it would refer to parent in child context */
    $this->answer  = new Answer($this::CONTENT_TYPE,$this::CHARSET);
    if( ! in_array($this->request->method,$this::ALLOW ) ) {
      $this->notAllowed();
    }
  }

  protected function notAllowed() {
    $this->answer
      ->body("Not allowed")
      ->close(405);
  }

  public function handle() {
    $this->answer
      ->body("Not implemented")
      ->close(501);
  }

}

?>
