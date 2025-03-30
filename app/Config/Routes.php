<?php

use App\Controllers\Chat;
use App\Models\Message;
use App\Models\User;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('register', 'Auth::register');

$routes->get('login', function () {
  return view('login');
});

$routes->get('/', function () {
  return view('login');
});
$routes->post('login', 'Auth::login');

$routes->get('logout', 'Auth::logout');

$routes->post('send-message', 'Chat::sendMessage');
$routes->get('messages/(:num)', 'Chat::getMessages/$1');

$routes->get('chat', function () {
  // Check if the user is logged in
  if (!session()->has('user_id')) {
    return redirect()->to('/login');
  }
  // Get the logged in user
  $loggedInUser = new User()->find(session()->get('user_id'));
  if (!$loggedInUser) {
    return redirect()->to('/login');
  }
  // Get the users to chat with
  $userModel = new User();
  $users = $userModel->where('id !=', $loggedInUser['id'])
    ->findAll();
  return view('chat', compact('users'));
});

$routes->get('chat/(:any)', function ($username) {
  // Check if the user is logged in
  if (!session()->has('user_id')) {
    return redirect()->to('/login');
  }
  // Get the user talk to
  $user = new User()->where('username', $username)->first();
  if (!$user)
    return redirect()->to('/chat');

  // Get the logged in user
  $loggedInUser = new User()->find(session()->get('user_id'));
  if (!$loggedInUser)
    return redirect()->to('/login');

  // Check if the logged in user is the same as the user being talked to
  if ($loggedInUser['id'] === $user['id']) {
    return redirect()->to('/chat');
  }

  // Get the messages between the two users
  $messageModel = new Message();
  $messages = $messageModel->where('sender_id', $loggedInUser['id'])
    ->where('receiver_id', $user['id'])
    ->orWhere('sender_id', $user['id'])
    ->where('receiver_id', $loggedInUser['id'])
    ->orderBy('created_at', 'ASC')
    ->findAll();

  return view('chat-more', ['username' => $username, 'messages' => $messages, 'user' => $user]);
}, ['as' => 'chat_more']);
