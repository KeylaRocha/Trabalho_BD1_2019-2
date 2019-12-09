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
		<div class="ui segments">
		  <div class="ui center aligned segment">
			<h2><?php echo $titulo; ?></h2>
			<p class="description">Escolha uma filial abaixo para completar <?php echo $descricao; ?></p>
		  </div>
		</div>
		
    </br>

	<?php
		if(isset($filiais)){
	?>	
	
			<div class="ui segments">
			  <div class="ui center aligned segment">
				<h2 id="filiais">Filiais</h2>
			  </div>
			</div>

	<?php 
			$i=0;
			foreach($filiais as $f){
				if($i%5==0){
					echo '<div class="ui center aligned segment">';
					echo '<div class="ui five inverted link cards">';
				}
				echo '<span class="ui centered card">';
					echo '<a href="http://localhost/ferramenta_bd1-master/index.php/MainPage/'.$funcaodesejada.'/'.$f[0].'" class="image">';
					echo '<img style="center;height:20em;width:17.65em" src="http://localhost/ferramenta_bd1-master/Imagens/Filial/'.$f[0].'.jpg">';
					echo '</a>';
					echo '<span class="content">';
						echo '<p class="header">'.$f[2].'</p>';
						echo '<p class="description"><strong>Endereço:</strong> '.$f[3].'</p>';
						echo '<p class="description"><strong>Telefone:</strong> '.$f[1].'</p>';
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