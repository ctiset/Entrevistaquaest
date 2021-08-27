<?php
session_start();
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	include_once 'conexao.php';
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	$erro = false;
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
		Necessário preencher todos os campos</div>";

	}elseif((strlen($dados['senha'])) < 6){
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
		A senha deve ter no minímo 6 caracteres</div>";
	}elseif(stristr($dados['senha'], "'")) {
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
		Caracter ( ' ) utilizado na senha é inválido</div>";
	}else{
		$result_usuario = "SELECT id FROM usuarios WHERE cpf='". $dados['cpf'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este usuário já está sendo utilizado";
		}
		
		$result_usuario = "SELECT id FROM usuarios WHERE cpf='". $dados['cpf'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
			Este CPF já está cadastrado</div>";
		}
	}
	
	//var_dump($dados);
	if(!$erro){
		//var_dump($dados);
		$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
		;
		$result_usuario = "INSERT INTO usuarios (nome, cpf, sexo, senha) VALUES (
		'" .$dados['nome']. "',
		'" .$dados['cpf']. "',
		'" .$dados['sexo']. "',
		'" .$dados['senha']. "'
	)";
	$resultado_usario = mysqli_query($conn, $result_usuario);
	if(mysqli_insert_id($conn)){
		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
		Usuário cadastrado com sucesso!</div>";
		header("Location: index.php");
	}else{
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
		Erro ao cadastrar o usuário</div>";
	}
}

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD - Cadastrar</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="form-signin">
			<h2>Tela de Cadastro</h2>
			<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			?>
			<form method="POST" action="">
				<label>Nome</label>
				<input type="text" name="nome" placeholder="Digite o nome" class="form-control"><br>

				<label>CPF</label>

				<input type="text" name="cpf" placeholder="Digite o seu CPF" class="form-control"><br>
				<div class="form-group">
					<label for="exampleFormControlSelect1">Escolha o Sexo</label>
					<select class="form-control" id="exampleFormControlSelect1" name="sexo">
						<option value="Feminino">Feminino</option>
						<option value="Maculino">Maculino</option>
						<option value="Outros">Outros</option>
						
					</select>
				</div>

				<label>Senha</label>
				<input type="password" name="senha" placeholder="Digite a senha" class="form-control"><br>

				<input type="submit" name="btnCadUsuario" value="Cadastrar" class="btn btn-success btn-block">
				<br><br>

				<div class="row text-center" style="margin-top: 20px;"> 
					Voltar a Tela de Login <a href="index.php">Clique aqui</a>
				</div>
			</form>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>