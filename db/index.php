<?php
require $_SERVER['DOCUMENT_ROOT'] . '/db/CreateTable.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db/Config.php';

use DLM\Db\Config;
use DLM\Db\CreateTable;

$sqlite = new CreateTable((new \PDO('sqlite:' . Config::PATH_TO_SQLITE_FILE)));

$sqlite->create_tables();

$tables = $sqlite->get_table_list();
?>
<!DOCTYPE html>
<html lang="en">

<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/head.php' ?>

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
