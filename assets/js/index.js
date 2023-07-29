const appDiv = document.getElementById('app');
const dyanamicDiv = document.createElement('div');
const dynamicForm = document.createElement('form');

let headingSectionCreated = false;
let imageSectionCreated = false;
let descriptionSectionCreated = false;


// Default Loading Page --> 
function defaultLoading() {
    // Create the container for main sections
    const mainDiv = document.createElement('div');
    mainDiv.id = "main_section";
    mainDiv.classList.add('fixed', 'grid', 'grid-cols-2', 'gap-2', 'text-center', 'w-full', 'h-full');

    // Create the new section
    const itemDiv = document.createElement('div');
    itemDiv.id = "items_section";
    itemDiv.classList.add('mx-5', 'my-9', 'border', 'border-dotted', 'border-3', 'border-indigo-500', 'rounded-lg');

    const title_components = document.createElement('h1');
    title_components.classList.add('text-2xl', 'flex-wrap', 'mx-3', 'rounded', 'relative', 'bg-white', 'inline-flex', 'bottom-5', 'w-4/5', 'place-content-center', 'items-center');
    title_components.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10.362 1.093a.75.75 0 00-.724 0L2.523 5.018 10 9.143l7.477-4.125-7.115-3.925zM18 6.443l-7.25 4v8.25l6.862-3.786A.75.75 0 0018 14.25V6.443zm-8.75 12.25v-8.25l-7.25-4v7.807a.75.75 0 00.388.657l6.862 3.786z" clip-rule="evenodd" /></svg> &nbsp; Components`;
    itemDiv.appendChild(title_components);

    dyanamicDiv.id = "dynamic_div_section";
    dyanamicDiv.classList.add('pt-5', 'space-y-9');
    dynamicForm.id = "dynamic_form";
    dynamicForm.enctype = "multipart/form-data";

    dyanamicDiv.appendChild(dynamicForm);
    itemDiv.appendChild(dyanamicDiv);

    const title_items = document.createElement('h3');
    title_items.id = "title_items";
    title_items.innerHTML = "Items";

    title_items.classList.add('mt-3', 'text-center', 'font-bold', 'p-3', 'w-full');
    itemDiv.appendChild(title_items);

    const buttonDiv = document.createElement('div');
    buttonDiv.classList.add('flex', 'justify-between', 'space-x-1', 'px-3');
    itemDiv.appendChild(buttonDiv);

    // Create the heading button
    const headingBtn = document.createElement('button');
    headingBtn.classList.add('text-1xl', 'bg-yellow-400', 'rounded-lg', 'hover:bg-yellow-500', 'py-3', 'px-5', 'flex-1');
    headingBtn.innerHTML = 'Heading';
    headingBtn.addEventListener('click', () => handleButtonClick('heading'));
    buttonDiv.appendChild(headingBtn);

    // Create the Image button
    const imageBtn = document.createElement('button');
    imageBtn.classList.add('text-1xl', 'bg-blue-400', 'rounded-lg', 'hover:bg-blue-500', 'py-3', 'px-5', 'flex-1');
    imageBtn.innerHTML = 'Image';
    imageBtn.addEventListener('click', () => handleButtonClick('image'));
    buttonDiv.appendChild(imageBtn);

    // Create the Description button
    const descriptionBtn = document.createElement('button');
    descriptionBtn.classList.add('text-1xl', 'bg-green-400', 'rounded-lg', 'hover:bg-green-500', 'py-3', 'px-5', 'flex-1');
    descriptionBtn.innerHTML = 'Description';
    descriptionBtn.addEventListener('click', () => handleButtonClick('description'));
    buttonDiv.appendChild(descriptionBtn);
    mainDiv.appendChild(itemDiv);

    // Live Section --> 
    const liveSectionDiv = document.createElement('div');
    liveSectionDiv.id = "live_section";
    liveSectionDiv.classList.add('mx-5', 'my-9', 'border', 'border-dotted', 'border-3', 'border-indigo-500', 'rounded-lg');


    const title_preview = document.createElement('h1');
    title_preview.classList.add('text-2xl', 'flex-wrap', 'mx-3', 'rounded', 'relative', 'bg-white', 'inline-flex', 'bottom-5', 'w-4/5', 'place-content-center', 'items-center');
    title_preview.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg> &nbsp; Preview`;
    liveSectionDiv.appendChild(title_preview);

    // Screen Capture Section --> 
    const liveScreenCapture = document.createElement('div');
    liveScreenCapture.id = "live_screen_capture";
    liveScreenCapture.classList.add('m-3', 'px-9', 'py-3', 'space-y-7', 'bg-gray-100', 'text-left', 'whitespace-break-spaces', 'break-words');

    const poster_title = document.createElement('h1');
    poster_title.id = 'live_heading_text';
    poster_title.classList.add('text-5xl', 'font-blod')
    liveScreenCapture.appendChild(poster_title);

    const poster_image = document.createElement('img');
    poster_image.id = 'live_image';
    poster_image.classList.add('w-800', 'h-400');
    liveScreenCapture.appendChild(poster_image);

    const poster_description = document.createElement('p');
    poster_description.id = 'live_description';
    poster_description.classList.add('pb-3', 'text-2xl');
    liveScreenCapture.appendChild(poster_description);
    liveSectionDiv.appendChild(liveScreenCapture);

    const submitButton = document.createElement('button');
    submitButton.classList.add('absolute', 'bottom-11', 'left-3/4', 'transform', '-translate-x-1/2');
    submitButton.innerHTML = "Download";
    submitButton.id = 'download_button';
    liveSectionDiv.appendChild(submitButton);

    mainDiv.appendChild(liveSectionDiv);

    appDiv.appendChild(mainDiv);
}

// Function to generate the Heading section
function generateHeadingSection() {
    if (!headingSectionCreated) {
        const headingSection = document.getElementById('heading_section');
        if (headingSection) {
            headingSection.remove();
        }

        // Create the new heading section
        const headingOptionsDiv = document.createElement('div');
        headingOptionsDiv.id = 'heading_section';
        headingOptionsDiv.classList.add('m-5', 'p-5', 'flex', 'flex-wrap', 'border', 'border-5', 'shadow', 'justify-between');

        const headingTitle = document.createElement('h2');
        headingTitle.classList.add('flex', 'relative', 'bottom-11', 'bg-gray-300', 'px-5', 'py-3', 'rounded-lg');
        headingTitle.innerHTML = 'Heading';
        headingOptionsDiv.appendChild(headingTitle);

        // Create the close button for the heading section
        const closeButton = document.createElement('button');
        closeButton.innerText = 'X';
        closeButton.classList.add('text-base', 'justify-end', 'cursor-pointer', 'flex', 'p-3', 'rounded-full', 'text-red-500', 'bg-gray-50', 'relative', 'bottom-11', 'left-9', 'font-bold');
        closeButton.addEventListener('click', () => {
            headingOptionsDiv.remove(); // Remove the heading section when the close button is clicked
            headingSectionCreated = false; // Reset the heading section status to not created
            headingBtn.classList.remove('hidden'); // Show the "Heading Generate" button when the section is closed
        });
        headingOptionsDiv.appendChild(closeButton);

        // Create the Poster Title input
        const posterTitleInput = document.createElement('input');
        posterTitleInput.type = 'text';
        posterTitleInput.name = 'heading';
        posterTitleInput.required = true;
        posterTitleInput.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:border-blue-500', 'mb-2');
        headingOptionsDiv.appendChild(posterTitleInput);

        // Create the Heading Position buttons
        const headingPositionButtonsDiv = document.createElement('div');
        headingPositionButtonsDiv.classList.add('flex', 'space-x-4', 'mb-2', 'w-1/2');
        const positionOptions = ['left', 'center', 'right'];
        positionOptions.forEach(option => {
            const positionButton = document.createElement('button');
            positionButton.type = 'button';
            positionButton.classList.add('w-8', 'h-8', 'rounded-full', 'focus:outline-none');
            positionButton.innerHTML = getIconForPosition(option);
            positionButton.addEventListener('click', () => {
                // Set the selected position in the form data
                const positionInput = document.createElement('input');
                positionInput.type = 'hidden';
                positionInput.name = 'heading_position';
                positionInput.value = option;
                // Update the live view for heading position
                updateHeadingPosition(option);

                positionButton.appendChild(positionInput);

            });
            headingPositionButtonsDiv.appendChild(positionButton);
        });
        headingOptionsDiv.appendChild(headingPositionButtonsDiv);

        // Create the Heading Color buttons
        const headingColorButtonsDiv = document.createElement('div');
        headingColorButtonsDiv.classList.add('flex', 'space-x-4', 'w-1/2', 'justify-end');
        const colorOptions = ['blue', 'black', 'green'];
        colorOptions.forEach(option => {
            const colorButton = document.createElement('button');
            colorButton.type = 'button';
            colorButton.classList.add('w-8', 'h-8', 'rounded-full', 'focus:outline-none');
            colorButton.style.backgroundColor = option;
            colorButton.addEventListener('click', () => {
                // Set the selected color in the form data
                const colorInput = document.createElement('input');
                colorInput.type = 'hidden';
                colorInput.name = 'heading_color';
                colorInput.value = option;
                colorButton.appendChild(colorInput);
                // Update the live view for heading color
                updateHeadingColor(option);
            });
            headingColorButtonsDiv.appendChild(colorButton);
        });
        headingOptionsDiv.appendChild(headingColorButtonsDiv);

        // Add the full options ---->
        dynamicForm.appendChild(headingOptionsDiv)
        // dyanamicDiv.appendChild(headingOptionsDiv);

        headingSectionCreated = true; // Set the heading section status to created
        headingBtn.classList.add('hidden');
    }
}



function getIconForPosition(position) {
    if (position === 'left') {
        // return '&#x2190;'; // Unicode character for left arrow
        return `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">  <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" /></svg>`;
    } else if (position === 'center') {
        // return '&#x21D5;'; // Unicode character for up-down arrow
        return `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6"><path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" /></svg>`;
    } else if (position === 'right') {
        // return '&#x2192;'; // Unicode character for right arrow
        return `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">  <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" /></svg>`;
    }
    return '';
}




// Function to generate the Image section
function generateImageSection() {
    const imageSection = document.getElementById('image_section');
    if (imageSection) {
        imageSection.remove();
    }

    const uploadImageDiv = document.createElement('div');
    uploadImageDiv.id = 'image_section';
    uploadImageDiv.classList.add('m-5', 'p-5', 'flex', 'flex-wrap', 'border', 'border-5', 'shadow', 'justify-between');

    const posterImage = document.createElement('h2');
    posterImage.classList.add('flex', 'relative', 'bottom-11', 'bg-gray-300', 'px-5', 'py-3', 'rounded-lg');
    posterImage.innerHTML = 'Poster Image';
    uploadImageDiv.appendChild(posterImage);

    // Create the close button for the heading section
    const closeButton = document.createElement('button');
    closeButton.innerText = 'X';
    closeButton.classList.add('text-base', 'justify-end', 'cursor-pointer', 'flex', 'p-3', 'rounded-full', 'text-red-500', 'bg-gray-50', 'relative', 'bottom-11', 'left-9', 'font-bold');
    closeButton.addEventListener('click', () => {
        uploadImageDiv.remove();
        headingSectionCreated = false;
        imageBtn.classList.remove('hidden');
    });
    uploadImageDiv.appendChild(closeButton);

    // Create the Poster Image input
    const dropZone = document.createElement('div');
    dropZone.classList.add('w-full', 'h-40', 'border', 'border-dashed', 'bg-white', 'text-gray-400', 'border-gray-300', 'rounded', 'flex', 'flex-col', 'items-center', 'justify-center', 'cursor-pointer');
    dropZone.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" /> </svg> <p> <strong> Click to Upload </strong> or Drag & Drop Image <br> SVG, PNG, JPG or GIF (Max. 800x400px) </p> `;
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    fileInput.name = 'poster_image';
    // Handle the file selected event
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        handleImageFile(file);
    });

    // Handle the click event to open the file picker
    dropZone.addEventListener('click', () => {
        fileInput.click();
    });

    // Handle the drag and drop functionality
    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.classList.add('border-blue-500');
    });

    dropZone.addEventListener('dragleave', (event) => {
        event.preventDefault();
        dropZone.classList.remove('border-blue-500');
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.classList.remove('border-blue-500');
        const file = event.dataTransfer.files[0];
        handleImageFile(file);
    });

    dropZone.appendChild(fileInput);
    uploadImageDiv.appendChild(dropZone);
    dynamicForm.appendChild(uploadImageDiv)

    imageSectionCreated = true;
    imageBtn.classList.add('hidden');

}

