<?php

namespace NoLibForIt\API;

class Map {

  public const SERVICE = array(
    "ping"    => "\NoLibForIt\Service\Ping",
    "ip"      => "\NoLibForIt\Service\Ip",
    "server"  => "\NoLibForIt\Service\DumpServer",
  );

}
