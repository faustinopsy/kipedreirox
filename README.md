# Ki-Pedreiro - Documentação do Projeto

Este documento detalha a arquitetura, o fluxo de dados e a estrutura do projeto **Ki-Pedreiro**. O objetivo é facilitar o entendimento para novos desenvolvedores e descrever como o sistema opera.

## 🏗️ Visão Geral da Arquitetura

O projeto utiliza uma **arquitetura Híbrida** composta por:

1.  **Frontend Estático (Landing Pages)**:
    - Localizado na raiz do projeto (`/`).
    - Desenvolvido em **HTML5, CSS3 e JavaScript (Vanilla)**.
    - Responsável pela apresentação pública (Home, Serviços, Projetos, Contato).
    - Arquivos principais: `index.html`, `servicos.html`, `contato.html`.

2.  **Backend MVC (API e Painel Admin)**:
    - Localizado na pasta `/backend`.
    - Desenvolvido em **PHP** seguindo o padrão **MVC (Model-View-Controller)**.
    - Utiliza **Bramus Router** para gerenciamento de rotas.
    - Responsável pela lógica de negócios, autenticação, interação com banco de dados e gerenciamento de conteúdo (Painel Administrativo).
    - Ponto de entrada: `/backend/index.php`.

## 📂 Estrutura de Diretórios

```plaintext
/
├── assets/                 # Recursos estáticos (CSS, JS, Imagens)
│   ├── css/                # Estilos (style.css)
│   ├── img/                # Imagens do site
│   └── js/                 # Scripts (main.js, navbar.js)
├── backend/                # Núcleo do sistema PHP
│   ├── Config.php          # (Raiz ou Database) Configurações de Banco de Dados
│   ├── Controllers/        # Lógica de controle (Admin, Auth, Servico, etc.)
│   ├── Core/               # Classes base (EmailService, Flash, Session)
│   ├── Database/           # Conexão e configuração DB
│   ├── Models/             # Modelos de dados
│   ├── Rotas/              # Definição das rotas (Rotas.php)
│   ├── Views/              # Templates HTML do painel administrativo
│   └── index.php           # Entry Point do Backend
├── vendor/                 # Dependências PHP (Composer)
├── index.html              # Página Inicial
├── contato.html            # Página de Contato
└── ... (outros HTMLs)
```

## 🔄 Fluxo de Informação (Data Flow)

### 1. Acesso Público (Visitante)
*   **Ação**: O usuário acessa o domínio principal (`/`).
*   **Fluxo**:
    1.  O servidor entrega o arquivo `index.html` estático.
    2.  O navegador carrega CSS (`style.css`) e JS (`main.js`).
    3.  Links de navegação levam a outros arquivos estáticos (`servicos.html`, etc.).

### 2. Fluxo Administrativo (Backend)
*   **Ação**: O administrador acessa o painel (ex: `/backend/login` ou rota configurada).
*   **Fluxo**:
    1.  A requisição chega em `backend/index.php`.
    2.  O `Bramus Router` analisa a URL e direciona para o **Controller** correspondente (definido em `backend/Rotas/Rotas.php`).
    3.  **Controller**:
        *   Valida a sessão/autenticação.
        *   Interage com o **Model** para buscar dados no Banco de Dados.
        *   Retorna uma **View** (página HTML dinâmica) ou JSON (se for API).

### 3. Integração Frontend-Backend (Estado Atual)
*   Atualmente, o frontend estático (`.html`) e o backend (`/backend`) operam de forma quase independente.
*   **Ponto de Atenção**: Formulários no frontend estático (como `contato.html`) tentam enviar dados para scripts que podem não estar integrados corretamente ao sistema de rotas do backend (ex: `enviaemail.php` vs Rotas do Controller).

## 🚀 Como Utilizar (Setup)

### Pré-requisitos
*   PHP 7.4 ou superior.
*   Composer.
*   Servidor Web (Apache/Nginx) ou PHP Built-in Server.
*   Banco de Dados MySQL.

### Instalação
1.  **Clone o repositório**:
    ```bash
    git clone https://github.com/FaustinoPSY/kipedreirox.git
    ```

2.  **Instale as dependências**:
    Navegue até a raiz ou pasta backend (dependendo de onde está o `composer.json`) e execute:
    ```bash
    composer install
    ```

3.  **Configuração do Banco de Dados**:
    *   Abra `backend/Database/Config.php`.
    *   Configure as credenciais (Host, Nome do Banco, Usuário, Senha).
    *   Importe o esquema do banco de dados (caso haja um arquivo SQL disponível).

4.  **Execução**:
    Para rodar localmente com PHP na raiz do projeto:
    ```bash
    php -S localhost:8000
    ```
    *   Frontend acessível em: `http://localhost:8000`
    *   Backend acessível em: `http://localhost:8000/backend`

## 🛠️ Tecnologias Principais
*   **Frontend**: HTML5, CSS3, JS Vanilla.
*   **Backend**: PHP.
*   **Rotas**: Bramus/Router.
*   **Email**: PHPMailer.
