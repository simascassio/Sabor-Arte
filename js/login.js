window.onload = () => {
  const nomeUsuario = localStorage.getItem("usuarioLogado");
  const spanNome = document.getElementById("nome-usuario");
  const btnSair = document.getElementById("btn-sair");
  const linkLogin = document.querySelector('.usuario-box a[href="Login.html"]');
  const icon = document.getElementById("usuario");

  if (nomeUsuario) {
    // Usuário logado: mostra ícone e nome, oculta "Login"
    if (spanNome) spanNome.textContent = nomeUsuario;
    if (linkLogin) linkLogin.style.display = "none";
    if (icon) icon.style.display = "inline-block"; // mostra ícone
    if (btnSair) btnSair.style.display = "none"; // botão sair oculto até clicar
  } else {
    // Usuário não logado: mostra "Login", oculta ícone e botão sair
    if (spanNome) spanNome.textContent = "";
    if (linkLogin) linkLogin.style.display = "inline-block";
    if (icon) icon.style.display = "none"; // oculta ícone
    if (btnSair) btnSair.style.display = "none";
  }
};

// Função chamada no formulário de login
function logar(event) {
  event.preventDefault();
  const nome = document.getElementById("input-nome-login").value.trim();

  if (nome !== "") {
    localStorage.setItem("usuarioLogado", nome);
    window.location.href = "Home.html"; // redireciona para a página inicial
  }
}

// Alterna visibilidade do botão sair ao clicar no ícone
function alternarSair() {
  const btnSair = document.getElementById("btn-sair");
  btnSair.style.display = (btnSair.style.display === "block") ? "none" : "block";
}

// Limpa o login
function sair() {
  localStorage.removeItem("usuarioLogado");
  window.location.reload(); // atualiza navbar
}

