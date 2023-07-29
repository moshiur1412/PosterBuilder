<?php
// print_r($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $heading = $_POST["heading"] ?? "Default Heading";
    $heading_position = $_POST["heading_position"] ?? "left"; // Default to "left"
    $heading_color = $_POST["heading_color"] ?? "black"; // Default to "black"
    $description = $_POST["description"] ?? "Default Description";
    $description_position = $_POST["description_position"] ?? "left"; // Default to "left"
    $description_color = $_POST["description_color"] ?? "black"; // Default to "black"

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

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
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
                $image = imagecreatefromjpeg($target_file);
            } else {
                echo "Sorry, there was an error uploading your file.";
                // Redirect back to the form or show an error message
            }
        }
    } else {
        // Use the default image
        $default_image_path = 'assets/default_image.jpg';
        if (file_exists($default_image_path)) {
            $image = imagecreatefromjpeg($default_image_path);
        } else {
            echo "Default image not found.";
            exit;
        }
    }

    // Get the image dimensions
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);   

    // Fonts Path 
    $fontPath = realpath('assets/poppins_medium.ttf');

    // Set the maximum width for title and description texts
    $maxTitleWidth = $imageWidth - 10; // Leave some margin from the right side
    $maxDescriptionWidth = $imageWidth - 20; // Leave some margin from both sides

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

    // Wrap the title and description texts if they exceed the maximum width
    $wrappedTitle = wrapText($image, $fontPath, $heading, $maxTitleWidth);
    $wrappedDescription = wrapText($image, $fontPath, $description, $maxDescriptionWidth);

    // Determine y-coordinates for title and description
    $titleY = 100;
    $descriptionY = $imageHeight - 50;

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
    $textColor = imagecolorallocate($image, 0, 0, 0); // Default to black color
    if ($heading_color === 'blue') {
        $textColor = imagecolorallocate($image, 0, 0, 255); // Blue color
    } elseif ($heading_color === 'green') {
        $textColor = imagecolorallocate($image, 0, 128, 0); // Green color
    }

    // Add wrapped title to the image
    $fontsize = 30;
    $angle = 0;
    foreach ($wrappedTitle as $line) {
        imagettftext($image, $fontsize, $angle, $titleX, $titleY, $textColor, $fontPath, $line);
        $titleY += 40; // Increase the Y-coordinate for the next line
    }

    // Set the description color
    $descriptionColor = imagecolorallocate($image, 0, 0, 0); // Default to black color
    if ($description_color === 'blue') {
        $descriptionColor = imagecolorallocate($image, 0, 0, 255); // Blue color
    } elseif ($description_color === 'green') {
        $descriptionColor = imagecolorallocate($image, 0, 128, 0); // Green color
    }

    // Add wrapped description to the image
    $fontsize = 20;
    $angle = 0;
    $descriptionY -= (count($wrappedDescription) - 1) * 40; // Adjust Y-coordinate for wrapped lines
    foreach ($wrappedDescription as $line) {
        imagettftext($image, $fontsize, $angle, $descriptionX, $descriptionY, $descriptionColor, $fontPath, $line);
        $descriptionY += 30; // Increase the Y-coordinate for the next line
    }

    // Save the final image to a file
    $final_image_path = 'assets/downloads/generated_poster.jpg';
    imagejpeg($image, $final_image_path);
    imagedestroy($image);

    // Get the absolute URL of the generated image
    $base_url = "http://" . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER["REQUEST_URI"] . '?') . '/';
    $image_url = $base_url . $final_image_path;

    // Send the absolute image URL back to JavaScript for download
    $response = array('image_url' => $image_url);
    echo json_encode($response);
}
?>