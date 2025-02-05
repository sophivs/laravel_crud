# Teste Prático Laravel - API de Tarefas

## 📌 Sobre o Projeto
Esta é uma API RESTful desenvolvida em **Laravel 10+** para gerenciar um sistema de tarefas. 
O sistema permite a autenticação de usuários, gerenciamento de tarefas e categorias, além de funcionalidades como filtragem e ordenação.

---

## 🚀 Tecnologias Utilizadas
- **Laravel 10+**
- **Laravel Sanctum** (Autenticação JWT)
- **Eloquent ORM**
- **Banco de Dados: MySQL ou SQLite**
- **Testes: PHPUnit / Pest**
- **Docker (opcional)**
- **Swagger (opcional, para documentação da API)**

---

## ⚙️ Instalação e Execução
### 1️⃣ Clonar o Repositório
```sh
git clone https://github.com/sophivs/laravel_crud.git
cd laravel_crud
```

### 2️⃣ Instalar Dependências
```sh
composer install
```

### 3️⃣ Configurar o Banco de Dados
Renomeie o arquivo **.env.example** para **.env** e configure as credenciais do banco:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teste_pratico
DB_USERNAME=root
DB_PASSWORD=sua_senha
```
Se preferir SQLite:
```ini
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
Crie o arquivo SQLite:
```sh
touch database/database.sqlite
```

### 4️⃣ Gerar a Chave da Aplicação
```sh
php artisan key:generate
```

### 5️⃣ Rodar as Migrações e Seeders
```sh
php artisan migrate --seed
```
Isso criará as tabelas e populará o banco com dados iniciais.

### 6️⃣ Iniciar o Servidor
```sh
php artisan serve
```
A API estará disponível em **http://127.0.0.1:8000/api**

---

## 🔥 Endpoints Disponíveis
### 1️⃣ Autenticação
| Método | Rota         | Descrição |
|--------|-------------|------------|
| POST   | /register   | Registro de novo usuário |
| POST   | /login      | Login do usuário |

**Exemplo de Requisição (Registro):**
```json
{
  "name": "João Silva",
  "email": "joao@email.com",
  "password": "123456",
  "password_confirmation": "123456"
}
```

### 2️⃣ Tarefas
| Método | Rota          | Descrição |
|--------|--------------|------------|
| GET    | /tasks       | Listar todas as tarefas do usuário autenticado |
| POST   | /tasks       | Criar uma nova tarefa |
| GET    | /tasks/{id}  | Obter detalhes de uma tarefa |
| PUT    | /tasks/{id}  | Atualizar uma tarefa |
| DELETE | /tasks/{id}  | Deletar uma tarefa |

**Exemplo de Requisição (Criar Tarefa):**
```json
{
  "title": "Comprar mantimentos",
  "description": "Leite, pão e ovos",
  "category_id": 1,
  "status": "pendente"
}
```

### 3️⃣ Categorias
| Método | Rota         | Descrição |
|--------|-------------|------------|
| GET    | /categories | Listar todas as categorias |
| POST   | /categories | Criar uma nova categoria |

---

## 🗂️ Scripts de Migração e Seeders
Criação do banco de dados e população com dados iniciais:
```sh
php artisan migrate --seed
```
Os seeders criam categorias e um usuário padrão para testes.

---

## 🧪 Testes
Para rodar os testes automatizados:
```sh
php artisan test
```
Isso valida funcionalidades como autenticação e manipulação de tarefas.

---

## 📄 Documentação da API (Opcional)
Se o Swagger estiver configurado, gere a documentação com:
```sh
php artisan l5-swagger:generate
```
Acesse em **http://127.0.0.1:8000/api/documentation**.

---

## 🛠️ Possíveis Melhorias
- Criar um sistema de notificação para tarefas
- Implementar caching para otimizar a API

---

## 📌 Autor
Sophia Victória Santos - Desenvolvedor PHP/Laravel