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
      <h4 class="ui header">Edição de Aluguel</h4>
    </div>
	<form action="http://localhost/ferramenta_bd1-master/index.php/Edicao/Aluguel/<?php if(isset($dados)) echo $dados["id"]; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">

		<div class="two fields">
			<div class="field">
			  <label>Máquina</label>
			  <input placeholder="Máquina" disabled name="maq" id="maq" type="text" <?php if(isset($dados)) echo 'value="'.$dados['maq'].'"';?>>
			</div>
			<div class="field">
			  <label>CPF/CNPJ do Cliente</label>
			  <input placeholder="cliente" disabled name="cliente" id="cliente" type="text" <?php if(isset($dados)) echo 'value="'.$dados['cliente'].'"';?>>
			</div>
			<div class="field">
			  <label>Reserva</label>
			  <input placeholder="Reserva" disabled disabled="True" name="res" id="res" type="text"  <?php if(isset($dados)) echo 'value="'.$dados['res'].'"';?>>
			</div>
		</div>
		
		<div class="two fields">
			<div class="field">
			  <label>Data da Retirada</label>
			  <input placeholder="Data da Retirada" name="dataRet" id="dataRet" type="text" <?php if(isset($dados)) echo 'value="'.$dados['dataRet'].'"';?>>
			</div>
			<div class="field">
			  <label>Data da Devolução</label>
			  <input placeholder="Data da Devolução" name="dataDev" id="dataDev" type="text"  <?php if(isset($dados)) echo 'value="'.$dados['dataDev'].'"';?>>
			</div>
		</div>
	
		
	
		<div class="two fields">
			<div class="field">
			  <label>Taxa</label>
			  <input placeholder="Taxa" name="taxa" id="taxa" type="text" <?php if(isset($dados)) echo 'value="'.$dados['taxa'].'"';?>>
			</div>
			<div class="field">
			  <label style="margin-bottom: -1.3em;">Seguro</label>
			  <div class="ui radio inverted checkbox 1">
				<input type="radio" name="seguro" value=0 <?php if(isset($dados)) {if($dados['seguro']==0) echo 'checked="checked"';} else echo 'checked="checked"'; ?>>
				<label style="margin-right: 3em;">Não</label>
			  </div>
			  
			  <div class="ui radio inverted checkbox 2">
				<input type="radio" name="seguro" value=1 <?php if(isset($dados)) if($dados['seguro']==1) echo 'checked="checked"';?>>
				<label>Sim</label>
			  </div>
			</div>
		</div>
		
		
		<div class="field">
			<label>Operador</label>
				<input placeholder="Operador" disabled name="operador" id="operador" type="text" <?php if(isset($dados)) echo 'value="'.$dados['operador'].'"';?>>
		</div>
			
		<?php if(isset($dados)) if($dados['manut']==NULL){?>
		<input type="hidden" name="manut" value="N">
		<div class="field">
		  <input id="manut2" type="button" class="ui button" value="Adicionar Manutenção">
		</div>
		
		<div id="extraMan" style="display:none;">
		<div class="three fields">
			<div class="field">
			  <label>Início da Manutenção</label>
			  <input placeholder="Início da Manutenção" name="inicio" id="inicio" type="text">
			</div>
			<div class="field">
			  <label>Fim da Manutenção</label>
			  <input placeholder="Fim da Manutenção" name="fim" id="fim" type="text">
			</div>
			<div class="field">
			  <label>Custo da Manutenção</label>
			  <input placeholder="Custo da Manutenção" name="custo" id="custo" type="text">
			</div>
		</div>
		</div>
		<?php } else {?>
		<input type="hidden" name="manut" value="S">
		<div class="three fields">
			<div class="field">
			  <label>Início da Manutenção</label>
			  <input placeholder="Início da Manutenção" name="inicio" id="inicio" type="text" <?php if(isset($dados)) echo 'value="'.$dados['custo'].'"';?>>
			</div>
			<div class="field">
			  <label>Fim da Manutenção</label>
			  <input placeholder="Fim da Manutenção" name="fim" id="fim" type="text" <?php if(isset($dados)) echo 'value="'.$dados['custo'].'"';?>>
			</div>
			<div class="field">
			  <label>Custo da Manutenção</label>
			  <input placeholder="Custo da Manutenção" name="custo" id="custo" type="text" <?php if(isset($dados)) echo 'value="'.$dados['custo'].'"';?>>
			</div>
		</div>
		<?php } ?>
		
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