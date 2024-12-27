<!DOCTYPE html>
<html lang="en">

<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/head.php' ?>

<body class="bg-dark text-white d-flex flex-column vh-100">
  <div class="container">
    <!-- Header -->
    <div class="text-center pt-5 mb-3">
      <h4 class="text-light fw-bold">MediumBlue</h4>
      <p class="text-light">Manage your tasks effortlessly</p>
    </div>

    <!-- Charts Section -->
    <div class="row chart-container">
      <div class="col-md-6 mb-4">
        <canvas id="dailyBarChart"></canvas>
      </div>
      <div class="col-md-6 mb-4">
        <canvas id="completionPieChart"></canvas>
      </div>
      <div class="col-md-6">
        <canvas id="lineChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Chart.js Script -->
  <script src="stats.js"></script>
</body>

</html>
