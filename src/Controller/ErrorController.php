<?php

namespace App\Controller;

class ErrorController extends Controller {
  public function get404() {
    $this->render('404.twig');
  }

  public function get500() {
    $this->render('500.twig');
  }
}