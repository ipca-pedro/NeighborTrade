# NT - Negócios e Trocas

## Configuração do Ambiente de Desenvolvimento

### Pré-requisitos

1. Instalar o [XAMPP](https://www.apachefriends.org/download.html)
2. Instalar o [Composer](https://getcomposer.org/download/)
3. Instalar o [Node.js](https://nodejs.org/)
4. Instalar o [Git](https://git-scm.com/downloads)

### Passos para Configuração

1. **Clonar o Repositório**
```bash
git clone [URL_DO_REPOSITÓRIO]
cd NT
```

2. **Configurar o XAMPP**
- Iniciar o Apache e MySQL no XAMPP Control Panel
- Acessar http://localhost/phpmyadmin
- Criar uma nova base de dados chamada 'nt'

3. **Configurar o Laravel**
```bash
# Instalar dependências do PHP
composer install

# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar o arquivo .env
# DB_DATABASE=nt
# DB_USERNAME=root
# DB_PASSWORD=

# Criar link simbólico para storage
php artisan storage:link

# Executar migrações
php artisan migrate
```

4. **Configurar o React**
```bash
# Entrar na pasta frontend
cd frontend

# Instalar dependências
npm install

# Instalar dependências adicionais
npm install react-router-dom react-bootstrap bootstrap axios
```

5. **Iniciar o Projeto**

Em terminais separados, execute:
```bash
# Terminal 1 - Backend Laravel
php artisan serve

# Terminal 2 - Frontend React
cd frontend
npm start
```

### Estrutura do Projeto

- `app/` - Backend Laravel
  - `Http/Controllers/` - Controladores
  - `Models/` - Modelos do banco de dados
  - `storage/app/public/comprovativos/` - Arquivos de comprovativo de morada
- `frontend/` - Frontend React
  - `src/components/auth/` - Componentes de autenticação
  - `src/services/` - Serviços e chamadas API

### Dependências

#### Backend (Laravel)
```json
{
    "require": {
        "php": "^8.1",
        "laravel/framework": "^10.0",
        "laravel/sanctum": "^3.2"
    }
}
```

#### Frontend (React)
```json
{
    "dependencies": {
        "react": "^18.2.0",
        "react-dom": "^18.2.0",
        "react-router-dom": "^6.0.0",
        "react-bootstrap": "^2.0.0",
        "bootstrap": "^5.0.0",
        "axios": "^1.0.0"
    }
}
```

### Funcionalidades Implementadas

#### Backend
1. Sistema de Autenticação
   - Login com token JWT
   - Registro com upload de comprovativo de morada
   - Logout
   - Rota protegida para dados do usuário

2. Modelos de Dados
   - Utilizador (User)
   - Morada (Address)
   - Imagem (Image)

3. Armazenamento de Arquivos
   - Upload de comprovativos de morada
   - Suporte para imagens (JPEG, PNG, JPG) e PDF
   - Armazenamento em storage/app/public/comprovativos

#### Frontend
1. Páginas de Autenticação
   - Login (/login)
   - Registro (/register)
   - Redirecionamento automático

2. Componentes React
   - Formulários com validação
   - Preview de imagens
   - Mensagens de erro
   - Integração com Bootstrap

3. Serviços
   - Integração com API Laravel
   - Gerenciamento de tokens
   - Upload de arquivos

### Endpoints da API

- `POST /api/auth/login` - Login
- `POST /api/auth/register` - Registro
- `POST /api/auth/logout` - Logout (requer autenticação)
- `GET /api/auth/me` - Dados do usuário (requer autenticação)

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
