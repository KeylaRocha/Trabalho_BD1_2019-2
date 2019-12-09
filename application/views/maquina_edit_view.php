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

    <div class="ui segment">
      <h4 class="ui header">Edição de Ferramentas</h4>
    </div>
	<form action="http://localhost/ferramenta_bd1-master/index.php/Edicao/Maquina/<?php if(isset($dados)) echo $dados["id"]; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">
      <div class="two fields">
        <div class="field">
          <label>Modelo</label>
          <input placeholder="Modelo" name="modelo" id="modelo" type="text" <?php if(isset($dados['modelo'])) echo 'value="'.$dados['modelo'].'"';?>>
        </div>
        <div class="field">
          <label>Fabricante</label>
          <input placeholder="Fabricante" name="fabricante" id="fabricante" type="text" <?php if(isset($dados['fabricante'])) echo 'value="'.$dados['fabricante'].'"';?>>
        </div>
      </div>
	  
	  <div class="two fields">
		<div class="field">
          <label>Número de Série</label>
          <input placeholder="Numero de Série" name="numserie" id="numserie" type="text" <?php if(isset($dados['numserie'])) echo 'value="'.$dados['numserie'].'"';?>>
        </div>
		<div class="field">
        <label>Tipo da Máquina</label>
        <div class="ui selection dropdown">
          <input type="hidden" name="tipomaquina">
          <i class="dropdown icon"></i>
          <div class="default text">Tipo de Máquina</div>
		  <?php
			if(isset($tipomaquinas)){
				echo '<div class="menu">';
				foreach($tipomaquinas as $tm){
					echo '<div class="item" data-value="'.$tm->getIdTipo().'" >'.$tm->getDescricao().'</div>';
				}
				echo '</div>';
			}
		  ?>
        </div>
      </div>
      </div>
	  
      <input type="hidden" name="filial" value="<?php if(isset($dados['filial'])) echo $dados['filial']; ?>">
	  <div class="field">
          <label>Filial</label>
          <input placeholder="Filial" disabled="true" name="end" id="end" type="text" <?php if(isset($dados['end'])) echo 'value="'.$dados['end'].'"';?>>
        </div>
		
	  <div class="field">
	  <label>Imagem</label>
	  <input type="file" class="ui button" accept="image/jpeg, image/gif, image/png" id="foto" name="foto" size="20"/>
	  </div>
	  
	  <div class="field">
	  <input type="submit" class="ui button" value="Confirma">
	  </div>
    </div>
	</form>


    </br>

	<?php
		if(isset($erro)){
			echo $erro;
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
  <script type="text/javascript" src="http://localhost/ferramenta_bd1-master/Ferrament@.js"></script>
</body>

</html>