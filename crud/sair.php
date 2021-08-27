<?php
session_start();
unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['cpf']);

$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
		Deslogado com sucesso</div>";
header("Location: index.php");
?>