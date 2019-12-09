<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE PESSOAFISICA
 *---------------------------------------------------------------
 */

class PessoaFisica {
	
	/**
	 * Atributos
	 */
	private $idCliente;
	private $cpf;
	private $dataNascimento;
	
	private $nome;
	private $telefone;
	private $email;
	
	/**
	 * Construtor
	 */
	public function __construct($idCliente,$cpf,$dataNascimento,$nome=NULL,$telefone=NULL,$email=NULL) {
		$this->setIdCliente($idCliente);
		$this->setCPF($cpf);
		$this->setDataNascimento($dataNascimento);
		
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

	public function getCPF(){
		return $this->cpf;
	}
	
	public function getDataNascimento(){
		return $this->dataNascimento;
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
	
	public function setCPF($newValue){
		$this->cpf = $newValue;
	}
	
	public function setDataNascimento($newValue){
		$this->dataNascimento = $newValue;
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
		$saida[] = "<td>".$this->getCPF()."</td>";
		$saida[] = "<td>".$this->getNome()."</td>";
		$saida[] = "<td>".$this->getTelefone()."</td>";
		$saida[] = "<td>".$this->getEmail()."</td>";
		$saida[] = "<td>".$this->getDataNascimento()."</td>";
		$saida[] = "<td><a href='http://localhost/Ferramenta_BD1-master/index.php/Listagens/exibir/EnderecoCliente/".$this->getIdCliente()."'><i class='eye icon'></a></td>";
		return implode(" ",$saida);
	}
	
	public function getCabecalho(){
		$saida = array();
		$saida[] = "<th>IdCliente</th>";
		$saida[] = "<th>CPF</th>";
		$saida[] = "<th>Nome</th>";
		$saida[] = "<th>Telefone</th>";
		$saida[] = "<th>Email</th>";
		$saida[] = "<th>Data de Nascimento</th>";
		$saida[] = "<th>Endereço</th>";
		return implode(" ",$saida);
	}

	public function getNomeTabela(){
		return "PessoaFisica";
	}
	
	public function getId(){
		return $this->idCliente;
	}		
	
};

/* End of file PessoaFisica.php */
/* Location: ./application/libraries/PessoaFisica.php */
