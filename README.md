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

# Executar migrações
php artisan migrate
```

4. **Configurar o React**
```bash
# Entrar na pasta frontend
cd frontend

# Instalar dependências
npm install
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
- `frontend/` - Frontend React
  - `src/components/` - Componentes React
  - `src/services/` - Serviços e chamadas API

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
