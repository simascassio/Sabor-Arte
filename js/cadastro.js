
      function validarFormulario() {
        let valido = true;
        const nomematerno = document.getElementById("nomematerno").value;
        const nome = document.getElementById("nome").value;
        const cpf = document.getElementById("cpf").value;
        const email = document.getElementById("email").value;
        const telefone = document.getElementById("telefoneCelular").value;
        const telefonefixo = document.getElementById("telefonefixo").value;

        const login = document.getElementById("login").value;
        const senha = document.getElementById("senha").value;
        const confirmarSenha = document.getElementById("confirmarSenha").value;
        const dataNascimento = document.getElementById("dataNascimento").value;
        const cep = document.getElementById("cep").value;
        const endereco = document.getElementById("endereco").value;
        const numerocasa = document.getElementById("numerocasa").value;

        const regexNomematerno = /^[a-zA-Z\s]{15,80}$/;
        const regexNome = /^[a-zA-Z\s]{15,80}$/;
        const regexCPF = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        const regexEmail = /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/;
        const regexTelefone = /^\(\+55\)\d{2} \d{9}$/;
        const regexTelefonefixo = /^\(\+55\)\d{2} \d{9}$/;

        const regexLogin = /^[a-zA-Z]{6}$/;
        const regexSenha = /^[a-zA-Z]{8}$/;

        // Limpar erros anteriores
        const camposErro = ["data","cep","endereco", "numerocasa", "nome", "materno", "cpf", "email", "celular", "telefonefixo", "login", "senha", "confirmar"];
        camposErro.forEach(id => document.getElementById(`erro-${id}`).textContent = "");

        


        // Validações
        if (!regexNome.test(nome)) {
          document.getElementById("erro-nome").textContent = "Seu nome deve ter entre 15 e 80 letras.";
          valido = false;
        }
        if (!regexNomematerno.test(nomematerno)) {
          document.getElementById("erro-materno").textContent = "Nome materno deve ter entre 15 a 80 letras.";
          valido = false;
        }

        if (!regexCPF.test(cpf)) {
          document.getElementById("erro-cpf").textContent = "CPF inválido. Ex: 123.456.789-00";
          valido = false;
        }

        if (!regexEmail.test(email)) {
          document.getElementById("erro-email").textContent = "E-mail inválido.";
          valido = false;
        }

        if (!regexTelefone.test(telefone)) {
          document.getElementById("erro-celular").textContent = "Formato de telefone celular inválido.";
          valido = false;
        }

        if (!regexTelefonefixo.test(telefonefixo)) {
          document.getElementById("erro-telefonefixo").textContent = "Formato de telefone celular inválido.";
          valido = false;
        }

        if (!dataNascimento) {
          document.getElementById("erro-data").textContent = "Preencha a data de nascimento.";
          valido = false;
        }

        if (!/^\d{5}-\d{3}$/.test(cep)) {
          document.getElementById("erro-cep").textContent = "CEP deve seguir o formato 00000-000.";
          valido = false;
        }

        if (endereco.length < 10) {
          document.getElementById("erro-endereco").textContent = "Endereço incompleto. Verifique os dados.";
          valido = false;
        }
        if (numerocasa.length <2) {
          document.getElementById("erro-numerocasa").textContent = "Preencha o N° da Residência.";
          valido = false;
        }


        if (!regexLogin.test(login)) {
          document.getElementById("erro-login").textContent = "Login deve conter exatamente 6 letras.";
          valido = false;
        }

        if (!regexSenha.test(senha)) {
          document.getElementById("erro-senha").textContent = "Senha deve conter exatamente 8 letras.";
          valido = false;
        }

        if (senha !== confirmarSenha) {
          document.getElementById("erro-confirmar").textContent = "As senhas não coincidem.";
          valido = false;
        }

        

        return valido;
      }

      function buscarEndereco() {
        const cep = document.getElementById("cep").value.replace("-", "");
        const url = `https://viacep.com.br/ws/${cep}/json/`;

        fetch(url)
        .then(response => response.json())
        .then(data => {
          if (!data.erro) {
            document.getElementById("endereco").value =
                `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
          } else {
            document.getElementById("erro-cep").textContent = "CEP não encontrado, preencha manualmente.";
          }
        })
        .catch(() => {
          document.getElementById("erro-cep").textContent = "Erro ao buscar o endereço.";
        });
      }

    


    