// Function to handle the image file
function handleImageFile(file) {
    if (!file) {
        return;
    }
    const formData = new FormData();
    formData.append('poster_image', file);
    updateImageLiveView(file);
}


// function to update the live view with the current selected image
function updateImageLiveView(file) {
    const liveView = document.getElementById('live_image');
    if (!liveView) {
        console.error('Live view element not found.');
        return;
    }
    // Crete a FileReader to read the selected image and set it as the soure for the live view
    const reader = new FileReader();
    reader.onload = (event) => {
        liveView.src = event.target.result;
        // liveView.style.width = '100%'; // Set the image width to 100%
    };

    reader.readAsDataURL(file);
}


// Function to generate the Description section
function generateDescriptionSection() {
    const descriptionSection = document.getElementById('description_section');
    if (descriptionSection) {
        descriptionSection.remove();
    }

    // Create the new Description section
    const descriptionDiv = document.createElement('div');
    descriptionDiv.id = 'description_section';
    descriptionDiv.classList.add('m-5', 'p-5', 'flex', 'flex-wrap', 'border', 'border-5', 'shadow', 'justify-between');

    const descTitle = document.createElement('h2');
    descTitle.classList.add('flex', 'relative', 'bottom-11', 'bg-gray-300', 'px-5', 'py-3', 'rounded-lg');
    descTitle.innerHTML = 'Description';
    descriptionDiv.appendChild(descTitle);

    // Create the close button for the heading section
    const closeButton = document.createElement('button');
    closeButton.innerText = 'X';
    closeButton.classList.add('text-base', 'justify-end', 'cursor-pointer', 'flex', 'p-3', 'rounded-full', 'text-red-500', 'bg-gray-50', 'relative', 'bottom-11', 'left-9', 'font-bold');
    closeButton.addEventListener('click', () => {
        descriptionDiv.remove();
        headingSectionCreated = false;
        descriptionBtn.classList.remove('hidden');
    });
    descriptionDiv.appendChild(closeButton);

    const posterDescriptionTextarea = document.createElement('textarea');
    posterDescriptionTextarea.name = 'description';
    posterDescriptionTextarea.rows = '5';
    posterDescriptionTextarea.required = true;
    posterDescriptionTextarea.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:border-blue-500');

    descriptionDiv.appendChild(posterDescriptionTextarea);
    dynamicForm.appendChild(descriptionDiv)

    descriptionSectionCreated = true;
    descriptionBtn.classList.add('hidden');
}

