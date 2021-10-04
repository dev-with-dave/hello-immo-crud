"use strict";
const estateImagesElement = document.querySelector('.estate-images');
const estateBackdropElement = document.querySelector('.estate-backdrop');
const estateCardImage = document.querySelector('.estate-card__image');
estateCardImage === null || estateCardImage === void 0 ? void 0 : estateCardImage.addEventListener('click', () => toggleBackdrop(estateCardImage.style.backgroundImage));
if (estateBackdropElement)
    estateBackdropElement.addEventListener('click', () => toggleBackdrop());
if (estateImagesElement) {
    const estateImageElements = estateImagesElement.querySelectorAll('div');
    for (const estateImageElement of estateImageElements) {
        estateImageElement.addEventListener('click', () => toggleBackdrop(estateImageElement.style.backgroundImage));
    }
}
function toggleBackdrop(image = '') {
    const estateBackdropElement = document.querySelector('.estate-backdrop');
    if (estateBackdropElement.classList.contains('visible')) {
        estateBackdropElement.classList.remove('visible');
        return;
    }
    const estateBackdropImageElement = estateBackdropElement.querySelector('div');
    estateBackdropImageElement.style.backgroundImage = image;
    estateBackdropElement === null || estateBackdropElement === void 0 ? void 0 : estateBackdropElement.classList.add('visible');
}
