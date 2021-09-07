<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

const PROJECT_PATH = __DIR__;
const SERVICES_PATH = PROJECT_PATH . "/config/services.php";
const CACHE_PATH = PROJECT_PATH . "/var/cache";
const ROUTES_PATH = PROJECT_PATH . "/config/routes.php";
const COMMAND_ROUTES_PATH = PROJECT_PATH . "/config/command_routes.php";
const DUMP_LOG_PATH = PROJECT_PATH . "/var/log/dump.log";

const SUBPROCESS_LOG_FILE = PROJECT_PATH . '/var/log/subprocess.log';
