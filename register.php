<?php
session_start(); //inicia a sessão
require 'conn.php';  // necessita do ficheiro que faz a ligação a base com a base de dados

//verifica se o formulario foi enviado com sucesso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //recebe os valores nome, email, senha
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verifica se o email já está registrado
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    //se o email já existir exibe uma mensagem de erro
    if ($stmt->rowCount() > 0) {
        $erro = "Este email já está registrado.";
    } else {
        // Insere novo usuário
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        if ($stmt->execute([$nome, $email, $senha])) {
            header("Location: login.php");
            exit();
            //mensagem de erro caso não seja possivel adcionar um user
        } else {
            $erro = "Erro ao registrar. Tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
    <link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="IMG/favicon_io/site.webmanifest">
    <!-- CSS -->
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f8;
            color: #333;
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode {
            background: #1c1c1c;
            color: #f1f1f1;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: auto;
            margin-top: 10vh;
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode .login-container {
            background: #2a2a2a;
            color: #f1f1f1;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
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

        .dark-mode input {
            background-color: #333;
            color: #f1f1f1;
            border: 1px solid #555;
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

        .theme-toggle {
            position: fixed;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #007bff;
            z-index: 1000;
        }

        .dark-mode .theme-toggle {
            color: #f1f1f1;
        }
    </style>
</head>
<body>
    <!-- Div que contem o froms para criar conta -->
    <div class="login-container">
        <h2>Sign Up</h2>
        <!-- Exibe mensagem de erro, caso seja defenida -->
        <?php if (isset($erro)): ?>
            <p class="error-message"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Sign Up</button>
        </form>
        <!-- Caso o user já tenha conta, pode fazer o login clicando no texto  -->
        <div class="register-link">
            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
        </div>
    </div>


</body>
</html>
