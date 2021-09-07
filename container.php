<?php

use App\Component\Core\DIContainer;
use App\Exception\BuildException;
use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions(SERVICES_PATH);
//$builder->enableCompilation(__DIR__ . CACHE_PATH);
try {
    $container = $builder->build();
    DIContainer::setContainer($container);
    $container->set('routes', include ROUTES_PATH);
    $container->set('command_routes', include COMMAND_ROUTES_PATH);
} catch (Throwable $exception) {
    throw new BuildException($exception->getMessage());
}

return $container;
