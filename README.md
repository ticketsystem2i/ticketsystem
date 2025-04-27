# 🎟️ Sistema de Tickets

## 📌 Descrição
Este é um sistema de tickets desenvolvido para gerenciar solicitações de suporte, incidentes e tarefas. Ele permite a criação, edição, atribuição e resolução de tickets, facilitando a organização e o atendimento.

## ✨ Funcionalidades
📝 Criação de tickets com título, descrição, prioridade, Área e Estado

👤 Atribuição de tickets a áreas de trabalho (Programação, Manutenção etc...)

🔄 Atualização do estado do ticket (🟢 Aberto, 🟡 Em andamento, 🔴 Fechado)

🔍 Filtros e pesquisa de tickets

## 🛠️ Tecnologias Utilizadas
💻 Linguagem: PHP

🗄️ Banco de Dados: MySQL

🎨 Frontend: HTML, CSS, JavaScript

🔑 Autenticação: Gerenciamento de sessões em PHP

## 🚀 Como Executar o Projeto
### ⚙️ Backend
Clone o repositório:

bash
Copiar
Editar
git clone https://github.com/seu-usuario/nome-do-projeto.git
Importe o banco de dados:

Crie um banco de dados MySQL chamado tickets

Importe o arquivo tickets.sql localizado na raiz do projeto

Configure a conexão com o banco de dados:

Abra o arquivo config.php

Atualize as variáveis de conexão (DB_HOST, DB_USER, DB_PASS, DB_NAME) conforme suas configurações

Hospede os arquivos em um servidor com suporte a PHP e MySQL

### 🎨 Frontend
Acesse a página de login:

arduino
Copiar
Editar
http://seu-dominio.com/tickets/login.php
Entre com suas credenciais para acessar o sistema

Crie, visualize e gerencie tickets conforme suas permissões

- 🛠️ Como Contribuir
Faça um fork do repositório

Crie uma branch para sua feature:

bash
Copiar
Editar
git checkout -b minha-feature
Faça commit das suas alterações:

bash
Copiar
Editar
git commit -m 'Adiciona nova feature'
Faça push para a branch:

bash
Copiar
Editar
git push origin minha-feature
