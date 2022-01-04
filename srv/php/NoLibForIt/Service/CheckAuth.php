<?php

namespace NoLibForIt\Service;

class CheckAuth {

  public const ALLOW        = [ "GET", "POST", "PUT", "PATCH" ];
  public const CONTENT_TYPE = "text/plain; charset=utf-8";

  public static function handle($request) {
    $this->request->requiresAuth();
    $this->answer
      ->plain("{$this->request->method} access granted")
      ->ok();
  }

}

?>
