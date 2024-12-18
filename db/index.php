<?php
require $_SERVER['DOCUMENT_ROOT'] . '/db/CreateTable.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db/Config.php';

use DLM\Db\Config;
use DLM\Db\CreateTable;

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != 'zreG4tnu') {
  header('Location: /');
}

$sqlite = new CreateTable((new \PDO('sqlite:' . Config::PATH_TO_SQLITE_FILE)));

$sqlite->create_tables();

$tables = $sqlite->get_table_list();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="view tables">
  <title>Check Tables</title>
  <link href="../utils/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <header class="page-header m-3">
    <h1>CHECK TABLES</h1>
  </header>

  <main class="m-3">
    <div class="accordion" id="tablesAccordion">
      <?php foreach ($tables as $table => $columns) : ?>
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-<?php echo $table; ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $table; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $table; ?>">
              <?php echo $table; ?>
            </button>
          </h2>
          <div id="collapse-<?php echo $table; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $table; ?>" data-bs-parent="#tablesAccordion">
            <div class="accordion-body">
              <ul class="list-group">
                <?php foreach ($columns as $column) : ?>
                  <li class="list-group-item"><?php echo $column; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <script src="../utils/bootstrap.bundle.min.js"></script>
</body>
