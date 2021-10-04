<?php

namespace App\Controller;

class MainController extends Controller {

  public function getHome() {
    $this->render('home.twig');
  }
}