# NeighborTrade - Sistema de Negócios e Trocas

Plataforma comunitária para compra, venda e troca de produtos e serviços entre vizinhos, com um sistema de aprovação.

**⚠️ AVISO IMPORTANTE ⚠️**
Este repositório inclui o ficheiro `.env` diretamente no controlo de versão para simplificar a configuração inicial *neste contexto específico*. **Esta NÃO é uma prática de segurança recomendada** e não deve ser replicada em projetos reais ou públicos, pois expõe informações sensíveis como senhas e chaves de API.

## Índice

-   [Funcionalidades Principais](#funcionalidades-principais)
-   [Stack Tecnológica](#stack-tecnológica)
-   [Pré-requisitos Essenciais](#pré-requisitos-essenciais)
-   [Guia Rápido de Instalação (Após Clonar - Usando .env do Repositório)](#guia-rápido-de-instalação-após-clonar---usando-env-do-repositório)
-   [Executando o Projeto](#executando-o-projeto)
-   [Estrutura do Projeto](#estrutura-do-projeto)
-   [Banco de Dados](#banco-de-dados)
-   [Endpoints da API](#endpoints-da-api)
-   [Testando a API](#testando-a-api)
-   [Configurações Adicionais](#configurações-adicionais)
    -   [CORS](#cors-cross-origin-resource-sharing)
    -   [Armazenamento de Imagens](#armazenamento-de-imagens)
-   [Solução de Problemas Comuns](#solução-de-problemas-comuns)
-   [Próximas Funcionalidades](#próximas-funcionalidades)
-   [Contribuição](#contribuição)
-   [Extensões VS Code Recomendadas](#extensões-vs-code-recomendadas)

## Funcionalidades Principais

-   **Autenticação Segura:** Registo com validação, upload de comprovativo, login JWT.
-   **Gestão de Anúncios:** Criação/edição de anúncios de produtos ou serviços com múltiplas imagens.
-   **Sistema de Aprovação:** Administradores aprovam novos utilizadores e anúncios para manter a qualidade da plataforma.
-   **Listagem e Pesquisa:** Visualização de anúncios por categorias, tipo, vendedor e pesquisa por termos.
-   **Perfil de Utilizador:** Gestão de dados pessoais e visualização de anúncios próprios.
-   **Administração:** Dashboard com estatísticas e painéis para gestão de aprovações pendentes.
-   **Recuperação de Senha:** Fluxo seguro para redefinição de senha via email.

## Stack Tecnológica

-   **Backend:** PHP 8.2+ / Laravel 10+
-   **Frontend:** React.js 18+
-   **Banco de Dados:** MySQL 5.7+
-   **Servidor Web (Desenvolvimento):** Servidor embutido do PHP (`php artisan serve`), Servidor de desenvolvimento do Node/React (`npm start`)
-   **Gestor de Pacotes:** Composer (PHP), npm (Node.js)
-   **Controlo de Versão:** Git

## Pré-requisitos Essenciais

Antes de começar, garanta que tem instalado:

-   **PHP**: Versão 8.2+
-   **Composer**: Última versão
-   **MySQL**: Versão 5.7+ (ou MariaDB compatível) - **Importante:** O seu servidor MySQL local *deve* estar configurado para aceitar as credenciais (utilizador/senha) que estão definidas no ficheiro `.env` do repositório.
-   **Node.js**: Versão 16+
-   **npm**: Versão 8+ (vem com o Node.js)
-   **Git**
-   **Ferramenta de Gestão de BD:** Acesso ao [phpMyAdmin](https://www.phpmyadmin.net/) (comum com XAMPP) ou outra ferramenta como MySQL Workbench.

*(Opcional, mas recomendado para ambiente local: [XAMPP](https://www.apachefriends.org/download.html) ou [Laragon](https://laragon.org/download/))*

## Guia Rápido de Instalação (Após Clonar - Usando .env do Repositório)

Este guia assume que acabou de clonar o repositório e que o ficheiro `.env` **já está presente e configurado na raiz do projeto** (incluído no Git).

1.  **Clonar o Repositório (se ainda não o fez):**
    ```bash
    git clone https://github.com/ipca-pedro/NeighborTrade.git
    cd NeighborTrade
    ```

2.  **Configurar o Backend (Laravel):**
    *   Navegue até a pasta raiz do projeto (`NeighborTrade`).
    *   **Instalar dependências PHP:**
        ```bash
        composer install
        ```
        *(Não precisa copiar `.env.example` nem gerar chave, pois o `.env` já existe no repositório com a chave definida).*
    *   **Configurar Banco de Dados (Manualmente):**
        *   **Verifique** o ficheiro `.env` incluído no projeto para saber o nome da base de dados (`DB_DATABASE`) e as credenciais (`DB_USERNAME`, `DB_PASSWORD`).
        *   **Garanta que o seu servidor MySQL local está configurado** para aceitar conexões com o utilizador e senha definidos no ficheiro `.env`. (Ex: Se o `.env` diz `DB_USERNAME=root` e `DB_PASSWORD=`, o seu MySQL local deve ter um utilizador `root` sem senha).
        *   Aceda à sua ferramenta de gestão de MySQL (ex: phpMyAdmin).
        *   **Crie** uma nova base de dados com o nome exato que está no `.env` (ex: `neighbortrade`). Use codificação `utf8mb4_unicode_ci`.
        *   **Importe** o script SQL fornecido (`ER.sql` na raiz do projeto) para dentro da base de dados que acabou de criar.

3.  **Configurar o Frontend (React):**
    *   Navegue até a pasta do frontend:
        ```bash
        cd frontend
        ```
    *   **Instalar dependências JavaScript:**
        ```bash
        npm install
        ```
    *   Volte para a pasta raiz do projeto para o próximo passo:
        ```bash
        cd ..
        ```

## Executando o Projeto

Abra **dois terminais** na pasta raiz do projeto (`NeighborTrade`).

1.  **Terminal 1 - Iniciar Backend:**
    ```bash
    php artisan serve
    ```
    *(API disponível em `http://localhost:8000`)*

2.  **Terminal 2 - Iniciar Frontend:**
    ```bash
    # Navegue até a pasta frontend
    cd frontend
    # Inicie o servidor de desenvolvimento React
    npm start
    ```
    *(Aplicação disponível em `http://localhost:3000`)*

A aplicação deve abrir automaticamente no seu navegador em `http://localhost:3000`.

## Estrutura do Projeto
NeighborTrade/
├── app/ # Lógica principal do Laravel (Controllers, Models, etc.)
│ ├── Http/
│ │ ├── Controllers/ # Controladores (AuthController, AnuncioController, etc.)
│ │ └── Middleware/ # Middlewares (Autenticação, CORS)
│ ├── Models/ # Modelos Eloquent (Utilizador, Anuncio, Morada, etc.)
│ └── Providers/ # Service Providers
├── bootstrap/ # Ficheiros de inicialização do Laravel
├── config/ # Ficheiros de configuração (database, cors, app)
├── database/ # Migrations e Seeders
│ ├── migrations/
│ └── seeders/
├── public/ # Pasta pública web (index.php)
│ └── storage/ # Link simbólico para storage/app/public
├── resources/ # Views (se usar Blade), assets não compilados
├── routes/ # Definição de rotas (api.php, web.php)
├── storage/ # Ficheiros gerados (logs, cache, ficheiros carregados)
│ ├── app/
│ │ └── public/ # Ficheiros acessíveis publicamente
│ │ ├── perfil/
│ │ └── produtos/
│ └── logs/
├── tests/ # Testes unitários e de funcionalidade
├── vendor/ # Dependências do Composer
├── frontend/ # Aplicação React
│ ├── public/ # Ficheiros estáticos do React (index.html)
│ ├── src/ # Código fonte do React
│ │ ├── components/ # Componentes reutilizáveis (Auth, Layout, Anuncios)
│ │ ├── pages/ # Componentes de página (HomePage, LoginPage, AnuncioDetailsPage)
│ │ ├── services/ # Lógica de chamadas à API (axios)
│ │ ├── App.js # Componente principal e rotas do React
│ │ └── index.js # Ponto de entrada do React
│ ├── node_modules/ # Dependências do npm
│ └── package.json # Configuração e dependências do frontend
├── .env # Configurações de ambiente (INCLUÍDO NESTE REPO)
├── .env.example # Exemplo de ficheiro .env
├── composer.json # Dependências do PHP (Backend)
├── artisan # CLI do Laravel
├── ER.sql # (Opcional) Dump da estrutura do banco de dados
└── README.md # Este ficheiro


## Banco de Dados

O banco de dados MySQL é estruturado para suportar todas as funcionalidades da plataforma. As tabelas principais incluem:

-   `utilizador`: Armazena informações dos usuários (nome, email, senha, CC, status, tipo).
-   `morada`: Endereços associados aos usuários.
-   `anuncio`: Detalhes dos anúncios (título, descrição, preço, tipo, categoria, status).
-   `imagem`: Caminhos das imagens associadas aos anúncios e perfis.
-   `categoria`: Categorias de anúncios (ex: Eletrónicos, Mobiliário, Serviços).
-   `aprovacao`: Registo de aprovações/rejeições de usuários e anúncios pelos administradores.
-   `password_resets`: Tokens para recuperação de senha.
-   Tabelas de relacionamento (ex: `item_imagem`).
-   Tabelas de suporte para status (ex: `status_anuncio`, `status_utilizador`).

A estrutura completa pode ser criada executando `php artisan migrate` após configurar o `.env` e criar a base de dados vazia.

## Endpoints da API

A API RESTful fornece os dados necessários para o frontend. Alguns endpoints principais (prefixo `/api`):

#### Autenticação (`/auth`)

-   `POST /register`: Registo de novo utilizador (com upload de comprovativo).
-   `POST /login`: Autenticação e obtenção de token JWT.
-   `POST /logout`: Invalidação do token atual (requer autenticação).
-   `GET /profile`: Obtenção dos dados do utilizador autenticado (requer autenticação).
-   `POST /password/forgot`: Solicitação de reset de senha.
-   `POST /password/reset`: Efetivação do reset de senha com token.

#### Anúncios (`/anuncios`)

-   `GET /`: Listar anúncios ativos (com filtros opcionais).
-   `GET /{id}`: Ver detalhes de um anúncio específico.
-   `POST /`: Criar novo anúncio (requer autenticação, com upload de imagens).
-   `PUT /anuncios/{id}`: Atualizar um anúncio existente (requer autenticação e ser o dono).
-   `DELETE /{id}`: Marcar um anúncio como eliminado (soft delete, requer autenticação e ser o dono).
-   `GET /categoria/{id}`: Listar anúncios por categoria.
-   `GET /vendedor/{id}`: Listar anúncios de um vendedor específico.
-   `GET /procurar?termo={termo}`: Pesquisar anúncios por título ou descrição.

#### Moradas (`/moradas`)

-   `GET /`: Listar todas as moradas disponíveis para seleção no registo.
-   `POST /`: (Potencialmente restrito a admin) Adicionar nova morada.

#### Administração (`/admin`) - *Rotas protegidas para administradores*

-   `GET /usuarios/pendentes`: Listar utilizadores aguardando aprovação.
-   `POST /usuarios/{id}/aprovar`: Aprovar ou rejeitar um utilizador.
-   `GET /anuncios/pendentes`: Listar anúncios aguardando aprovação.
-   `POST /anuncios/{id}/aprovar`: Aprovar ou rejeitar um anúncio.
-   `GET /dashboard`: Obter estatísticas gerais da plataforma.

**Documentação Completa:** A documentação interativa (se gerada, ex: Swagger) pode estar disponível em `/api/documentation`.

## Testando a API

Pode testar os endpoints da API usando ferramentas como:

1.  **Postman / Insomnia / Thunder Client (Extensão VS Code):**
    *   Importe o ficheiro `testes_api.json` (se fornecido na raiz) para ter exemplos de requisições prontas.
    *   Crie requisições manualmente:
        *   Selecione o método (GET, POST, PUT, DELETE).
        *   Insira a URL completa (ex: `http://localhost:8000/api/anuncios`).
        *   Para POST/PUT, defina o `Body` como `form-data` (para uploads) ou `raw` (JSON) e configure os `Headers` (ex: `Accept: application/json`, `Content-Type: application/json`).
        *   Para rotas protegidas, adicione o Header `Authorization` com o valor `Bearer SEU_TOKEN_JWT`.

2.  **cURL (Linha de Comando):**
    ```bash
    # Listar anúncios (GET)
    curl -X GET http://localhost:8000/api/anuncios

    # Login (POST com JSON)
    curl -X POST http://localhost:8000/api/auth/login -H "Content-Type: application/json" -H "Accept: application/json" -d '{"Email": "user@example.com", "Password": "password"}'

    # Listar perfil (GET com token)
    curl -X GET http://localhost:8000/api/auth/profile -H "Authorization: Bearer SEU_TOKEN_JWT" -H "Accept: application/json"
    ```

3.  **Navegador:**
    *   Endpoints `GET` que não requerem autenticação podem ser acedidos diretamente no navegador (ex: `http://localhost:8000/api/anuncios`).

**Respostas Esperadas:**
-   **2xx (Sucesso):** Geralmente `200 OK` ou `201 Created`, com dados em JSON no corpo.
-   **4xx (Erro do Cliente):** `400 Bad Request` (dados inválidos), `401 Unauthorized` (não autenticado), `403 Forbidden` (sem permissão), `404 Not Found` (recurso não encontrado), `422 Unprocessable Entity` (erro de validação).
-   **5xx (Erro do Servidor):** Indica um problema no backend. Verifique os logs do Laravel (`storage/logs/laravel.log`).

## Configurações Adicionais

### CORS (Cross-Origin Resource Sharing)

-   Configurado em `config/cors.php`.
-   Permite que o frontend (`http://localhost:3000`) faça requisições para o backend (`http://localhost:8000`).
-   A configuração padrão (`'allowed_origins' => ['*']`) é permissiva para desenvolvimento.
-   **Em produção, restrinja `allowed_origins`** para o domínio do seu frontend (ex: `['https://www.neighbortrade.com']`).

### Armazenamento de Imagens

-   Imagens de perfil e produtos são salvas em `storage/app/public/perfil` e `storage/app/public/produtos`, respetivamente.
-   O comando `php artisan storage:link` cria um link simbólico de `public/storage` para `storage/app/public`, tornando esses ficheiros acessíveis via web.
-   Certifique-se de que o servidor web (PHP/Apache/Nginx) tem permissões de escrita nestes diretórios.

## Solução de Problemas Comuns

-   **Erro de conexão DB:** Verifique as credenciais no `.env` e se o MySQL está a correr e a base de dados existe.
-   **Imagens não aparecem (404):** Garanta que `php artisan storage:link` foi executado com sucesso e verifique as permissões da pasta `storage/app/public`. Verifique se `APP_URL` no `.env` está correto (ex: `APP_URL=http://localhost:8000`).
-   **Erro "Class not found":** Execute `composer dump-autoload`.
-   **Erro CORS:** Verifique `config/cors.php`. Limpe caches (`php artisan cache:clear`, `php artisan config:clear`, cache do navegador).

## Próximas Funcionalidades

-   [ ] **Sistema de Chat:** Comunicação em tempo real entre utilizadores interessados em anúncios.
-   [ ] **Sistema de Trocas:** Funcionalidade para propor e negociar trocas de produtos/serviços.
-   [ ] **Sistema de Avaliações:** Permitir que utilizadores avaliem vendedores/compradores após uma transação/troca.
-   [ ] **Notificações:** Avisos sobre novas mensagens, propostas, aprovações, etc.
-   [ ] **Pagamentos:** Integração com gateway de pagamento para transações monetárias seguras (opcional).
-   [ ] **Melhorias de UI/UX:** Refinamento da interface e experiência do utilizador.

## Contribuição

Contribuições são bem-vindas! Siga estes passos:

1.  Faça um **Fork** do repositório.
2.  Crie uma nova **Branch** para a sua funcionalidade ou correção:
    ```bash
    git checkout -b feature/nome-da-sua-feature # ou fix/descricao-do-bug
    ```
3.  Faça as suas alterações e **Commit**:
    ```bash
    git add .
    git commit -m "feat: Adiciona funcionalidade X" # ou "fix: Corrige problema Y"
    ```
4.  Faça **Push** para a sua branch no seu fork:
    ```bash
    git push origin feature/nome-da-sua-feature
    ```
5.  Abra um **Pull Request** no repositório original, descrevendo as suas alterações.

## Extensões VS Code Recomendadas

Para facilitar o desenvolvimento, considere instalar estas extensões no Visual Studio Code:

**Geral & Utilidades:**
-   `eamodio.gitlens`: Superpoderes para o Git (blame, histórico).
-   `mhutchie.git-graph`: Visualização gráfica do histórico Git.
-   `mikestead.dotenv`: Destaque de sintaxe para ficheiros `.env`.
-   `christian-kohler.path-intellisense`: Autocompletar caminhos de ficheiros.
-   `formulahendry.auto-rename-tag`: Renomeia tags HTML/XML automaticamente.
-   `rangav.vscode-thunder-client`: Cliente REST API dentro do VS Code (alternativa ao Postman).
-   `PKief.material-icon-theme`: Ícones para ficheiros e pastas.
-   `zhuangtongfa.material-theme` ou `dracula-theme.theme-dracula`: Temas populares.

**PHP/Laravel (Backend):**
-   `bmewburn.vscode-intelephense-client`: IntelliSense avançado para PHP.
-   `xdebug.php-debug`: Debugging PHP com Xdebug.
-   `MehediDracula.php-namespace-resolver`: Importa e organiza namespaces PHP.
-   `neilbrayfield.php-docblocker`: Gera blocos de documentação PHPDoc.
-   `onecentlin.laravel-blade`: Snippets e formatação para Blade.
-   `shufo.vscode-blade-formatter`: Formatador para ficheiros Blade.

**JavaScript/React (Frontend):**
-   `dbaeumer.vscode-eslint`: Integração com ESLint para linting de JS/TS.
-   `esbenp.prettier-vscode`: Formatador de código automático (requer configuração).
-   `dsznajder.es7-react-js-snippets`: Snippets úteis para React/Redux/JS moderno.

**Banco de Dados:**
-   `mtxr.sqltools`: Cliente SQL genérico.
-   `mtxr.sqltools-driver-mysql`: Driver MySQL para SQLTools.

**Como Instalar:**
-   Abra o VS Code.
-   Vá à aba de Extensões (ícone de quadrados no lado esquerdo ou `Ctrl+Shift+X`).
-   Pesquise pelo nome ou ID da extensão e clique em "Install".

---

*Nota de Segurança: Incluir o ficheiro `.env` diretamente no controlo de versão (Git) não é uma prática recomendada, pois pode expor informações sensíveis como senhas e chaves de API. Para projetos futuros ou públicos, é fortemente aconselhável adicionar o ficheiro `.env` ao seu `.gitignore` e fornecer um ficheiro `.env.example` como modelo para que cada desenvolvedor configure o seu próprio ambiente.*
