<?php

/**
 * Loading all the services from services folder
 */

$definitions = [];

foreach (scandir(__DIR__ . '/command_routes') as $file) {
    if (!in_array($file, ['.', '..'], true)) {
        $definitions = array_merge($definitions, require __DIR__ . '/command_routes' . "/$file");
    }
}

return $definitions;
