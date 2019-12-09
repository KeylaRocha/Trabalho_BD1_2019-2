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
        <h2>Maquinário Novo (Ainda Sem Manutenções)</h2>
      </div>
    </div>
	<div class="ui large container">
	<div class="ui top attached inverted header">Máquinas</div>
	<table class="ui bottom attached table">
    <thead>
	  <tr>
	  </tr>
      <tr>
		  <th>IdMaquina</th>
		  <th>Modelo</th>
		  <th>Numero de Série</th>
		  <th>Fabricante</th>
		  <th>Filial</th>
		  <th>Tipo de Máquina</th>
		  <th>Opções<text style="color:#f9fafb;">____</text></th>
	  </tr>
	</thead>
    <tbody>
	<?php if(isset($maqs)){
			$i=0;
			foreach($maqs as $r){
				echo "<tr>";
				echo "<td>".$r[0]->getIdMaquina()."</td>";
				echo "<td>".$r[0]->getModelo()."</td>";
				echo "<td>".$r[0]->getNumeroSerie()."</td>";
				echo "<td>".$r[0]->getFabricante()."</td>";
				echo "<td>".$r[1]."</td>";
				echo "<td>".$r[2]."</td>";
				echo '<td>
						<a class="bug popup icon item" href="http://localhost/ferramenta_bd1-master/index.php/Edicao/'.$r[0]->getNomeTabela().'/'.$r[0]->getId().'"><i class="edit icon"></i></a>
						<a class="bug popup icon item"><i class="trash alternate icon" href="#" onclick="modal(\''.$r[0]->getNomeTabela().'/'.$r[0]->getId().'\')"></i></a>
					</td>';
				echo "</tr>";
				$i+=1;
			}
		}
	?>
    </tbody>
  </table>
  </div>
	
	<div class="ui basic modal">
  <div class="ui icon header">
    <i class="trash alternate icon"></i>
    Remoção
  </div>
  </br>
  <div class="content">
    <p>Você confirma que deseja deletar a Máquina ?</p>
	</div>
	<div class="actions">
		<div class="ui red cancel inverted button">
		  <i class="remove icon"></i>
		  Não
		</div>
		<a id='link' href="">
		<div class="ui green ok inverted button">
		  <i class="checkmark icon"></i>
		  Sim
		</div>
		</a>
	  </div>
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
  <script type="text/javascript" src="http://localhost/Ferramenta_BD1-master/Ferrament@.js"></script>
  <script type="text/javascript">
  function modal(id){
	  $('#link').attr("href","http://localhost/ferramenta_bd1-master/index.php/Remocao/"+id);
	  $('.ui.basic.modal').modal('show');
  }
  </script>
</body>

</html>