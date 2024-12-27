fetch("/services/task/stats.php")
  .then((response) => {
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    return response.json(); // This will parse the JSON response
  })
  .then((statsData) => {
    // Bar Chart
    const dailyBarChartCtx = document
      .getElementById("dailyBarChart")
      .getContext("2d");
    new Chart(dailyBarChartCtx, {
      type: "bar",
      data: {
        labels: statsData.map((stat) => stat.date),
        datasets: [
          {
            label: "Total Tasks",
            data: statsData.map((stat) => stat.total),
            backgroundColor: "rgba(54, 162, 235, 0.2)",
          },
          {
            label: "Done Tasks",
            data: statsData.map((stat) => stat.done),
            backgroundColor: "rgba(75, 192, 192, 0.6)",
          },
          {
            label: "Pending Tasks",
            data: statsData.map((stat) => stat.pending),
            backgroundColor: "rgba(255, 99, 132, 0.6)",
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: "top",
          },
          title: {
            display: true,
            text: "Daily Task Breakdown",
          },
        },
      },
    });

    // Pie Chart
    const completionPieChartCtx = document
      .getElementById("completionPieChart")
      .getContext("2d");
    const totalDone = statsData.reduce((sum, stat) => sum + stat.done, 0);
    const totalPending = statsData.reduce((sum, stat) => sum + stat.pending, 0);
    new Chart(completionPieChartCtx, {
      type: "pie",
      data: {
        labels: ["Done Tasks", "Pending Tasks"],
        datasets: [
          {
            data: [totalDone, totalPending],
            backgroundColor: [
              "rgba(75, 192, 192, 0.6)",
              "rgba(255, 99, 132, 0.6)",
            ],
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: "top",
          },
          title: {
            display: true,
            text: "Overall Task Completion Rate",
          },
        },
      },
    });

    // Line Chart
    const lineChartCtx = document.getElementById("lineChart").getContext("2d");
    new Chart(lineChartCtx, {
      type: "line",
      data: {
        labels: statsData.map((stat) => stat.date), // X-axis labels (dates)
        datasets: [
          {
            label: "Total Tasks",
            data: statsData.map((stat) => stat.total),
            borderColor: "rgba(54, 162, 235, 1)", // Blue for total tasks
            backgroundColor: "rgba(54, 162, 235, 0.2)", // Light blue
            fill: false, // Do not fill under the line
            tension: 0.4,
          },
          {
            label: "Done Tasks",
            data: statsData.map((stat) => stat.done),
            borderColor: "rgba(75, 192, 192, 1)", // Green for done tasks
            backgroundColor: "rgba(75, 192, 192, 0.2)", // Light green
            fill: false,
            tension: 0.4,
          },
          {
            label: "Pending Tasks",
            data: statsData.map((stat) => stat.pending),
            borderColor: "rgba(255, 99, 132, 1)", // Red for pending tasks
            backgroundColor: "rgba(255, 99, 132, 0.2)", // Light red
            fill: false,
            tension: 0.4,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: "top", // Position of the legend
          },
          title: {
            display: true,
            text: "Task Progress Over Time",
          },
        },
        scales: {
          x: {
            title: {
              display: true,
              text: "Date",
            },
          },
          y: {
            title: {
              display: true,
              text: "Number of Tasks",
            },
            beginAtZero: true, // Ensure the y-axis starts at 0
          },
        },
      },
    });
  })
  .catch((error) => {
    console.error("Error fetching stats:", error);
  });
