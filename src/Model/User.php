<?php

namespace App\Model;

use App\Controller\ErrorController;
use App\Database;
use PDO;
use PDOException;

class User {
  private $id;
  private $name;
  private $email;
  private $password;
  /** @var "user"|"admin" */
  private $type;
  private $created_at;
  private $updated_at;

  public static function findOne(array $params = [], string $word = 'AND'): User | null {
    if (!in_array(strtolower($word), ['and', 'or'])) {
      echo '<pre>';
      print_r("$word non reconu pour la requete sql");
      echo '</pre>';
      die();
    }
    $pdo = Database::getConnection();

    $keys = array_keys($params);
    $paramNames = array_map(fn($key) => ":$key", $keys);
    $values = array_values($params);
    $values = array_map(fn($value) => htmlentities($value), $values);

    $sql = <<< EOL
    SELECT * FROM users WHERE
    EOL;

    $sqlParams = [];

    for ($i = 0; $i < sizeof($keys); $i++) {
      array_push($sqlParams, "$keys[$i]=$paramNames[$i]");
    }

    $sqlParams = implode(" $word ", $sqlParams);

    $sql .= " $sqlParams";

    $statementParams = array_combine($paramNames, $values);

    try {
      $statement = $pdo->prepare($sql);
      $statement->execute($statementParams);
      $users = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
      if (!empty($users)) {
        return $users[0];
      }

    } catch (PDOException $e) {
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
      die();
      $errorController = new ErrorController();
      $errorController->get500();
    }
  }

  public function getId() {
    return $this->id;
  }

  public function setId(int $id): self {
    $this->id = $id;
    return $this;
  }

  public function getName() {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail(string $email): self {
    $this->email = $email;
    return $this;
  }

  public function getPassword() {
    return $this->password;
  }

  public function setPassword(string $password): self {
    $this->password = $password;
    return $this;
  }

  public function getType() {
    return $this->type;
  }

  public function setType(string $type): self {
    $this->type = $type;
    return $this;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function setCreatedAt(string $created_at): self {
    $this->created_at = $created_at;
    return $this;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }

  public function setUpdatedAt(string $updated_at): self {
    $this->updated_at = $updated_at;
    return $this;
  }

}