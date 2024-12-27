<?php

use DLM\Repository\TaskRepository;

require $_SERVER['DOCUMENT_ROOT'] . '/repository/TaskRepository.php';

header('Content-Type: application/json');

echo json_encode((new TaskRepository())->list_stats($_COOKIE['user_id'])); 
