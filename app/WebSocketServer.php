<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'vendor/autoload.php';

class ChatServer implements MessageComponentInterface
{
  protected $clients;
  protected $mapped_client_ids;
  protected $db;

  public function __construct()
  {
    $this->clients = [];
    $this->mapped_client_ids = [];
    $this->db = new PDO('mysql:host=localhost;dbname=realtime_chatapp', 'razherana', '');
  }

  public function onOpen(ConnectionInterface $conn)
  {
    $this->clients[$conn->resourceId] = $conn;
  }

  public function onMessage(ConnectionInterface $from, $msg)
  {
    $data = json_decode($msg, true);

    if (isset($data['id'])) {
      $this->mapped_client_ids[$data['id']] = $from->resourceId;
      return;
    }

    $receiver_id = $data['receiver_id'];
    $senderId = $data['sender_id'];
    $message = $data['message'];

    $this->db->prepare('INSERT INTO messages (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?)')->execute([
      $senderId,
      $receiver_id,
      $message,
      date('Y-m-d H:i:s')
    ]);

    $this->mapped_client_ids[$senderId] = $from->resourceId;

    if (isset($this->mapped_client_ids[$receiver_id])) {
      $this->clients[$this->mapped_client_ids[$receiver_id]]->send($message);
    } else {
      foreach ($this->clients as $client) {
        if ($client !== $from) {
          $client->send($message);
        }
      }
    }
  }

  public function onClose(ConnectionInterface $conn)
  {
    $this->clients[$conn->resourceId] = null;
    unset($this->clients[$conn->resourceId]);
    foreach ($this->mapped_client_ids as $userId => $resourceId) {
      if ($resourceId == $conn->resourceId) {
        unset($this->mapped_client_ids[$userId]);
        break;
      }
    }
    echo "Connection {$conn->resourceId} has disconnected\n";
  }

  public function onError(ConnectionInterface $conn, \Exception $e)
  {
    echo "Error: {$e->getMessage()}\n";
    $conn->close();
  }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
  new HttpServer(new WsServer(new ChatServer())),
  8081
);
$server->run();
