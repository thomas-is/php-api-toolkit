<?php

namespace NoLibForIt\API;

class Answer {

  private string $_contentType = "";
  private string $_charset     = "";
  private array  $_header      = [];
  private string $_body        = "";

  public function __construct( string $contentType = "text/plain", string $charset = "utf-8" ) {
    $allowOrigin = getenv('API_ALLOW_ORIGIN');
    if( ! empty($allowOrigin) ) {
      $this->setHeader("Access-Control-Allow-Origin", $allowOrigin);
    }
    $this->contentType($contentType)->charset($charset);
  }

  public function header( string $key, string $value ): self {
    $this->_header[$key] = $value;
    return $this;
  }

  /* protected because should not be overriden by Service */
  protected function contentType( string $contentType ): self {
    $this->_contentType = $contentType;
    return $this;
  }
  /* protected because should not be overriden by Service */
  protected function charset( string $charset ): self {
    $this->_charset = $charset;
    return $this;
  }

  public function attachementName( string $filename ): self {
    return $this->header("Content-Disposition", "attachment; filename=".trim($filename));
  }

  public function body( string $body ): self {
    $this->_body = $body;
    return $this;
  }

  public function close( int $code ): never {
    $this->header( "Content-Type", "{$this->_contentType}; {$this->_charset}" );
    $protocol = @$_SERVER['SERVER_PROTOCOL'] ?: "HTTP/1.1";
    header( "$protocol $code");
    foreach( $this->_header as $key => $value ) {
      header( "$key: $value" );
    }
    die($this->_body);
  }

  public function ok(): never {
    return $this->close(200);
  }

  /* helpers, should be excluded */

  public function plain( string $text ): self {
    return $this
      ->contentType("text/plain")
      ->body($text);
  }

  public function html( string $html ): self {
    return $this
      ->contentType("text/html")
      ->body($html);
  }

  public function json( $obj ): self {
    return $this
      ->contentType("application/json")
      ->body( json_encode($obj, JSON_INVALID_UTF8_IGNORE) );
  }

  /**
    * format body into a CSV
    * @param array $assoc, array of associative array
    * @return self
    **/
  public function csv( array $assoc, string $separator = ";", string $filename = "array.csv" ): self {
    $csv = implode($separator, array_keys( (array) @$assoc[0] ));
    foreach( $assoc as $line ) {
      if( ! is_array($line) ) { continue; }
      $csv .= "\n" . implode($separator,$line);
    }
    return $this
      ->contentType("text/csv")
      ->attachementName($filename)
      ->body($csv);
  }

  public function pdf( string $file ): self {
    return $this
      ->contentType("application/pdf")
      ->body(file_get_contents($file));
  }

}

?>
