<?php
require 'conn.php';  // necessita do ficherio qeu faz a ligação a base com a base de dados
session_start();

// Verifica se o usuário está logado e se é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['cargo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// associação dos valores inseridos pelo user com uma variavel
$nome = $_SESSION['nome'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = $_POST['senha'];
    $cargo = 'admin';
    $area = trim($_POST['area']);

    // Criptografa a senha
    $senhaCriptografada = password_hash($password, PASSWORD_DEFAULT);

    
     // Insere novo admin na base de dados
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cargo, area) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $senhaCriptografada, $cargo, $area]);
        header("Location: login.php");
        exit();
    // Mensagem que é apresentada, caso um user tente criar conta com um email existente
    } catch (PDOException $e) {
        $error = $e->getCode() == 23000 ? "Este email já está registrado." : "Erro ao registrar: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
    <link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon_io/apple-touch-icon.png">  
    <link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="IMG/favicon_io/site.webmanifest">
    <meta charset="UTF-8">
    <title>Registrar</title>
    <!-- Esta parte do style, é a parte do css, onde fica a parte que dá o visual ao site -->
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            color: #444;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Criação do container de login-->
    <div class="login-container">
        <h2>Registrar</h2>

        <!-- vai bucar a mensagem de erro da linha 32 para ser apresentada -->
        <?php if (isset($erro)): ?>
            <p class="error-message"><?php echo $erro; ?></p>
        <?php endif; ?>
        <!-- Cria o formul´rtio pa ra o user criar a conta -->
        <form method="post">
            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <label>Área:</label>
            <select name="area" required>
                <option value="">-- Selecione uma área --</option>
                <option value="ti">TI</option>
                <option value="3d">3D</option>
                <option value="comunicação">Comunicação</option>
                <option value="programação">Programação</option>
                <option value="manutenção">Manutenção</option>
            </select>
            <!-- Botão que valida a criação do user --> 
            <button type="submit">Registrar</button>
        </form>
        <!-- Texto com link, que leva para a página de login -->
        <div class="register-link">
            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>