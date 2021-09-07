<?php

require "vendor/autoload.php";
require "ini.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(PROJECT_PATH);
$dotenv->load();

function processLog(string $data, string $process = 'Unknown', string $severity = "DUMP")
{
    $now = date('H:i:s d.m.Y');
    $message = "[$now] {$process}: $data" . PHP_EOL;
    file_put_contents(SUBPROCESS_LOG_FILE, $message, FILE_APPEND);
}