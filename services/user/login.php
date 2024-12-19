<?php

use DLM\Repository\UserRepository;

require $_SERVER['DOCUMENT_ROOT'] . '/repository/UserRepository.php';

if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $repo = new UserRepository();

  $verified = $repo->verify_credentials(name: $_POST['name'], password: $_POST['password']);

  if ($verified) {
    header("HX-Location: /");
    exit;
  } else {
?>
    <!-- Toast Container -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
      <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            Invalid Credentials
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
}
