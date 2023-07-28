<?php
// Get the content sent by the AJAX request
$content = $_POST['content'];

// Create a new image from the content
$image = imagecreatetruecolor(800, 400); // Set the image dimensions
$bgColor = imagecolorallocate($image, 255, 255, 255); // Set the background color to white
imagefill($image, 0, 0, $bgColor);

// Add the content to the image
$fontColor = imagecolorallocate($image, 0, 0, 0); // Set the font color to black
$font = 'poppins_medium.ttf'; // Set the path to your font file
imagettftext($image, 20, 0, 20, 50, $fontColor, $font, $content);

// Save the image as a PNG file
$filename = 'captured_image_' . uniqid() . '.png'; // Generate a unique filename
imagepng($image, 'assets/downloads/' . $filename); // Save the image in the 'assets/downloads' directory

// Free up memory
imagedestroy($image);

// Return the URL of the saved image
echo 'assets/downloads/' . $filename;
?>