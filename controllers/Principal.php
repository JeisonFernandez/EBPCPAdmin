<?php

class Principal extends Controller
{

  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['usuario'])) {
      header('Location: ' .  BASE_URL);
      die();
    }
    parent::__construct();
  }

  public function index()
  {
    $data['title'] = 'Principal';
    $data['usuario'] = $_SESSION['usuario'];
    $this->views->getView($this, "index", $data);
  }
}
