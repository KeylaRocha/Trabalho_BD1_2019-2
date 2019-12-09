<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE TIPOMAQUINA
 *---------------------------------------------------------------
 */

class TipoMaquina {
	
	/**
	 * Atributos
	 */
	private $idTipo;
	private $valorAluguel;
	private $descricao;
	private $ramo;
	
	/**
	 * Construtor
	 */
	public function __construct($idTipo,$valorAluguel,$descricao,$ramo) {
		$this->setIdTipo($idTipo);
		$this->setValorAluguel($valorAluguel);
		$this->setDescricao($descricao);
		$this->setRamo($ramo);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	public function getValorAluguel(){
		return $this->valorAluguel;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function getRamo(){
		return $this->ramo;
	}
	
	/**
	 * Setters
	 */	
	
	public function setIdTipo($newValue){
		$this->idTipo = $newValue;
	}

	public function setValorAluguel($newValue){
		$this->valorAluguel = $newValue;
	}
	
	public function setDescricao($newValue){
		$this->descricao = $newValue;
	}
	
	public function setRamo($newValue){
		$this->ramo = $newValue;
	}
	
	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdTipo()."</td>";
		$saida[] = "<td>".$this->getValorAluguel()."</td>";
		$saida[] = "<td>".$this->getDescricao()."</td>";
		$saida[] = "<td>".$this->getRamo()."</td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdTipo</th>";
		$saida[] = "<th>Valor do Aluguel</th>";
		$saida[] = "<th>Descrição</th>";
		$saida[] = "<th>Ramo de Atividade</th>";
		return implode(" ",$saida);
	}
	 
	public function getNomeTabela(){
		return "TipoMaquina";
	}
	
	public function getId(){
		return $this->idTipo;
	}
	 
};

/* End of file TipoMaquina.php */
/* Location: ./application/libraries/TipoMaquina.php */