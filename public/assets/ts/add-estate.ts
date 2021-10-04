function removeImage(fileToRemove: File, event: MouseEvent) {
  const fileInput = document.querySelector('input[type="file"]') as HTMLInputElement;
  const files = fileInput.files;
  const target = event.target as HTMLDivElement;

  if (files && fileToRemove) {
    const filesCopy = [...files];
    const fileIndex = filesCopy.indexOf(fileToRemove);
    filesCopy.splice(fileIndex, 1);

    const updatedFiles = new DataTransfer();

    filesCopy.forEach((file) => updatedFiles.items.add(file));
    fileInput.files = updatedFiles.files;

    target.closest('.image-container')?.remove();
  }
}

function displayPreview(event: Event) {
  const target = event.target as HTMLInputElement;

  if (target.files) {
    const imagePreviewElement = document.querySelector('#image-preview') as HTMLDivElement;
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
fileInput?.addEventListener('change', displayPreview);
