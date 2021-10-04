"use strict";
function removeImage(fileToRemove, event) {
    var _a;
    const fileInput = document.querySelector('input[type="file"]');
    const files = fileInput.files;
    const target = event.target;
    if (files && fileToRemove) {
        const filesCopy = [...files];
        const fileIndex = filesCopy.indexOf(fileToRemove);
        filesCopy.splice(fileIndex, 1);
        const updatedFiles = new DataTransfer();
        filesCopy.forEach((file) => updatedFiles.items.add(file));
        fileInput.files = updatedFiles.files;
        (_a = target.closest('.image-container')) === null || _a === void 0 ? void 0 : _a.remove();
    }
}
function displayPreview(event) {
    const target = event.target;
    if (target.files) {
        const imagePreviewElement = document.querySelector('#image-preview');
        imagePreviewElement.textContent = '';
        for (const file of target.files) {
            const imageContainerElement = document.createElement('div');
            imageContainerElement.className = 'image-container';
            const imageElement = document.createElement('img');
            imageElement.src = URL.createObjectURL(file);
            const deleteCrossElement = document.createElement('div');
            deleteCrossElement.className = 'delete-cross';
            deleteCrossElement.addEventListener('click', removeImage.bind(null, file));
            imageContainerElement.append(imageElement, deleteCrossElement);
            imagePreviewElement.append(imageContainerElement);
        }
    }
}
const fileInput = document.querySelector('input[type="file"]');
fileInput === null || fileInput === void 0 ? void 0 : fileInput.addEventListener('change', displayPreview);
