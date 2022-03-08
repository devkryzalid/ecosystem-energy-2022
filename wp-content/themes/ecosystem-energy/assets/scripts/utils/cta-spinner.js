// Initialize rotating animation for contact-cta
const image = document.getElementById('cta-spinner');
if (image) {
  const speed = 0.1;
  const timer = 10;

  let rotation = 0;

  setInterval(() => {
    rotation = rotation > 360 ? 0 : (rotation + speed);
    image.style.transform = 'rotate(' + rotation + 'deg)'; 
  }, timer)
}