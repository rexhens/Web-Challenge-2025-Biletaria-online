// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Fetch data and create chart
fetch('../../includes/get_reservations_percentage.php')
    .then(response => response.json())
    .then(onlinePercentage => {
      // Ensure percentage is an integer and in valid range
      if (typeof onlinePercentage !== 'number' || isNaN(onlinePercentage)) {
        throw new Error('Invalid percentage value received');
      }

      // Pie Chart Example (inside the fetch callback!)
      var ctx = document.getElementById("myPieChart");
      var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ["Online", "Në biletari"],
          datasets: [{
            data: [onlinePercentage, 100 - onlinePercentage],
            backgroundColor: ['#8f793f', '#716a69'],
            hoverBackgroundColor: ['#c9bba7', '#c9bba7'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: false
          },
          cutoutPercentage: 80,
        },
      });
    })
    .catch(error => console.error('Online percentage error:', error));