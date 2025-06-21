
  document.addEventListener("DOMContentLoaded", () => {
    const lista = document.getElementById("pedido-lista");
    const pedido = JSON.parse(localStorage.getItem("pedido")) || [];
    const total = parseFloat(localStorage.getItem("total")) || 0;

    if (pedido.length === 0) {
      lista.innerHTML = "<li id='pedido-feito'>Nenhum item encontrado no pedido.</li>";

      return;
    }

    // Exibe os itens do pedido
    pedido.forEach(item => {
      const li = document.createElement("li");
      li.textContent = `${item.nome} (${item.qntd}×) — R$ ${(item.preco * item.qntd).toFixed(2).replace('.', ',')}`;
      lista.appendChild(li);
    });

    // Exibe o total no final da lista
    const liTotal = document.createElement("li");
    liTotal.innerHTML = `<strong>Total: R$ ${total.toFixed(2).replace('.', ',')}</strong>`;
    lista.appendChild(liTotal);
  });
document.addEventListener("DOMContentLoaded", () => {
  const cepInput = document.getElementById("cep");
  const ruaInput = document.getElementById("rua");
  const bairroInput = document.getElementById("bairro");
  const cepErroDiv = document.createElement("div");
  cepErroDiv.style.color = "red";
  cepErroDiv.style.fontSize = "0.9em";
  cepErroDiv.style.marginTop = "4px";
  cepInput.insertAdjacentElement("afterend", cepErroDiv);

  // Busca e valida CEP
  cepInput.addEventListener("blur", () => {
    const cep = cepInput.value.replace(/\D/g, "");
    cepErroDiv.textContent = "";
    ruaInput.value = "";
    bairroInput.value = "";

    if (cep.length !== 8) {
      cepErroDiv.textContent = "CEP inválido. Informe 8 números.";
      return;
    }

    ruaInput.value = "...";
    bairroInput.value = "...";

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then((response) => response.json())
      .then((data) => {
        if (!data.erro) {
          ruaInput.value = data.logradouro || "";
          bairroInput.value = data.bairro || "";
        } else {
          cepErroDiv.textContent = "CEP não encontrado.";
          ruaInput.value = "";
          bairroInput.value = "";
        }
      })
      .catch(() => {
        cepErroDiv.textContent = "Erro ao buscar o CEP. Tente novamente.";
        ruaInput.value = "";
        bairroInput.value = "";
      });
  });

  // Modal
  const modal = document.getElementById("modal-sucesso");
  const btnFechar = document.getElementById("fechar-modal");
  const formEndereco = document.getElementById("form-endereco");

formEndereco.addEventListener("submit", (e) => {
  e.preventDefault();

  // Salva o tema atual antes de limpar
  const temaAtual = localStorage.getItem("tema");

  // Limpa todo o localStorage
  localStorage.clear();

  // Restaura o tema salvo
  if (temaAtual !== null) {
    localStorage.setItem("tema", temaAtual);
  }

  // Mostra o modal
  modal.style.display = "flex";

  // Após 3 segundos, fecha modal, reseta formulário e redireciona
  setTimeout(() => {
    modal.style.display = "none";
    formEndereco.reset();
    window.location.href = "Home.html";
  }, 3000);
})});
