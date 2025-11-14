document.addEventListener('DOMContentLoaded', () => {
  const darkBtn = document.getElementById('dark-btn');
  const lightBtn = document.getElementById('light-btn');
  const body = document.body;

  const temaSalvo = localStorage.getItem('tema');

  if (temaSalvo === 'dark') {
    body.classList.add('dark-mode');
    darkBtn.style.display = 'none';
    lightBtn.style.display = 'block';
  } else {
    body.classList.remove('dark-mode');
    darkBtn.style.display = 'block';
    lightBtn.style.display = 'none';
  }

  darkBtn.addEventListener('click', () => {
    body.classList.add('dark-mode');
    localStorage.setItem('tema', 'dark');
    darkBtn.style.display = 'none';
    lightBtn.style.display = 'block';
  });

  lightBtn.addEventListener('click', () => {
    body.classList.remove('dark-mode');
    localStorage.setItem('tema', 'light');
    darkBtn.style.display = 'block';
    lightBtn.style.display = 'none';
  });
});
