<?php
function addTitleToImage($image, $font, $text, $maxWidth, $x, $y, $color, $position)
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

    $textColor = imagecolorallocate($image, 0, 0, 0); // Default to black color
    if ($color === 'blue') {
        $textColor = imagecolorallocate($image, 0, 0, 255); // Blue color
    } elseif ($color === 'green') {
        $textColor = imagecolorallocate($image, 0, 128, 0); // Green color
    }

    $fontsize = 30;
    $angle = 0;
    $titleY = $y - 30;

    // Calculate the total height required by the title text
    // $totalTitleHeight = count($lines) * 40;

    if ($position === 'center') {
        // Center align the title
        $titleX = ($maxWidth - imagettfbbox($fontsize, $angle, $font, $lines[0])[2]) / 2;
    } elseif ($position === 'right') {
        // Right align the title
        $titleX = $maxWidth - imagettfbbox($fontsize, $angle, $font, $lines[0])[2] - 5;
    } else {
        // Left align by default
        $titleX = $x;
    }

    foreach ($lines as $line) {
        imagettftext($image, $fontsize, $angle, $titleX, $titleY, $textColor, $font, $line);
        $titleY += 40; // Increase the Y-coordinate for the next line
    }
}

// Function to wrap and add description text to the default image
function addDescriptionToImage($image, $font, $text, $maxWidth, $x, $y, $color)
{
    $words = explode(' ', $text);
    $lines = [];
    $currentLine = '';

    foreach ($words as $word) {
        $testLine = $currentLine . $word . '  ';
        $testBox = imagettfbbox(15, 0, $font, $testLine);

        if ($testBox[2] > $maxWidth && !empty($currentLine)) {
            $lines[] = trim($currentLine);
            $currentLine = $word . ' ';
        } else {
            $currentLine = $testLine;
        }
    }

    $lines[] = trim($currentLine);

    $descriptionColor = imagecolorallocate($image, 0, 0, 0); // Default to black color
    if ($color === 'blue') {
        $descriptionColor = imagecolorallocate($image, 0, 0, 255); // Blue color
    } elseif ($color === 'green') {
        $descriptionColor = imagecolorallocate($image, 0, 128, 0); // Green color
    }

    $fontsize = 15;
    $angle = 0;
    $descriptionY = $y;
    foreach ($lines as $line) {
        imagettftext($image, $fontsize, $angle, $x, $descriptionY, $descriptionColor, $font, $line);
        $descriptionY += 5;
        $descriptionBox = imagettfbbox($fontsize, $angle, $font, $line);
        $descriptionY += abs($descriptionBox[7] - $descriptionBox[1]) + 5; // Add some margin (10) between lines
    }
}

?>