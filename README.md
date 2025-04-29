# 🎟️ Sistema de Tickets

## 📌 Descrição
Este é um sistema de tickets desenvolvido para gerenciar solicitações de suporte. Este sistema permite a criação, edição, eliminação e visualização de tickets, de varias visões diferentes.

## ✨ Funcionalidades
📝 Criação de tickets com título, descrição, prioridade, Área e Estado

👤 Atribuição de tickets a áreas de trabalho (Programação, Manutenção etc...)

🔄 Atualização do estado do ticket (🟢 Aberto, 🟡 Em andamento, 🔴 Fechado)

🔍 Filtros e pesquisa de tickets

## 🛠️ Tecnologias Utilizadas
💻 Backend: PHP

🎨 Frontend: HTML, CSS

🗄️ Banco de Dados: MySQL

🔑 Autenticação: Gerenciamento de sessões em PHP

## 🗂️ Estrutura de Ficheiros

```bash
├── /IMG/                                           # Pasta que guarda as imagem
      ├── /favicon_io/                              # Pasta que guarda o icon
            ├── android-chrome-192x192.png          # Imagem com o icon
            ├── android-chrome-512x512.png          # Imagem com o icon
            ├── apple-touch-icon.png.png            # Imagem com o icon
            ├── favicon.ico                         # Imagem com o icon
            ├── favicon-16x16.png                   # Imagem com o icon
            ├── favicon-32x32.png                   # Imagem com o icon
            └── site.webmanifest                    # Imagem com o icon
      ├── Logo_sem_texto.png                        # Imagem com o logotipo sem texto
      └── LogotipoTextoWhite.png                    # Imagem com o logotipo branco
├── conn.php                                        # Ficheiro para fazer a ligação a base de dados
├── criaradmin.php                                  # Ficheiro para criar o admin
├── criarTicket.php                                 # Ficheiro para criar os tickets
├── delete_ticket.php                               # Ficheiro para apagar os tickets
├── edit_ticket.php                                 # Ficheiro para editar os tickets
├── gerirTickets.php                                # Ficheiro para gerir os tickets
├── gerirTicketsADM.php                             # Ficheiro para o admin gerir os tickets
├── index.php                                       # Ficheiro com o conteúdo principal
├── ljmn_38667775_ticketsystem.sql                  # Ficheiro com a base de dados
├── login.php                                       # Ficheiro para fazer o login
├── logout.php                                      # Ficheiro para terminar a sessão
└── register.php                                    # Ficheiro para fazer o resgisto do user
```

