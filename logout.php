<?php
// Inicia a sessão
session_start();
// Remove todas as variáveis de sessão
session_unset();
// Acaba com a sessão
session_destroy();
// Redireciona o usuário para a página de login 
header("Location: login.php");
// Finaliza o script 
exit();
?>