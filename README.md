<div align="center">
  <img src="URL_DO_SEU_LOGOTIPO_AQUI" width="400" alt="BookOrganizer Logo">
  <br><br>
  <h1>📚 BookOrganizer</h1>
  <p><strong>Um sistema completo de gestão de biblioteca com requisições, roles e integração com APIs externas.</strong></p>
  <p>Desenvolvido com o ecossistema TALL (Tailwind, Alpine.js, Laravel, Livewire) e DaisyUI.</p>
  <br>
</div>

---

## 🌟 Sobre o Projeto

O **BookOrganizer** evoluiu de um simples catálogo para um sistema de gestão de biblioteca robusto e multifuncional. A aplicação foi desenhada para oferecer uma experiência de utilizador diferenciada para três tipos de acesso: **Visitante**, **Cidadão** (utilizador registado) e **Administrador**. O foco do projeto foi demonstrar as melhores práticas de desenvolvimento, incluindo segurança, interatividade em tempo real e integração com serviços de terceiros.

<br>

<div align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-4F318B?style=for-the-badge" alt="Livewire">
  <img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=black" alt="Alpine.js">
  <img src="https://img.shields.io/badge/DaisyUI-5A0EF8?style=for-the-badge" alt="DaisyUI">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</div>

---

## ✨ Arquitetura e Funcionalidades

O sistema está estruturado em torno de três níveis de acesso com funcionalidades específicas:

### 👤 **Visitante (Acesso Público)**
A página inicial (`/`) serve como uma montra pública do acervo, acessível sem necessidade de autenticação.
- **Montra de Livros:** Visualização do catálogo de livros disponíveis, com capas, títulos e autores.
- **Carrosséis Dinâmicos:** Apresentação animada dos "Recém-Adicionados", "Mais Baratos" e "Mais Populares", que se movem automaticamente.
- **Detalhes Rápidos:** Ao clicar num livro, um modal flutuante exibe os detalhes completos, incluindo a bibliografia.
- **Acesso à Aplicação:** Botões proeminentes para **Login** e **Registo** de novas contas (que são criadas com o `role` de "Cidadão" por defeito).

### 👨‍👩‍👧‍👦 **Cidadão (Utilizador Autenticado)**
Após o login, o cidadão é direcionado para uma dashboard personalizada.
- **Dashboard Pessoal:**
    - **Ações Rápidas:** Atalhos para "Gerir Perfil", "Pesquisar no Acervo" e "Minhas Requisições".
    - **Reputação Visível:** Exibição da sua pontuação de reputação (0-5 estrelas).
    - **Sugestões "Podes Gostar":** Um carrossel com sugestões de livros personalizadas, geradas por um algoritmo que analisa o seu histórico de leitura.
- **Pesquisa no Acervo:** Acesso à lista completa de livros, com ferramentas de pesquisa e ordenação.
- **Sistema de Requisições:**
    - Pode requisitar livros que tenham stock disponível.
    - Acompanha o status das suas requisições (`Pendente`, `Aprovada`, `Concluída`, etc.) na sua página "Minhas Requisições".
    - Visualiza o histórico completo, incluindo as datas e a avaliação do estado de conservação dos livros devolvidos.

### 👑 **Administrador (Gestão Total)**
O admin tem acesso a todas as funcionalidades do cidadão, mais um conjunto de ferramentas de gestão poderosas.
- **Dashboard de Admin:**
    - **Visão Geral:** Estatísticas em tempo real sobre o total de livros, autores e editoras.
    - **Destaques:** Cartões que mostram o autor e a editora com mais livros no acervo.
    - **Ações Rápidas:** Atalhos para todas as páginas de gestão, incluindo "Gerir Utilizadores" e "Gerir Requisições".
- **CRUD Completo:** Gestão total (Criar, Ler, Atualizar, Apagar) de **Livros**, **Autores** e **Editoras**, com formulários em modais e funcionalidades de edição.
- **Gestão de Utilizadores:**
    - Página protegida para listar todos os utilizadores.
    - Capacidade de alterar o `role` (promover para Admin ou rebaixar para Cidadão).
    - Ativar ou desativar contas de utilizadores.
    - Editar nome e email.
    - Apagar utilizadores (com regras de segurança para não apagar contas com histórico).
- **Gestão de Requisições:**
    - Painel central para visualizar e filtrar todas as requisições por status, utilizador, livro, etc.
    - Ações para **Aprovar** ou **Rejeitar** novos pedidos.
    - Ferramenta para **Confirmar a Devolução** de um livro.
- **Sistema de Reputação (Lado do Admin):**
    - Ao confirmar uma devolução, o admin avalia o estado de conservação do livro.
    - O sistema calcula e atualiza automaticamente a pontuação de reputação do utilizador com base nesta avaliação e em possíveis atrasos na entrega.

---

## 🔌 APIs e Serviços Externos

*   **Google Books API:** Utilizada no formulário de adição de livros. Ao inserir um ISBN, a aplicação conecta-se à API para buscar e preencher automaticamente os dados do livro, incluindo título, autores, editora, bibliografia e imagem da capa. A lógica também cria novos autores e editoras na base de dados se eles não existirem.
*   **Mailtrap.io:** Utilizado como servidor SMTP de desenvolvimento para capturar e depurar os emails transacionais da aplicação, como a notificação de requisição aprovada.

---

## 🛠️ Tecnologias e Segurança

*   **Stack:** Laravel 11, Livewire 3, Alpine.js, Tailwind CSS, DaisyUI.
*   **Base de Dados:** MySQL.
*   **Ambiente:** Laravel Herd.
*   **Segurança:**
    *   **Autenticação 2FA:** Disponível para todos os utilizadores.
    *   **Criptografia de Dados:** Dados sensíveis (nomes de livros, autores, bibliografias) são encriptados na base de dados.
    *   **Middleware de Admin:** Rotas de gestão críticas são protegidas para garantir que apenas administradores as possam aceder.
    *   **Regras de Negócio:** Lógica para prevenir a exclusão de dados interligados (ex: apagar uma editora que tem livros).

---

## 🚀 Como Executar o Projeto

1.  Clone o repositório.
2.  Instale as dependências com `composer install` e `npm install`.
3.  Configure o seu ficheiro `.env` e crie a base de dados.
4.  Execute as migrações com `php artisan migrate:fresh` para garantir uma estrutura limpa.
5.  Crie o link simbólico para o armazenamento com `php artisan storage:link`.
6.  Compile os assets com `npm run dev`.

---

<div align="center">
  <p>Desenvolvido por <strong>Vinicius Lemos</strong></p>
</div>
