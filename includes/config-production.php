<?php

// Database Constants
defined("DB_SERVER") ? null : define("DB_SERVER", getenv("PIGGY_HOST"));
defined("DB_USER") ? null : define("DB_USER", getenv("PIGGY_USER"));
defined("DB_PASS") ? null : define("DB_PASS", getenv("PIGGY_PASSWORD"));
defined("DB_NAME") ? null : define("DB_NAME", getenv("PIGGY_NAME"));
defined("DB_PORT") ? null : define("DB_PORT", getenv("PIGGY_PORT"));
// defined("DB_NAME") ? null : define("DB_NAME", "monitor");

?>