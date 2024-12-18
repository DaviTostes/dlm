<!DOCTYPE html>
<html lang="en">

<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/head.php' ?>

<body class="bg-dark text-white d-flex flex-column vh-100">
  <div class="container my-5 flex-grow-1">
    <!-- Header -->
    <div class="text-center mb-4">
      <p class="text-light">Manage your tasks effortlessly</p>
    </div>

    <!-- Add Task Section -->
    <div class="mb-4">
      <form class="d-flex" id="add-task-form" hx-post="/services/task/new.php" hx-target="#new-resp">
        <input type="text" id="name" name="name" class="form-control me-2 bg-dark text-white border-light"
          id="taskInput" required>
        <button class="btn btn-light">
          <i class="bi bi-plus fs-5"></i>
        </button>
      </form>

      <div id="new-resp"></div>
    </div>

    <!-- Task List Section -->
    <div id="tasks" hx-get="/views/task/list.php" hx-trigger="load"></div>
  </div>

  <!-- Footer -->
  <footer class="text-center mt-5">
    <p class="text-light">&copy; 2024 DLM. All rights reserved.</p>
  </footer>

  <script>
    document.addEventListener('htmx:afterRequest', function(event) {
      let reqs = ['add-task-form', 'delete-task', 'toogle-task']

      if (event.target.id === reqs[0]) {
        document.querySelector('#name').value = ''
      }

      if (reqs.includes(event.target.id)) {
        htmx.ajax('GET', '/views/task/list.php', {
          target: '#tasks',
        })
      }
    })
  </script>

</body>

</html>
