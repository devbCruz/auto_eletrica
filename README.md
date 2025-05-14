# ⚡ Auto Elétrica - Sistema de Gestão de Serviços

Sistema desenvolvido em PHP para gerenciar os serviços de uma auto elétrica.  
Este projeto passou por diversas melhorias e correções, listadas abaixo, com foco em funcionalidade, usabilidade e organização do código.

---

## ✅ Funcionalidades Adicionadas

### 1. 📦 Composer
- **Implementação do Composer** como gerenciador de dependências.
- Automatização da instalação e atualização de bibliotecas externas necessárias, como PHPMailer e DomPDF.

---

### 2. 📧 Envio de E-mails
- Criado o arquivo `enviar-email.php` utilizando a biblioteca **PHPMailer**.
- Implementado o uso de **variáveis de ambiente (.env)** para armazenar dados sensíveis como e-mail e senha.
- O envio de e-mail é acionado automaticamente ao finalizar um serviço na tela inicial.

---

### 3. ❌ Correção de Exclusão de Clientes
- Corrigido o erro que impedia a exclusão adequada dos clientes.
- Criado o arquivo `exclui-cli.php` para tratar a inativação corretamente (ao invés de exclusão direta).

---

### 4. 📊 Banco de Dados
- Adicionado o campo `email` nas tabelas `clientes` e `servicos` para viabilizar a comunicação com o cliente.
- Corrigida a origem dos dados da tela de valores, que estava incorretamente puxando da tabela `servicos` e passou a utilizar `servicos_baixados`.

---

### 5. 🧾 Geração de Relatórios em PDF
- Corrigido o erro que impedia a geração de relatórios.
- Adicionado ao projeto a biblioteca **DomPDF** para geração de relatórios em PDF dos serviços executados.

---

### 6. 🧹 Outras Correções e Melhorias

- 🔧 Corrigida a funcionalidade de **exclusão de serviços**.
- 🖌 Estilização da tabela de **serviços pendentes** na página inicial.
- 🎨 Estilizado o **botão de finalizar serviço** com layout mais moderno e visualmente destacado.
- ✅ Ajustado o comportamento do botão “Finalizar serviço” que não estava funcionando corretamente.
- 📄 Tela de **serviços baixados** agora apresenta os dados corretamente e está integrada à tela principal.

---

## 📂 Estrutura Atualizada do Projeto

auto_eletrica/
│
├── conexao.php # Conexão com o banco de dados
├── cadServico.php # Cadastro de serviços
├── excluir-cli.php # Inativação de clientes
├── servicos.php # Tela principal com serviços pendentes
├── enviar-email.php # Envio de e-mail com PHPMailer
├── pdf.php # Geração de relatórios com DomPDF
├── estilo.css # Estilizações gerais e layout
├── .env # Variáveis de ambiente (não versionado)
└── vendor/ # Dependências gerenciadas pelo Composer


---

## 💡 Próximas Melhorias (Sugestões)

- Implementar autenticação (login) para administradores.
- Adicionar filtros por data, cliente ou tipo de serviço.
- Melhorar layout responsivo para dispositivos móveis.
- Criar painel com gráficos estatísticos.

---

## 🙋‍♂️ Desenvolvedores

- **Bruno Cruz**  
- **João Claudio**  
- **Ruth Gomes**  
- **Amorim**
📧 bruno.cruz9653@gmail.com  
🎓 Projeto acadêmico  com foco em automação de processos simples para oficinas.

---

## 📜 Licença

Este projeto está sob a licença MIT.  
Você pode usar, modificar e distribuir livremente.

---


