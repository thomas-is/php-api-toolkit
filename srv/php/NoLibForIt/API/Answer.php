<?php

namespace NoLibForIt\API;

class Answer {

  private array  $header       = [];
  private string $body         = "";
  private string $contentType  = "";
  private string $charset      = "";

  public function __construct( $contentType = "text/plain", $charset = "utf-8" ) {

    $this->contentType = $contentType;
    $this->charset     = $charset;

    $allowOrigin = getenv('API_ALLOW_ORIGIN');
    if( ! empty($allowOrigin) ) {
      $this->setHeader("Access-Control-Allow-Origin", $allowOrigin);
    }

  }

  private function contentTypeHeader() {
    $this->setHeader('Content-Type',$this->contentType."; ".$this->charset);
  }

  public function reset() {
    return new Answer($this->contentType,$this->charset);
  }

  public function json( $obj ) {
    $this->contentType = "application/json";
    $this->contentTypeHeader();
    $this->body = json_encode($obj, JSON_INVALID_UTF8_IGNORE);
    return $this;
  }

  public function plain( string $text ) {
    $this->contentType = "text/plain";
    $this->contentTypeHeader();
    $this->body = $text;
    return $this;
  }
  public function pdf( string $file ) {
    $this->setHeader("Content-Type","application/pdf");
    $this->body = file_get_contents($file);
    return $this;
  }

  public function ok() {
    return $this->close(200);
  }

  public function close( int $code ) {
    $protocol = @$_SERVER['SERVER_PROTOCOL'] ?: "HTTP/1.1";
    header( "$protocol $code");
    foreach( $this->header as $key => $value ) {
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
