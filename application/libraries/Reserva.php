<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE RESERVA
 *---------------------------------------------------------------
 */

class Reserva {
	
	/**
	 * Atributos
	 */
	private $idReserva;
	private $hora;
	private $dataRetirada;
	private $dataDevolucao;
	private $idCliente;
	private $idEndereco;
	
	/**
	 * Construtor
	 */
	public function __construct($idReserva,$hora,$dataRetirada,$dataDevolucao,$idCliente,$idEndereco) {
		$this->setIdReserva($idReserva);
		$this->setHora($hora);
		$this->setDataRetirada($dataRetirada);
		$this->setDataDevolucao($dataDevolucao);
		$this->setIdCliente($idCliente);
		$this->setIdEndereco($idEndereco);
	}
	
	
	/**
	 * Getters
	 */
	
	public function getIdReserva(){
		return $this->idReserva;
	}
	
	public function getHora(){
		return $this->hora;
	}
	
	public function getDataRetirada(){
		return $this->dataRetirada;
	}
	
	public function getDataDevolucao(){
		return $this->dataDevolucao;
	}
	
	
	public function getIdCliente(){
		return $this->idCliente;
	}
	
	public function getIdEndereco(){
		return $this->idEndereco;
	}
	
	/**
	 * Setters
	 */	
	
	public function setIdReserva($newValue){
		$this->idReserva = $newValue;
	}
	
	public function setHora($newValue){
		$this->hora = $newValue;
	}
	
	public function setDataRetirada($newValue){
		$this->dataRetirada = $newValue;
	}
	
	public function setDataDevolucao($newValue){
		$this->dataDevolucao = $newValue;
	}
	
	public function setIdCliente($newValue){
		$this->idCliente = $newValue;
	}
	
	public function setIdEndereco($newValue){
		$this->idEndereco = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdReserva()."</td>";
		$saida[] = "<td>".$this->getHora()."</td>";
		$saida[] = "<td>".$this->getDataRetirada()."</td>";
		$saida[] = "<td>".$this->getDataDevolucao()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Cliente/".$this->getIdCliente()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Endereco/".$this->getIdEndereco()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdReserva</th>";
		$saida[] = "<th>Hora</th>";
		$saida[] = "<th>Data de Retirada</th>";
		$saida[] = "<th>Data de Devolução</th>";
		$saida[] = "<th>Cliente</th>";
		$saida[] = "<th>Endereço</th>";
		return implode(" ",$saida);
	}
	 
	public function getNomeTabela(){
		return "Reserva";
	}
	
	public function getId(){
		return $this->idReserva;
	}
	
};

/* End of file Reserva.php */
/* Location: ./application/libraries/Reserva.php */