## 🚀 Como implementar o projeto
 1. Aceder ao [Alojamento Grátis](http://www.alojamento-gratis.com/?i=1).
  2. Clicar em "alojamento web grátis", na navbar no topo da página. <b>Observação</b>: Se tiveres conta criada podes <b>saltar para o passo 6.2.</b>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1DDQZxnMBm5BMopwWacAh_gkH45UYIBxu" alt="Alojamento Web grátis" width="500">
  3. Descer a página até aparecer o botão "Peça já o seu alojamento web grátis" e clicar no botão. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1ZGt2M5eORxPp5ZuJY_URnTff6OlZ6U3v" alt="Peça já o seu alojamento grátis" width="500">
  4. Preencher os dados do resgisto e clicar no botão para continuar. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1iB9GwaRlMX6MFJM3_ddsPnYP0e-di2gm" alt="Formulário" width="500">
  5. Ir ao email, e clicar no link da nossa página web. <b>Obserevação</b>: o email pode estar no spam. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=155rerKVtiixYO0ntPBlRbXRPPPCNSxij" alt="Link no email" width="500">
  6. Clicar no link que corresponde ao CPanel e deve colocar o username respetivo ao CPanel e a palavra-passe que defeniu. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1iKf33ijzhh6RxeoHCv63afD-HRywMTFx" alt="Link correspondente ao CPanel" width="500">
  <img src="https://drive.google.com/uc?export=view&id=1o_kgsagXV5g6RdIcvmMI2o-XssbUIY2X" alt="Login no CPanel" width="500">
     6.1. Clicar no botão "I approve". <b>Observação</b>: Faça este passo caso seja a primeira <b>pode saltar este passo</b><br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=13t2Y2zxVwI4N_sbAmqLB7BLdCnjp0Ksd" alt="Clicar em I Approve" width="500">
    6.2 <b>Este passo só se aplica se você já tem conta criada</b> - Clicar em "Login" na navbar e deve colocar o username respetivo ao CPanel e a palavra-passe que defeniu. <br>
    <br>
    <img src="https://drive.google.com/uc?export=view&id=1zQY0E8bSOhtrkl-CnKvqlGz7OZ0qC0Q4" alt="Login no Alojamento grátis" width="500">
    <img src="https://drive.google.com/uc?export=view&id=1o_kgsagXV5g6RdIcvmMI2o-XssbUIY2X" alt="Login no CPanel" width="500">
  7. Clicar em "Online File Maneger" <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1rffW5CIUvqPRgqxtTnCzV1hokIRsSa8Y" alt="Clicar em Online File Maneger" width="500">
  8. Criar uma nova pasta dentro da htdocs ou usar a pasta htdocs para colocar os ficheiros, exeto o ficheiro da base de dados. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1sGkC6XqHvDqQzly6TnAT6Opo-SFo1C5R" alt="Pasta com os ficheiros" width="500">
  9. Voltar ao CPanel e clicar em "MySQL Databases". <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1VLeIX5f3RTCRQedCHipZYo0yEbvuXNQx" alt="Clicar em MySQL" width="500">
  10. Dar um nome a base de dados e clicar no botão "Create Database". <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=17otBVYmhWGazTF8GJWli035IIgbiBil-" alt="Criar base de dados" width="500">
  11. Clicar no botão admin, respetivo a base de dados criada, na tabela em baixo. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1BQ4sI-yIMEBQ5x02PMfar554wY9l0W9g" alt="Clicar em admin" width="500">
  12. Clicar em "Importar", na navbar. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1iQib6GQXbVnppX2yfYipxXr4a69_Zo6Z" alt="Clicar em importar" width="500">
  13. Clicar no botão "Escolher ficheiro" e selecionar o ficheiro .sql, que foi disponibilizado. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1nisV1PL53Nsb-YsBbOM-mc9tUFVCoi1q" alt="Ficheiro selecionado" width="500">
  14. Voltar ao menu "MySQL Database", para verificar os dados de acesso da base de dados.
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1_RLVtfnyNGJ1kMGRd9NoeHrRAWko8CX2" alt="Verificar os dados" width="500">

  15. Ir ao "Online File Maneger", ir a pasta em que colocou os ficheiros e abrir o ficheiro config.php e colocar os dados de acesso a base de dados. <b>Observação</b>: No MySQL Database, o primeiro campo representa o último campo do ficheiro config.php, o último campo do MySQL representa o primeiro campo do ficheiro.php e os dois campos do meio mantêm-se igual, por fim deve <b>salvar o ficheiro</b> config.php. <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1sGkC6XqHvDqQzly6TnAT6Opo-SFo1C5R" alt="Pasta com os ficheiros" width="500">
  <img src="https://drive.google.com/uc?export=view&id=1dO1331fF_3EUQXTJrUCTrXin1f8WQuVa" alt="Codigo do ficherio conn.php" width="500">

  16. Para acabar deves aceder a página web, o link está no email enviado, ao criar a conta. <b>Observação</b>: Tem que colocar, depois do fim do link, o seguinte complemento "/nome da pasta/nome do ficheiro (neste caso "login.php")" <br>
  <br>
  <img src="https://drive.google.com/uc?export=view&id=1l_R_tE8da6s8e9HvGkDegjVC8YS1pxSk" alt="Link" width="500">
  17. Ver <a href="http://ticketsystem.alojamento-gratis.com/tickets/login.php" target="_blank">resultado final</a>. <br>
  <br>
  18. vídeo explicativo  🎥 [Ver demonstração em vídeo](https://drive.google.com/file/d/1Qj_Jbbrck95yBO9GA3mu1rtqYjdBRQtv/view?usp=sharing)


  <br>
  Feito por João Martins - Líder/Fluxo (a14486) || Simão Ribeiro - Uploads/Documentação (a14549) || Francisco Martins - Backend/Status (a14568) || Francisco Rosas - Frontend/UI (a14598)
