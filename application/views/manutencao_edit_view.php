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
      <h4 class="ui header">Edição de Manutenção</h4>
    </div>
	<form action="http://localhost/ferramenta_bd1-master/index.php/Edicao/Manutencao/<?php if(isset($dados)) echo $dados["id"]; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">

		<input type="hidden" name="maquina" <?php if(isset($dados['maquina'])) echo 'value="'.$dados['maquina'].'"';?>>
		
		<div class="two fields">
			<div class="field">
			  <label>Início da Manutenção</label>
			  <input placeholder="Início da Manutenção" name="inicio" id="inicio" type="text" <?php if(isset($dados)) echo 'value="'.$dados['inicio'].'"';?>>
			</div>
			<div class="field">
			  <label>Fim da Manutenção</label>
			  <input placeholder="Fim da Manutenção" name="fim" id="fim" type="text" <?php if(isset($dados)) echo 'value="'.$dados['fim'].'"';?>>
			</div>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Máquina</label>
			  <input placeholder="Máquina" disabled="true" name="maq" id="maq" type="text" <?php if(isset($dados)) echo 'value="'.$dados['maq'].'"';?>>
			</div>
			<div class="field">
			  <label>Custo da Manutenção</label>
			  <input placeholder="Custo da Manutenção" name="custo" id="custo" type="text" <?php if(isset($dados)) echo 'value="'.$dados['custo'].'"';?>>
			</div>
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
			
			if(isset($sucesso)){
				echo $sucesso;
			}
		?>

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
  <script type="text/javascript" src="http://localhost/ferramenta_bd1-master/Ferrament@.js"></script>
</body>

</html>