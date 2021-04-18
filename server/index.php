<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSockets\Controller\ChatController;

require __DIR__ . '/vendor/autoload.php';


$port = 8081;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatController()
        )
    ),
    $port
);

$server->run();
