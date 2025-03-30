<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Real-Time Chat</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    #chat-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 10px;
      overflow-y: auto;
      border-bottom: 1px solid #ccc;
    }

    .message {
      margin: 5px 0;
      padding: 10px;
      border-radius: 5px;
    }

    .message.user {
      background-color: #d1e7dd;
      align-self: flex-end;
    }

    .message.other {
      background-color: #f8d7da;
      align-self: flex-start;
    }

    #input-container {
      display: flex;
      padding: 10px;
      border-top: 1px solid #ccc;
    }

    #message-input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    #send-button {
      margin-left: 10px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #send-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <h1>Chatting with <?= $username ?></h1>
  <div id="chat-container">
    <!-- Messages will be displayed here -->
    <?php foreach ($messages as $message) : ?>
      <div class="message <?= $message['sender_id'] == session()->get('user_id') ? 'user' : 'other' ?>">
        <?= htmlspecialchars($message['message']) ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div id="input-container">
    <input type="text" id="message-input" placeholder="Type your message here...">
    <button id="send-button">Send</button>
  </div>

  <script>
    const chatContainer = document.getElementById('chat-container');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');

    // Replace with your WebSocket server URL
    const socket = new WebSocket('ws://localhost:8081');

    socket.addEventListener('open', () => {
      socket.send(JSON.stringify({
        id: <?= session()->get('user_id') ?>
      }));
    });


    // Handle incoming messages
    socket.addEventListener('message', (event) => {
      const message = event.data;
      displayMessage(message, 'other');
    });

    // Send message on button click
    sendButton.addEventListener('click', () => {
      const message = messageInput.value.trim();
      if (message) {
        socket.send(JSON.stringify({
          receiver_id: <?= $user['id'] ?>,
          sender_id: <?= session()->get('user_id') ?>,
          message: message
        }));
        displayMessage(message, 'user');
        messageInput.value = '';
      }
    });

    // Display message in the chat container
    function displayMessage(message, type) {
      const messageElement = document.createElement('div');
      messageElement.classList.add('message', type);
      messageElement.textContent = message;
      chatContainer.appendChild(messageElement);
      chatContainer.scrollTop = chatContainer.scrollHeight;
    }
  </script>
</body>

</html>