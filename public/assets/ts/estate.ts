const estateImagesElement = document.querySelector('.estate-images');
const estateBackdropElement = document.querySelector('.estate-backdrop');
const estateCardImage = document.querySelector('.estate-card__image') as HTMLDivElement;
estateCardImage?.addEventListener('click', () =>
  toggleBackdrop(estateCardImage.style.backgroundImage),
);
if (estateBackdropElement) estateBackdropElement.addEventListener('click', () => toggleBackdrop());

if (estateImagesElement) {
  const estateImageElements = estateImagesElement.querySelectorAll('div');
  for (const estateImageElement of estateImageElements) {
    estateImageElement.addEventListener('click', () =>
      toggleBackdrop(estateImageElement.style.backgroundImage),
    );
  }
}

function toggleBackdrop(image: string = '') {
  const estateBackdropElement = document.querySelector('.estate-backdrop') as HTMLDivElement;

  if (estateBackdropElement.classList.contains('visible')) {
    estateBackdropElement.classList.remove('visible');
    return;
  }

  const estateBackdropImageElement = estateBackdropElement.querySelector('div') as HTMLDivElement;

  estateBackdropImageElement.style.backgroundImage = image;

  estateBackdropElement?.classList.add('visible');
}
