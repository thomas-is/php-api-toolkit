<?php

define("DIR_SRV"         , "/srv"               );
define("DIR_PHP_CORE"    , DIR_SRV . "/core"    );
define("DIR_PHP"         , DIR_SRV . "/php"     );
define("DIR_WEBROOT"     , DIR_SRV . "/webroot" );

define("API_BASE_URI"    , "/api"           );
define("API_MAP_FILE"    , getenv("API_MAP_FILE")     ?: DIR_SRV . "/map.php");
define("API_AUTH_FILE"   , getenv("API_AUTH_FILE")    ?: DIR_SRV . "/token"  );
define("API_ALLOW_ORIGIN", getenv("API_ALLOW_ORIGIN") ?: "*"                 );

require_once(API_MAP_FILE);

?>
