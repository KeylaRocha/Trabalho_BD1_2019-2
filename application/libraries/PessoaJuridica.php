<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE PESSOAJURIDICA
 *---------------------------------------------------------------
 */

class PessoaJuridica {
	
	/**
	 * Atributos
	 */
	private $idCliente;
	private $cnpj;
	private $razaosocial;
	private $representante;
	
	private $nome;
	private $telefone;
	private $email;
	
	/**
	 * Construtor
	 */
	public function __construct($idCliente,$cnpj,$razaosocial,$representante,$nome=NULL,$telefone=NULL,$email=NULL) {
		$this->setIdCliente($idCliente);
		$this->setCNPJ($cnpj);
		$this->setRazaoSocial($razaosocial);
		$this->setRepresentante($representante);
		
		$this->setNome($nome);
		$this->setTelefone($telefone);
		$this->setEmail($email);
	}
	
	
	/**
	 * Getters
	 */
	public function getIdCliente(){
		return $this->idCliente;
	}

	public function getCNPJ(){
		return $this->cnpj;
	}
	
	public function getRazaoSocial(){
		return $this->razaosocial;
	}
	
	public function getRepresentante(){
		return $this->representante;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function getTelefone(){
		return $this->telefone;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	/**
	 * Setters
	 */	
	public function setIdCliente($newValue){
		$this->idCliente = $newValue;
	}
	
	public function setCNPJ($newValue){
		$this->cnpj = $newValue;
	}
	
	public function setRazaoSocial($newValue){
		$this->razaosocial = $newValue;
	}
	
	public function setRepresentante($newValue){
		$this->representante = $newValue;
	}
	
	public function setNome($newValue){
		$this->nome = $newValue;
	}
	
	public function setTelefone($newValue){
		$this->telefone = $newValue;
	}
	
	public function setEmail($newValue){
		$this->email = $newValue;
	}

	/**
	 * Extra
	 */	
	
	public function getTabela(){
		$saida = array();
		$saida[] = "<td>".$this->getIdCliente()."</td>";
		$saida[] = "<td>".$this->getCNPJ()."</td>";
		$saida[] = "<td>".$this->getRazaoSocial()."</td>";
		$saida[] = "<td>".$this->getRepresentante()."</td>";
		$saida[] = "<td>".$this->getNome()."</td>";
		$saida[] = "<td>".$this->getTelefone()."</td>";
		$saida[] = "<td>".$this->getEmail()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/EnderecoCliente/".$this->getIdCliente()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdCliente</th>";
		$saida[] = "<th>CNPJ</th>";
		$saida[] = "<th>Razão Social</th>";
		$saida[] = "<th>Representante</th>";
		$saida[] = "<th>Nome</th>";
		$saida[] = "<th>Telefone</th>";
		$saida[] = "<th>Email</th>";
		$saida[] = "<th>Endereço</th>";
		return implode(" ",$saida);
	}

	public function getNomeTabela(){
		return "PessoaJuridica";
	}
	
	public function getId(){
		return $this->idCliente;
	}	
	
};

/* End of file PessoaJuridica.php */
/* Location: ./application/libraries/PessoaJuridica.php */
