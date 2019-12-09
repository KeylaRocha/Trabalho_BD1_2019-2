<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE RESERVATIPO
 *---------------------------------------------------------------
 */

class ReservaTipo {
	
	/**
	 * Atributos
	 */
	private $idTipo;
	private $idReserva;
	private $quantidade;
	
	/**
	 * Construtor
	 */
	public function __construct($idReserva,$idTipo,$quantidade) {
		$this->setIdTipo($idTipo);
		$this->setIdReserva($idReserva);
		$this->setQuantidade($quantidade);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	public function getIdReserva(){
		return $this->idReserva;
	}
	
	public function getQuantidade(){
		return $this->quantidade;
	}
	
	/**
	 * Setters
	 */	
	
	public function setIdTipo($newValue){
		$this->idTipo = $newValue;
	}

	public function setIdReserva($newValue){
		$this->idReserva = $newValue;
	}
	
	public function setQuantidade($newValue){
		$this->quantidade = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/TipoMaquina/".$this->getIdTipo()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Reserva/".$this->getIdReserva()."'><i class='eye icon'></a></td>";
		$saida[] = "<td>".$this->getQuantidade()."</td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>Tipo de Máquina</th>";
		$saida[] = "<th>Reserva</th>";
		$saida[] = "<th>Quantidade</th>";
		return implode(" ",$saida);
	}
	 
	public function getNomeTabela(){
		return "ReservaTipo";
	}
	
	public function getId(){
		return $this->idReserva."/".$this->idTipo;
	}		

};

/* End of file ReservaTipo.php */
/* Location: ./application/libraries/ReservaTipo.php */