	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE ENDERECOS
 *---------------------------------------------------------------
 */

class Enderecos {
	
	/**
	 * Atributos
	 */
	private $idEndereco;
	private $cep;
	private $estado;
	private $cidade;
	private $bairro;
	private $rua;
	private $numero;
	private $complemento;
	private $ehPrincipal;
	private $idCliente;
	
	/**
	 * Construtor
	 */
	public function __construct($idEndereco,$cep,$estado,$cidade,$bairro,$rua,$numero,$complemento,$ehPrincipal,$idCliente) {
		$this->setIdEndereco($idEndereco);
		$this->setCEP($cep);
		$this->setEstado($estado);
		$this->setCidade($cidade);
		$this->setBairro($bairro);
		$this->setRua($rua);
		$this->setNumero($numero);
		$this->setComplemento($complemento);
		$this->setEhPrincipal($ehPrincipal);
		$this->setIdCliente($idCliente);
	}
	
	/**
	 * Getters
	 */
	
	public function getIdEndereco(){
		return $this->idEndereco;
	}
	
	public function getCEP(){
		return $this->cep;
	}
	
	public function getEstado(){
		return $this->estado;
	}
	
	public function getCidade(){
		return $this->cidade;
	}
	
	public function getBairro(){
		return $this->bairro;
	}
	
	public function getRua(){
		return $this->rua;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function getComplemento(){
		return $this->complemento;
	}
	
	public function getEhPrincipal(){
		return $this->ehPrincipal;
	}
	
	public function getIdCliente(){
		return $this->idCliente;
	}
	
	
	/**
	 * Setters
	 */	

	public function setIdEndereco($newValue){
		$this->idEndereco = $newValue;
	}
	
	public function setCEP($newValue){
		$this->cep = $newValue;
	}
	
	public function setEstado($newValue){
		$this->estado = $newValue;
	}
	
	public function setCidade($newValue){
		$this->cidade = $newValue;
	}
	
	public function setBairro($newValue){
		$this->bairro = $newValue;
	}
	
	public function setRua($newValue){
		$this->rua = $newValue;
	}
	
	public function setNumero($newValue){
		$this->numero = $newValue;
	}
	
	public function setComplemento($newValue){
		$this->complemento = $newValue;
	}
	
	public function setEhPrincipal($newValue){
		$this->ehPrincipal = $newValue;
	}
	
	public function setIdCliente($newValue){
		$this->idCliente = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdEndereco()."</td>";
		$saida[] = "<td>".$this->getCEP()."</td>";
		$saida[] = "<td>".$this->getEstado()."</td>";
		$saida[] = "<td>".$this->getCidade()."</td>";
		$saida[] = "<td>".$this->getBairro()."</td>";
		$saida[] = "<td>".$this->getRua()."</td>";
		$saida[] = "<td>".$this->getNumero()."</td>";
		$saida[] = "<td>".$this->getComplemento()."</td>";
		$saida[] = "<td>".$this->getEhPrincipal()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/Cliente/".$this->getIdCliente()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdEndereco</th>";
		$saida[] = "<th>CEP</th>";
		$saida[] = "<th>Estado</th>";
		$saida[] = "<th>Cidade</th>";
		$saida[] = "<th>Bairro</th>";
		$saida[] = "<th>Rua</th>";
		$saida[] = "<th>Número</th>";
		$saida[] = "<th>Complemento</th>";
		$saida[] = "<th>Principal?</th>";
		$saida[] = "<th>Cliente</th>";
		return implode(" ",$saida);
	}
	 
	public function getNomeTabela(){
		return "Enderecos";
	}
	
	public function getId(){
		return $this->idEndereco;
	}		

};

/* End of file Enderecos.php */
/* Location: ./application/libraries/Enderecos.php */