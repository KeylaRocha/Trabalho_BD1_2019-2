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
      <h4 class="ui header">Aluguel (Devolução)</h4>
    </div>
	<form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="ui form 1">
    <div class="ui form inverted segment">
		
		<div class="two fields">
		<div class="field">
		  <label>CPF/CNPJ do Cliente</label>
		  <input placeholder="CPF/CNPJ do Cliente" name="cliente" id="cliente" type="text"  <?php if(isset($post_data)) echo 'value="'.$post_data['cliente'].'"';?>>
		</div>
		<div class="field">
		  <label style="margin-bottom: -1.3em;">Tipo de Cliente</label>
		  <div class="ui radio inverted checkbox 1">
			<input type="radio" name="tipocliente" value="fisica" <?php if(isset($post_data)) {if($post_data['tipocliente']=='fisica') echo 'checked="checked"';} else echo 'checked="checked"'; ?>>
			<label style="margin-right: 3em;">Pessoa Física</label>
		  </div>
		  
		  <div class="ui radio inverted checkbox 2">
			<input type="radio" name="tipocliente" value="juridica" <?php if(isset($post_data)) if($post_data['tipocliente']=='juridica') echo 'checked="checked"';?>>
			<label>Pessoa Jurídica</label>
		  </div>
		</div>
		</div>
		
		<div class="two fields">
			<div class="field">
				<label>Aluguel</label>
				<?php if(!isset($alugueis)){?>
				  <input type="hidden" name="carregarAlg" value="1">
				  <input type="submit" class="ui button" value="Buscar alugueis ">
				<?php } else { ?>
				<div class="ui selection dropdown">
				  <input type="hidden" name="aluguel" value="">
				  <i class="dropdown icon"></i>
				  <div class="default text">Nenhum Aluguel</div>
				  <?php
					if(isset($alugueis)){
						echo '<div class="menu">';
						foreach($alugueis as $a){
							echo '<div class="item" data-value="'.$a[0].'" >'.$a[1].'</div>';
						}
						echo '</div>';
					}
				  ?>
				</div>
				<?php } ?>
			</div>
			<div class="field">
			  <label>Data da Devolução</label>
			  <input placeholder="Data da Devolução" name="dataDev" id="dataDev" type="text"  <?php if(isset($post_data)) echo 'value="'.$post_data['dataDev'].'"';?>>
			</div>
		</div>
	
		
	
		<div class="two fields">
			<div class="field">
			  <label>Taxa</label>
			  <input placeholder="Taxa" name="taxa" id="taxa" type="text"  <?php if(isset($post_data)) echo 'value="'.$post_data['taxa'].'"';?>>
			</div>
			<div class="field">
			  <label style="margin-bottom: -1.3em;">Manutenção Necessária?</label>
			  <div class="ui radio inverted checkbox 1">
				<input type="radio" id="manut1" name="manut" value="N" <?php if(isset($post_data)) {if($post_data['manut']=='N') echo 'checked="checked"';} else echo 'checked="checked"'; ?>>
				<label style="margin-right: 3em;">Não</label>
			  </div>
			  
			  <div class="ui radio inverted checkbox 2">
				<input type="radio" id="manut2" name="manut" value="S" <?php if(isset($post_data)) if($post_data['manut']=='S') echo 'checked="S"';?>>
				<label>Sim</label>
			  </div>
			</div>
		</div>

		<div id="extraMan" style="display:none;">
		<div class="two fields">
			<div class="field">
			  <label>Tempo de Manutenção</label>
			  <input placeholder="Tempo da Manutenção" name="tempo" id="tempo" type="text">
			</div>
			<div class="field">
			  <label>Custo da Manutenção</label>
			  <input placeholder="Custo da Manutenção" name="custo" id="custo" type="text">
			</div>
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