<?php

namespace DLM\Db;

class CreateTable
{
  private $pdo;

  /**
   * @param mixed $pdo
   */
  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function create_tables(): void
  {
    $this->pdo->exec(
      'CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY,
        name TEXT NOT NULL,
        done INTEGER NOT NULL DEFAULT 0,
        user_id INTEGER NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
      )'
    );

    $this->pdo->exec(
      'CREATE TABLE IF NOT EXISTS users(
        id INTEGER PRIMARY KEY,
        name TEXT NOT NULL,
        password TEXT NOT NULL,
        token TEXT
      )'
    );

    $this->pdo->exec(
      'CREATE TABLE IF NOT EXISTS task_stats(
        date DATE PRIMARY KEY,
        total INTEGER NOT NULL,
        done INTEGER NOT NULL,
        pending INTEGER NOT NULL
      )'
    );
  }

  public function get_table_list(): array
  {
    $stmt = $this->pdo->query("SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name");
    $tables = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $tableName = $row['name'];
      $columnsStmt = $this->pdo->query("PRAGMA table_info($tableName)");
      $columns = [];

      while ($column = $columnsStmt->fetch(\PDO::FETCH_ASSOC)) {
        $columns[] = $column['name'];
      }

      $tables[$tableName] = $columns;
    }

    return $tables;
  }
}
