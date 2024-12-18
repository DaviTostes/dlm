<?php
use DLM\Repository\TaskRepository;

require $_SERVER['DOCUMENT_ROOT'] . '/repository/TaskRepository.php';

if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $toast_type = '';
  $toast_message = '';

  $repo = new TaskRepository();

  $task_id = end(explode('/', $_SERVER['REQUEST_URI']));

  $task_deleted = $repo->delete(id: $task_id); 

  if($task_deleted) {
    $toast_type = 'success';
    $toast_message = 'Task Deleted';
  } else {
    $toast_type = 'danger';
    $toast_message = 'Error Deleting Task';
  }
?>
  <!-- Toast Container -->
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
    <div class="toast align-items-center text-bg-<?php echo $toast_type; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <?php echo $toast_message; ?>
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- Script to show the toast -->
  <script>
    var toastEl = document.querySelector('.toast');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
  </script>
<?php
}
