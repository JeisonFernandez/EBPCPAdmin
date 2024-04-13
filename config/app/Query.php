<?php
class Query extends Conexion
{
  private $pdo, $con, $sql, $datos;
  public function __construct()
  {
    $this->pdo = new Conexion();
    $this->con = $this->pdo->conectar();
  }
  public function select(string $sql)
  {
    $this->sql = $sql;
    $resul = $this->con->prepare($this->sql);
    $resul->execute();
    $data = $resul->fetch(PDO::FETCH_ASSOC);
    return $data;
  }
  public function selectAll(string $sql)
  {
    $this->sql = $sql;
    $resul = $this->con->prepare($this->sql);
    $resul->execute();
    $data = $resul->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }
  public function save(string $sql, array $datos)
  {
    $this->sql = $sql;
    $this->datos = $datos;
    $insert = $this->con->prepare($this->sql);
    $data = $insert->execute($this->datos);
    if ($data) {
      $res = 1;
    } else {
      $res = 0;
    }
    return $res;
  }
  public function insertar(string $sql, array $datos)
  {
    $this->sql = $sql;
    $this->datos = $datos;
    $insert = $this->con->prepare($this->sql);
    $data = $insert->execute($this->datos);
    if ($data) {
      $res = $this->con->lastInsertId();
    } else {
      $res = 0;
    }
    return $res;
  }

  public function multiQueryU($sqlList)
  {
    // Supongamos que $sqlList es un array de consultas SQL
    // Ejemplo: $sqlList = ["INSERT INTO tabla1 ...", "UPDATE tabla2 ..."];

    foreach ($sqlList as $sql) {
      $stmt = $this->con->prepare($sql);
      $stmt->execute();
    }
  }
}
