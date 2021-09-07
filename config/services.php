<?php

/**
 * Loading all the services from services folder
 */

$definitions = [];

foreach (scandir(__DIR__ . '/services') as $file) {
    if (!in_array($file, ['.', '..'], true)) {
        $definitions = array_merge($definitions, require __DIR__ . '/services' . "/$file");
    }
}

return $definitions;
