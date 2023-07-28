<!DOCTYPE html>
<html class="h-full bg-gray-100 m-0">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full m-0 font-sans">
    <!-- HTML content -->
    <div id="contentToSave" class="container mx-auto">
        <h2> Title </h2>
        <img src="assets/default_image.jpg" width="200">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, fuga architecto veritatis provident
            corporis laborum! Autem veritatis perferendis blanditiis</p>
    </div>

    <button class="w-1/3 bg-green-300" onclick="convertDivToImage()">Save as Image</button>

    <script>
        function convertDivToImage() {
            // Get the div element
            const divToSave = document.getElementById('contentToSave');
            // Create a canvas element
            const canvas = document.createElement('canvas');
            canvas.width = divToSave.offsetWidth;
            canvas.height = divToSave.offsetHeight;

            // Get the canvas context
            const context = canvas.getContext('2d');

            // Draw the div content on the canvas
            const htmlContent = divToSave.innerHTML;
            const DOMURL = window.URL || window.webkitURL || window;
            const img = new Image();
            const svg = new Blob([htmlContent], { type: 'image/svg+xml' });
            const url = DOMURL.createObjectURL(svg);

            img.onload = function () {
                context.drawImage(img, 0, 0);
                DOMURL.revokeObjectURL(url);

                // Call the function to save the image
                saveCanvasAsImage(canvas);
            };

            img.src = url;
        }

        function saveCanvasAsImage(canvas) {
            // Get the data URL of the canvas
            const dataURL = canvas.toDataURL('image/png');

            // Create a hidden form to send the data to the PHP backend
            const form = document.createElement('form');
            form.method = 'post';
            form.action = '';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'imageDataURL';
            input.value = dataURL;
            form.appendChild(input);
            document.body.appendChild(form);

            // Submit the form to trigger the PHP script
            form.submit();
        }
    </script>

    <?php
    if (isset($_POST['imageDataURL'])) {
        $imageData = $_POST['imageDataURL'];
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageData = base64_decode($imageData);

        // Define the file path and name
        $filename = 'saved_image.png';

        // Save the image to the server
        file_put_contents($filename, $imageData);
        echo 'Image saved successfully.';
    }
    ?>
</body>

</html>