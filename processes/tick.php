<?php

use Swoole\Server;

require "setup.php";

const PROCESS_PORT = 9503;

$server = new Server($_ENV['SERVER_HOST'], PROCESS_PORT, SWOOLE_BASE, SWOOLE_SOCK_UDP);

$server->set(
    [
        'worker_num' => 8,
        'daemonize' => false,
        'backlog' => 128,
    ]
);


$process = new Swoole\Process(
    static function ($process) use ($server) {
        $lastSecond = 0;
        while (true) {
            usleep($_ENV['TICK_RATE']);
            if (time() % 3 === 0 && $lastSecond !== time()) {
                $lastSecond = time();
                processLog('Tick ' . $lastSecond, basename(__FILE__));
            }
            $data = json_encode(
                [
                    'dispatch_time' => microtime()
                ],
                JSON_THROW_ON_ERROR
            );
            $pass = $_ENV['RCON_PASS'];
            $server->sendto('0.0.0.0', $_ENV['SERVER_PORT'], "tick|{$pass}|$data");
        }
    }, true
);

$server->on(
    'Packet',
    static function ($server, $clientInfo, $data) {
        //...
    }
);

$server->addProcess($process);

$server->start();