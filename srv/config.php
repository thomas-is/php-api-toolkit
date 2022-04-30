<?php

define("DIR_SRV"         , "/srv"          );
define("DIR_PHP"         , "/srv/php"      );
define("DIR_WEBROOT"     , "/srv/webroot"  );
define("API_BASE_URI"    , "/api"          );
define("API_MAP_FILE"    , getenv("API_MAP_FILE")     ?: "/srv/map.php");
define("API_AUTH_FILE"   , getenv("API_AUTH_FILE")    ?: "/srv/token" );
define("API_ALLOW_ORIGIN", getenv("API_ALLOW_ORIGIN") ?: "*"          );

require_once(API_MAP_FILE);

?>
