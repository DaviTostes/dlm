<?php

use DLM\Repository\TaskRepository;
use DLM\Repository\UserRepository;

require $_SERVER['DOCUMENT_ROOT'] . '/repository/TaskRepository.php';
require $_SERVER['DOCUMENT_ROOT'] . '/repository/UserRepository.php';

if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $task_repo = new TaskRepository();
  $user_repo = new UserRepository();

  $tasks = $task_repo->list_all($user_repo->verify_user_token());
?>
  <span id="taskCount" class="badge bg-light text-dark mb-3">Total: <?php echo count($tasks); ?></span>
  <ul class="list-group list-group-flush gap-3">
    <?php foreach ($tasks as $key => $task) { ?>
      <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center border <?php echo $task['done'] ? '' : "border-success" ?> py-3 rounded">
        <span class="<?php echo $task['done'] ? '' : 'text-success' ?>"><?php echo $task['name'] ?></span>
        <div>
          <button class="btn btn-sm btn-<?php echo $task['done'] ? 'success' : 'danger' ?> me-2" id="toogle-task"
            hx-post="/services/task/toogle.php/<?php echo $task['id'] ?>"
            hx-target="#new-resp">
            <i class="bi bi-<?php echo $task['done'] ? 'check' : 'x' ?>"></i>
          </button>

          <button class="btn btn-sm btn-light" id="delete-task"
            hx-delete="/services/task/delete.php/<?php echo $task['id'] ?>"
            hx-target='#new-resp'>
            <i class="bi bi-trash-fill"></i>
          </button>
        </div>
      </li>
    <?php } ?>
  </ul>
<?php
}
?>
