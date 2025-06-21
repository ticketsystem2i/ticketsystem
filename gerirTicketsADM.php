<?php
session_start();   //inicia a sessão
require 'conn.php';   // necessita do ficherio qeu faz a ligação a base com a base de dados

ini_set('display_errors', 1);  
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se o user está com o login feito e se o codigo recebe o id
if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: login.php");// se não tiver o login, redireciona para a página de login
    exit();  // encerra o comando
}

// recebe o ID do ticket, ID do usuario, e o cargo
$usuario_id = $_SESSION['usuario_id'];
$cargo = $_SESSION['cargo'];
$ticket_id = $_GET['id'];

// Se o user for um admin, vai buscar o ticket pelo ID, assim o admin vê todos os tickets
if ($cargo === 'admin') {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->execute([$ticket_id]);
// Se o user não tiver cargo, vai buscar o ticket pelo ID e o nome do user, assim o  user só ve os seus tickets
} else {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ? AND nome_usuario = ?");
    $stmt->execute([$ticket_id, $usuario_id]);
}
$ticket = $stmt->fetch();

// Se nenhum ticket for encontrado, mostra uma mensagem de erro
if (!$ticket) {
    echo "Ticket não encontrado ou acesso negado.";
    exit();
}

// recebe os dados do ticket criado 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $prioridade = $_POST['prioridade'];
    $area = $_POST['area'];
    $estado = $_POST['estado'];


    // se o cargo for admin, prepara o coamndo para dar update no ticket
    if ($cargo === 'admin') {
        $update = $pdo->prepare("UPDATE tickets SET titulo = ?, descricao = ?, prioridade = ?, area = ?, estado = ? WHERE id = ?");
        $update->execute([$titulo, $descricao, $prioridade, $area, $estado, $ticket_id]);
    
    // se o user não tiver cargo, prepara o coamndo para dar update no ticket
    } else {
        $update = $pdo->prepare("UPDATE tickets SET titulo = ?, descricao = ?, prioridade = ?, area = ?, estado = ? WHERE id = ? AND nome_usuario = ?");
        $update->execute([$titulo, $descricao, $prioridade, $area,  $estado, $ticket_id, $usuario_id]);
    }

    header("Location: " . ("gerirTickets.php"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Ticket</title>
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
    <link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="IMG/favicon_io/site.webmanifest">
    <!-- Esta parte do style, é a parte do css, onde fica a parte que dá o visual ao site -->
    <style>
    .sidebar {
            width: 250px;
            background-color: #09121b; 
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
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 50px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            padding: 12px 20px;
            background-color: #09121b;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #007bff;
        }

        p {
            margin-top: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-links {
            text-align: center;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
    <div class="sidebar">
    <!-- Logotipo na sidebar -->
        <img src="IMG/LogotipoTextoWhite.png" alt="Logotipo" width="120">
        <a href="index.php">Início</a>
        <a href="criarTicket.php">Criar Ticket</a>
        <a href="gerirTickets.php">Gerir Tickets</a>      
        <div class="logout-link">
            <a href="logout.php">Sair</a>
        </div>
    </div>
   
    <!-- FROMS para receber os novos dados do tickets -->
    <form method="post">
        <label>Título:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($ticket['titulo']); ?>" required>

        <label>Descrição:</label>
        <textarea name="descricao" rows="5" required><?php echo htmlspecialchars($ticket['descricao']); ?></textarea>

        <label>Prioridade:</label>
        <select name="prioridade" required>
            <option value="Baixa" <?php if ($ticket['prioridade'] == 'Baixa') echo 'selected'; ?>>Baixa</option>
            <option value="Média" <?php if ($ticket['prioridade'] == 'Média') echo 'selected'; ?>>Média</option>
            <option value="Alta" <?php if ($ticket['prioridade'] == 'Alta') echo 'selected'; ?>>Alta</option>
        </select>

        <label>Área:</label>
        <select name="area" required>
            <option value="TI" <?php if ($ticket['area'] == 'TI') echo 'selected'; ?>>TI</option>
            <option value="3D" <?php if ($ticket['area'] == '3D') echo 'selected'; ?>>3D</option>
            <option value="COMUNICAÇÃO" <?php if ($ticket['area'] == 'COMUNICAÇÃO') echo 'selected'; ?>>Comunicação</option>
            <option value="PROGRAMAÇÃO" <?php if ($ticket['area'] == 'PROGRAMAÇÃO') echo 'selected'; ?>>Programação</option>
            <option value="MANUTENÇÃO" <?php if ($ticket['area'] == 'MANUTENÇÃO') echo 'selected'; ?>>Manutenção</option>
        </select>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Aberto" <?php if ($ticket['estado'] == 'Aberto') echo 'selected'; ?>>Aberto</option>
            <option value="Em Andamento" <?php if ($ticket['estado'] == 'Em Andamento') echo 'selected'; ?>>Em Andamento</option>
            <option value="Fechado" <?php if ($ticket['estado'] == 'Fechado') echo 'selected'; ?>>Fechado</option>
        </select>


        <!-- Botão para submeter os novos dados -->
        <button type="submit" href="gerirTickets.php">Salvar Alterações</button>
    </form>
</body>
</html>
