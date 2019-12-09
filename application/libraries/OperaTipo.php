<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE OPERATIPO
 *---------------------------------------------------------------
 */

class OperaTipo {
	
	/**
	 * Atributos
	 */
	private $idTipo;
	private $idOperador;
	
	/**
	 * Construtor
	 */
	public function __construct($idTipo,$idOperador) {
		$this->setIdTipo($idTipo);
		$this->setIdOperador($idOperador);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	public function getIdOperador(){
		return $this->idOperador;
	}
	
	/**
	 * Setters
	 */	
	
	public function setIdTipo($newValue){
		$this->idTipo = $newValue;
	}

	public function setIdOperador($newValue){
		$this->idOperador = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/TipoMaquina/".$this->getIdTipo()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Operador/".$this->getIdOperador()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>Tipo de Máquina</th>";
		$saida[] = "<th>Operador</th>";
		return implode(" ",$saida);
	}
	 

	public function getNomeTabela(){
		return "OperaTipo";
	}
	
	public function getId(){
		return $this->idOperador."/".$this->idTipo;
	}		
};

/* End of file OperaTipo.php */
/* Location: ./application/libraries/OperaTipo.php */