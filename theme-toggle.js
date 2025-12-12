(function(){
  const KEY = 'site-theme-mode';
  const applyMode = (mode) => {
    if(mode === 'light'){
      document.documentElement.classList.remove('dark');
      document.documentElement.classList.add('light-theme');
    } else {
      document.documentElement.classList.remove('light-theme');
      document.documentElement.classList.add('dark');
    }
  };

  // create floating button
  const btn = document.createElement('button');
  btn.setAttribute('aria-label','Alternar tema claro/escuro');
  btn.id = 'theme-toggle-btn';
  btn.style.position = 'fixed';
  btn.style.right = '16px';
  btn.style.bottom = '16px';
  btn.style.zIndex = 9999;
  btn.style.border = 'none';
  btn.style.padding = '10px 12px';
  btn.style.borderRadius = '8px';
  btn.style.background = '#ec1313';
  btn.style.color = '#fff';
  btn.style.boxShadow = '0 6px 18px rgba(0,0,0,0.2)';
  btn.style.cursor = 'pointer';
  btn.style.fontWeight = '700';

  const updateLabel = (mode) => { btn.textContent = mode === 'light' ? 'Escuro' : 'Claro'; };

  btn.addEventListener('click', () => {
    const current = localStorage.getItem(KEY) === 'light' ? 'light' : 'dark';
    const next = current === 'light' ? 'dark' : 'light';
    localStorage.setItem(KEY, next);
    applyMode(next);
    updateLabel(next);
  });

  // on load
  const stored = localStorage.getItem(KEY) || (document.documentElement.classList.contains('dark') ? 'dark' : 'light');
  applyMode(stored);
  updateLabel(stored);

  document.addEventListener('DOMContentLoaded', () => {
    document.body.appendChild(btn);
  });
})();
