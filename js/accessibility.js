// Accessibility JS: font controls, contrast, TTS, and mobile variants
(function(){
  const getElement = (id) => document.getElementById(id);
  let fontSize = parseInt(localStorage.getItem('site-font-size') || 100, 10);
  const updateFontSize = () => {
    document.documentElement.style.fontSize = fontSize + '%';
    localStorage.setItem('site-font-size', fontSize);
  };
  const setThemeClass = (theme) => {
    document.documentElement.classList.remove('light-theme','dark-theme','red-theme');
    if (theme === 'dark') document.documentElement.classList.add('dark-theme');
    if (theme === 'red') document.documentElement.classList.add('red-theme');
    if (theme === 'light') document.documentElement.classList.add('light-theme');
    localStorage.setItem('site-theme', theme);
  };
  // Initialize
  document.addEventListener('DOMContentLoaded', () => {
    // restore font size
    fontSize = parseInt(localStorage.getItem('site-font-size') || 100, 10);
    updateFontSize();

    // restore theme
    const theme = localStorage.getItem('site-theme') || 'light';
    const select = getElement('theme-select');
    if (select) select.value = theme;
    setThemeClass(theme);

    // buttons
    const increase = getElement('increase-font');
    const decrease = getElement('decrease-font');
    const reset = getElement('reset-font');
    const contrast = getElement('toggle-contrast');
    const tts = getElement('tts-toggle');

    if (increase) increase.addEventListener('click', () => { fontSize += 10; updateFontSize(); });
    if (decrease) decrease.addEventListener('click', () => { if(fontSize > 50) { fontSize -= 10; updateFontSize(); }});
    if (reset) reset.addEventListener('click', () => { fontSize = 100; updateFontSize(); });
    if (contrast) contrast.addEventListener('click', () => { document.documentElement.classList.toggle('high-contrast'); });

    let ttsActive = false;
    let utterance;
    if (tts) tts.addEventListener('click', () => {
      if (!('speechSynthesis' in window)) { alert('Navegador não suporta síntese de voz.'); return; }
      if (!ttsActive) {
        utterance = new SpeechSynthesisUtterance(document.body.innerText);
        speechSynthesis.speak(utterance);
        ttsActive = true;
        tts.textContent = 'Parar';
      } else {
        speechSynthesis.cancel(); ttsActive = false; tts.textContent = 'Ouvir';
      }
    });

    const themeSelect = getElement('theme-select');
    if (themeSelect) themeSelect.addEventListener('change', (e) => setThemeClass(e.target.value));

    // Mobile control handlers (if mobile controls are present)
    const mobileIncrease = getElement('increase-font-mobile');
    const mobileDecrease = getElement('decrease-font-mobile');
    const mobileReset = getElement('reset-font-mobile');
    const mobileContrast = getElement('toggle-contrast-mobile');
    const mobileTts = getElement('tts-toggle-mobile');
    if (mobileIncrease) mobileIncrease.addEventListener('click', () => { fontSize += 10; updateFontSize(); });
    if (mobileDecrease) mobileDecrease.addEventListener('click', () => { if(fontSize > 50) { fontSize -= 10; updateFontSize(); }});
    if (mobileReset) mobileReset.addEventListener('click', () => { fontSize = 100; updateFontSize(); });
    if (mobileContrast) mobileContrast.addEventListener('click', () => { document.documentElement.classList.toggle('high-contrast'); });
    if (mobileTts) mobileTts.addEventListener('click', () => { if (!('speechSynthesis' in window)) { alert('Navegador não suporta síntese de voz.'); return; } if (!ttsActive) { utterance = new SpeechSynthesisUtterance(document.body.innerText); speechSynthesis.speak(utterance); ttsActive = true; mobileTts.textContent='Parar'; } else { speechSynthesis.cancel(); ttsActive=false; mobileTts.textContent='Ouvir'; } });

  });
})();
