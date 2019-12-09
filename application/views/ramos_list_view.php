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
      <h2>Ramos de Atividade</h2>
	
	  <?php if(isset($tipomaquinas)){
			foreach($tipomaquinas as $t){
	  ?>
	  <div class="ui one link cards">
	  <a class="card" href="http://localhost/Ferramenta_BD1-master/index.php/Listagens/ramos_atividade/<?php echo $t->getIdTipo();?>">
          <div class="content">
            </br>
            <div class="header"><?php echo $t->getRamo(); ?></div>
            <div class="description">
              Listagem do Maquinário e Serviços do Ramo de Atividade <?php echo $t->getRamo(); ?>.
            </div>
            </br>
          </div>
        </a>
		</div>
		<?php }
			}
		?>
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
  <script type="text/javascript" src="Ferrament@.js"></script>
</body>

</html>