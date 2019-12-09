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
      <h4 class="ui header">Edição de Clientes (Pessoa Física)</h4>
    </div>
	<form action="http://localhost/ferramenta_bd1-master/index.php/Edicao/PessoaFisica/<?php if(isset($dados)) echo $dados["id"]; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">
	  
	  <div class="two fields">
        <div class="field">
          <label>Nome</label>
          <input placeholder="Nome" name="nome" id="nome" type="text" <?php if(isset($dados['nome'])) echo 'value="'.$dados['nome'].'"';?>>
        </div>
        <div class="field">
          <label>Email</label>
          <input placeholder="Email" name="email" id="email" type="text" <?php if(isset($dados['email'])) echo 'value="'.$dados['email'].'"';?>>
        </div>
      </div>
	  
	  <div class="two fields">
		<div class="field">
          <label>CPF/CNPJ do Cliente</label>
          <input placeholder="CPF" name="cliente" id="cliente" type="text" <?php if(isset($dados['cliente'])) echo 'value="'.$dados['cliente'].'"';?>>
        </div>
		<div class="field">
          <label>Data de Nascimento</label>
          <input placeholder="Data de Nascimento" name="nasc" id="nasc" type="text" <?php if(isset($dados['nasc'])) echo 'value="'.$dados['nasc'].'"';?>>
        </div>
	  </div>
	</div>  
	
	
	<div class="ui form inverted segment">
      <div class="two fields">
        <div class="field">
          <label>Bairro</label>
          <input placeholder="Bairro" name="bairro" id="bairro" type="text" <?php if(isset($dados['bairro'])) echo 'value="'.$dados['bairro'].'"';?>>
        </div>
        <div class="field">
          <label>Cidade</label>
          <input placeholder="Cidade" name="cidade" id="cidade" type="text" <?php if(isset($dados['cidade'])) echo 'value="'.$dados['cidade'].'"';?>>
        </div>
      </div>
	  
	  	  	  <div class="two fields">
		<div class="field">
          <label>Estado</label>
          <input placeholder="Estado" name="uf" id="uf" type="text" <?php if(isset($dados['uf'])) echo 'value="'.$dados['uf'].'"';?>>
        </div>
		<div class="field">
			<label>Rua</label>
			<input placeholder="Rua" name="rua" id="rua" type="text" <?php if(isset($dados['rua'])) echo 'value="'.$dados['rua'].'"';?>>
		</div>
      </div>
	  
	  <div class="two fields">
	  <div class="field">
          <label>Número</label>
          <input placeholder="Número" name="num" id="num" type="text" <?php if(isset($dados['num'])) echo 'value="'.$dados['num'].'"';?>>
        </div>
	  <div class="field">
          <label>Complemento</label>
          <input placeholder="Complemento" name="comp" id="comp" type="text" <?php if(isset($dados['comp'])) echo 'value="'.$dados['comp'].'"';?>>
      </div>
      </div>
	  
	  <div class="two fields">
		<div class="field">
			<label>CEP</label>
			<input placeholder="CEP" name="cep" id="cep" type="text" <?php if(isset($dados['cep'])) echo 'value="'.$dados['cep'].'"';?>>
		</div>
		<div class="field">
          <label>Telefone</label>
          <input placeholder="Telefone" name="tel" id="tel" type="text" <?php if(isset($dados['tel'])) echo 'value="'.$dados['tel'].'"';?>>
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