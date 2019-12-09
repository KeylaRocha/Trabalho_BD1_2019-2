<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE OPERADOR
 *---------------------------------------------------------------
 */

class Operador {
	
	/**
	 * Atributos
	 */
	private $idOperador;
	private $nome;
	private $celular;
	private $valorHora;
	
	/**
	 * Construtor
	 */
	public function __construct($idOperador,$nome,$celular,$valorHora) {
		$this->setIdOperador($idOperador);
		$this->setNome($nome);
		$this->setCelular($celular);
		$this->setValorHora($valorHora);
	}
	
	/**
	 * Getters
	 */	
	
	public function getIdOperador(){
		return $this->idOperador;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function getCelular(){
		return $this->celular;
	}
	
	public function getValorHora(){
		return $this->valorHora;
	}
	
	/**
	 * Setters
	 */	
	

	public function setIdOperador($newValue){
		$this->idOperador = $newValue;
	}

	public function setNome($newValue){
		$this->nome = $newValue;
	}
	
	public function setCelular($newValue){
		$this->celular = $newValue;
	}

	public function setValorHora($newValue){
		$this->valorHora = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdOperador()."</td>";
		$saida[] = "<td>".$this->getNome()."</td>";
		$saida[] = "<td>".$this->getCelular()."</td>";
		$saida[] = "<td>".$this->getValorHora()."</td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdOperador</th>";
		$saida[] = "<th>Nome</th>";
		$saida[] = "<th>Celular</th>";
		$saida[] = "<th>Valor da Hora</th>";
		return implode(" ",$saida);
	}
	 	
	public function getNomeTabela(){
		return "Operador";
	}
	
	public function getId(){
		return $this->idOperador;
	}
	
};

/* End of file Operador.php */
/* Location: ./application/libraries/Operador.php */