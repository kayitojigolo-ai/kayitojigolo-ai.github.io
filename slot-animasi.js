function spinReels() {
  const reels = document.querySelectorAll('.reel');
  reels.forEach(reel => {
    reel.innerHTML = '';
    for (let i = 0; i < 3; i++) {
      const sym = getRandomSymbol();
      const div = document.createElement('div');
      div.className = 'symbol';
      div.textContent = sym;
      reel.appendChild(div);
    }
  });
}
