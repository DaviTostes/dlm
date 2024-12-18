<?php

use DLM\Repository\TaskRepository;

require $_SERVER['DOCUMENT_ROOT'] . '/repository/TaskRepository.php';

if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $toast_type = '';
  $toast_message = '';

  $repo = new TaskRepository();

  $task_id = end(explode('/', $_SERVER['REQUEST_URI']));

  $task_toogled = $repo->toogle($task_id);
}
