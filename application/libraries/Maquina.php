<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE MAQUINA
 *---------------------------------------------------------------
 */

class Maquina {
	
	/**
	 * Atributos
	 */
	private $idMaquina;
	private $numeroSerie;
	private $modelo;
	private $fabricante;
	private $idFilial;
	private $idTipo;
	
	/**
	 * Construtor
	 */
	public function __construct($idMaquina,$numeroSerie,$modelo,$fabricante,$idFilial,$idTipo) {
		$this->setIdMaquina($idMaquina);
		$this->setNumeroSerie($numeroSerie);
		$this->setModelo($modelo);
		$this->setFabricante($fabricante);
		$this->setIdFilial($idFilial);
		$this->setIdTipo($idTipo);
	}
	
	/**
	 * Getters
	 */
	public function getIdMaquina(){
		return $this->idMaquina;
	}

	public function getNumeroSerie(){
		return $this->numeroSerie;
	}

	public function getModelo(){
		return $this->modelo;
	}
	
	public function getFabricante(){
		return $this->fabricante;
	}
	
	public function getIdFilial(){
		return $this->idFilial;
	}
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	/**
	 * Setters
	 */	
	public function setIdMaquina($newValue){
		$this->idMaquina = $newValue;
	}

	public function setNumeroSerie($newValue){
		$this->numeroSerie = $newValue;
	}

	public function setModelo($newValue){
		$this->modelo = $newValue;
	}
	
	public function setFabricante($newValue){
		$this->fabricante = $newValue;
	}
	
	public function setIdFilial($newValue){
		$this->idFilial = $newValue;
	}
	
	public function setIdTipo($newValue){
		$this->idTipo = $newValue;
	}
	
	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdMaquina()."</td>";
		$saida[] = "<td>".$this->getModelo()."</td>";
		$saida[] = "<td>".$this->getNumeroSerie()."</td>";
		$saida[] = "<td>".$this->getFabricante()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Filial/".$this->getIdFilial()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/TipoMaquina/".$this->getIdTipo()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdMaquina</th>";
		$saida[] = "<th>Modelo</th>";
		$saida[] = "<th>Número de Série</th>";
		$saida[] = "<th>Fabricante</th>";
		$saida[] = "<th>Filial</th>";
		$saida[] = "<th>Tipo de Máquina</th>";
		return implode(" ",$saida);
	}
	 	
	public function getNomeTabela(){
		return "Maquina";
	}
	
	public function getId(){
		return $this->idMaquina;
	}

};

/* End of file Maquina.php */
/* Location: ./application/libraries/Maquina.php */