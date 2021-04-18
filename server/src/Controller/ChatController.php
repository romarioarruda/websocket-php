<?php

namespace App\WebSockets\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class ChatController implements MessageComponentInterface
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "Nova conexão de {$conn->resourceId}" . PHP_EOL;
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo 'Fechando ' . PHP_EOL;
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "ocorreu um erro: {$e->getMessage()}\n";

        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Recebendo mensagem de $from->resourceId\n";

        foreach ($this->clients as $client) {
            if ($client !== $from) $client->send(json_encode(['type' => 'chat', 'text' => $msg]));
        }
    }
}
