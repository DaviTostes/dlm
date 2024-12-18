<?php

use DLM\Repository\TaskRepository;

require $_SERVER['DOCUMENT_ROOT'] . '/repository/TaskRepository.php';

$date = (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))->format('H:i');

if ($date == '00:00') {
  $repo = new TaskRepository();

  $repo->resetTasks();

  echo 'done';
} else {
  echo 'not right time';
  http_response_code(418);
}
