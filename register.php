<!DOCTYPE html>
<html lang="en">

<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/head.php' ?>

<body class="bg-dark text-white d-flex flex-column vh-100">
  <div class="container flex-grow-1">
    <!-- Header -->
    <div class="text-center mt-5 mb-3">
      <h4 class="text-light fw-bold">MediumBlue</h4>
      <p class="text-light">Create your account to get started</p>
    </div>

    <!-- Registration Form -->
    <div class="mb-4">
      <form id="register-form" class="bg-dark p-4 rounded shadow-sm border-light" 
            hx-post="/services/user/register.php" hx-target="#register-resp">
        <div class="mb-3">
          <label for="name" class="form-label text-light">Name</label>
          <input type="text" name="name" id="name" class="form-control bg-dark text-white border-light" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label text-light">Password</label>
          <input type="password" name="password" id="password" class="form-control bg-dark text-white border-light" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-light">Register</button>
        </div>
      </form>

      <div id="register-resp" class="mt-3"></div>
    </div>

    <!-- Link to Login -->
    <div class="text-center">
      <p class="text-light">Already have an account? <a href="/login.php" class="text-decoration-none text-primary" hx-boost="true">Login here</a></p>
    </div>
  </div>
</body>

</html>
