function handle_drag(dropArea, output, allowedTypes) {
    function isValidFileType(file) {
        return allowedTypes.includes(file[0].type);
    }
    
    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        if (!isValidFileType(files)) {return false}
        if (files.length) {
            output[0].files = files;
            handle_upload(output);
        }
    }

    function preventDefaults(event) {
        event.preventDefault();
        event.stopPropagation();
    }

    dropArea[0].addEventListener('dragover', preventDefaults);
    dropArea[0].addEventListener('dragenter', preventDefaults);
    dropArea[0].addEventListener('dragleave', preventDefaults);

    dropArea[0].addEventListener('drop', handleDrop);
}
