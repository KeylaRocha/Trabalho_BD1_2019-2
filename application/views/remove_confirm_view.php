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
        <h2>Item Deletado</h2>
      
	<div class="ui large container">
	<table class="ui bottom attached table">
    <thead>
	  <tr>
	  </tr>
      <tr>
		  <?php if(isset($dados)){
					echo $dados[0]->getCabecalho();
		?>
	  </tr>
	</thead>
    <tbody>
	<?php 
			$i=0;
			foreach($dados as $d){
				echo "<tr>";
				echo $d->getTabela();
				echo "</tr>";
				$i+=1;
			}
		}
	?>
    </tbody>
  </table>
  </div>
  </div>
	
	<?php
		if(isset($erro)){
	?>
		<div class="ui negative message transition">
		  <div class="header">
			<?php echo $erro; ?>
		  </div>
		</div>
	<?php }
		if(isset($sucesso)){
	?>
		<div class="ui positive message transition">
		  <div class="header">
			<?php echo $sucesso; ?>
		  </div>
		</div>
	<?php }?>
	
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