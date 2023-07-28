<?php

phpinfo();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['imageData'])) {
    $imageData = $_POST['imageData'];
    $decodedImageData = base64_decode(str_replace('data:image/png;base64,', '', $imageData));

    // Generate a unique filename for the image
    $filename = 'captured_image_' . uniqid() . '.png';
    $filepath = realpath('asset/uploads/') . $filename;

    // Save the image to the specified directory
    file_put_contents($filepath, $decodedImageData);

    // Optionally, you can respond with a success message to the client
    echo 'Image saved successfully.';
  } else {
    // Respond with an error message if imageData is not provided
    http_response_code(400);
    echo 'Bad Request: imageData not provided.';
  }
} else {
  // Respond with an error message for unsupported request methods
  http_response_code(405);
  echo 'Method Not Allowed';
}
?>
