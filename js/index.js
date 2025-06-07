// js/index.js

document.addEventListener("DOMContentLoaded", () => {
  // Animate product cards on scroll: fade-in effect
  const fadeElements = document.querySelectorAll('.fade-in');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.1
  });

  fadeElements.forEach(el => observer.observe(el));

  // Animate offer banner sliding continuously
  const offerTrack = document.getElementById('offerTrack');

  let position = 0;
  const speed = 1; // pixels per frame
  const offerTrackWidth = offerTrack.scrollWidth / 2; // since duplicated content

  function slideOffers(){
    position -= speed;
    if(Math.abs(position) >= offerTrackWidth){
      position = 0;
    }
    offerTrack.style.transform = `translateX(${position}px)`;
    requestAnimationFrame(slideOffers);
  }
  slideOffers();

  // Placeholder: Update cart count if needed - here example static number
  const cartCountElem = document.getElementById('cart-count');
  const cartCount = 3; // example, replace with real logic if you want

  if(cartCount > 0){
    cartCountElem.textContent = cartCount;
    cartCountElem.style.display = 'inline-block';
  } else {
    cartCountElem.style.display = 'none';
  }
});
