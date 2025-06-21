<?php
session_start();  //inicia a sessão
require 'conn.php';   // necessita do ficherio qeu faz a ligação a base com a base de dados

// verifica se o user tem o login feito
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");   // se não tem o login feito redireciona para a página de login
    exit(); // encerra o comando
}
//pega no nome e no cargo do usuario 
$nome = $_SESSION['nome'] ?? 'Usuário'; //caso não exista um nome, fica com o padrão 
$cargo = $_SESSION['cargo'] ?? null;  // caso não exista um cargo, fica com o padrão

//Verifica se o formulário foi enviada corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $prioridade = $_POST['prioridade'];
    $area = $_POST['area'];
    $usuario_id = $_SESSION['usuario_id'];

    //prepara o comando para inserir o novo ticket
    $stmt = $pdo->prepare("INSERT INTO tickets (titulo, descricao, prioridade, area, nome_usuario) VALUES (?, ?, ?, ?, ?)");
    try {
        //execuat o comando par inserir o novo ticket
        $stmt->execute([$titulo, $descricao, $prioridade, $area, $usuario_id]);
        header("Location: index.php"); // Redireciona para a página index após criar o ticket
        exit(); // encerra o comando
        //Cria a variavel para ser apresentada caso aconteca um erro
    } catch (PDOException $e) {
        $error = "Erro ao criar o ticket: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Ticket</title>
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
    <link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon_io/favicon-16x16.png">
    <!-- Esta parte do style, é a parte do css, onde fica a parte que dá o visual ao site --><link rel="manifest" href="IMG/favicon_io/site.webmanifest">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f4f6f8;
        }

        .sidebar {
            width: 250px;
            background-color: #09121b; /* Sidebar color */
            color: #fff;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            transition: background-color 0.3s;
            width: 100%;
        }

        .sidebar a:hover {
            background-color: #007bff; 
        }

        .sidebar .logout-link {
            margin-top: auto;
            padding: 15px;
            text-align: center;
            background-color: #dc3545;
            width: 100%;
        }

        .sidebar .logout-link a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            width: 100%;
        }

        .sidebar .logout-link a:hover {
            background-color: #c82333;
            width: 100%; 
        }

        .logout-link {
            margin-top: auto;
            padding: 15px;
            width: 100%;
            background-color: #dc3545;
            text-align: center;
        }

        .logout-link a:hover {
            background-color: #c82333;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .container {
            background-color: white;
            width: 90%;
            max-width: 600px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        form label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            resize: vertical;
        }

        .form-buttons {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
        }

        button,
        .cancel-button {
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .form-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- esta div é para a side bar que contem os botões gerirTickets e sair -->
    <div class="sidebar">
        <img src="IMG/LogotipoTextoWhite.png" alt="Logotipo" width="120">    
        <a href="index.php">Início</a>
        <?php if ($cargo === 'admin'): ?>
            <a href="gerirTickets.php">Gerir Tickets</a>
        <?php endif; ?>
        <div class="logout-link">
            <a href="logout.php">Sair</a>
        </div>
    </div>

    <!-- esta div contem o conteudo o forms para criar o ticket -->
    <div class="main-content">
        <h1>Criar Novo Ticket</h1>
        <!-- apresenta a mensssagem de erro -->
        <div class="container">
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <!-- Froms onde o user vai inserir os dados do ticket  -->
            <form method="post">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>

                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" rows="6" placeholder="Descreva o problema ou solicitação..." required></textarea>

                <label for="prioridade">Prioridade:</label>
                <select name="prioridade" id="prioridade" required>
                    <option value="Baixa">Baixa</option>
                    <option value="Média" selected>Média</option>
                    <option value="Alta">Alta</option>
                </select>

                <label for="area">Área:</label>
                <select name="area" id="area" required>
                    <option value="TI">TI</option>
                    <option value="3D">3D</option>
                    <option value="COMUNICAÇÃO">Comunicação</option>
                    <option value="PROGRAMAÇÃO">Programação</option>
                    <option value="MANUTENÇÃO">Manutenção</option>
                </select>

                <div class="form-buttons">
                    <!-- Botão para submeter os dados do novo ticket -->
                    <button type="submit">Criar Ticket</button>
                    <!-- Botão para cancelar a criação do ticket -->
                    <a href="index.php" class="cancel-button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
