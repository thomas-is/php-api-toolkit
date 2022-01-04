<?php

namespace NoLibForIt\API;

class Answer {

  private array  $header  = [];
  private string $body    = "";
  private string $charset = "utf-8";

  public function __construct( string $charset = "utf-8") {
    $this->charset = $charset;
    $allowOrigin = getenv('API_ALLOW_ORIGIN');
    if( ! empty($allowOrigin) ) {
      $this->setHeader("Access-Control-Allow-Origin", $allowOrigin);
    }
  }

  public function json( $obj ) {
    $this->setHeader("Content-Type", "application/json; charset={$this->charset}");
    $this->body = json_encode($obj, JSON_INVALID_UTF8_IGNORE);
    return $this;
  }

  public function plain( string $text ) {
    $this->setHeader("Content-Type", "text/plain; charset={$this->charset}");
    $this->body = $text;
    return $this;
  }

  public function ok() {
    return $this->close(200);
  }

  public function close( int $code ) {
    $protocol = @$_SERVER['SERVER_PROTOCOL'] ?: "HTTP/1.1";
    header( "$protocol $code");
    foreach( $this->header as $key => $value ) {
      if( empty($value) ) {
        continue;
      }
      header( "$key: $value" );
    }
    die($this->body);
  }

  public function setHeader( string $key, string $value ) {
    $this->header[$key] = $value;
    return $this;
  }

}

?>
