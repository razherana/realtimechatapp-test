<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Users</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
    }

    .user-list-container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .user-list-header {
      background-color: #4CAF50;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 1.5em;
    }

    .user-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .user-list li {
      padding: 15px;
      border-bottom: 1px solid #ddd;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .user-list li:last-child {
      border-bottom: none;
    }

    .user-list li:hover {
      background-color: #f1f1f1;
      cursor: pointer;
    }

    .user-name {
      font-size: 1.2em;
      color: #333;
    }

    .chat-button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9em;
    }

    .chat-button:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>
  <div class="user-list-container">
    <div class="user-list-header">Users to Chat With</div>
    <ul class="user-list">
      <?php foreach ($users as $user) : ?>
        <li>
          <span class="user-name"><?= $user['username'] ?></span>
          <a href="<?= route_to('chat_more', $user['username']) ?>" class="chat-button">Chat</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</body>

</html>