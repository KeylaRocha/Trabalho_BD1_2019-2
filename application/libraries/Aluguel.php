<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE ALUGUEL
 *---------------------------------------------------------------
 */

class Aluguel {
	
	/**
	 * Atributos
	 */
	private $idAluguel;
	private $dataDevEfetiva;
	private $dataRetEfetiva;
	private $temSeguro;
	private $valorTotal;
	private $taxa;
	private $idMaquina;
	private $idReserva;
	private $idManutencao;
	private $idOperador;
	
	/**
	 * Construtor
	 */
	public function __construct($idAluguel,$dataDevEfetiva,$dataRetEfetiva,$temSeguro,$valorTotal,$taxa,$idMaquina,$idReserva,$idManutencao,$idOperador) {
		$this->setIdAluguel($idAluguel);
		$this->setDataDevEfetiva($dataDevEfetiva);
		$this->setDataRetEfetiva($dataRetEfetiva);
		$this->setTemSeguro($temSeguro);
		$this->setValorTotal($valorTotal);
		$this->setTaxa($taxa);
		$this->setIdMaquina($idMaquina);
		$this->setIdReserva($idReserva);
		$this->setIdManutencao($idManutencao);
		$this->setIdOperador($idOperador);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdAluguel(){
		return $this->idAluguel;
	}
	
	public function getDataDevEfetiva(){
		return $this->dataDevEfetiva;
	}
	
	public function getDataRetEfetiva(){
		return $this->dataRetEfetiva;
	}
	
	public function getTemSeguro(){
		return $this->temSeguro;
	}
	
	public function getValorTotal(){
		return $this->valorTotal;
	}
	
	public function getTaxa(){
		return $this->taxa;
	}
	
	public function getIdMaquina(){
		return $this->idMaquina;
	}
	
	public function getIdReserva(){
		return $this->idReserva;
	}
	
	public function getIdManutencao(){
		return $this->idManutencao;
	}
	
	public function getIdOperador(){
		return $this->idOperador;
	}
	
	/**
	 * Setters
	 */	
	

	public function setIdAluguel($newValue){
		$this->idAluguel = $newValue;
	}
	
	public function setDataDevEfetiva($newValue){
		$this->dataDevEfetiva = $newValue;
	}
	
	public function setDataRetEfetiva($newValue){
		$this->dataRetEfetiva = $newValue;
	}
	
	public function setValorTotal($newValue){
		$this->valorTotal = $newValue;
	}
	
	public function setTemSeguro($newValue){
		$this->temSeguro = $newValue;
	}

	public function setTaxa($newValue){
		$this->taxa = $newValue;
	}
	
	public function setIdMaquina($newValue){
		$this->idMaquina = $newValue;
	}
	
	public function setIdReserva($newValue){
		$this->idReserva = $newValue;
	}
	
	public function setIdManutencao($newValue){
		$this->idManutencao = $newValue;
	}
	
	public function setIdOperador($newValue){
		$this->idOperador = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdAluguel()."</td>";
		$saida[] = "<td>".$this->getDataRetEfetiva()."</td>";
		$saida[] = "<td>".$this->getDataDevEfetiva()."</td>";
		$saida[] = "<td>".$this->getValorTotal()."</td>";
		$saida[] = "<td>".$this->getTemSeguro()."</td>";
		$saida[] = "<td>".$this->getTaxa()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Maquina/".$this->getIdMaquina()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Reserva/".$this->getIdReserva()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Manutencao/".$this->getIdManutencao()."'><i class='eye icon'></a></td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Operador/".$this->getIdOperador()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdAluguel</th>";
		$saida[] = "<th>Data de Retirada</th>";
		$saida[] = "<th>Data de Devolução</th>";
		$saida[] = "<th>Valor Total</th>";
		$saida[] = "<th>Seguro?</th>";
		$saida[] = "<th>Taxa</th>";
		$saida[] = "<th>Máquina</th>";
		$saida[] = "<th>Reserva</th>";
		$saida[] = "<th>Manutenção</th>";
		$saida[] = "<th>Operador</th>";
		return implode(" ",$saida);
	}
	

	public function getNomeTabela(){
		return "Aluguel";
	}
	
	public function getId(){
		return $this->idAluguel;
	}		
	
};

/* End of file Aluguel.php */
/* Location: ./application/libraries/Aluguel.php */