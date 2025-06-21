<?php
session_start();    //inicia a sessão
require 'conn.php';     // necessita do ficherio qeu faz a ligação a base com a base de dados

date_default_timezone_set('Europe/Lisbon'); //recebe a hora atual em portugal 

$hora = date('H'); // variavel recebe a hora em portugal

//compara se o valor da hora está entre os valores de hora de manha, tarde e noite
if ($hora >= 6 && $hora < 12) {
    $cumprimento = "Bom dia";
} elseif ($hora >= 12 && $hora < 20) {
    $cumprimento = "Boa tarde";
} else {
    $cumprimento = "Boa noite";
}

//verifica se o user tem o login feito
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// recebe o nome, cargo, o userID
$nome = $_SESSION['nome'];
$cargo = $_SESSION['cargo'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

//recebe os valores de estado e area, que serve de filtros
$filtro_estado = $_GET['estado'] ?? '';
$filtro_area = $_GET['area'] ?? '';

//Criar a query, para buscar os tickets com o nome do user
$sql = "SELECT * FROM tickets WHERE nome_usuario = ?";
$params = [$usuario_id];

// Verifica se o filtro do estado foi aplicado, se sim adciona a query o estado e adciona o valor do filtro ao parametro da consulta
if ($filtro_estado !== '') {
    $sql .= " AND estado = ?";
    $params[] = $filtro_estado;
}
// Verifica se o filtro do area foi aplicado, se sim adciona a query a area e adciona o valor do filtro ao parametro da consulta
if ($filtro_area !== '') {
    $sql .= " AND area = ?";
    $params[] = $filtro_area;
}

//Prepara o comando na variuavel sql
$stmt = $pdo->prepare($sql);
//executa o comando com os parametro
$stmt->execute($params);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema Tickets 2I</title>
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
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
            width: 100%; 
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

        .button-group {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .filters {
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
        }

        .filters select,
        .filters button {
            padding: 10px;
            font-size: 16px;
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
            max-width: 200px;
        }

        th {
            background-color: #f4f6f8;
        }

        td {
            background-color: #fff;
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
    <!-- Logotipo na side bar -->
    <img src="IMG/LogotipoTextoWhite.png" alt="Logotipo" width="120">
        <!-- Botão criar Ticket -->
        <a href="criarTicket.php">Criar Ticket</a>
        <!-- Caso seja admin aparece o botão Gerir tickets-->
        <?php if ($cargo === 'admin'): ?>
            <a href="gerirTickets.php">Gerir Tickets</a>
        <?php endif; ?>
        <!-- Botão para sair e volta para o login -->
        <div class="logout-link">
            <a href="logout.php">Sair</a>
        </div>
    </div>

    <!-- Div com o contuedo principal -->
    <div class="main-content">
    <div class="welcome-box">
        <h1>Sistema de Tickets</h1>
        <h2><?php echo $cumprimento . ", " . htmlspecialchars($nome); ?>!</h2>
    </div>

    <div class="filters">
        <form method="get">
            <label for="estado">Filtrar por status:</label>
            <select name="estado" id="estado">
                <option value="">Todos</option>
                <option value="Aberto" <?php if ($filtro_estado == 'Aberto') echo 'selected'; ?>>Aberto</option>
                <option value="Em andamento" <?php if ($filtro_estado == 'Em andamento') echo 'selected'; ?>>Em andamento</option>
                <option value="Fechado" <?php if ($filtro_estado == 'Fechado') echo 'selected'; ?>>Fechado</option>
            </select>

            <label for="area">Filtrar por área:</label>
            <select name="area" id="area">
                <option value="">Todas</option>
                <option value="TI" <?php if ($filtro_area == 'TI') echo 'selected'; ?>>TI</option>
                <option value="3D" <?php if ($filtro_area == '3D') echo 'selected'; ?>>3D</option>
                <option value="COMUNICAÇÃO" <?php if ($filtro_area == 'COMUNICAÇÃO') echo 'selected'; ?>>Comunicação</option>
                <option value="PROGRAMAÇÃO" <?php if ($filtro_area == 'PROGRAMAÇÃO') echo 'selected'; ?>>Programação</option>
                <option value="MANUTENÇÃO" <?php if ($filtro_area == 'MANUTENÇÃO') echo 'selected'; ?>>Manutenção</option>
            </select>

            <button type="submit">Aplicar Filtros</button>
            <a href="index.php"><button type="button">Limpar</button></a>
        </form>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <p style="color: green;">Ticket apagado com sucesso!</p>
    <?php endif; ?>

    <?php
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

    <?php if (count($tickets_abertos) === 0): ?>
        <p style="color: red;">Nenhum ticket aberto encontrado com os filtros aplicados.</p>
    <?php else: ?>
        <div class="ticket-card">
            <h2>Tickets Abertos / Em Andamento</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Área</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($tickets_abertos as $ticket): ?>
                    <tr>
                        <td><?php echo $ticket['id']; ?></td>
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
                        <td><?php echo $ticket['area']; ?></td>
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
                            <form action="edit_ticket.php" method="get" style="display: inline;">
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
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Área</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($tickets_fechados as $ticket): ?>
                    <tr>
                        <td><?php echo $ticket['id']; ?></td>
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
                        <td><?php echo $ticket['area']; ?></td>
                        <td>
                            <span class="status-dot status-fechado"></span>
                            <?php echo $ticket['estado']; ?>
                        </td>
                        <td>
                            <form action="edit_ticket.php" method="get" style="display: inline;">
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
</div>




</body>
</html>
