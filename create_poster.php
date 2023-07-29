<?php
print_r($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $heading = $_POST["heading"] ?? "Default Heading";
    $heading_position = $_POST["heading_position"] ?? "left"; // Default to "left"
    $heading_color = $_POST["heading_color"] ?? "black"; // Default to "black"
    $description = $_POST["description"] ?? "Default Description";
    $description_position = $_POST["description_position"] ?? "left"; // Default to "left"
    $description_color = $_POST["description_color"] ?? "black"; // Default to "black"

    // Fonts Path 
    $fontPath = realpath('assets/poppins_medium.ttf');

    // Load the default image
    $default_image_path = 'assets/default_image.jpg';
    if (file_exists($default_image_path)) {
        $default_image = imagecreatefromjpeg($default_image_path);
    } else {
        echo "Default image not found.";
        exit;
    }

    // Get the image dimensions
    $imageWidth = imagesx($default_image);
    $imageHeight = imagesy($default_image);

    // Handle image upload
    if (isset($_FILES["poster_image"]) && $_FILES["poster_image"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = "assets/uploads/";
        $target_file = $target_dir . basename($_FILES["poster_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["poster_image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["poster_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain image file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // Redirect back to the form or show an error message
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["poster_image"]["tmp_name"], $target_file)) {
                // Create an image with the uploaded image
                $uploaded_image = imagecreatefromjpeg($target_file);

                // Get the dimensions of the uploaded image
                $uploadedImageWidth = imagesx($uploaded_image);
                $uploadedImageHeight = imagesy($uploaded_image);

                // Calculate the position to center the uploaded image on the default image
                $uploadedImageX = ($imageWidth - 800) / 2; // Center horizontally with a fixed width of 800
                $uploadedImageY = ($imageHeight - 400) / 2; // Center vertically with a fixed height of 400

                // Create a new image with fixed dimensions (800x400)
                $resized_uploaded_image = imagecreatetruecolor(800, 400);

                // Resize the uploaded image to fit within the fixed dimensions (800x400)
                imagecopyresampled($resized_uploaded_image, $uploaded_image, 0, 0, 0, 0, 800, 400, $uploadedImageWidth, $uploadedImageHeight);

                // Copy the resized uploaded image onto the default image (centered)
                imagecopy($default_image, $resized_uploaded_image, $uploadedImageX, $uploadedImageY, 0, 0, 800, 400);

                // Destroy the uploaded image and resized uploaded image resources as they are no longer needed
                imagedestroy($uploaded_image);
                imagedestroy($resized_uploaded_image);
            } else {
                echo "Sorry, there was an error uploading your file.";
                // Redirect back to the form or show an error message
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Existing uploaded image has been removed.";
        }

    }


    // Calculate x-coordinate for the title
    $titleX = 5; // Left align by default
    if ($heading_position === 'center') {
        $titleX = ($imageWidth - imagettfbbox(30, 0, $fontPath, $wrappedTitle[0])[2]) / 2;
    } elseif ($heading_position === 'right') {
        $titleX = $imageWidth - imagettfbbox(30, 0, $fontPath, $wrappedTitle[0])[2] - 5;
    }

    // Calculate x-coordinate for the description
    $descriptionX = 5; // Left align by default
    if ($description_position === 'center') {
        $descriptionX = ($imageWidth - imagettfbbox(20, 0, $fontPath, $wrappedDescription[0])[2]) / 2;
    } elseif ($description_position === 'right') {
        $descriptionX = $imageWidth - imagettfbbox(20, 0, $fontPath, $wrappedDescription[0])[2] - 5;
    }

    // Set the title color
    $textColor = imagecolorallocate($default_image, 0, 0, 0); // Default to black color
    if ($heading_color === 'blue') {
        $textColor = imagecolorallocate($default_image, 0, 0, 255); // Blue color
    } elseif ($heading_color === 'green') {
        $textColor = imagecolorallocate($default_image, 0, 128, 0); // Green color
    }

    // Set the description color
    $descriptionColor = imagecolorallocate($default_image, 0, 0, 0); // Default to black color
    if ($description_color === 'blue') {
        $descriptionColor = imagecolorallocate($default_image, 0, 0, 255); // Blue color
    } elseif ($description_color === 'green') {
        $descriptionColor = imagecolorallocate($default_image, 0, 128, 0); // Green color
    }



// Function to wrap text and calculate its dimensions
function wrapText($image, $font, $text, $maxWidth)
{
    $words = explode(' ', $text);
    $lines = [];
    $currentLine = '';

    foreach ($words as $word) {
        $testLine = $currentLine . $word . ' ';
        $testBox = imagettfbbox(30, 0, $font, $testLine);

        if ($testBox[2] > $maxWidth && !empty($currentLine)) {
            $lines[] = trim($currentLine);
            $currentLine = $word . ' ';
        } else {
            $currentLine = $testLine;
        }
    }

    $lines[] = trim($currentLine);
    return $lines;
}

    // Set the maximum width for title and description texts
    $maxTitleWidth = $uploadedImageWidth - 10; // Leave some margin from the right side
    $maxDescriptionWidth = $uploadedImageWidth - 20; // Leave some margin from both sides

    // Wrap the title and description texts if they exceed the maximum width
    $wrappedTitle = wrapText($default_image, $fontPath, $heading, $maxTitleWidth);
    $wrappedDescription = wrapText($default_image, $fontPath, $description, $maxDescriptionWidth);

    // Determine y-coordinates for title and description
    $titleY = $uploadedImageY - 50;
    // $titleX  = $uploadedImageX + 10; 

    // Calculate the available space for the title
    $availableTitleWidth = $uploadedImageWidth - 800; // 800 is the width of the uploaded image

    // Calculate the starting X-coordinate for the title
    $titleX = $availableTitleWidth / 2;
    // $titlePositionY = $uploadedImageY - 30;
    // Add wrapped title to the default image
    $fontsize = 30;
    $angle = 0;
    $titleHeight = 0; // Initialize the title height
    foreach ($wrappedTitle as $line) {
        $titleBox = imagettfbbox($fontsize, $angle, $fontPath, $line);
        $titleWidth = $titleBox[2] - $titleBox[0];

       
        // Adjust the title X-coordinate to keep it within the available width
        if ($titleX + $titleWidth > 800) {
            $titleX = $availableTitleWidth / 2; // Reset X-coordinate to center
            $titleY += 40; // Move to the next line
            $titleHeight += abs($titleBox[7] - $titleBox[1]); // Calculate the height of the current line
        }

        imagettftext($default_image, $fontsize, $angle, $uploadedImageX, $titleY, $textColor, $fontPath, $line);
        $titleX += $titleWidth; // Move the X-coordinate for the next line
    }

  // Calculate the available space for the description

// Starting Y-coordinate for the wrapped description
$descriptionY = $uploadedImageY + 400 + 30; // 400 is the height of the uploaded image, add some margin (30) for the next line

// Add wrapped description to the default image
$fontsize = 18;
$angle = 0;

foreach ($wrappedDescription as $line) {
    // Calculate the bounding box of the current line of text
    $descriptionBox = imagettfbbox($fontsize, $angle, $fontPath, $line);
    print_r($descriptionBox);
    $descriptionWidth = $descriptionBox[2] - $descriptionBox[0];

    // Check if the current line exceeds the available width
    if ($descriptionWidth > 800) {
    
        $descriptionBox = imagettfbbox($fontsize, $angle, $fontPath, $line);
        $descriptionWidth = $descriptionBox[2] - $descriptionBox[0];
    }

    // Calculate the starting X-coordinate to be the same as the uploaded image
    $descriptionX = $uploadedImageX;

    // Draw the text
    imagettftext($default_image, $fontsize, $angle, $descriptionX, $descriptionY, $descriptionColor, $fontPath, $line);

    // Increase the Y-coordinate for the next line
    $descriptionY += abs($descriptionBox[7] - $descriptionBox[1]) + 10; // Add some margin (10) between lines

    // $descriptionY += abs($descriptionBox[7] - $descriptionBox[1]) + 10; // Add some margin (10) between lines
}






    // Save the final image to a file
    $final_image_path = 'assets/downloads/generated_poster.jpg';
    imagejpeg($default_image, $final_image_path);
    imagedestroy($default_image);


    // Get the absolute URL of the generated image
    $base_url = "http://" . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER["REQUEST_URI"] . '?') . '/';
    $image_url = $base_url . $final_image_path;

    // Send the absolute image URL back to JavaScript for download
    $response = array('image_url' => $image_url);
    echo json_encode($response);

}