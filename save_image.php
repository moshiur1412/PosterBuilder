<?php
// Check if the POST parameter "imageData" is set
if (isset($_POST['imageData'])) {
  // Get the base64 encoded image data
  $imageData = $_POST['imageData'];

  // Remove the "data:image/png;base64," part from the data URL
  $imageData = str_replace('data:image/png;base64,', '', $imageData);

  // Decode the base64 image data
  $decodedImageData = base64_decode($imageData);

  // Generate a unique filename for the image
  $filename = 'captured_image_' . uniqid() . '.png';

  // Specify the path where you want to save the image (make sure the folder exists and has write permissions)
  $savePath = '/assets/downloads/' . $filename;

  // Save the image to the specified path
  if (file_put_contents($savePath, $decodedImageData)) {
    // Send the generated filename back to the frontend
    echo $filename;
  } else {
    // Error handling (if needed)
    echo 'Error: Unable to save the image.';
  }
} else {
  echo 'Error: Image data not received.';
}
?>
