<?php

namespace App\Controller;

class AdminController extends Controller {
  public function getHome() {
    $this->render('admin/home.twig');
  }
}