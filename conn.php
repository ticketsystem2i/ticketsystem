<?php
//Comando que faz a conexão com a base de dados
try {
    $pdo = new PDO("mysql:host=sql304.alojamento-gratis.com;dbname=ljmn_38667775_ticketsystem;charset=utf8", "ljmn_38667775", "123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>