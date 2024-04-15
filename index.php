<?php
  require_once 'assets/vendor/autoload.php';

  require_once "config/Config.php";

  $ruta = empty($_GET['url']) ? 'Home/index' : $_GET['url'];
  
  $arrRuta = explode('/', $ruta);

  $controller = $arrRuta[0];
  $metodo = "index";
  $parametro = "";

  if (!empty($arrRuta[1])) {
    if (!empty($arrRuta[1]) != "") {
      $metodo = $arrRuta[1];
    }
  }

  if (!empty($arrRuta[2])) {
    if (!empty($arrRuta[2]) != "") {
      for ($i=2; $i < count($arrRuta); $i++) { 
        $parametro .= $arrRuta[$i] . ",";
      }
      $parametro = trim($parametro, ",");
    }
  }
  
  require_once 'config/app/Autoload.php';

  $dirController = "controllers/".$controller.".php";

  if (file_exists($dirController)) {
    require_once $dirController;
    $controller = new $controller();

    if (method_exists($controller, $metodo)) {
      $controller->$metodo($parametro);
    }else{
      require_once "views/Pagenotfound/index.php";
    }
  }else {
    require_once "views/Pagenotfound/index.php";
  }