<?php

namespace DLM\Repository;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Config.php';

use PDO;
use DLM\Db\Config;

class TaskRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $this->pdo = new \PDO('sqlite:' . Config::PATH_TO_SQLITE_FILE);
  }

  public function insert(string $name, string $user_id): int
  {
    $sql = 'INSERT INTO tasks(name, done, user_id) VALUES(:name, :done, :user_id)';

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':done', 1);
    $stmt->bindValue(':user_id', $user_id);

    $stmt->execute();

    return $this->pdo->lastInsertId();
  }

  public function list_all(string $user_id): mixed
  {
    $stmt = $this->pdo->prepare(
      'SELECT * FROM tasks WHERE user_id = :user_id'
    );

    $stmt->bindValue(':user_id', $user_id);

    $stmt->execute();

    $rows = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $rows[] = $row;
    }

    return $rows;
  }

  public function count(): int
  {
    $sql = 'select count(*) from tasks';

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchColumn();
  }

  public function delete(string $id): bool
  {
    $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $exec = $stmt->execute();

    return $exec ? true : false;
  }

  public function find_by_id(string $id): mixed
  {
    $stmt = $this->pdo->query('SELECT * FROM tasks WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ORI_FIRST, \PDO::FETCH_ASSOC);
  }

  public function toogle(string $id): bool
  {
    $stmt = $this->pdo->prepare(
      'UPDATE tasks set done = case 
       when done = 1 then 0
       when done = 0 then 1
       end
       where id = :id'
    );

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function resetTasks(): void
  {
    $this->pdo->exec('UPDATE tasks set done = 1');
  }
}
