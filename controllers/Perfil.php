<?php
 
  class Perfil extends Controller{
    public function __construct() {
      session_start();
      if(!isset($_SESSION["usuario"])){
        header('Location: ' . BASE_URL);
        die();
      }
      parent::__construct();
    }

    public function index(){
      $data['usuario'] = $_SESSION['usuario'];
      $data['script'] = 'perfil.js';
      $this->views->getView($this, "index", $data);
    }
  }