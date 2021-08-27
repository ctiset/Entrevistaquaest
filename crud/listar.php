
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD - Lista de Dados</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">CRUD</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="sair.php">Sair</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<center>
			<div class="form-signin">
				<?php
				if(!empty($_SESSION['id'])){
					echo "Seja Bem Vindo(a)<br> ".$_SESSION['nome']." <br>";
				}else{
					$_SESSION['msg'] = "Área restrita";
					header("Location: index.php");	
				}
				?>
			</div>
		</center>
		<h2 class="text-center">Lista de Dados</h2>
	</div>
</div>	

<?php
include_once("conexao.php");
$result_usuario = "SELECT * FROM usuarios";
$resultado_usuario = mysqli_query($conn, $result_usuario);
?>

<div class="container theme-showcase" role="main">
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nome</th>
						<th>CPF</th>
						<th>Sexo</th>
						<th>Senha</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php while($rows_usuario = mysqli_fetch_assoc($resultado_usuario)){ ?>
						<tr>
							<td><?php echo $rows_usuario['id']; ?></td>
							<td><?php echo $rows_usuario['nome']; ?></td>
							<td><?php echo $rows_usuario['cpf']; ?></td>
							<td><?php echo $rows_usuario['sexo']; ?></td>
							<td><?php echo $rows_usuario['senha']; ?></td>
							<td>
								<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal<?php echo $rows_usuario['id']; ?>">Visualizar</button>
								<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $rows_usuario['id']; ?>" data-whatevernome="<?php echo $rows_usuario['nome']; ?>"data-whatevercpf="<?php echo $rows_usuario['cpf']; ?>"data-whateversexo="<?php echo $rows_usuario['sexo']; ?>" data-whateversenha="<?php echo $rows_usuario['senha']; ?>">Editar</button>
								
								<?php
								echo "<a href='apagar.php?id=" . $rows_usuario['id'] . "''><button type='submit'  class='btn btn-xs btn-danger'>Apagar</button></a>"
								?>

							</form>
						</td>
					</tr>
					<!-- Inicio Modal -->
					<div class="modal fade" id="myModal<?php echo $rows_usuario['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">

									<h4 class="modal-title text-center" id="myModalLabel"><?php echo $rows_usuario['nome']; ?></h4>
								</div>
								<div class="modal-body">
									<p>ID: <?php echo $rows_usuario['id']; ?></p>
									<p>Nome: <?php echo $rows_usuario['nome']; ?></p>
									<p>CPF: <?php echo $rows_usuario['cpf']; ?></p>
									<p>Sexo: <?php echo $rows_usuario['sexo']; ?></p>
									<p>Senha: <?php echo $rows_usuario['senha']; ?></p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
								</div>
							</div>

						</div>
					</div>
					<!-- Fim Modal -->
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>		

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				
				<h4 class="modal-title" id="exampleModalLabel">Usuários</h4>
			</div>
			<div class="modal-body">
				<form method="POST" action="processa.php" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Nome:</label>
						<input name="nome" type="text" class="form-control" id="recipient-name">
					</div>

					<div class="form-group">
						<label for="recipient-cpf" class="control-label">CPF:</label>
						<input name="cpf" class="form-control" id="recipient-cpf">
					</div>

					<div class="form-group">
						<label for="recipient-sexo">Escolha o Sexo</label>
						<select class="form-control" id="recipient-sexo" name="sexo">
							<option value="Feminino">Feminino</option>
							<option value="Maculino">Maculino</option>
							<option value="Outros">Outros</option>

						</select>
					</div>

					<div class="form-group">
						<label for="recipient-senha" class="control-label">Senha:</label>
						<input name="senha" class="form-control" id="recipient-senha">
					</div>
					<input name="id" type="hidden" class="form-control" id="id" value="">
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger">Alterar</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	$('#exampleModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  var recipientnome = button.data('whatevernome')
		  var recipientcpf = button.data('whatevercpf')
		  var recipientsexo = button.data('whateversexo')
		  var recipientsenha = button.data('whateversenha')
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('ID ' + recipient)
		  modal.find('#id').val(recipient)
		  modal.find('#recipient-name').val(recipientnome)
		  modal.find('#recipient-cpf').val(recipientcpf)
		  modal.find('#recipient-sexo').val(recipientsexo)
		  modal.find('#recipient-senha').val(recipientsenha)
		  
		})
	</script>
</body>
</html>		
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

