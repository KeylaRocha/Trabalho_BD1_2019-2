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
      <h4 class="ui header">Edição de Tipos de Máquina</h4>
    </div>
	<form action="http://locahost/ferramenta_bd1-master/index.php/Edicao/TipoMaquina/<?php if(isset($dados)) echo $dados['id']; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">
        <div class="field">
          <label>Descrição</label>
          <input placeholder="Descrição" name="desc" id="desc" type="text" <?php if(isset($dados['desc'])) echo 'value="'.$dados['desc'].'"';?>>
        </div>
        <div class="field">
          <label>Valor do Aluguel</label>
          <input placeholder="Valor do Aluguel" name="valor" id="valor" type="text" <?php if(isset($dados['valor'])) echo 'value="'.$dados['valor'].'"'?>>
        </div>
		<div class="field">
          <label>Ramo de Atividade Relacionada</label>
          <input placeholder="Ramo de Atividade" name="ramo" id="ramo" type="text" <?php if(isset($dados['ramo'])) echo 'value="'.$dados['ramo'].'"'?>>
        </div>
		
	  <div class="field">
	  <input type="submit" class="ui button" value="Confirma">
	  </div>
    </div>
	</form>


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