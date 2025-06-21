<?php
session_start();   //inicia a sessão
require 'conn.php';   // necessita do ficherio qeu faz a ligação a base com a base de dados

// Verifica se o user está com o login feito e se o codigo recebe o id
if (!isset($_SESSION['usuario_id']) || $_SESSION['cargo'] !== 'admin') {
    header("Location: login.php");    // se não tiver o login, redireciona para a página de login
    exit();  
}

// recebe area e nome 
$admin_area = $_SESSION['area'];
$admin_nome = $_SESSION['nome'];

// prepara e executa o comando para mostrar os tickets da area do admin
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE LOWER(area) = LOWER(?)");
$stmt->execute([$admin_area]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Admin area: " . $admin_area . "<br>";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
    <title>Gerir Tickets - <?php echo htmlspecialchars($admin_area); ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="IMG/favicon_io/site.webmanifest">
    <!-- Esta parte do style, é a parte do css, onde fica a parte que dá o visual ao site -->
    <style>
    .ticket-card {
    background: #f9f9f9;
    padding: 20px;
    margin-top: 30px;
    margin-bottom: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .ticket-card h2 {
        margin-top: 0;
        color: #333;
    }

    .ticket-card table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .ticket-card th, .ticket-card td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    .ticket-card th {
        background-color: #e9e9e9;
        text-align: left;
    }

    .status-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 8px;
    }

    .status-aberto {
        background-color: green;
    }

    .status-andamento {
        background-color: orange;
    }

    .status-fechado {
        background-color: red;
    }

    .priority-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 8px;
    }

    .priority-baixa {
        background-color: green;
    }

    .priority-media {
        background-color: orange;
    }

    .priority-alta {
        background-color: red;
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
        }

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
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            width: 100%;
        }

        .welcome-box {
            margin-bottom: 40px;
        }

        .welcome-box h1 {
            margin-bottom: 10px;
            color: #333;
        }

        .filters {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        td {
            background-color: #fff;
            word-wrap: break-word;
            word-break: break-word;
            vertical-align: top;
        }

        th {
            background-color: #f4f6f8;
        }

        td {
            background-color: #fff;
        }

        .logout-link a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            width: 100%;
        }

        .error-message {
            color: red;
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
        <div class="logout-link">
            <a href="logout.php">Sair</a>
        </div>
    </div>

    <!-- Esta div contem o conteudo principal -->
    <div class="main-content">
    <div class="welcome-box">
        <h1>Gerir Tickets</h1>
        <h2>Área: <?php echo htmlspecialchars($admin_area); ?></h2>
    </div>

    <?php
    // Separar tickets abertos/em andamento e fechados
    $tickets_abertos = [];
    $tickets_fechados = [];

    foreach ($tickets as $ticket) {
        if (strtolower($ticket['estado']) === 'fechado') {
            $tickets_fechados[] = $ticket;
        } else {
            $tickets_abertos[] = $ticket;
        }
    }
    ?>

    <?php if (count($tickets) === 0): ?>
        <p style="color: red;">Não há tickets para a sua área no momento.</p>
    <?php else: ?>

        <?php if (count($tickets_abertos) > 0): ?>
            <div class="ticket-card">
                <h2>Tickets Abertos / Em Andamento</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Prioridade</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($tickets_abertos as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket['id']; ?></td>
                            <td><?php echo htmlspecialchars($ticket['nome_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['descricao']); ?></td>
                            <td>
                                <?php
                                    $prioridade = strtolower($ticket['prioridade']);
                                    $classe = 'priority-dot ';
                                    if ($prioridade === 'baixa') $classe .= 'priority-baixa';
                                    elseif ($prioridade === 'média' || $prioridade === 'media') $classe .= 'priority-media';
                                    elseif ($prioridade === 'alta') $classe .= 'priority-alta';
                                ?>
                                <span class="<?php echo $classe; ?>"></span>
                                <?php echo $ticket['prioridade']; ?>
                            </td>
                            <td>
                                <?php
                                    $estado = strtolower($ticket['estado']);
                                    $classe_estado = 'status-dot ';
                                    if ($estado === 'aberto') $classe_estado .= 'status-aberto';
                                    elseif ($estado === 'em andamento') $classe_estado .= 'status-andamento';
                                ?>
                                <span class="<?php echo $classe_estado; ?>"></span>
                                <?php echo $ticket['estado']; ?>
                            </td>
                            <td>
                                <form action="gerirTicketsADM.php" method="get" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;" title="Editar">✏️</button>
                                </form>
                                <form action="delete_ticket.php" method="get" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja apagar este ticket?');">
                                    <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;" title="Apagar">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>

        <?php if (count($tickets_fechados) > 0): ?>
            <div class="ticket-card">
                <h2>Tickets Fechados</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Prioridade</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($tickets_fechados as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket['id']; ?></td>
                            <td><?php echo htmlspecialchars($ticket['nome_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['descricao']); ?></td>
                            <td>
                                <?php
                                    $prioridade = strtolower($ticket['prioridade']);
                                    $classe = 'priority-dot ';
                                    if ($prioridade === 'baixa') $classe .= 'priority-baixa';
                                    elseif ($prioridade === 'média' || $prioridade === 'media') $classe .= 'priority-media';
                                    elseif ($prioridade === 'alta') $classe .= 'priority-alta';
                                ?>
                                <span class="<?php echo $classe; ?>"></span>
                                <?php echo $ticket['prioridade']; ?>
                            </td>
                            <td>
                                <span class="status-dot status-fechado"></span>
                                <?php echo $ticket['estado']; ?>
                            </td>
                            <td>
                                <form action="gerirTicketsADM.php" method="get" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;" title="Editar">✏️</button>
                                </form>
                                <form action="delete_ticket.php" method="get" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja apagar este ticket?');">
                                    <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;" title="Apagar">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <br><br><br><br>
</div>
</body>
</html>
