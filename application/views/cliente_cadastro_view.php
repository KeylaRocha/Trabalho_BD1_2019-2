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
      <h4 class="ui header">Cadastro de Clientes</h4>
    </div>
	<form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">
	
	  <div class="two fields">
        <div class="field">
          <label>Nome</label>
          <input placeholder="Nome" name="nome" id="nome" type="text">
        </div>
        <div class="field">
          <label>Email</label>
          <input placeholder="Email" name="email" id="email" type="text">
        </div>
      </div>
	  
	  <div class="two fields">
		<div class="field">
          <label>CPF/CNPJ do Cliente</label>
          <input placeholder="CPF/CNPJ do Cliente" name="cliente" id="cliente" type="text">
        </div>
		<div class="field">
		  <label style="margin-bottom: -1.3em;">Tipo de Cliente</label>
		  <div class="ui radio inverted checkbox 1">
			<input type="radio" name="tipocliente" checked="checked" value="fisica">
			<label style="margin-right: 3em;">Pessoa Física</label>
		  </div>
		  
		  <div class="ui radio inverted checkbox 2">
			<input type="radio" name="tipocliente" value="juridica">
			<label>Pessoa Jurídica</label>
		  </div>
		</div>
	  </div>
	</div>  
	
	<div class="ui form inverted segment" id="extraPes" style="display:inherit;">
		<div class="field">
          <label>Data de Nascimento</label>
          <input placeholder="Data de Nascimento" name="nasc" id="nasc" type="text">
        </div>
	</div>
	
	<div class="ui form inverted segment" id="extraJur" style="display:none;">
		<div class="field">
          <label>Razão Social</label>
          <input placeholder="Razão Social" name="razaosoc" id="razaosoc" type="text">
        </div>
		<div class="field">
          <label>Nome do Representante</label>
          <input placeholder="Representante" name="repr" id="repr" type="text">
        </div>
	</div>
	
	<div class="ui form inverted segment">
      <div class="two fields">
        <div class="field">
          <label>Bairro</label>
          <input placeholder="Bairro" name="bairro" id="bairro" type="text">
        </div>
        <div class="field">
          <label>Cidade</label>
          <input placeholder="Cidade" name="cidade" id="cidade" type="text">
        </div>
      </div>
	  
	  	  	  <div class="two fields">
		<div class="field">
          <label>Estado</label>
          <input placeholder="Estado" name="uf" id="uf" type="text">
        </div>
		<div class="field">
			<label>Rua</label>
			<input placeholder="Rua" name="rua" id="rua" type="text">
		</div>
      </div>
	  
	  <div class="two fields">
	  <div class="field">
          <label>Número</label>
          <input placeholder="Número" name="num" id="num" type="text">
        </div>
	  <div class="field">
          <label>Complemento</label>
          <input placeholder="Complemento" name="comp" id="comp" type="text">
      </div>
      </div>
	  
	  <div class="two fields">
		<div class="field">
			<label>CEP</label>
			<input placeholder="CEP" name="cep" id="cep" type="text">
		</div>
		<div class="field">
          <label>Telefone</label>
          <input placeholder="Telefone" name="tel" id="tel" type="text">
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