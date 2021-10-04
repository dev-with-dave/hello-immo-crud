const tabElements = document.querySelectorAll('.tab');
const searchForm = document.querySelector('.tabs')?.nextElementSibling as HTMLFormElement | null;

for (const tabElement of tabElements) {
  tabElement.addEventListener('click', (event) => {
    for (const tabElement of tabElements) {
      tabElement.classList.remove('active');
    }

    const tab = event.target as HTMLDivElement;

    tab.classList.add('active');
    if (searchForm) searchForm.action = `/${tab.dataset.type!}`;
  });
}

searchForm?.addEventListener('submit', (event) => {
  const form = event.target as HTMLFormElement;
  const inputs = Array.from(form.querySelectorAll('input'));

  if (inputs.every((input) => !input.value)) {
    return event.preventDefault();
  }

  for (const input of inputs) {
    if (!input.value) input.name = '';
  }

  form.submit();
});

function changeImage(position?: number) {
  clearTimeout(timeout);
  timeout = setTimeout(changeImage, CAROUSEL_IMAGE_DURATION);

  const activeCarouselImageElement = document.querySelector('.carousel__image.active');
  const activeIndicatorElement = document.querySelector('.indicator.active');
  activeCarouselImageElement?.classList.remove('active');
  activeIndicatorElement?.classList.remove('active');

  const carouselImageElements = Array.from(document.querySelectorAll('.carousel__image'));
  const carouselIndicatorElements = Array.from(document.querySelectorAll('.indicator'));

  if (position && position >= 0) {
    carouselImageElements[position].classList.add('active');
    carouselIndicatorElements[position].classList.add('active');
    return;
  }

  if (
    activeCarouselImageElement?.nextElementSibling &&
    activeIndicatorElement?.nextElementSibling
  ) {
    activeCarouselImageElement.nextElementSibling.classList.add('active');
    activeIndicatorElement.nextElementSibling.classList.add('active');
    return;
  }

  carouselImageElements[0].classList.add('active');
  carouselIndicatorElements[0].classList.add('active');
}

function createIndicators() {
  const carouselImageCount = document.querySelectorAll('.carousel__image').length;

  for (let i = 0; i < carouselImageCount; i++) {
    const indicatorElement = document.createElement('div');
    indicatorElement.className = `indicator ${i === 0 ? 'active' : ''}`;
    indicatorElement.addEventListener('click', changeImage.bind(null, i));
    document.querySelector('.indicators')?.append(indicatorElement);
  }
}

const CAROUSEL_IMAGE_DURATION = 10000;

createIndicators();
let timeout = setTimeout(changeImage, CAROUSEL_IMAGE_DURATION);
