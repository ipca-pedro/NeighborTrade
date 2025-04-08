# Documentação da API NeighborTrade

## Introdução

Esta documentação descreve os endpoints disponíveis na API NeighborTrade, uma plataforma para comércio local entre vizinhos. A API foi desenvolvida utilizando o framework Laravel e segue os princípios RESTful.

## Autenticação

A API utiliza o Laravel Sanctum para autenticação baseada em tokens. Para aceder a rotas protegidas, é necessário incluir o token de autenticação no cabeçalho da requisição:

```
Authorization: Bearer {token}
```

## Endpoints

### Autenticação e Gestão de Utilizadores

#### Registo de Utilizador
- **URL**: `/api/auth/register`
- **Método**: `POST`
- **Autenticação**: Não
- **Parâmetros**:
  - `User_Name` (obrigatório): Nome de utilizador único
  - `Name` (obrigatório): Nome completo
  - `Email` (obrigatório): Email válido e único
  - `Password` (obrigatório): Palavra-passe (mínimo 8 caracteres)
  - `Password_confirmation` (obrigatório): Confirmação da palavra-passe
  - `CC` (opcional): Número de cartão de cidadão
  - `Data_Nascimento` (opcional): Data de nascimento (formato: YYYY-MM-DD)
  - `MoradaID_Morada` (obrigatório): ID da morada selecionada
  - `comprovativo_morada` (obrigatório): Comprovativo de morada (formatos: jpeg, png, jpg, pdf)
- **Resposta de Sucesso**:
  - Código: `201 Created`
  - Conteúdo: `{ "message": "Registo realizado com sucesso", "user": {...}, "token": "..." }`

#### Login
- **URL**: `/api/auth/login`
- **Método**: `POST`
- **Autenticação**: Não
- **Parâmetros**:
  - `Email` (obrigatório): Email do utilizador
  - `Password` (obrigatório): Palavra-passe
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "user": {...}, "token": "..." }`

#### Logout
- **URL**: `/api/auth/logout`
- **Método**: `POST`
- **Autenticação**: Sim

### Moradas

#### Teste de API
- **URL**: `/api/moradas/test`
- **Método**: `GET`
- **Autenticação**: Não
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "API funcionando corretamente" }`

#### Listar Moradas
- **URL**: `/api/moradas`
- **Método**: `GET`
- **Autenticação**: Não
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `[{ "ID_Morada": 1, "Rua": "Nome da Rua" }, ...]`

#### Criar Morada
- **URL**: `/api/moradas`
- **Método**: `POST`
- **Autenticação**: Não
- **Parâmetros**:
  - `Rua` (obrigatório): Nome da rua
- **Resposta de Sucesso**:
  - Código: `201 Created`
  - Conteúdo: `{ "ID_Morada": 1, "Rua": "Nome da Rua" }`
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Logout efetuado com sucesso" }`

#### Informações do Utilizador Atual
- **URL**: `/api/auth/me`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "user": {...} }`

#### Alteração de Palavra-passe
- **URL**: `/api/auth/change-password`
- **Método**: `PUT`
- **Autenticação**: Sim
- **Parâmetros**:
  - `current_password` (obrigatório): Palavra-passe atual
  - `password` (obrigatório): Nova palavra-passe (mínimo 8 caracteres)
  - `password_confirmation` (obrigatório): Confirmação da nova palavra-passe
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Palavra-passe alterada com sucesso" }`

#### Eliminação de Conta
- **URL**: `/api/auth/delete-account`
- **Método**: `DELETE`
- **Autenticação**: Sim
- **Parâmetros**:
  - `password` (obrigatório): Palavra-passe para confirmação
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Conta eliminada com sucesso" }`

#### Recuperação de Palavra-passe
- **URL**: `/api/auth/reset-password`
- **Método**: `POST`
- **Autenticação**: Não
- **Parâmetros**:
  - `email` (obrigatório): Email do utilizador
  - `token` (obrigatório): Token recebido por email
  - `password` (obrigatório): Nova palavra-passe (mínimo 8 caracteres)
  - `password_confirmation` (obrigatório): Confirmação da nova palavra-passe
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Palavra-passe atualizada com sucesso" }`

### Perfil de Utilizador

#### Visualizar Perfil
- **URL**: `/api/perfil`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "user": {...} }`

#### Atualizar Perfil
- **URL**: `/api/perfil`
- **Método**: `PUT`
- **Autenticação**: Sim
- **Parâmetros**:
  - `name` (opcional): Nome completo
  - `user_name` (opcional): Nome de utilizador único
  - `cc` (opcional): Número de cartão de cidadão
  - `data_nascimento` (opcional): Data de nascimento (formato: YYYY-MM-DD)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Perfil atualizado com sucesso", "user": {...} }`

