<?php

namespace App\Controller;

use App\Form;
use App\Model\User;
use App\Router;

class AuthController extends Controller {
  public function getConnection() {
    $this->render('auth/login.twig', [
      'title' => 'Connexion',
    ]);
  }

  public function postConnection() {
    $errors = Form::validate($_POST, [], true);

    if (empty($errors)) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $user = User::findOne(['email' => $email]);

      if ($user && password_verify($password, $user->getPassword())) {
        $_SESSION['user'] = serialize($user);
        $type = $user->getType();
        Router::redirect($type === 'admin' ? '/admin/accueil' : '');
        return;
      }

      $errors['notFound'] = 'email ou mot de passe incorrect';
    }

    $this->render('auth/login.twig', [
      'title' => 'Connexion',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function logout() {
    unset($_SESSION['user']);
    Router::redirect('/');
  }
}