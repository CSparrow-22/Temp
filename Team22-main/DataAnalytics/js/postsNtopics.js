/* globals Chart:false */

(() => {
  'use strict'



  fetch('http://34.142.47.100/Temp/Team22-main/API/index.php/weeklydata')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        console.log('Response:', response);
        return response.text(); // Get the response text
    })
    .then(text => {
        console.log('Response Text:', text); // Log the response text
        // Check if response text is empty
        if (!text) {
            throw new Error('Empty response');
        }
        // Attempt to parse the response text as JSON
        const data = JSON.parse(text);
        // Your data processing and chart rendering logic goes here...
    })
    .catch(error => {
        console.error('Error:', error);
    });

        console.log('Labels:', labels);
        console.log('Values:', values);
        // Graphs
        const ctx = document.getElementById('myChart')
        // eslint-disable-next-line no-unused-vars
        const myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              data: values,
              lineTension: 0,
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              borderWidth: 4,
              pointBackgroundColor: '#007bff'
            }]
          },
          options: {
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                boxPadding: 3
              }
            }
          }
        })

      })



})()