#### Atualizar Morada
- **URL**: `/api/perfil/morada`
- **Método**: `PUT`
- **Autenticação**: Sim
- **Parâmetros**:
  - `rua` (obrigatório): Nome da rua
  - `numero` (obrigatório): Número da porta
  - `codigo_postal` (obrigatório): Código postal
  - `localidade` (obrigatório): Localidade
  - `distrito` (obrigatório): Distrito
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Morada atualizada com sucesso", "morada": {...} }`

#### Atualizar Foto de Perfil
- **URL**: `/api/perfil/foto`
- **Método**: `POST`
- **Autenticação**: Sim
- **Parâmetros**:
  - `foto` (obrigatório): Imagem de perfil (formatos: jpeg, png, jpg)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Foto de perfil atualizada com sucesso", "imagem": {...} }`

#### Histórico de Anúncios
- **URL**: `/api/perfil/anuncios/historico`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncios": [...] }`

### Notificações

#### Listar Notificações
- **URL**: `/api/notificacoes`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "notificacoes": [...] }`

#### Contar Notificações Recentes
- **URL**: `/api/notificacoes/recentes/count`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "count": 5 }`

#### Visualizar Notificação
- **URL**: `/api/notificacoes/{id}`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "notificacao": {...} }`

#### Registar Visualização de Notificação
- **URL**: `/api/notificacoes/{id}/visualizar`
- **Método**: `PUT`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Notificação visualizada com sucesso" }`

#### Marcar Todas as Notificações como Vistas
- **URL**: `/api/notificacoes/todas/visualizar`
- **Método**: `PUT`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Todas as notificações foram marcadas como vistas", "notificacoes": [...] }`

#### Eliminar Notificação
- **URL**: `/api/notificacoes/{id}`
- **Método**: `DELETE`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Notificação eliminada com sucesso" }`

#### Limpar Notificações Antigas
- **URL**: `/api/notificacoes/antigas/limpar`
- **Método**: `DELETE`
- **Autenticação**: Sim
- **Parâmetros**:
  - `dias` (opcional): Número de dias para considerar uma notificação como antiga (padrão: 30)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Notificações antigas excluídas com sucesso", "quantidade": 5 }`

### Anúncios

#### Listar Anúncios
- **URL**: `/api/anuncios`
- **Método**: `GET`
- **Autenticação**: Não
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncios": [...] }`

#### Buscar Anúncios
- **URL**: `/api/anuncios/buscar`
- **Método**: `GET`
- **Autenticação**: Não
- **Parâmetros**:
  - `q` (opcional): Termo de busca
  - `categoria` (opcional): ID da categoria
  - `tipo` (opcional): ID do tipo de anúncio
  - `preco_min` (opcional): Preço mínimo
  - `preco_max` (opcional): Preço máximo
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncios": [...] }`

#### Anúncios por Tipo
- **URL**: `/api/anuncios/tipo/{tipoId}`
- **Método**: `GET`
- **Autenticação**: Não
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncios": [...] }`

#### Anúncios por Categoria
- **URL**: `/api/anuncios/categoria/{categoriaId}`
- **Método**: `GET`
- **Autenticação**: Não
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncios": [...] }`

#### Visualizar Anúncio
- **URL**: `/api/anuncios/{id}`
- **Método**: `GET`
- **Autenticação**: Não
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncio": {...} }`

#### Meus Anúncios
- **URL**: `/api/meus-anuncios`
- **Método**: `GET`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "anuncios": [...] }`

#### Criar Anúncio
- **URL**: `/api/anuncios`
- **Método**: `POST`
- **Autenticação**: Sim
- **Parâmetros**:
  - `titulo` (obrigatório): Título do anúncio
  - `descricao` (obrigatório): Descrição do anúncio
  - `preco` (obrigatório): Preço do item/serviço
  - `categoria_id` (obrigatório): ID da categoria
  - `tipo_id` (obrigatório): ID do tipo de anúncio
  - `imagens[]` (opcional): Imagens do anúncio (formatos: jpeg, png, jpg)
- **Resposta de Sucesso**:
  - Código: `201 Created`
  - Conteúdo: `{ "message": "Anúncio criado com sucesso", "anuncio": {...} }`

#### Atualizar Anúncio
- **URL**: `/api/anuncios/{id}`
- **Método**: `PUT`
- **Autenticação**: Sim
- **Parâmetros**:
  - `titulo` (opcional): Título do anúncio
  - `descricao` (opcional): Descrição do anúncio
  - `preco` (opcional): Preço do item/serviço
  - `categoria_id` (opcional): ID da categoria
  - `tipo_id` (opcional): ID do tipo de anúncio
  - `imagens[]` (opcional): Novas imagens do anúncio (formatos: jpeg, png, jpg)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Anúncio atualizado com sucesso", "anuncio": {...} }`

