<?php

use App\KernelInterface;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

require __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/ini.php';

$dotenv = Dotenv::createImmutable(PROJECT_PATH);
$dotenv->load();

/** @var ContainerInterface $container */
$container = include __DIR__ . '/container.php';

/** @var KernelInterface $kernel */
$kernel = $container->get(KernelInterface::class);

$kernel->setContainer($container);

$kernel->listen();
