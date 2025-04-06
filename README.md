# NT - Negócios e Trocas

## Configuração do Ambiente de Desenvolvimento

### Requisitos Prévios

1. [XAMPP](https://www.apachefriends.org/download.html) - Servidor local Apache e MySQL
2. [Composer](https://getcomposer.org/download/) - Gestor de dependências PHP
3. [Node.js](https://nodejs.org/) - Ambiente de execução JavaScript
4. [Git](https://git-scm.com/downloads) - Sistema de controlo de versões

### Configuração Passo a Passo

1. **Clonar o Projeto na pasta C:\xampp\htdocs**
```bash
git clone https://github.com/ipca-pedro/NeighborTrade
cd NT
```

2. **Configurar Base de Dados**
- Iniciar Apache e MySQL no Painel de Controlo do XAMPP
- Aceder ao http://localhost/phpmyadmin
- Criar uma nova base de dados com o nome 'nt'

3. **Configurar Backend (Laravel)**
```bash
# Instalar dependências PHP
composer install

# Copiar e configurar ficheiro de ambiente
cp .env.example .env

# Configurar .env com os dados da base de dados:
DB_DATABASE=nt
DB_USERNAME=root
DB_PASSWORD=

# Gerar chave da aplicação
php artisan key:generate

# Criar ligação simbólica para armazenamento
php artisan storage:link

# Executar migrações da base de dados
php artisan migrate
```

4. **Configurar Frontend (React)**
```bash
# Criar e aceder à pasta do frontend
cd frontend

# Instalar dependências base do React
npm install

# Instalar pacotes necessários:

# react-router-dom - Gestão de rotas
npm install react-router-dom

# react-bootstrap e bootstrap - Interface gráfica
npm install react-bootstrap bootstrap

# axios - Cliente HTTP para chamadas à API
npm install axios
```

5. **Iniciar a Aplicação**

Abrir dois terminais separados e executar:
```bash
# Terminal 1 - Servidor Laravel (Backend)
cd NT
php artisan serve

# Terminal 2 - Servidor React (Frontend)
cd NT/frontend
npm start
```

A aplicação estará disponível em:
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000

### Estrutura do Projeto

#### Backend (Laravel)
- `app/`
  - `Http/Controllers/` - Controladores da aplicação
  - `Models/` - Modelos da base de dados
  - `storage/app/public/comprovativos/` - Ficheiros de comprovativos de morada

#### Frontend (React)
- `frontend/`
  - `src/`
    - `components/`
      - `auth/` - Componentes de autenticação (Login e Registo)
      - `layout/` - Componentes de estrutura (Navbar, etc)
    - `services/` - Serviços e chamadas à API
    - `App.js` - Componente principal e rotas

### Pacotes e Dependências

#### Backend (Laravel)
- **Laravel Framework** (^10.0)
  - Framework PHP para desenvolvimento web
  - Inclui sistema de rotas, ORM Eloquent, etc

- **Laravel Sanctum** (^3.2)
  - Sistema de autenticação via tokens
  - Proteção de rotas da API

#### Frontend (React)

1. **Pacotes Base**
   - `react` (^18.2.0)
     - Biblioteca principal do React
   - `react-dom` (^18.2.0)
     - Renderização do React no navegador

2. **Gestão de Rotas**
   - `react-router-dom` (^6.0.0)
     - Navegação entre páginas
     - Proteção de rotas
     - Redirecionamentos

3. **Interface Gráfica**
   - `react-bootstrap` (^2.0.0)
     - Componentes Bootstrap para React
     - Formulários, botões, alertas, etc
   - `bootstrap` (^5.0.0)
     - Framework CSS para estilos

4. **Chamadas à API**
   - `axios` (^1.0.0)
     - Cliente HTTP para comunicação com backend
     - Gestão de headers e tokens
     - Upload de ficheiros

### Funcionalidades

#### Sistema de Autenticação
1. **Registo de Utilizador**
   - Formulário completo com validação
   - Upload de comprovativo de morada
   - Pré-visualização de imagens
   - Criação automática de conta

2. **Login**
   - Autenticação segura
   - Gestão de tokens JWT
   - Armazenamento em localStorage

3. **Proteção de Rotas**
   - Frontend: Redirecionamento automático
   - Backend: Middleware de autenticação

#### Armazenamento de Ficheiros
- Suporte para imagens (JPEG, PNG) e PDF
- Validação de tipos e tamanhos
- Armazenamento seguro no servidor
- Nomes únicos para evitar conflitos

### Endpoints da API

#### Autenticação
- `POST /api/auth/login`
  - Login do utilizador
  - Recebe: `{ Email, Password }`
  - Retorna: Token e dados do utilizador

- `POST /api/auth/register`
  - Registo de novo utilizador
  - Recebe: Formulário multipart com dados e ficheiro
  - Retorna: Token e dados do utilizador

- `POST /api/auth/logout`
  - Terminar sessão
  - Requer: Token de autenticação
  - Retorna: Mensagem de sucesso

- `GET /api/auth/me`
  - Dados do utilizador atual
  - Requer: Token de autenticação
  - Retorna: Dados completos do utilizador

### Contribuição

1. Crie uma branch para sua feature
```bash
git checkout -b feature/nome-da-feature
```

2. Faça commit das mudanças
```bash
git add .
git commit -m "Descrição das mudanças"
```

3. Faça push para o repositório
```bash
git push origin feature/nome-da-feature
```

4. Crie um Pull Request
