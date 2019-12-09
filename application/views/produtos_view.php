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
          <a class="active item" href="http://localhost/Ferramenta_BD1-master/index.php/Produto">Produtos</a>
          <a class="item" href="http://localhost/Ferramenta_BD1-master/index.php/MainPage/navegacao">Cadastros</a>
        </div>
      </div>
    </div>

  </header>

  <main>
    </br>

	<?php
		if(isset($servicos)){
	?>
		<div id="servicos" class="ui segments">
		  <div class="ui center aligned segment">
			<h2>Serviços</h2>
		  </div>
		</div>
		
		<div class="ui segments">
		  <div class="ui huge celled list">
			<?php
			foreach($servicos as $servico){
				echo '<div class="item">';
				echo '<p class="header">Operador de Maquina do tipo '.$servico->getDescricao().'</p>';
				echo '</div>';
			}
			?>
			
		  </div>
		</div>
	
	<?php
		}
	?>
	
	</br>

		<?php
		if(isset($maquinas)){
	?>	
	
			<div class="ui segments">
			  <div class="ui center aligned segment">
				<h2 id="maquinario">Maquinário</h2>
			  </div>
			</div>

	<?php 
			$i=0;
			foreach($maquinas as $m){
				if($i%5==0){
					echo '<div class="ui center aligned segment">';
					echo '<div class="ui five inverted link cards">';
				}
				echo '<span class="ui centered card">';
					echo '<a class="image">';
					echo '<img style="center;height:20em;width:17.65em" src="http://localhost/Ferramenta_BD1-master/Imagens/Maquina/'.$m->getIdMaquina().'.jpg">';
					echo '</a>';
					echo '<span class="content">';
						echo '<p class="header">'.$m->getModelo().'</p>';
						echo '<p class="description"><strong>Fabricante:</strong> '.$m->getFabricante().'</p>';
						echo '<p class="description"><strong>Número de Série:</strong> '.$m->getNumeroSerie().'</p>';
					echo '</span>';
				echo '</span>';
				$i+=1;
				if($i%5==0){
					echo '</div>';
					echo '</div>';
				}
			}
			if($i<5){
					echo '</div>';
					echo '</div>';
				}
		}
	?>

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
  <script type="text/javascript" src="Ferrament@.js"></script>
</body>

</html>