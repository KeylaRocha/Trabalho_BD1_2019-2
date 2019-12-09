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
          <a class="ui large header fitted item" href="Main.html">Ferrament@</a>
        </div>
        <div class="vertically fitted right menu">
          <a class="active item" href="#">Inicio</a>
          <a class="item" href="http://localhost/Ferramenta_BD1-master/index.php/Produto">Produtos</a>
          <a class="item" href="http://localhost/Ferramenta_BD1-master/index.php/MainPage/navegacao">Cadastros</a>
        </div>
      </div>
    </div>

  </header>

  <main>
  
	</br>
		<div class="ui segments">
		  <div class="ui center aligned segment">
			<h2>Bem Vindo!</h2>
			<p class="description">Aqui na <strong>Ferrament@</strong> você encontra todos os serviços e maquinário dos mais diversos tipos, </br> pode confiar nas nossas filiais espalhadas pela Zona da Mata para um atendimento de qualidade.</p>
			<p class="description">Encontre abaixo a <a href="#filiais">Filial</a> mais próxima de você, o <a href="#servicos">Serviço</a> que mais precisa, ou o <a href="#maquinario">Maquinário</a> que mais lhe falta!</p>
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
					echo '<a href="http://localhost/Ferramenta_BD1-master/index.php/MainPage/ferramentas_disp/'.$f[0].'" class="image">';
					echo '<img style="center;height:20em;width:17.65em" src="Imagens/Filial/'.$f[0].'.jpg">';
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
			if($i < 5){
				echo '</div>';
					echo '</div>';
			}
		}
	?>

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
				echo '<p class="header">Operador de Maquina do tipo '.$servico->getDescricao().'	';
				echo '<a href="http://localhost/Ferramenta_BD1-master/index.php/MainPage/tipos_de_ferramentas/'.$servico->getIdTipo().'"><i class="external alternate icon"></i></a>';
				echo '</p>';
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
					echo '<a href="http://localhost/Ferramenta_BD1-master/index.php/MainPage/tipos_de_ferramentas/'.$m->getIdTipo().'" class="image">';
					echo '<img style="center;height:20em;width:17.65em" src="Imagens/Maquina/'.$m->getIdMaquina().'.jpg">';
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
			if($i < 5){
				echo '</div>';
					echo '</div>';
			}
		}
	?>
	<div>
	<p>
	
	</p>
	</div>
	</br>
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