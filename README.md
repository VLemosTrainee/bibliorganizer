<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  <br><br>
  <h1>📚 BookOrganizer</h1>
  <p><strong>Um sistema elegante e moderno para gestão de bibliotecas.</strong></p>
  <p>Desenvolvido com Laravel, Livewire e DaisyUI.</p>
  <br>
</div>

---

## 🌟 Sobre o Projeto

O **BookOrganizer** é uma aplicação web minimalista projetada para demonstrar as melhores práticas de desenvolvimento com o ecossistema Laravel. O projeto permite a gestão completa de uma coleção de livros, autores e editoras, com uma interface de utilizador moderna, reativa e segura.

<br>

<div align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-4F318B?style=for-the-badge" alt="Livewire">
  <img src="https://img.shields.io/badge/DaisyUI-5A0EF8?style=for-the-badge" alt="DaisyUI">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</div>

---

## ✨ Funcionalidades Principais

*   **Dashboard Informativa:**
    *   **Ações Rápidas:** Atalhos para adicionar novos livros, autores e editoras.
    *   **Visão Geral:** Estatísticas em tempo real sobre a sua coleção.
    *   **Carrosséis Dinâmicos:** Exibição animada dos 5 últimos livros adicionados e dos 5 mais baratos.
    *   **Destaques:** Cartões que mostram o autor e a editora com mais livros no acervo.

*   **Gestão de Livros (CRUD Completo):**
    *   **Busca Inteligente (Google Books API):** Adicione livros rapidamente apenas com o ISBN. O sistema busca e preenche automaticamente o nome, bibliografia, autores, editora e até a imagem da capa.
    *   **Listagem Avançada:** Pesquise por título, autor ou ISBN. Ordene por nome ou preço.
    *   **Edição e Apagamento:** Edite os detalhes de qualquer livro ou apague-o, preservando os dados dos autores e editoras.

*   **Gestão de Autores e Editoras:**
    *   CRUD completo para adicionar, editar e apagar autores e editoras.
    *   Sistema inteligente que evita a duplicação de registos.
    *   Regras de negócio que impedem o apagamento de autores/editoras com livros associados.

*   **Exportação para Excel:**
    *   Exporte a sua lista de livros, autores ou editoras para um ficheiro `.xlsx` formatado.
    *   Exporte a lista completa, apenas os resultados de uma pesquisa, ou apenas os itens que você selecionar manualmente.

*   **Segurança Robusta:**
    *   **Autenticação 2FA:** Os utilizadores podem ativar a autenticação de dois fatores no seu perfil para uma camada extra de segurança.
    *   **Criptografia de Dados:** Nomes de livros, autores, editoras e bibliografias são guardados de forma cifrada na base de dados.

---

## 🛠️ Tecnologias Utilizadas

*   **Backend:** Laravel 11
*   **Frontend:** Livewire 3, Alpine.js, Tailwind CSS
*   **UI/UX:** DaisyUI
*   **Base de Dados:** MySQL
*   **APIs Externas:** Google Books API (para busca de dados por ISBN)
*   **Ambiente de Desenvolvimento:** Laravel Herd

---

## 🚀 Como Executar o Projeto

1.  Clone o repositório:
    ```bash
    git clone https://github.com/VLemosTrainee/bibliorganizer.git
    ```
2.  Navegue para a pasta do projeto e instale as dependências:
    ```bash
    cd bibliorganizer
    composer install
    npm install
    ```
3.  Configure o seu ficheiro `.env` com as credenciais da base de dados.
4.  Execute as migrações:
    ```bash
    php artisan migrate
    ```
5.  Compile os assets:
    ```bash
    npm run dev
    ```
6.  Inicie o servidor (se não estiver a usar o Herd).

---

<div align="center">
  <p>Feito com ❤️ por <strong>Vinicius Lemos</strong></p>
</div>
