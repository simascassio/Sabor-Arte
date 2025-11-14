document.addEventListener('DOMContentLoaded', () => {
  const usuarioBox = document.getElementById('usuario-box');
  const usuarioIcon = document.getElementById('usuario');
  const usuarioMenu = document.getElementById('usuario-menu');

  // Se não existir (não logado), nada a fazer
  if (!usuarioBox || !usuarioIcon || !usuarioMenu) return;

  // Abre/fecha menu ao clicar no ícone ou no nome
  function toggleUsuarioMenu(e) {
    e.stopPropagation();
    const isOpen = usuarioMenu.style.display === 'block';
    usuarioMenu.style.display = isOpen ? 'none' : 'block';
    usuarioIcon.setAttribute('aria-expanded', !isOpen);
  }

  usuarioIcon.addEventListener('click', toggleUsuarioMenu);
  // também abre ao clicar no nome (melhora UX)
  const nomeSpan = document.getElementById('nome-usuario');
  if (nomeSpan) nomeSpan.addEventListener('click', toggleUsuarioMenu);

  // Fecha o menu se clicar fora
  document.addEventListener('click', (e) => {
    if (!e.target.closest('#usuario-box')) {
      if (usuarioMenu.style.display === 'block') {
        usuarioMenu.style.display = 'none';
        usuarioIcon.setAttribute('aria-expanded', 'false');
      }
    }
  });

  // Opcional: fecha com Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      usuarioMenu.style.display = 'none';
      usuarioIcon.setAttribute('aria-expanded', 'false');
    }
  });
});

