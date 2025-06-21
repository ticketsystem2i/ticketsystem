<?php
session_start(); //inicia a sessão
require 'conn.php';  // necessita do ficherio qeu faz a ligação a base com a base de dados

// Verifica se o user está com o login feito e se o codigo recebe o id
if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: login.php"); // se não tiver o login, redireciona para a página de login
    exit();  // encerra o comando
}

// recebe o ID do ticket, ID do usuario, e o cargo
$ticket_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];
$cargo = $_SESSION['cargo'];

// se o user for admin, ele pode apagar todos os tickets
if ($cargo === 'admin') {
    $stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->execute([$ticket_id]);
    header("Location: index.php");
    exit();
} else {
// se o user não tiver cargo, ele pode apagar só os seus tickets
    $stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ? AND nome_usuario = ?");
    $stmt->execute([$ticket_id, $usuario_id]);
    header("Location: meusTickets.php?deleted=1");
    exit();
}
?>
