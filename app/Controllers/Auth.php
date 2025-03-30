<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
  public function register()
  {
    $userModel = new User();
    $data = $this->request->getPost();

    // Hash password
    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
    $userModel->insert($data);

    return $this->response->setJSON(['message' => 'User registered']);
  }

  public function login()
  {
    $userModel = new User();
    $data = $this->request->getPost();

    $user = $userModel->where('email', $data['email'])->first();
    
    if ($user && password_verify($data['password'], $user['password'])) {
      session()->set('user_id', $user['id']);
      return $this->response->setJSON(['message' => 'Login successful', 'user_id' => $user['id']]);
    }

    return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid credentials']);
  }


  public function logout()
  {
    session()->destroy();
    return $this->response->setJSON(['message' => 'Logged out']);
  }
}
