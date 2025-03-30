<?php

namespace App\Controllers;

use App\Models\Message;

class Chat extends BaseController
{
  public function sendMessage()
  {
    $messageModel = new Message();
    $data = $this->request->getPost();
    $data['sender_id'] = session()->get('user_id'); // Ensure user is logged in
    $data['created_at'] = date('Y-m-d H:i:s');

    $messageModel->insert($data);

    return $this->response->setJSON(['message' => 'Message sent']);
  }

  public function getMessages($receiver_id)
  {
    $messageModel = new Message();
    $user_id = session()->get('user_id');

    $messages = $messageModel
      ->where("(sender_id = $user_id AND receiver_id = $receiver_id) OR (sender_id = $receiver_id AND receiver_id = $user_id)")
      ->orderBy('created_at', 'ASC')
      ->findAll();

    return $this->response->setJSON($messages);
  }
}