// Function to handle button clicks
function handleButtonClick(type) {
    if (type === 'heading') {
        generateHeadingSection();
    } else if (type === 'image') {
        generateImageSection();
    } else if (type === 'description') {
        generateDescriptionSection();
    }

    // Check if all buttons are hidden
    if (areAllButtonsHidden()) {
        const title_items = document.getElementById('title_items');
        if (title_items) {
            title_items.style.display = 'none';
        }
    }
}

// Check if all buttons are hidden
function areAllButtonsHidden() {
    const headingBtn = document.querySelector('.bg-yellow-400');
    const imageBtn = document.querySelector('.bg-blue-400');
    const descriptionBtn = document.querySelector('.bg-green-400');

    return (
        headingBtn.classList.contains('hidden') &&
        imageBtn.classList.contains('hidden') &&
        descriptionBtn.classList.contains('hidden')
    );
}

// Call the defaultLoading() function to create the initial buttons
defaultLoading();

// Add event listeners to the buttons to control their visibility
const headingBtn = document.querySelector('.bg-yellow-400');
headingBtn.addEventListener('click', () => {
    generateHeadingSection();
});

const imageBtn = document.querySelector('.bg-blue-400');
imageBtn.addEventListener('click', () => {
    generateImageSection();
});

const descriptionBtn = document.querySelector('.bg-green-400');
descriptionBtn.addEventListener('click', () => {
    generateDescriptionSection();
});



const liveHeadingText = document.getElementById('live_heading_text');
function updateHeadingLiveView() {
    const heading = document.querySelector('[name="heading"]');
    if (heading) {
        const inputValue = heading.value;
        liveHeadingText.textContent = inputValue;
    }

}


// Function to update the live view with the current heading position
function updateHeadingPosition(position) {
    if (!liveHeadingText) {
        console.error('Live view element not found.');
        return;
    }
    liveHeadingText.style.textAlign = position;
}

// Function to update the live view with the current heading color
function updateHeadingColor(color) {
    if (!liveHeadingText) {
        console.error('Live view element not found.');
        return;
    }
    liveHeadingText.style.color = color;
}


// Function to updateDescription Live View
function updateDescriptionLiveView() {
    const description = document.querySelector('[name="description"]');
    if (description) {
        const inputValue = description.value;
        const livedescription = document.getElementById('live_description');
        livedescription.textContent = inputValue;
    }
}

// Listen for input events on the input field and call the updateHeadingLiveView function
document.addEventListener('input', function (event) {
    const target = event.target;
    if (target.name === 'heading') {
        updateHeadingLiveView();
    }
    if (target.name == 'description') {
        updateDescriptionLiveView();
    }
});