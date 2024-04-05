<?php
 
  class Views {
    public function getView($controlador, $vista, $data = ""){
      $controlador = get_class($controlador);

      if ($controlador == "Home") {
        $vista = "views/".$vista.".php";
      }else {
        $vista = "views/".$controlador."/".$vista.".php";
      }
      require $vista;
    }
  }