<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $heading = $_POST["heading"] ?? "Default Heading";
    $heading_position = $_POST["heading_position"] ?? "left"; // Default to "left"
    $heading_color = $_POST["heading_color"] ?? "black"; // Default to "black"
    $description = $_POST["description"] ?? "Default Description";
    $description_position = $_POST["description_position"] ?? "left"; // Default to "left"
    $description_color = $_POST["description_color"] ?? "black"; // Default to "black"

    // Fonts Path 
    $bold_font_path = realpath('assets/sf-ui-display-semibold.otf');
    $medium_font_path = realpath('assets/sf-ui-display-medium.otf');

    // Load the default image
    $default_image_path = 'assets/default_image.jpg';
    if (file_exists($default_image_path)) {
        $default_image = imagecreatefromjpeg($default_image_path);
    } else {
        echo "Default image not found.";
        exit;
    }

    require('functions.php');

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
                $uploadedImageY = ($imageHeight - 575) / 2; // Center vertically with a fixed height of 400

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
            unlink($target_file);
            // echo "Existing uploaded image has been removed.";
        }
    }

    if (!isset($uploaded_image)) {
        // Function to wrap and add title text to the default image

        $titleY = 100;
        // Calculate x-coordinate for the title
        $titleX = 5; // Left align by default
        if ($heading_position === 'center') {
            $titleX = ($imageWidth - imagettfbbox(30, 0, $fontPath, $wrappedTitle[0])[2]) / 2;
        } elseif ($heading_position === 'right') {
            $titleX = $imageWidth - imagettfbbox(30, 0, $fontPath, $wrappedTitle[0])[2] - 5;
        }

        $titleY = 100;

        // Add title to the default image
        $maxTitleWidth = $imageWidth + 100; // Leave some margin from the right side
        addTitleToImage($default_image, $bold_font_path, $heading, $maxTitleWidth, $titleX, $titleY, $heading_color);

        // Calculate x-coordinate for the description
        $descriptionX = 5; // Left align by default
        if ($description_position === 'center') {
            $descriptionX = ($imageWidth - imagettfbbox(20, 0, $fontPath, $wrappedDescription[0])[2]) / 2;
        } elseif ($description_position === 'right') {
            $descriptionX = $imageWidth - imagettfbbox(20, 0, $fontPath, $wrappedDescription[0])[2] - 5;
        }

        $descriptionY = $imageHeight - 50;

        // Add description to the default image
        $maxDescriptionWidth = $imageWidth + 35; // Leave some margin from both sides
        addDescriptionToImage($default_image, $medium_font_path, $description, $maxDescriptionWidth, $descriptionX, $descriptionY, $description_color);
    }else{
        // uploaded image --> 
        
        // Calculate x-coordinate for the title
        $titleX = $uploadedImageX; // Left align by default
        if ($heading_position === 'center') {
            $titleX = $uploadedImageWidth / 2;
        } elseif ($heading_position === 'right') {
            $titleX = $uploadedImageWidth - 45;
        }
        
        $titleY = $uploadedImageY - 3;

        // Add title to the default image
        $maxTitleWidth = $imageWidth + 100; // Leave some margin from the right side
        addTitleToImage($default_image, $bold_font_path, $heading, $maxTitleWidth, $titleX, $titleY, $heading_color);

        // Calculate x-coordinate for the description
        $descriptionX = $uploadedImageX; // Left align by default
        $descriptionY = $uploadedImageHeight + 135;

        // Add description to the default image
        $maxDescriptionWidth = $uploadedImageWidth + 35; // Leave some margin from both sides
        addDescriptionToImage($default_image, $medium_font_path, $description, $maxDescriptionWidth, $descriptionX, $descriptionY, $description_color);
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