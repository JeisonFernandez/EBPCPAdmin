<?php
 
  class Conexion {
    private $connect;

    public function __construct() {
      $pdo = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";".DB_CHARSET;

      try {
        $this->connect = new PDO($pdo, DB_USER, DB_PASS);
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Error de conexion a la bd: " . $e->getMessage();
      }
    }

    public function conectar(){
      return $this->connect;
    }
  }