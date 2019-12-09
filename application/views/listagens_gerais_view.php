<html>

<head>

  <title>Ferrament@</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width = device-width, initial-scale = 1.0">

</head>

<body>

  <header>

    <div class="ui inverted secondary menu">
      <div class="ui inverted massive borderless top fixed menu">
        <div class="item">
          <a class="ui large header fitted item" href="http://localhost/Ferramenta_BD1-master/">Ferrament@</a>
        </div>
        <div class="vertically fitted right menu">
          <a class="item" href="http://localhost/Ferramenta_BD1-master/">Inicio</a>
          <a class="item" href="http://localhost/Ferramenta_BD1-master/index.php/Produto">Produtos</a>
          <a class="active item" href="http://localhost/Ferramenta_BD1-master/index.php/MainPage/navegacao">Cadastros</a>
        </div>
      </div>
    </div>

  </header>

  <main>
    </br>
      <div class="ui center aligned segment">
        <h2>Listagens Gerais</h2>
      
	<div class="ui large container">
	<div class="ui top attached inverted header"> <?php echo $tabela;?></div>
	<table class="ui bottom attached table">
    <thead>
	  <tr>
	  </tr>
      <tr>
		  <?php if(isset($dados)){
					echo $dados[0]->getCabecalho();
		?>
		<th>Opções</th>
	  </tr>
	</thead>
    <tbody>
	<?php 
			$i=0;
			foreach($dados as $d){
				echo "<tr>";
				echo $d->getTabela();
				echo '<td>
						<a href="http://localhost/ferramenta_bd1-master/index.php/Edicao/'.$d->getNomeTabela().'/'.$d->getId().'" class="bug popup icon item"><i class="edit icon"></i></a>
						<a href="#" onclick="modal(\''.$d->getNomeTabela().'/'.$d->getId().'\')" class="bug popup icon item"><i class="trash alternate icon"></i></a>
					</td>';
				echo "</tr>";
				$i+=1;
			}
		}
	?>
    </tbody>
  </table>
  </div>
  </div>
	
	<div class="ui basic modal">
  <div class="ui icon header">
    <i class="trash alternate icon"></i>
    Remoção
  </div>
  </br>
  <div class="content">
    <p>Você confirma que deseja deletar o item de <?php echo $tabela;?> ?</p>
	</div>
	<div class="actions">
		<div class="ui red cancel inverted button">
		  <i class="remove icon"></i>
		  Não
		</div>
		<a id='link' href="">
		<div class="ui green ok inverted button">
		  <i class="checkmark icon"></i>
		  Sim
		</div>
		</a>
	  </div>
	</div>
	
    </br>
  </main>

  <footer>
    <span class="ui small borderless inverted bottom fixed menu">
      <p class="ui center item">Desenvolvido pela força do ódio</p>
    </span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.7.8/dist/semantic.min.css">
  <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.7.8/dist/semantic.min.js"></script>
  <script type="text/javascript" src="http://localhost/Ferramenta_BD1-master/Ferrament@.js"></script>
  <script type="text/javascript">
  function modal(id){
	  $('#link').attr("href","http://localhost/ferramenta_bd1-master/index.php/Remocao/"+id);
	  $('.ui.basic.modal').modal('show');
  }
  </script>
</body>

</html>