<?php
session_start(); //inicia a sessão
require 'conn.php'; // necessita do ficheiro que faz a ligação a base com a base de dados

// Verifica se o formulário foi enviado 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe o email enviado pelo formulário(remove espaços(com a funcao trim)) e tambem recebe a senha
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    //prepara e executa a consulta
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    //verifica se o user existe e compara a senha colocada com a associada ao email
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['cargo'] = $usuario['cargo'];
        $_SESSION['area'] = $usuario['area'];

        //compara o email inserido com o  email alberto@oficina.pt, para criar um admin
        if ($usuario['email'] === 'alberto@oficina.pt') {
            header("Location: criaradmin.php");  // envia o user para a pagina de criar admin
        } else {
            header("Location: index.php");
        }
        exit();
        //mensagem de erro apresentada
    } else {
        $erro = "Email ou senha incorretos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Este segmento do codigo serve para colocr o ico junto ao titulo no navegador-->
    <link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="IMG/favicon_io/site.webmanifest">
    <!-- css -->
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

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
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
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #007bff;
        }

        .dark-mode .theme-toggle {
            color: #f1f1f1;
        }
    </style>
</head>
<body>
    <!-- div com o container login -->
    <div class="login-container">
        <h2>Login</h2>

        <!-- Exibe a mensagem de erro -->
        <?php if (isset($erro)): ?>
            <p class="error-message"><?php echo $erro; ?></p>
        <?php endif; ?>
        <!-- Formulario de login -->
        <form action="login.php" method="post">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <!--botão de validação de login-->
            <button type="submit">Login</button>
        </form>

        <!-- Texto com link para o user criar conta-->
        <div class="register-link">
            <p>Não tem uma conta? <a href="register.php">Registe-se aqui</a></p>
        </div>
    </div>
</body>
</html>