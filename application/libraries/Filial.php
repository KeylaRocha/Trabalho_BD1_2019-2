<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE FILIAL
 *---------------------------------------------------------------
 */

class Filial {
	
	/**
	 * Atributos
	 */
	private $idFilial;
	private $telefone;
	private $idEndereco;
	
	/**
	 * Construtor
	 */
	public function __construct($idFilial,$telefone,$idEndereco) {
		$this->setIdFilial($idFilial);
		$this->setTelefone($telefone);
		$this->setIdEndereco($idEndereco);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdFilial(){
		return $this->idFilial;
	}
	
	public function getTelefone(){
		return $this->telefone;
	}
	
	public function getIdEndereco(){
		return $this->idEndereco;
	}
	
	/**
	 * Setters
	 */	
	
	public function setIdFilial($newValue){
		$this->idFilial = $newValue;
	}

	public function setTelefone($newValue){
		$this->telefone = $newValue;
	}

	public function setIdEndereco($newValue){
		$this->idEndereco = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdFilial()."</td>";
		$saida[] = "<td>".$this->getTelefone()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Endereco/".$this->getIdEndereco()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdFilial</th>";
		$saida[] = "<th>Telefone</th>";
		$saida[] = "<th>Endereço</th>";
		return implode(" ",$saida);
	}

	public function getNomeTabela(){
		return "Filial";
	}
	
	public function getId(){
		return $this->idFilial;
	}
	
};

/* End of file Filial.php */
/* Location: ./application/libraries/Filial.php */