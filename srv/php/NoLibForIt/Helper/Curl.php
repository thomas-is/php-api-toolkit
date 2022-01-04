<?php

namespace NoLibForIt\Helper;

class Curl {

  public  $statusCode;
  public  $header = [];
  public  $answer;
  private $options = [];

  /**
    * to($url)
    * @param  string $url
    * @return $this
    * set CURLOPT_URL (location)
    **/
  public function to( string $url ) {
    $this->options[CURLOPT_URL] = $url;
    return $this;
  }

  public function asArray() {
    return json_decode( $this->answer, true );
  }
  public function asObject() {
    return json_decode( $this->answer, false );
  }

  /**
    * withHeader($header)
    * @param  string $header
    * @return $this
    * append $header to CURLOPT_HTTPHEADER
    *
    * $header **must** be a properly formated  HTTP header
    * @example
    *   $curl->to("https://foo.org")
    *   ->withHeader("Accept-Encoding: gzip, deflate, br")
    *   ->get()
    **/
  public function withHeader( string $header ) {
    $this->options[CURLOPT_HTTPHEADER][] = $header;
    return $this;
  }

  /**
    * withJson()
    * append the proper "Content-Type" HTTP header to CURLOPT_HTTPHEADER
    * set CURLOPT_POSTFIELDS to a json encoded body
    * @return $this
    **/
  public function withJson($body) {
    $this->options[CURLOPT_HTTPHEADER][] = "Content-Type: application/json";
    $this->options[CURLOPT_POSTFIELDS]   = json_encode($body);
    return $this;
  }

  /**
    * get()
    * performs a GET request (default)
    * @return $this
    **/
  public function get() {
    $this->options[CURLOPT_CUSTOMREQUEST] = 'GET';
    return $this->query();
  }

  /**
    * post()
    * performs a POST request
    * @return $this
    **/
  public function post() {
    $this->options[CURLOPT_CUSTOMREQUEST] = 'POST';
    return $this->query();
  }

  /**
    * put()
    * performs a PUT request
    * @return $this
    **/
  public function put() {
    $this->options[CURLOPT_CUSTOMREQUEST] = 'PUT';
    return $this->query();
  }

  /**
    * patch()
    * performs a PATCH request
    * @return $this
    **/
  public function patch() {
    $this->options[CURLOPT_CUSTOMREQUEST] = 'PATCH';
    return $this->query();
  }

  /**
    * delete()
    * performs a DELETE request
    * @return $this
    **/
  public function delete() {
    $this->options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
    return $this->query();
  }

  /**
    * query()
    * performs the request
    * @return $this
    **/
  private function query() {

    $this->options[CURLOPT_RETURNTRANSFER] = true;
    $this->options[CURLOPT_FOLLOWLOCATION] = true;
    $this->options[CURLOPT_HEADER] = true;

    $ch = curl_init();

    curl_setopt_array( $ch, $this->options );

    $packet = curl_exec($ch);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

    $this->header     = self::parseLastHeader( substr($packet,0,$headerSize) );
    $this->answer     = substr($packet,$headerSize);
    $this->statusCode = curl_getinfo($ch)['http_code'];

    curl_close($ch);
    $this->options = [];

    return $this;

  }

  /**
    * parseLastHeader
    *
    * @param  string  raw HTTP headers
    * @return array   last response $header
    *
    **/
  private static function parseLastHeader( string $text ) {

    $block = [[]];
    $lines = explode("\n",$text);

    $part = 0;
    foreach( $lines as $line) {
      if( empty(rtrim($line)) ) {
        $part++;
      } else {
        $block[$part][] = rtrim($line);
      }
    }

    $last = array_pop($block);

    $header = [];
    foreach( $last as $line ) {
      $field = explode(": ",$line,2);
      if( empty(@$field[1]) ) {
        $header['HTTP'] = $field[0];
      } else {
        $header[$field[0]] = $field[1];
      }
    }

    return $header;

  }


}
