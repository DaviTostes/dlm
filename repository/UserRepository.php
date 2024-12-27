<?php

namespace DLM\Repository;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Config.php';

use PDO;
use DLM\Db\Config;

class UserRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $this->pdo = new \PDO('sqlite:' . Config::PATH_TO_SQLITE_FILE);
  }

  public function insert(string $name, string $password): int
  {
    $stmt = $this->pdo->prepare(
      'SELECT * FROM users WHERE name = :name'
    );

    $stmt->bindValue(':name', $name);

    $stmt->execute();

    $rows = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $rows[] = $row;
    }

    if (count($rows) > 0) {
      return -1;
    }

    $encripted_pass = password_hash($password, 0);

    $sql = 'INSERT INTO users(name, password) VALUES(:name, :password)';

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':password', $encripted_pass);

    $stmt->execute();

    return $this->pdo->lastInsertId();
  }

  public function verify_credentials(string $name, string $password): bool
  {
    $stmt = $this->pdo->prepare(
      'SELECT * FROM users WHERE name = :name'
    );

    $stmt->bindValue(':name', $name);

    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($user) {
      $token_result = $this->_generate_new_token($user['id']);

      if($token_result == 'Error') {
        return false;
      }

      setcookie("token", $token_result, time() + 3600 * 24 * 7, '/');
      setcookie("user_id", $user['id'], time() + 3600 * 24 * 7, '/');

      return password_verify($password, $user['password']);
    }

    return false;
  }

  public function verify_user_token(): string {
    $token = $_COOKIE['token'];

    if(!isset($token)) {
      return '';
    }

    $stmt = $this->pdo->prepare(
      'SELECT * FROM users WHERE token = :token'
    );

    $stmt->bindValue(':token', $token);

    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    if(!$user) {
      return '';
    }

    return $user['id'];
  }

  private function _generate_new_token(string $id): string {
    $new_token = uniqid("", true);

    $stmt = $this->pdo->prepare('update users set token = :token where id = :id');

    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':token', $new_token);

    $exec = $stmt->execute();

    return $exec ? $new_token : 'Error';
  }
}
