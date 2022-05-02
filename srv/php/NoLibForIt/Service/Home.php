<?php

namespace NoLibForIt\Service;

class Home extends \NoLibForIt\API\Service {

  public const ALLOW        = [ "GET" ];
  public const CONTENT_TYPE = "text/html";

  public function handle() {
    $this->answer
      ->body( "<h1>Home</h1>" )
      ->ok();
  }

}
?>