#### Eliminar Anúncio
- **URL**: `/api/anuncios/{id}`
- **Método**: `DELETE`
- **Autenticação**: Sim
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Anúncio eliminado com sucesso" }`

### Administração

#### Listar Utilizadores Pendentes
- **URL**: `/api/admin/pending-users`
- **Método**: `GET`
- **Autenticação**: Sim (apenas admin)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "users": [...] }`

#### Aprovar Utilizador
- **URL**: `/api/admin/approve-user/{id}`
- **Método**: `POST`
- **Autenticação**: Sim (apenas admin)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Utilizador aprovado com sucesso" }`

#### Rejeitar Utilizador
- **URL**: `/api/admin/reject-user/{id}`
- **Método**: `POST`
- **Autenticação**: Sim (apenas admin)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Utilizador rejeitado com sucesso" }`

#### Listar Produtos Pendentes
- **URL**: `/api/admin/produtos/pendentes`
- **Método**: `GET`
- **Autenticação**: Sim (apenas admin)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "produtos": [...] }`

#### Aprovar Produto
- **URL**: `/api/admin/produtos/{id}/aprovar`
- **Método**: `POST`
- **Autenticação**: Sim (apenas admin)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Produto aprovado com sucesso" }`

#### Rejeitar Produto
- **URL**: `/api/admin/produtos/{id}/rejeitar`
- **Método**: `POST`
- **Autenticação**: Sim (apenas admin)
- **Resposta de Sucesso**:
  - Código: `200 OK`
  - Conteúdo: `{ "message": "Produto rejeitado com sucesso" }`

## Códigos de Erro

- `400 Bad Request`: Requisição inválida ou parâmetros incorretos
- `401 Unauthorized`: Autenticação necessária ou token inválido
- `403 Forbidden`: Sem permissão para aceder ao recurso
- `404 Not Found`: Recurso não encontrado
- `422 Unprocessable Entity`: Erro de validação
- `500 Internal Server Error`: Erro interno do servidor

## Modelos de Dados

### Utilizador
- `ID_User`: Identificador único
- `User_Name`: Nome de utilizador
- `Name`: Nome completo
- `Data_Nascimento`: Data de nascimento
- `Password`: Palavra-passe (hash)
- `CC`: Número de cartão de cidadão
- `Email`: Email
- `MoradaID_Morada`: ID da morada
- `ImagemID_Imagem`: ID da imagem de perfil
- `Status_UtilizadorID_status_utilizador`: Status do utilizador (1=Pendente, 2=Aprovado, 3=Rejeitado)
- `TipoUserID_TipoUser`: Tipo de utilizador (1=Admin, 2=Utilizador normal)

### Anúncio
- `ID_Anuncio`: Identificador único
- `Titulo`: Título do anúncio
- `Descricao`: Descrição do anúncio
- `Preco`: Preço
- `DataCriacao`: Data de criação
- `DataAtualizacao`: Data de atualização
- `UtilizadorID_User`: ID do utilizador que criou o anúncio
- `CategoriaID_Categoria`: ID da categoria
- `TipoAnuncioID_TipoAnuncio`: ID do tipo de anúncio
- `Status`: Status do anúncio (pendente, aprovado, rejeitado)

### Notificação
- `ID_Notificacao`: Identificador único
- `Mensagem`: Conteúdo da notificação
- `DataNotificacao`: Data de criação da notificação
- `ReferenciaID`: ID da referência (anúncio, utilizador, etc.)
- `UtilizadorID_User`: ID do utilizador destinatário
- `ReferenciaTipoID_ReferenciaTipo`: Tipo de referência
- `TIPO_notificacaoID_TipoNotificacao`: Tipo de notificação

### Morada
- `ID_Morada`: Identificador único
- `Rua`: Nome da rua
- `Numero`: Número da porta
- `CodigoPostal`: Código postal
- `Localidade`: Localidade
- `Distrito`: Distrito

### Imagem
- `ID_Imagem`: Identificador único
- `Caminho`: Caminho para o arquivo de imagem
- `Descricao`: Descrição opcional da imagem
