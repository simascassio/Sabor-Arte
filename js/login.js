// Executa assim que a página carrega
window.onload = () => {
  const nomeUsuario = localStorage.getItem("usuarioLogado");
  const spanNome = document.getElementById("nome-usuario");
  const btnSair = document.getElementById("btn-sair");
  const linkLogin = document.querySelector('a[href="Login.html"]');

  if (nomeUsuario) {
    // Se estiver logado, mostra nome, oculta o botão Login
    if (spanNome) spanNome.textContent = nomeUsuario;
    if (linkLogin) linkLogin.style.display = "none";
    if (btnSair) btnSair.style.display = "none";
  } else {
    // Se não estiver logado, limpa tudo
    if (spanNome) spanNome.textContent = "";
    if (linkLogin) linkLogin.style.display = "inline-block";
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
function alternarSair() {
  const btnSair = document.getElementById("btn-sair");
  btnSair.style.display = (btnSair.style.display === "block") ? "none" : "block";
}

// Limpa o login
function sair() {
  localStorage.removeItem("usuarioLogado");
  window.location.reload(); // recarrega a página para atualizar a navbar
}

