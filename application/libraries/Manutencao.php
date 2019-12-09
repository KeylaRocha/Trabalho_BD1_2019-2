<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE MANUTENCAO
 *---------------------------------------------------------------
 */

class Manutencao {
	
	/**
	 * Atributos
	 */
	private $idManutencao;
	private $dataEntrada;
	private $dataSaida;
	private $custo;
	private $idMaquina;
	
	/**
	 * Construtor
	 */
	public function __construct($idManutencao,$dataEntrada,$dataSaida,$custo,$idMaquina) {
		$this->setIdManutencao($idManutencao);
		$this->setDataEntrada($dataEntrada);
		$this->setDataSaida($dataSaida);
		$this->setCusto($custo);
		$this->setIdMaquina($idMaquina);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdManutencao(){
		return $this->idManutencao;
	}
	
	public function getDataEntrada(){
		return $this->dataEntrada;
	}
	
	public function getDataSaida(){
		return $this->dataSaida;
	}
	
	public function getCusto(){
		return $this->custo;
	}
	
	public function getIdMaquina(){
		return $this->idMaquina;
	}
	
	/**
	 * Setters
	 */	
	
	public function setIdManutencao($newValue){
		$this->idManutencao = $newValue;
	}

	public function setDataEntrada($newValue){
		$this->dataEntrada = $newValue;
	}

	public function setDataSaida($newValue){
		$this->dataSaida = $newValue;
	}

	public function setCusto($newValue){
		$this->custo = $newValue;
	}

	public function setIdMaquina($newValue){
		$this->idMaquina = $newValue;
	}
	
	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdManutencao()."</td>";
		$saida[] = "<td>".$this->getDataEntrada()."</td>";
		$saida[] = "<td>".$this->getDataSaida()."</td>";
		$saida[] = "<td>".$this->getCusto()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Maquina/".$this->getIdMaquina()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdManutencao</th>";
		$saida[] = "<th>Data de Entrada</th>";
		$saida[] = "<th>Data de Saída</th>";
		$saida[] = "<th>Custo</th>";
		$saida[] = "<th>Máquina</th>";
		return implode(" ",$saida);
	}
	
	public function getNomeTabela(){
		return "Manutencao";
	}
	
	public function getId(){
		return $this->idManutencao;
	}


};

/* End of file Manutencao.php */
/* Location: ./application/libraries/Manutencao.php */