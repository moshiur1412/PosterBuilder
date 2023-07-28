// Function to download the live section as an image
function downloadLiveSection() {
    const liveSection = document.getElementById('live_screen_capture');

    // Convert the live section to an image using html2canvas
    html2canvas(liveSection).then(function (canvas) {
        // Convert the canvas to an image URL
        const imageURL = canvas.toDataURL('image/png');

        // Create a download link and trigger the download
        const downloadLink = document.createElement('a');
        downloadLink.href = imageURL;
        downloadLink.download = 'live_section.png';
        downloadLink.click();
    });
}

// Add event listener to the download button for the live section
const downloadButton = document.getElementById('download_button');
downloadButton.addEventListener('click', downloadLiveSection);



// 2nd options data save backend folder-->

function saveAsImage() {
    const liveScreenCapture = document.getElementById('live_screen_capture');
    const width = liveScreenCapture.clientWidth;
    const height = liveScreenCapture.clientHeight;

    // Use html2canvas to capture the content as an image
    html2canvas(liveScreenCapture, { width, height })
        .then(canvas => {
            // Convert the canvas to a data URL (base64-encoded image data)
            const dataURL = canvas.toDataURL('image/png');

            // Send the dataURL to the server via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_image.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log('Image saved successfully.');
                }
            };
            xhr.send('imageData=' + encodeURIComponent(dataURL));
        })
        .catch(error => {
            console.error('Error capturing content as an image:', error);
        });
}



function saveAsImage() {
    // Get the content from the live_screen_capture div
    const liveScreenCapture = document.getElementById('live_screen_capture');

    // Convert the div content to an image using html2canvas library
    html2canvas(liveScreenCapture).then(function (canvas) {
      // Get the data URL of the canvas
      const imageDataURL = canvas.toDataURL('image/png');

      // Send the data to the backend using AJAX
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'save_image.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      // Handle the AJAX response
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Response from the backend (filename)
            const filename = xhr.responseText;
            console.log('Image saved successfully:', filename);

            // Create a downloadable link for the saved image
            const downloadLink = document.createElement('a');
            downloadLink.href = '/assets/downloads/' + filename;
            downloadLink.download = filename; // Set the download attribute to specify the filename
            downloadLink.style.display = 'none';

            // Add the link to the document body
            document.body.appendChild(downloadLink);

            // Click the link programmatically to trigger the download
            downloadLink.click();

            // Clean up: remove the link from the document body
            document.body.removeChild(downloadLink);
          } else {
            // Error handling (if needed)
            console.error('Error occurred while saving the image.');
          }
        }
      };

      // Send the data as POST parameters
      const params = 'imageData=' + encodeURIComponent(imageDataURL);
      xhr.send(params);
    });
  }

