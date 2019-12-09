<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * CLASSE ADMINISTRADOR
 *---------------------------------------------------------------
 */

class Administrador {
	
	/**
	 * Atributos
	 */
	private $idAdmin;
	private $email;
	private $senha;
	
	/**
	 * Construtor
	 */
	public function __construct($idAdmin, $email, $senha) {
		$this->setIdAdmin($idAdmin);
		$this->setEmail($email);
		$this->setSenha($senha);
	}
	
	/**
	 * Getters
	 */
	public function getIdAdmin(){
		return $this->idAdmin;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getSenha(){
		return $this->senha;
	}
	
	/**
	 * Setters
	 */	
	public function setIdAdmin($newValue){
		$this->idAdmin = $newValue;
	}

	public function setEmail($newValue){
		$this->email = $newValue;
	}

	public function setSenha($newValue){
		$this->senha = $newValue;
	}

};

/* End of file Administrador.php */
/* Location: ./application/libraries/Administrador.php */